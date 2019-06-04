<?php
/**
 * User: qilin
 * Date: 2018/1/11
 * Time: 10:18
 */
namespace app\modules\API\controllers;

use app\models\Admin\House;
use app\models\Admin\UserAccount;
use app\models\Admin\WaterBase;
use app\models\Admin\User;
use app\models\Admin\WaterPayment;
use app\common\wappay\Wxpay;
use app\common\wappay\Alipay;

Class WaterBaseController extends TmlController{

    /**
     * 水费订单
     */
    public function actionOrder(){
        $account_id = empty($this->post['account_id']) ? 0 : $this->post['account_id'];
        $user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
        if (!$user_id || !$account_id) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
        }
        $user = User::find()->where(['id'=>$user_id])->asArray()->one();
        if (!$user) {
            echo json_encode(['status'=>-200,'message'=>'用户不存在','code'=>'']);exit;
        }
        $account = UserAccount::find()->where(['account_id'=>$account_id])->asArray()->one();
        if (!$account) {
            echo json_encode(['status'=>-200,'message'=>'账户信息不存在','code'=>'']);exit;
        }
        if($account['house_id'] == 50){
            echo json_encode(['status'=>-200,'message'=>'抱歉，水费缴费功能暂不开放，如有疑问，请前往客服中心详询','code'=>'']);exit;
        }
        $house_id = House::find()->where(['id'=>$account['house_id']])->asArray()->one();
        $seat_id = House::find()->where(['id'=>$account['seat_id']])->asArray()->one();
        $room_num = WaterBase::find()->where(['house_id'=>$account['house_id'],'seat_id'=>$account['seat_id'],'room_num'=>$account['room_num'],'status'=>1,'water_type'=>0])->asArray()->one();
        if (!$house_id) {
            echo json_encode(['status'=>-200,'message'=>'楼盘不存在','code'=>'']);exit;
        }
        if (!$seat_id) {
            echo json_encode(['status'=>-200,'message'=>'座号不存在','code'=>'']);exit;
        }
        if (!$room_num) {
            $old_order = WaterPayment::find()->select('water_time as old_time,water_fee as old_money')->where(['user_id'=>$user_id,'status'=>2])->orderBy('order_id desc')->asArray()->one();
            if(!$old_order){
                $old_order['order_status'] = 3;
                $old_order['old_time'] = "";
                $old_order['old_money'] = "";
            }else{
                $old_order['order_status'] = 2;
                $old_order['old_time'] = empty($old_order['old_time']) ? '--' : date('Y-m-d',$old_order['old_time']);
            }
            echo json_encode(['status'=>200,'message'=>'此房间不需缴纳水费','code'=>$old_order]);exit;
        }
        $data = (new \yii\db\Query())
            ->select('b.*,sum(b.month_amount) as money,sum(b.month_dosage) as dosage,h1.housename as house_name,h2.housename as seat_name')
            ->from('water_base b')
            ->leftJoin('house h1','b.house_id=h1.id')
            ->leftJoin('house h2','b.seat_id=h2.id')
            ->where(['b.house_id'=>$account['house_id'],'b.seat_id'=>$account['seat_id'],'b.room_num'=>$account['room_num'],'b.status'=>1,'b.water_type'=>0])
            ->orderBy('b.id desc')
            ->one();
        if ($data) {
            $old_time = WaterPayment::find()->where(['user_id'=>$user_id,'status'=>2])->orderBy('order_id desc')->asArray()->one();
            if(!$old_time){
                $old_time = "";
            }
            $data['order_status'] = 1;
            $data['create_time'] = empty($data['create_time']) ? '--' : date('Y-m-d H:i:s',$data['create_time']);
            $data['old_time'] = empty($old_time['water_time']) ? '--' : date('Y-m-d',$old_time['water_time']);
            echo json_encode(['status'=>200,'message'=>'success','code'=>$data]);exit;
        }
        echo json_encode(['status'=>-200,'message'=>'不需缴纳水费','code'=>'']);exit;
    }

    /*
     * 水费缴费
     */
    public function actionPay(){
        $user_id  = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
        $account_id = empty($this->post['account_id']) ? 0 : $this->post['account_id'];
        $money    = empty($this->post['money']) ? 0 : $this->post['money'];
        $pay_type = empty($this->post['pay_type']) ? 0 : $this->post['pay_type'];
        $invoice_type = empty($this->post['invoice_type']) ? 0 : $this->post['invoice_type'];
        $invoice_name = empty($this->post['invoice_name']) ? '' : $this->post['invoice_name'];
        $invoice_num  = empty($this->post['invoice_num']) ? '' : $this->post['invoice_num'];
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
        if (empty($user_id) || empty($account_id) || empty($pay_type)) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>(object)[]]);exit;
        }
        $account = UserAccount::find()->where(['account_id'=>$account_id])->asArray()->one();
        if (empty($account)) {
            echo json_encode(['status'=>-200,'message'=>'账户不存在','code'=>(object)[]]);exit;
        }
        if($account['house_id'] == 50){
            echo json_encode(['status'=>-200,'message'=>'抱歉，水费缴费功能暂不开放，如有疑问，请前往客服中心详询','code'=>'']);exit;
        }
        $order = (new \yii\db\Query())
            ->select('sum(month_amount) as money,sum(month_dosage) as dosage')
            ->from('water_base')
            ->where(['house_id'=>$account['house_id'],'seat_id'=>$account['seat_id'],'room_num'=>$account['room_num'],'status'=>1,'water_type'=>0])
            ->orderBy('id desc')
            ->one();
        if($money !== $order['money']){
            echo json_encode(['status'=>-200,'message'=>'金额不正确','code'=>(object)[]]);exit;
        }
        $house_sort = House::find()->select('sort')->where(['id'=>$account['house_id']])->scalar();
        $order_sn = $house_sort.date('YmdHis',time()).rand(1000,9999);
        $model = new WaterPayment();
        $model->invoice_type = $invoice_type;
        if ($invoice_type != 0) {
            $model->invoice_name = $invoice_name;
            $model->invoice_num  = $invoice_num;
        }
        $model->order_sn = $order_sn;
        $model->account_id = $account_id;
        $model->user_id  = $user_id;
        $model->water_consumption = $order['dosage'];
        $model->water_fee = $money;
        $model->create_time = time();
        $model->status  = 1;

        $res = $model->save();
        if (!$res) {
            echo json_encode(['status'=>-200,'message'=>'水费预存订单创建失败','code'=>(object)[]]);exit;
        }

        $body = '生活缴费-水费预存';

        if ($pay_type == 1) { //微信支付
            $wxpay = new Wxpay();
            $res = $wxpay->wxUnifiedOrder($body,$order_sn,$money,'water_pay');
            if ($res['status'] == 200) {
                $res['data']['order_sn'] = $order_sn;
                echo json_encode(['status'=>200,'message'=>'SUCCESS','code'=>$res['data']]);exit;
            }
            echo json_encode(['status'=>-200,'message'=>$res['msg'],'code'=>(object)[]]);exit;
        } else if ($pay_type == 2) { //支付宝支付
            $alipay = new Alipay();
            $res = $alipay->alipay($body,$order_sn,$money,'water_pay');
            echo json_encode(['status'=>200,'message'=>'SUCCESS','code'=>['ali_order_info'=>$res,'order_sn'=>$order_sn]]);exit;
        }
    }
}