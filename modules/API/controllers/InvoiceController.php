<?php

namespace app\modules\API\controllers;

use app\models\Admin\Invoice;

class InvoiceController extends TmlController
{
    public function actionIndex()
    {
        $user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
        if (!$user_id) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
        }
        $data = Invoice::find()->where(['user_id'=>$user_id])->orderBy('sort desc,id desc')->asArray()->all();
        echo json_encode(['status'=>200,'message'=>'成功','code'=>$data]);exit;
    }
    public function actionSort(){
        $id = empty($this->post['id']) ? 0 : $this->post['id'];
        $ids = empty($this->post['ids']) ? 0 : $this->post['ids'];
        if (!$id) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
        }
        if($ids){
            $data = Invoice::updateAll(['sort'=>0],['id'=>$ids]);
        }
        $data = Invoice::updateAll(['sort'=>1],['id'=>$id]);
        if($data !==false){
            echo json_encode(['status'=>200,'message'=>'成功']);exit;
        }
        echo json_encode(['status'=>-200,'message'=>'失败']);exit;
    }
    public function actionAdd(){
        $data = $this->post;
        if($data == "" || $data == false){
            return json_encode(['status'=>-200,'message'=>'参数错误']);
        }
        $data['create_time'] = time();
        $m = new Invoice();
        $m->setAttributes($data,false);
        if (!$m->save()) {
            return json_encode(['status'=>-200,'message'=>$m->getFirstErrors()]);
        }
        return json_encode(['status'=>200,'message'=>'成功']);
    }
    public function actionUpdate(){
        $data = $this->post;
        if($data == "" || $data == false){
            return json_encode(['status'=>-200,'message'=>'参数错误']);
        }
        $data['create_time'] = time();
        $m = new Invoice();
        $res = $m->updateAll($data,['id'=>$data['id']]);
        if (!$res) {
            return json_encode(['status'=>-200,'message'=>'失败']);
        }
        return json_encode(['status'=>200,'message'=>'成功']);
    }
    public function actionDel(){
        $data = $this->post;
        if($data['id'] == "" || $data['id'] == false){
            return json_encode(['status'=>-200,'message'=>'参数错误']);
        }
        $res = Invoice::deleteAll(['id'=>$data['id']]);
        if (!$res) {
            return json_encode(['status'=>-200,'message'=>'失败']);
        }
        return json_encode(['status'=>200,'message'=>'成功']);
    }
}
