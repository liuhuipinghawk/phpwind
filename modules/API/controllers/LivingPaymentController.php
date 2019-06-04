<?php

namespace app\modules\API\controllers;

use yii\db\Expression;
use app\models\Admin\UserAccount;
use app\models\Admin\AccountBase;
use app\models\Admin\ThirdAccountBase;
use app\models\Admin\ElectricOrder;
use app\models\Admin\House;
use app\common\wappay\Wxpay;
use app\common\wappay\Alipay;
use app\util\CURLUtils;

/**
 * 生活缴费 tml 20180106
 */
class LivingPaymentController extends TmlController
{
	/**
	 * 添加账户
	 * @Author   tml
	 * @DateTime 2018-01-06
	 * @return   [type]     [description]
	 */
	public function actionAddAccount()
	{
		$user_id  = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
		$house_id = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
		$seat_id  = empty($this->post['seat_id']) ? 0 : $this->post['seat_id'];
		$room_num = empty($this->post['room_num']) ? '' : $this->post['room_num'];

		if (empty($user_id) || empty($house_id) || empty($seat_id) || empty($room_num)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>(object)[]]);exit;
		}
		//查询缴费账户基础信息表
		$account_base = AccountBase::find()->where(['house_id'=>$house_id,'seat_id'=>$seat_id,'room_num'=>$room_num])->one();
		//如果house_id存在于配置参数中，则去查询第三方缴费账户基础信息表
		if (in_array($house_id,\Yii::$app->params['third_config'])) {
			$account_base = ThirdAccountBase::find()->where(['house_id'=>$house_id,'seat_id'=>$seat_id,'room_name'=>$room_num])->one();
		}

		if (empty($account_base)) {
			echo json_encode(['status'=>-200,'message'=>'账户信息不存在','code'=>(object)[]]);exit;
		}

		$user_account = UserAccount::find()->where(['house_id'=>$house_id,'seat_id'=>$seat_id,'room_num'=>$room_num,'user_id'=>$user_id,'is_del'=>0])->all();

		if (empty($user_account)) {
			$model = new UserAccount();
			$model->user_id  = $user_id;
			$model->house_id = $house_id;
			$model->seat_id  = $seat_id;
			$model->room_num = $room_num;
			$model->rate     = empty($account_base['rate']) ? 1 : $account_base['rate'];
			$model->owner    = empty($account_base['owner']) ? '' : $account_base['owner'];
			$model->ammeter_id = empty($account_base['ammeter_id']) ? 0 : $account_base['ammeter_id'];
			$model->add_time = time();
			$res = $model->save();
			// var_dump($model->getErrors());exit;
			$new_id = $model->account_id;
			if ($res) {
				$user_account = (new \yii\db\Query())
					->select('a.account_id,a.house_id,a.seat_id,a.room_num,a.rate,h1.housename as house_name,h2.housename as seat_name,a.is_open,a.ammeter_id')
					->from('user_account a')
					->leftJoin('house h1','a.house_id=h1.id')
					->leftJoin('house h2','a.seat_id=h2.id')
					->where(['a.account_id'=>$new_id])
					->one();
				echo json_encode(['status'=>200,'message'=>'账户添加成功','code'=>$user_account]);exit;
			}
			echo json_encode(['status'=>-200,'message'=>'账户添加失败','code'=>(object)[]]);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'账户已存在，不能重复添加','code'=>(object)[]]);exit;
	}

	/**
	 * 账户列表
	 * @Author   tml
	 * @DateTime 2018-01-06
	 * @return   [type]     [description]
	 */
	public function actionAccountList()
	{
		$user_id = empty($this->get['user_id']) ? 0 : $this->get['user_id'];
		if (empty($user_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>(object)[]]);exit;
		}
		$list = (new \yii\db\Query())
			->select('a.account_id,a.house_id,a.seat_id,a.room_num,a.rate,a.is_open,h1.housename as house_name,h2.housename as seat_name,a.ammeter_id')
			->from('user_account a')
			->leftJoin('house h1','a.house_id=h1.id')
			->leftJoin('house h2','a.seat_id=h2.id')
			->where(['a.user_id'=>$user_id,'is_del'=>0])
			->orderBy('a.account_id desc')
			->all();
		echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;
	}

	/**
	 * 删除账户
	 * @Author   tml
	 * @DateTime 2018-01-06
	 * @return   [type]     [description]
	 */
	public function actionDelAccount()
	{
		$account_id = empty($this->post['account_id']) ? 0 : $this->post['account_id'];
		if (empty($account_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
		}
		$account = UserAccount::find()->where(['account_id'=>$account_id,'is_del'=>0])->one();
		if (empty($account)) {
			echo json_encode(['status'=>-200,'message'=>'账户不存在','code'=>'']);exit;
		}
		$res = UserAccount::updateAll(['is_del'=>1],['account_id'=>$account_id,'is_del'=>0]);
		if ($res) {
			echo json_encode(['status'=>200,'message'=>'删除成功','code'=>'']);exit;
		}
		echo json_encode(['status'=>200,'message'=>'删除失败','code'=>'']);exit;
	}

	/**
	 * 获取账户缴费状态
	 * @Author   tml
	 * @DateTime 2018-01-24
	 * @return   [type]     [description]
	 */
	public function actionAccountValid()
	{
		$account_id = empty($this->post['account_id']) ? 0 : $this->post['account_id'];
		if (empty($account_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>(object)[]]);exit;
		}
		$is_open = UserAccount::find()->select('is_open')->where(['account_id'=>$account_id])->scalar();
		echo json_encode(['status'=>200,'message'=>'success','code'=>['is_open'=>$is_open]]);exit;
	}

	/**
	 * 电费充值
	 * @Author   tml
	 * @DateTime 2018-01-09
	 * @return   [type]     [description]
	 */
	public function actionElectricRecharge()
	{
		$user_id    = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
		$account_id = empty($this->post['account_id']) ? 0 : $this->post['account_id'];
		$money      = empty($this->post['money']) ? 0 : $this->post['money'];
		$pay_type   = empty($this->post['pay_type']) ? 0 : $this->post['pay_type'];
		$invoice_type = empty($this->post['invoice_type']) ? 0 : $this->post['invoice_type'];
		$invoice_name = empty($this->post['invoice_name']) ? '' : $this->post['invoice_name'];
		$invoice_num  = empty($this->post['invoice_num']) ? '' : $this->post['invoice_num'];
		$remark = empty($this->post['remark']) ? '' : $this->post['remark'];

		if (empty($user_id) || empty($account_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>(object)[]]);exit;
		}
		$account = UserAccount::find()->where(['account_id'=>$account_id])->asArray()->one();
		if (empty($account)) {
			echo json_encode(['status'=>-200,'message'=>'账户不存在','code'=>(object)[]]);exit;
		}
		if (strlen($remark) > 255) {
			echo json_encode(['status'=>-200,'message'=>'备注信息不可超过255个字符','code'=>(object)[]]);exit;
		}

		$house_id = $account['house_id'];
		$seat_id  = $account['seat_id'];
		$room_num = $account['room_num'];
		$rate     = $account['rate'];
		$ammeter_id = $account['ammeter_id'];

		if ($rate < 1) {
			echo json_encode(['status'=>-200,'message'=>'电表倍率不正确','code'=>(object)[]]);exit;
		}

		// if ($money < 50) {
		// 	echo json_encode(['status'=>-200,'message'=>'充值金额不能小于50元','code'=>(object)[]]);exit;
		// }
		
		if ($money % $rate != 0) {
			echo json_encode(['status'=>-200,'message'=>'充值金额和倍率表不匹配','code'=>(object)[]]);exit;
		}

		if (in_array($invoice_type,[1,2])) {
			if (empty($invoice_name) || empty($invoice_num)) {
				echo json_encode(['status'=>-200,'message'=>'发票信息不全','code'=>(object)[]]);exit;
			}
			if ($invoice_type == 1) {
				if (!$this->checkMobile($invoice_num)) {
					echo json_encode(['status'=>-200,'message'=>'手机号不正确','code'=>(object)[]]);exit;
				}
			}
		}
		$house_sort = House::find()->select('sort')->where(['id'=>$house_id])->scalar();
		$order_sn = $house_sort.date('YmdHis',time()).rand(1000,9999);

		$model = new ElectricOrder();
		$model->order_sn = $order_sn;
		$model->account_id = $account_id;
		$model->ammeter_id = $ammeter_id;
		$model->house_id = $house_id;
		$model->seat_id  = $seat_id;
		$model->room_num = $room_num;
		$model->user_id  = $user_id;
		$model->rate     = $rate;
		$model->money    = $money;
		$model->add_time = time();
		$model->invoice_type = $invoice_type;
		$model->remark = $remark;
		if ($invoice_type != 0) {
			$model->invoice_name = $invoice_name;
			$model->invoice_num  = $invoice_num;
		}
		
		$res = $model->save();

		if (!$res) {
			echo json_encode(['status'=>-200,'message'=>'电费预存订单创建失败','code'=>(object)[]]);exit;
		}
		$house_name = House::find()->where(['id'=>$house_id])->select('housename')->scalar();
		$body = '生活缴费-'.$house_name.'-电费预存';

		if ($pay_type == 1) { //微信支付
			$wxpay = new Wxpay();
			$res = $wxpay->wxUnifiedOrder($body,$order_sn,$money,'electric_recharge');
			if ($res['status'] == 200) {
				$res['data']['order_sn'] = $order_sn;
				echo json_encode(['status'=>200,'message'=>'SUCCESS','code'=>$res['data']]);exit;
			}
			echo json_encode(['status'=>-200,'message'=>$res['msg'],'code'=>(object)[]]);exit;
		} else if ($pay_type == 2) { //支付宝支付
			// echo json_encode(['status'=>-200,'message'=>'支付宝支付暂停使用，请使用微信支付']);exit;
			$alipay = new Alipay();
			$res = $alipay->alipay($body,$order_sn,$money,'electric_recharge');
			echo json_encode(['status'=>200,'message'=>'SUCCESS','code'=>['ali_order_info'=>$res,'order_sn'=>$order_sn]]);exit;
		} 
	}

	/**
	 * 电费充值列表
	 * @Author   tml
	 * @DateTime 2018-01-10
	 * @return   [type]     [description]
	 */
	public function actionRechargeList()
	{
		$user_id = empty($this->get['user_id']) ? 0 : $this->get['user_id'];
		$pagenum = empty($this->get['pagenum']) ? 1 : $this->get['pagenum'];
		if (empty($user_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>[]]);exit;
		}

		$page_size = \Yii::$app->params['APP_PAGE_SIZE'];

		$list = (new \yii\db\Query())
			->select(new Expression('o.order_id,o.order_sn,o.house_id,o.seat_id,o.room_num,o.rate,o.money,o.pay_type,from_unixtime(o.pay_time,"%Y-%m-%d %H:%i") as pay_time,o.order_status,from_unixtime(o.send_time,"%Y-%m-%d %H:%i") as send_time,h1.housename as house_name,h2.housename as seat_name'))
			->from('electric_order o')
			->leftJoin('house h1','o.house_id=h1.id')
			->leftJoin('house h2','o.seat_id=h2.id')
			->where(['user_id'=>$user_id,'o.pay_status'=>2,'is_del'=>0])
			->offset(($pagenum-1)*$page_size)
			->limit($page_size)
			->orderBy('o.pay_time desc')
			->all();

		echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;
	}

	/**
	 * 获取电表剩余电量
	 * @Author   tml
	 * @DateTime 2018-01-29
	 * @return   [type]     [description]
	 */
	public function actionGetRestElectric()
	{
		$account_id = empty($this->post['account_id']) ? 0 : $this->post['account_id'];
		if (empty($account_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>(object)[]]);exit;
		}
		$account = UserAccount::find()->where(['account_id'=>$account_id])->one();
		if (empty($account)) {
			echo json_encode(['status'=>-200,'message'=>'账户不存在','code'=>(object)[]]);exit;
		}
		$url  = \Yii::$app->params['third_url'] . '/getReserveAM';
		$data = 'AmMeter_ID='.$account['ammeter_id'];	
        $ret  = CURLUtils::_request($url, false, 'POST', $data);
         var_dump($data);exit;
        $xml  = simplexml_load_string($ret);
        $resultInfo = $xml->resultInfo;
        if ($resultInfo->result == 1) { //成功
        	$rdata['remain_power'] = (string)$xml->remainPower;
        	$rdata['remain_name']  = (string)$xml->remainName;
        	$rdata['z_value']      = (string)$xml->ZVlaue;
        	$rdata['read_time']    = (string)$xml->readTime;
        	echo json_encode(['status'=>200,'message'=>'success','code'=>$rdata]);exit;
        }
        echo json_encode(['status'=>-200,'message'=>$resultInfo->msg,'code'=>(object)[]]);exit;
	}
}