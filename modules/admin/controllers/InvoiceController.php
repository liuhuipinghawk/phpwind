<?php

namespace app\modules\admin\controllers;

use app\models\Admin\Invoice;
use Yii;
use yii\data\Pagination;

class InvoiceController extends CommonController
{
    public function actionIndex()
    {
        $this->layout = 'layout1';
        $title = empty(Yii::$app->request->get()['title']) ? '' : Yii::$app->request->get()['title'];
        $mobile = empty(Yii::$app->request->get()['mobile']) ? '' : Yii::$app->request->get()['mobile'];
        $type = empty(Yii::$app->request->get()['type']) ? '' : Yii::$app->request->get()['type'];
        $jquery = Invoice::find()->select('u.TrueName,invoice.*')->leftJoin('user u','u.id = invoice.user_id');
        if(!empty($title)){
            $jquery = $jquery->andWhere(['like','title',$title]);
        }
        if(!empty($mobile)){
            $jquery = $jquery->andWhere(['like','mobile',$mobile]);
        }
        if(!empty($type)){
            $jquery = $jquery->andWhere(['like','type',$type]);
        }
        $count = $jquery->count();
        $pagination = new Pagination(['totalCount'=>$count]);
        $data = $jquery
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('invoice.id desc')
            ->asArray()
            ->all();
        return $this->render('index',[
            'data' => $data,
            'pagination'=>$pagination
        ]);
    }
    public function actionDet(){
        $op_id = empty(Yii::$app->request->post()['op_id']) ? 0 : Yii::$app->request->post()['op_id'];
        $res = Invoice::deleteAll(['id'=>$op_id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }
    public function actionDetails(){
        $this->layout=false;
        $id = empty(Yii::$app->request->get()['invoice_id']) ? 0 : Yii::$app->request->get()['invoice_id'];
        if (empty($id)) {
            echo '没有发票';exit;
        }
        $res = Invoice::find()->where(['id'=>$id])->asArray()->one();
        return $this->render('details',[
            'res'  => $res
        ]);
    }
}
