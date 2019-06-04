<?php
namespace app\modules\API\controllers;

use app\API\models\User;
use app\models\Admin\OrderRemind;
use app\models\Admin\PropertyPay;
use app\models\Admin\UserAccount;
use app\util\MessageUtil;
use yii;
use yii\web\Controller;
use app\models\Admin\ParkingPayment;
use app\models\Admin\PrePayment;
use app\models\Admin\ElectricOrder;
use app\models\Admin\WaterPayment;
use app\models\Admin\WaterBase;
use app\util\CURLUtils;

require_once Yii::$app->basePath.'/vendor/wappay/wxpay/lib/WxPayApi.php';
require_once Yii::$app->basePath.'/vendor/wappay/wxpay/lib/WxPayNotify.php';
require_once Yii::$app->basePath.'/vendor/wappay/alipay/aop/AopClient.php';
require_once Yii::$app->basePath.'/vendor/wappay/wxpay/lib/log.php';

class NotifyController extends Controller{

	public $enableCsrfValidation = false;

	public function init(){
		//初始化日志
		$logHandler= new \CLogFileHandler(Yii::$app->basePath.'/web/logs/wappay_log_'.date('Ymd').'.log');
		$log = \Log::Init($logHandler, 15);
	}

	/**
	 * 微信支付回调
	 * @Author   tml
	 * @DateTime 2017-12-23
	 * @return   [type]     [description]
	 */
	public function actionWxNotify(){
		\Log::DEBUG("wxpay begin notify");
		$notify = new WxPayNotifyCallBack();
		$notify->Handle(false);
	}

	/**
	 * 支付宝支付回调
	 * @Author   tml
	 * @DateTime 2017-12-23
	 * @return   [type]     [description]
	 */
	public function actionAlipayNotify(){
		\Log::DEBUG("alipay begin notify");	
		$aop = new \AopClient;
		$aop->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAu+erWpQad3+0tCTeTnlzvN5B7AiN+2BCdKpvqe8BygB4yv3GQUqBXvhw5EXS9DyNgGE+aJkIO0P+Arrr6Rqa05zPGMZYeFwiazvOJpYW/EZw/vqQcXUIXhLE3jpOaev3uhPgnHccR6u4Ma30yCRMYrcLxi7rYnu01vAM58yFUf2mAHyti6FnCdgvjAus2KwdYFR8STX90VIMxaj2jvglCC5oK5uZQWg0HWZ9UJUVEFfX8M9SK75hhzyjtSMK7WHrtIrB3XeI1GAsYUeE+nQiQYsBDK7WVbaZrb9TvN6sPMbwlmo/52+cFZPjI14t4oFigo/tTeZ8S9qfwZJzqZ804QIDAQAB';
		// var_dump($_POST);exit;
		$flag = $aop->rsaCheckV1($_POST, $aop->alipayrsaPublicKey, "RSA2");
		\Log::DEBUG("alipay flag:" . $flag);	
		if ($flag && ($_POST['trade_status'] == 'TRADE_SUCCESS' || $_POST['trade_status'] == 'TRADE_FINISHED')) {
			\Log::DEBUG("call back:" . json_encode($_POST));
			$out_trade_no = empty($_POST['out_trade_no']) ? 0 : $_POST['out_trade_no'];
			$total_amount = empty($_POST['total_amount']) ? 0 : $_POST['total_amount'];
			$app_id       = empty($_POST['app_id']) ? '' : $_POST['app_id'];
			$trade_no     = empty($_POST['trade_no']) ? '' : $_POST['trade_no'];
			$passback_params = empty($_POST['passback_params']) ? '' : $_POST['passback_params'];		
			if (empty($out_trade_no) || empty($total_amount) || empty($app_id) || empty($trade_no) || empty($passback_params)) {
				echo 'failure';exit;
			}
			if ($app_id != '2017121300668897') {
				echo 'failure';exit;
			}
			//支付宝
			$res = $this->alipayUpdateOrderStatus($out_trade_no,$total_amount,$trade_no,$passback_params);
			\Log::DEBUG("alipay res:" . $res);
			if ($res) {
			    if($passback_params == 'parking_payment'){
			       $parking_payment = ParkingPayment::find()->where(array('order_sn'=>$out_trade_no))->one();
			       $user1 = User::find()->where(array('id'=>$parking_payment['user_id']))->one();
			       $mobiles = $user1['Tell'];
			       $content = '您在'.date("Y-m-d H:i:s",time()).'，缴纳停车费用:'.$total_amount.'元。【兴业APP】';
			       MessageUtil::paymentnotice($mobiles,$content);
                }elseif ($passback_params == 'electric_recharge'){
			       $electric_recharge = ElectricOrder::find()->where(array('order_sn'=>$out_trade_no))->one();
                    $user2 = User::find()->where(array('id'=>$electric_recharge['user_id']))->one();
                    $mobiles = $user2['Tell'];
                    $content = '您在'.date("Y-m-d H:i:s",time()).'，缴纳电费费用:'.$total_amount.'元。【兴业APP】';
                    MessageUtil::paymentnotice($mobiles,$content);   
                }elseif($passback_params == 'water_pay'){
                    $water_pay = WaterPayment::find()->where(array('order_sn'=>$out_trade_no))->one();
                    $user3 = User::find()->where(array('id'=>$water_pay['user_id']))->one();
                    $mobiles = $user3['Tell'];
                    $content = '您在'.date("Y-m-d H:i:s",time()).'，缴纳水费费用:'.$total_amount.'元。【兴业APP】';
                    MessageUtil::paymentnotice($mobiles,$content);
                }
                echo 'success';exit;
			} 
		}
		echo 'failure';exit;    
	}

