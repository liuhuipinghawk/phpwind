<?php

namespace app\modules\API\controllers;

use app\common\wappay\Alipay;
use app\common\wappay\Wxpay;
use app\models\Admin\AccountBase;
use app\models\Admin\Invoice;
use app\models\Admin\PropertyPay;
use app\models\Admin\UserAccount;
use app\models\Admin\House;

class PropertyFeeController extends TmlController
{
    /*
     * 物业费订单
     */
    public function actionIndex()
    {
//         echo json_encode(['status'=>-200,'message'=>'抱歉，物业缴费功能暂不开放，如有疑问，请前往客服中心详询','code'=>'']);exit;
        $account_id = empty($this->post['account_id']) ? 0 : $this->post['account_id'];
        $user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
        if (!$account_id || !$user_id) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
        }
        $account = UserAccount::find()->where(['account_id'=>$account_id])->asArray()->one();
        if (!$account) {
            echo json_encode(['status'=>-200,'message'=>'账户信息不存在','code'=>'']);exit;
        }
        if($account['house_id'] == 47){
            echo json_encode(['status'=>-200,'message'=>'抱歉，物业缴费功能暂不开放，如有疑问，请前往客服中心详询','code'=>'']);exit;
        }
        $base = AccountBase::find()->where(['house_id'=>$account['house_id'],'seat_id'=>$account['seat_id'],'room_num'=>$account['room_num']])->asArray()->one();
        $data = (new \yii\db\Query())->select('ab.*,h1.housename as house_name,h2.housename as seat_name')
            ->from('account_base ab')
            ->leftJoin('house h1','h1.id=ab.house_id')
            ->leftJoin('house h2','h2.id=ab.seat_id')
            ->where(['ab.id'=>$base['id']])
            ->one();
        $res = Invoice::find()->where(['user_id'=>$user_id])->orderBy('sort desc,id desc')->asArray()->one();
        $item = [];
        $item['name'] = $data['house_name'].$data['seat_name'].'-'.$data['room_num'];
        $item['area'] = $data['area'];
        $item['property_fee'] = $data['property_fee'];
        $item['money'] = round($item['property_fee'] * $item['area'] * 6);
        if($res == false){
            $item['status'] = 0;
        }else{
            $item['status'] = $res['status'];
            $item['title'] = $res['title'];
            $item['invoice_id'] = $res['id'];
            if($item['status'] == 1){
                $item['mobile'] = $res['mobile'];
            }else{
                $item['number'] = $res['number'];
                $item['address'] = $res['address'];
                $item['tell'] = $res['tell'];
            }
        }
        return json_encode(['status'=>200,'message'=>'成功','code'=>$item]);
    }
    /*
     * 物业费缴费
     */
    public function actionPay(){
//         echo json_encode(['status'=>-200,'message'=>'抱歉，物业缴费功能暂不开放，如有疑问，请前往客服中心详询','code'=>(object)[]]);exit;
        $user_id  = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
        $account_id = empty($this->post['account_id']) ? 0 : $this->post['account_id'];
        $money    = empty($this->post['money']) ? 0 : $this->post['money'];
        $pay_type = empty($this->post['pay_type']) ? 0 : $this->post['pay_type'];
        $invoice_id = empty($this->post['invoice_id']) ? 0 : $this->post['invoice_id'];
        $year = empty($this->post['year']) ? 0 : $this->post['year'];
        $year_status = empty($this->post['year_status']) ? 0 : $this->post['year_status'];
        if (empty($user_id) || empty($account_id) || empty($pay_type) || empty($money) || empty($year) || empty($year_status)) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>(object)[]]);exit;
        }
        $account = UserAccount::find()->where(['account_id'=>$account_id])->asArray()->one();
        if (empty($account)) {
            echo json_encode(['status'=>-200,'message'=>'账户不存在','code'=>(object)[]]);exit;
        }
        if($account['house_id'] == 47){
            echo json_encode(['status'=>-200,'message'=>'抱歉，物业缴费功能暂不开放，如有疑问，请前往客服中心详询','code'=>'']);exit;
        }
        $pay_order = PropertyPay::find()->where(['house_id'=>$account['house_id'],'seat_id'=>$account['seat_id'],'room'=>$account['room_num'],'year'=>$year,'year_status'=>$year_status,'status'=>2])->count();
        if($pay_order !=0){
            return json_encode(['status'=>-200,'message'=>'此时间物业费已缴，请选择其他时间','code'=>(object)[]]);
        }
        $order = AccountBase::find()->where(['house_id'=>$account['house_id'],'seat_id'=>$account['seat_id'],'room_num'=>$account['room_num']])->asArray()->one();
        if($money != round($order['property_fee'] * $order['area'] * 6)){
            echo json_encode(['status'=>-200,'message'=>'金额不正确','code'=>(object)[]]);exit;
        }
        if($money == 0){
            return json_encode(['status'=>-200,'message'=>'不需缴纳物业费','code'=>(object)[]]);
        }
        // $order_sn = date('YmdHis',time()).rand(1000,9999);

        $house_sort = House::find()->select('sort')->where(['id'=>$account['house_id']])->scalar();
        $order_sn = $house_sort.date('YmdHis',time()).rand(1000,9999);

        $model = new PropertyPay();
        $model->order_sn = $order_sn;
        $model->account_id = $account_id;
        $model->user_id  = $user_id;
        $model->pay_type = $pay_type;
        $model->money = $money;
        $model->property_fee = $order['property_fee'];
        $model->create_time = time();
        $model->invoice_id = $invoice_id;
        $model->year = $year;
        $model->year_status = $year_status;
        $model->area = $order['area'];
        $model->house_id = $account['house_id'];
        $model->seat_id = $account['seat_id'];
        $model->room = $account['room_num'];

        $res = $model->save();

        if (!$res) {
            echo json_encode(['status'=>-200,'message'=>'物业费预存订单创建失败','code'=>(object)[]]);exit;
        }

        $body = '生活缴费-物业费预存';

        if ($pay_type == 1) { //微信支付
            $wxpay = new Wxpay();
            $res = $wxpay->wxUnifiedOrder($body,$order_sn,$money,'property_pay');
            if ($res['status'] == 200) {
                $res['data']['order_sn'] = $order_sn;
                echo json_encode(['status'=>200,'message'=>'SUCCESS','code'=>$res['data']]);exit;
            }
            echo json_encode(['status'=>-200,'message'=>$res['msg'],'code'=>(object)[]]);exit;
        } else if ($pay_type == 2) { //支付宝支付
            $alipay = new Alipay();
            $res = $alipay->alipay($body,$order_sn,$money,'property_pay');
            echo json_encode(['status'=>200,'message'=>'SUCCESS','code'=>['ali_order_info'=>$res,'order_sn'=>$order_sn]]);exit;
        }
    }
    public function actionOrderlist(){
        $user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
        if (empty($user_id)) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>(object)[]]);exit;
        }
        $data = PropertyPay::find()->select('pp.account_id,pp.order_sn,pp.pay_time,pp.money,pp.pay_type,h1.housename as house_name,h2.housename as seat_name,a.room_num')->alias('pp')
            ->leftJoin('user_account a','a.account_id=pp.account_id')
            ->leftJoin('house h1','a.house_id=h1.id')
            ->leftJoin('house h2','a.seat_id=h2.id')
            ->where(['pp.status'=>2,'pp.user_id'=>$user_id])->orderBy('pp.id desc')->asArray()->all();
        if ($data) {
            foreach ($data as $k => $v) {
                $data[$k]['pay_time'] = empty($v['pay_time']) ? '--' : date('Y-m-d H:i:s',$v['pay_time']);
            }
        }
        return json_encode(['status'=>200,'message'=>'成功','code'=>$data]);
    }

}
