<?php

namespace app\modules\API\controllers;

use Yii;
use app\models\Admin\Propertynotice;
use yii\data\Pagination;
use app\models\Admin\House;


class ProerynoticeController extends TmlController
{

    public function actionIndex()
    {
        $user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
            $pagenum = empty($this->post['pagenum']) ? 1 : $this->post['pagenum'];
            $status = empty($this->post['status']) ? '' : $this->post['status'];
            $house_id = empty($this->post['house_id']) ? '' : $this->post['house_id'];
            $page_size = \Yii::$app->params['APP_PAGE_SIZE'];
            if (!$user_id || !$status) {
                echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
            }
            if($status == 3){
                $all = Propertynotice::find()->where(['author'=>$user_id])->
                andwhere(array('cateId' => $status))->orderBy('pNoticeId desc')->offset(($pagenum-1)*$page_size)
                    ->limit($page_size)->asArray()->all();
        }elseif($status == 1){
            $all = Propertynotice::find()->where(['house_id'=>$house_id])->
            andwhere(array('cateId' => $status))->orderBy('pNoticeId desc')->offset(($pagenum-1)*$page_size)
                ->limit($page_size)->asArray()->all();
        }

        echo json_encode(['status'=>200,'message'=>'success','code'=>$all]);exit;
    }
    public function actionDel(){
        $id = empty(Yii::$app->request->post()['pNoticeId']) ? 0 : Yii::$app->request->post()['pNoticeId'];
        $res = Propertynotice::deleteAll(['pNoticeId'=>$id]);
        if ($res) {
            echo json_encode(['status'=>200,'message'=>'操作成功']);exit;
        }
        echo json_encode(['status'=>-200,'message'=>'操作失败']);exit;
    }
    public function actionStatus(){
        $user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
        $house_id = empty($this->post['house_id']) ? '' : $this->post['house_id'];
        $data['property'] = Propertynotice::find()->where(['house_id'=>$house_id])->andwhere(['cateId'=>1])->andwhere(['status'=>1])->count();
        $data['system'] = Propertynotice::find()->where(['author'=>$user_id])->andwhere(['cateId'=>3])->andwhere(['status'=>1])->count();
        return json_encode(['status'=>200,'message'=>'success','code'=>$data]);
    }
    public function actionDet(){

        $id = empty(Yii::$app->request->get()['pNoticeId']) ? 0 : Yii::$app->request->get()['pNoticeId'];
        Propertynotice::updateAll(['status'=>2],['pNoticeId'=>$id]);
        $res = Propertynotice::find()->where(['pNoticeId'=>$id])->asArray()->one();
        return json_encode(['status'=>200,'message'=>'success','code'=>$res]);
    }
    public function actionRead(){
        $id = empty($this->post['id']) ? 0 : $this->post['id'];
        Propertynotice::updateAll(['status'=>2],['pNoticeId'=>$id]);
        return json_encode(['status'=>200,'message'=>'success']);
    }
}
