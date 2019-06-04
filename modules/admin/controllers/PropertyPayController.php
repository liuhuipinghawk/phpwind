<?php

namespace app\modules\admin\controllers;

use app\models\Admin\AccountBase;
use app\models\Admin\House;
use app\modules\API\controllers\TmlController;
use Yii;
use app\models\Admin\PropertyPay;
use yii\data\Pagination;

/**
 * PropertyPayController implements the CRUD actions for PropertyPay model.
 */
class PropertyPayController extends TmlController
{
    public function actionIndex(){
        $this->layout = 'layout1';
        $house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
        $seat_id  = empty($this->get['seat_id']) ? 0 : $this->get['seat_id'];
        $room_num = empty($this->get['room_num']) ? 0 : $this->get['room_num'];
        $status = empty($this->get['status']) ? 0 : $this->get['status'];
        $type = empty($this->get['type']) ? 0 : $this->get['type'];
        $pay_type = empty($this->get['pay_type']) ? 0 : $this->get['pay_type'];
        $pagenum  = empty($this->get['pagenum']) ? 1 : $this->get['pagenum'];
        $con=[];
        if (!empty($house_id)) {
            $con['pp.house_id'] = $house_id;
        }
        if (!empty($seat_id)) {
            $con['pp.seat_id'] = $seat_id;
        }
        if (!empty($room_num)) {
            $con['pp.room'] = $room_num;
        }
        if (!empty($status)) {
            $con['pp.status'] = $status;
        }
        if (!empty($pay_type)) {
            $con['pp.pay_type'] = $pay_type;
        }
        if (!empty($type)) {
            if($type!=3){
                $con['i.type'] = $type;
            }else{
                $con['i.type'] = null;
            }
        }
        $session = Yii::$app->session;
        $session = $session['admin'];
        $lists = explode(',',$session['house_ids']);
        $query = PropertyPay::find()->select('pp.*,u.TrueName,u.Tell,ab.owner,h1.housename,h2.housename as seatname,ab.area,ab.property_fee,i.type,i.status as sta')->alias('pp')->
            leftJoin('user u','u.id = pp.user_id')->
            leftJoin('account_base ab','ab.house_id = pp.house_id and ab.seat_id = pp.seat_id and ab.room_num = pp.room')->
            leftJoin('house h1','h1.id = ab.house_id')->leftJoin('house h2','h2.id = ab.seat_id')->
            leftJoin('invoice i','i.id = pp.invoice_id')->where($con)->andWhere(['in','pp.house_id',$lists]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount'=>$count]);
        $data = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('pp.id desc')->asArray()
            ->all();
        $house = House::find()->where(['parentId'=>0])->asArray()->all();
        return $this->render('index',[
            'data'=>$data,
            'pagination' => $pagination,
            'house'=>$house,
        ]);
    }
    public function actionDel(){
        $id = empty($this->post['id']) ? 0 : $this->post['id'];
        if (empty($id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $res = PropertyPay::deleteAll(['id'=>$id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }
    public function actionInvoice(){
        $id = empty($this->post['id']) ? 0 : $this->post['id'];
        if (empty($id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $res = PropertyPay::updateAll(['invoice_type'=>1],['id'=>$id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }
    public function actionAdd(){
        $this->layout = 'layout1';
        $house = House::find()->where(['parentId'=>0])->asArray()->all();
        $num = 2000;
        $year = [];
        for($i=$num;$i<2100;$i++){
            $r[] = $i;
        }
        $year = $r;
        if(Yii::$app->request->isPost){
            $data = $this->post;
            $account = AccountBase::find()->where(['house_id'=>$data['house_id'],'seat_id'=>$data['seat_id'],'room_num'=>$data['room_num']])->asArray()->one();
            if(!isset($account)){
                return json_encode(['code'=>-200,'msg'=>'添加失败,缴费账户基础信息没有这个房间']);
            }
            $pay_order = PropertyPay::find()->where(['house_id'=>$account['house_id'],'seat_id'=>$account['seat_id'],'room'=>$account['room_num'],'year'=>$data['year'],'year_status'=>$data['year_status']])->count();
            if($pay_order !=0){
                return json_encode(['code'=>-200,'msg'=>'此时间物业费已缴，请选择其他时间']);
            }if($data['money'] != ($account['property_fee'] * $account['area'] * 6)){
                return json_encode(['code'=>-200,'msg'=>'金额不正确']);
            }
            $session = \Yii::$app->session;
            $data['trade_no'] = $session['admin']['adminid'];
            $data['room'] = $data['room_num'];
            $data['create_time'] = time();
            $data['pay_time'] = $data['create_time'];
            $data['status'] = 2;
            $data['order_sn'] = date('YmdHis',time()).rand(1000,9999);
            $data['order_type'] = 2;
            $data['property_fee'] = $account['property_fee'];
            $data['area'] = $account['area'];
            $data['pay_type'] = 3;
            $m = new PropertyPay();
            $m->setAttributes($data,false);
            if (!$m->save()) {
                return json_encode(['code'=>-200,'msg'=>'添加失败']);
            }
            return json_encode(['code'=>200,'msg'=>'添加成功']);
        }
        return $this->render('add', [
            'house' => $house,
            'year'=>$year
        ]);
    }
}
