<?php
namespace app\common\wappay;

use yii;
use app\models\Admin\PrePayment;

require_once Yii::$app->basePath.'/vendor/wappay/wxpay/lib/WxPayApi.php';
require_once Yii::$app->basePath.'/vendor/wappay/wxpay/lib/WxPayNotify.php';
require_once Yii::$app->basePath.'/vendor/wappay/wxpay/lib/log.php';

class Wxpay{
	/**
	 * 微信统一下单接口
	 * @Author   tml
	 * @DateTime 2017-12-23
	 * @param    [type]     $order_sn    [description]
	 * @param    [type]     $parking_fee [description]
	 * @return   [type]                  [description]
	 */
	public function wxUnifiedOrder($body,$order_sn,$parking_fee,$type){
		//调取微信统一下单接口
		$input = new \WxPayUnifiedOrder();
		$input->SetBody($body); //商品交易描述，eg：兴业物联-停车缴费
		$input->SetOut_trade_no($order_sn);   //商户系统内部订单号
		$input->SetTotal_fee(bcmul($parking_fee,100));   //订单总金额
		$input->SetTrade_type('APP');
		$input->SetAttach($type);
		$input->SetNotify_url('http://106.15.127.161/API/notify/wx-notify');
		$result = \WxPayApi::unifiedOrder($input);

		if(array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS") {
			//调取微信统一下单接口成功，操作预支付订单记录表
			$pre_order = PrePayment::find()->where(['order_sn'=>$order_sn])->one();
			if (!empty($pre_order)) {
				PrePayment::deleteAll(['order_sn'=>$order_sn]);
			}
			$model = new PrePayment();
			$model->prepay_id   = $result['prepay_id'];
			$model->order_sn    = $order_sn;
			$model->pay_fee     = $parking_fee;
			$model->create_time = time();
			$model->pay_type    = 1;
			$res1 = $model->save();
			if ($res1) {
				$code['appid']     = \WxPayConfig::APPID;
				$code['partnerid'] = \WxPayConfig::MCHID;
				$code['prepayid']  = $result['prepay_id'];
				$code['package']   = 'Sign=WXPay';
				$code['noncestr']  = $result['nonce_str'];
				$code['timestamp'] = time();
				$wxPayResults      = new \WxPayResults();
				$wxPayResults->FromArray($code);
				$code['sign']      = $wxPayResults->MakeSign();
				return array('status'=>200,'data'=>$code);
			}
			return array('status'=>-200,'msg'=>'创建预支付订单失败');
		}
		if ($result['return_code'] == 'FAIL') {
			return array('status'=>-200,'msg'=>$result['return_msg']);
		}
		return array('status'=>-200,'msg'=>$result['err_code_des']);
	}

	/**
	 * 微信支付订单状态查询
	 * @Author   tml
	 * @DateTime 2018-01-09
	 * @param    [type]     $out_trade_no [description]
	 * @return   [type]                   [description]
	 */
	public function wxpayOrderQuery($out_trade_no){
		$input = new \WxPayOrderQuery();
		$input->SetOut_trade_no($out_trade_no);
		$result = \WxPayApi::orderQuery($input);
		if(array_key_exists("return_code", $result) && array_key_exists("result_code", $result) && array_key_exists("trade_state", $result) && $result["return_code"] == "SUCCESS" && $result["result_code"] == "SUCCESS" && $result["trade_state"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
}