	public function alipayUpdateOrderStatus($order_sn,$total_fee,$trade_no,$type){
		//停车缴费
		if ($type == 'parking_payment') {
            $order = ParkingPayment::find()->where(['order_sn'=>$order_sn,'parking_fee'=>$total_fee,'status'=>1])->one();
			if ($order) {
				$res = ParkingPayment::updateAll(['status'=>2,'pay_type'=>2,'pay_time'=>time(),'trade_no'=>$trade_no],['order_sn'=>$order_sn]);
				return $res;
			}
		}
		//电费预存
		else if ($type == 'electric_recharge') { 
			$order = ElectricOrder::find()->where(['order_sn'=>$order_sn,'money'=>$total_fee,'order_status'=>1,'pay_status'=>1])->one();
			//判断电表号是否为空，不为空则调取第三方电费在线充值接口
			if (!empty($order['ammeter_id'])) {
				$ret = $this->thirdRechargeOnline($order['order_sn'],$order['money'],$order['ammeter_id']);
				if ($ret) {
					$res = ElectricOrder::updateAll(['order_status'=>3,'pay_status'=>2,'pay_type'=>2,'pay_time'=>time(),'send_time'=>time(),'trade_no'=>$trade_no],['order_sn'=>$order_sn]);
					return $res;
				}
				return $ret;
			}
			if ($order) {
				/*
				 * 后台订单滚动提醒
				*/
				$m = new OrderRemind();
				$m->add_time=time();
				$m->house_id=$order['house_id'];
				$m->order_id=$order['order_id'];
				$m->remind_type=1;
				$m->seat_id=$order['seat_id'];
				$m->room_num=$order['room_num'];
				$m->money=$order['money'];
				$m->user_id=$order['user_id'];
				$m->save();
				$res = ElectricOrder::updateAll(['order_status'=>2,'pay_status'=>2,'pay_type'=>2,'pay_time'=>time(),'trade_no'=>$trade_no],['order_sn'=>$order_sn]);
				return $res;
			}
		}
		//水费预存
		else if ($type == 'water_pay') {
			$order = WaterPayment::find()->where(['order_sn'=>$order_sn,'water_fee'=>$total_fee,'status'=>1])->one();
			if ($order) {
				$res = WaterPayment::updateAll(['status'=>2,'pay_type'=>2,'water_time'=>time(),'trade_no'=>$trade_no],['order_sn'=>$order_sn]);
				$account = UserAccount::find()->where(['account_id'=>$order['account_id']])->asArray()->one();
				WaterBase::updateAll(['water_type'=>1],['house_id'=>$account['house_id'],'seat_id'=>$account['seat_id'],'room_num'=>$account['room_num'],'status'=>1]);
				return $res;
			}
		}
		//物业费预存
		else if ($type == 'property_pay') {
			$order = PropertyPay::find()->where(['order_sn'=>$order_sn,'money'=>$total_fee,'status'=>1])->one();
			if ($order) {
				$res = PropertyPay::updateAll(['status'=>2,'pay_type'=>2,'pay_time'=>time(),'trade_no'=>$trade_no],['order_sn'=>$order_sn]);
				return $res;
			}
		}
		return 0;
	}

	/**
	 * 第三方电费在线充值
	 * @Author   tml
	 * @DateTime 2018-01-29
	 * @param    [type]     $order_sn   [description]
	 * @param    [type]     $money      [description]
	 * @param    [type]     $ammeter_id [description]
	 * @return   [type]                 [description]
	 */
	public function thirdRechargeOnline($order_sn,$money,$ammeter_id)
	{
		$url = \Yii::$app->params['third_url'] . '/setPowerByStudentID';
		$money = $money*100;
		$str = 'studentID=0&AmMeter_ID='.$ammeter_id.'&money='.$money.'&orderNo='.$order_sn;
		$data = $str.'&sign='.md5($str).'&LoginName=xywl&Password=xywl';
        $ret  = CURLUtils::_request($url, false, 'POST', $data);
        $xml  = simplexml_load_string($ret);
        $result = $xml->result;
        return (string)$result;
	}
}


class WxPayNotifyCallBack extends \WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new \WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = \WxPayApi::orderQuery($input);
		\Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		\Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "微信支付订单号不存在";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		//回调成功，处理订单信息
		if (!array_key_exists('out_trade_no',$data)) {
			$msg = '商户系统内部订单号不存在';
			return false;
		}
		//回调成功，判断订单金额
		if (!array_key_exists('total_fee',$data)) {
			$msg = '支付总金额不存在';
			return false;
		}
		$order_sn  = $data['out_trade_no'];
		$total_fee = bcdiv($data['total_fee'],100,2);

		$res = $this->wxpayUpdateOrderStatus($order_sn,$total_fee,$data['attach']);
		//微信
		\Log::DEBUG("wxpay res:" . $res);
		if ($res) {
		    if($data['attach']=='parking_payment'){
                $parking_payment = ParkingPayment::find()->where(array('order_sn'=>$order_sn))->one();
                $user1 = User::find()->where(array('id'=>$parking_payment['user_id']))->one();
                $mobiles = $user1['Tell'];
                $content = '您在'.date("Y-m-d H:i:s",time()).'，缴纳停车费用:'.$total_fee.'元。【兴业APP】';
                MessageUtil::paymentnotice($mobiles,$content);
            }elseif ($data['attach']=='electric_recharge'){
                $electric_recharge = ElectricOrder::find()->where(array('order_sn'=>$order_sn))->one();
                $user2 = User::find()->where(array('id'=>$electric_recharge['user_id']))->one();
                $mobiles = $user2['Tell'];
                $content = '您在'.date("Y-m-d H:i:s",time()).'，缴纳电费费用:'.$total_fee.'元。【兴业APP】';
                MessageUtil::paymentnotice($mobiles,$content);
            }else{
                $water_pay = WaterPayment::find()->where(array('order_sn'=>$order_sn))->one();
                $user3 = User::find()->where(array('id'=>$water_pay['user_id']))->one();
                $mobiles = $user3['Tell'];
                $content = '您在'.date("Y-m-d H:i:s",time()).'，缴纳水费费用:'.$total_fee.'元。【兴业APP】';
                MessageUtil::paymentnotice($mobiles,$content);
            }
			return true;
		}
		return false;
	}

	/**
	 * 第三方电费在线充值
	 * @Author   tml
	 * @DateTime 2018-01-29
	 * @param    [type]     $order_sn   [description]
	 * @param    [type]     $money      [description]
	 * @param    [type]     $ammeter_id [description]
	 * @return   [type]                 [description]
	 */
	public function thirdRechargeOnline($order_sn,$money,$ammeter_id)
	{
		$url = \Yii::$app->params['third_url'] . '/setPowerByStudentID';
		$money = $money*100;
		$str = 'studentID=0&AmMeter_ID='.$ammeter_id.'&money='.$money.'&orderNo='.$order_sn;
		$data = $str.'&sign='.md5($str).'&LoginName=xywl&Password=xywl';
        $ret  = CURLUtils::_request($url, false, 'POST', $data);
        $xml  = simplexml_load_string($ret);
        $result = $xml->result;
        return (string)$result;
	}

	/**
	 * 微信支付更新订单状态
	 * @Author   tml
	 * @DateTime 2018-01-29
	 * @param    [type]     $order_sn  [description]
	 * @param    [type]     $total_fee [description]
	 * @param    [type]     $type      [description]
	 * @return   [type]                [description]
	 */
	public function wxpayUpdateOrderStatus($order_sn,$total_fee,$type){
		//处理预支付订单状态
		$pre_payment = PrePayment::find()->where(['order_sn'=>$order_sn,'pay_fee'=>$total_fee])->one();
		if (empty($pre_payment)) {
			$msg = '商户系统预支付订单不存在';
			return false;
		}
		if ($pre_payment['status'] == 1) {
			$msg = '订单已支付';
			return true;
		}
		if ($pre_payment['status'] == 0) {
			//开启事务
			$transaction = \Yii::$app->db->beginTransaction();

			$res = PrePayment::updateAll(['status'=>1,'pay_time'=>time()],['pre_id'=>$pre_payment['pre_id']]);
			if (!$res) {
				$transaction->rollback();
				$msg = '更新预支付订单状态失败';
				return false;
			}
			//停车缴费
			if ($type == 'parking_payment') {
				$res1 = ParkingPayment::updateAll(['status'=>2,'pay_type'=>1,'pay_time'=>time()],['order_sn'=>$order_sn]);
				if (!$res1) {
					$transaction->rollback();
					$msg = '更新停车缴费订单状态失败';
					return false;
				}
			} 
			//电费预存
			else if ($type == 'electric_recharge') { 
				$order = ElectricOrder::find()->where(['order_sn'=>$order_sn,'money'=>$total_fee,'order_status'=>1,'pay_status'=>1])->one();
				if (!empty($order['ammeter_id'])) {
					$ret = $this->thirdRechargeOnline($order['order_sn'],$order['money'],$order['ammeter_id']);
					if (!$ret) {
						$transaction->rollback();
						$msg = '调用第三方充值接口失败';
						return false;
					}
					$res2 = ElectricOrder::updateAll(['order_status'=>3,'pay_status'=>2,'pay_type'=>1,'pay_time'=>time(),'send_time'=>time()],['order_sn'=>$order_sn]);
					if (!$res2) {
						$transaction->rollback();
						$msg = '更新电费预存订单状态失败';
						return false;
					}
				} else {
				/*
				 * 后台订单滚动提醒
				*/
					$m = new OrderRemind();
					$m->add_time=time();
					$m->house_id=$order['house_id'];
					$m->order_id=$order['order_id'];
					$m->remind_type=1;
					$m->seat_id=$order['seat_id'];
					$m->room_num=$order['room_num'];
					$m->money=$order['money'];
					$m->user_id=$order['user_id'];
					$m->save();
					$res1 = ElectricOrder::updateAll(['order_status'=>2,'pay_status'=>2,'pay_type'=>1,'pay_time'=>time()],['order_sn'=>$order_sn]);
					if (!$res1) {
						$transaction->rollback();
						$msg = '更新电费预存订单状态失败';
						return false;
					}
				}
				
			}
			//水费预存
			else if ($type == 'water_pay') {
				$order = WaterPayment::find()->where(['order_sn'=>$order_sn])->one();
				if ($order) {
					$res = WaterPayment::updateAll(['status'=>2,'pay_type'=>1,'water_time'=>time()],['order_sn'=>$order_sn]);
					$account = UserAccount::find()->where(['account_id'=>$order['account_id']])->asArray()->one();
					WaterBase::updateAll(['water_type'=>1],['house_id'=>$account['house_id'],'seat_id'=>$account['seat_id'],'room_num'=>$account['room_num'],'status'=>1]);
				}else{
					$transaction->rollback();
					$msg = '更新水费预存订单状态失败';
					return false;
				}
			}
			//物业费预存
			else if ($type == 'property_pay') {
				$order = PropertyPay::find()->where(['order_sn'=>$order_sn])->one();
				if ($order) {
					$res = PropertyPay::updateAll(['status'=>2,'pay_type'=>1,'pay_time'=>time()],['order_sn'=>$order_sn]);
					if (!$res) {
						$transaction->rollback();
						$msg = '更新物业费预存订单状态失败';
						return false;
					}
				}
			}
			$transaction->commit();
		}
		return true;
	}
}