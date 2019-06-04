<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Admin\Propertynotice;
use yii\data\Pagination;
use app\models\Admin\House;


class ProerynoticeController extends CommonController
{

    public function actionIndex()
    {
        $this->layout = "layout1";
        $house_id = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
        $jquery = Propertynotice::find()->alias('p')->select('p.*,h.housename')->leftJoin('house h', 'h.id = p.house_id')->where(['p.cateId'=>1]);
        if (!empty($house_id)) {
            $jquery = $jquery->andWhere(['p.house_id'=> $house_id]);
        }
        $count = $jquery->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $data = $jquery
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('p.pNoticeId desc')
            ->asArray()
            ->all();
        $house = House::find()->where(['parentId' => 0])->asArray()->all();
        return $this->render('index', [
            'data' => $data,
            'pagination' => $pagination,
            'house' => $house,
            'house_id' => $house_id
        ]);
    }
    public function actionDel(){
        $op_id = empty(Yii::$app->request->post()['op_id']) ? 0 : Yii::$app->request->post()['op_id'];
        $res = Propertynotice::deleteAll(['pNoticeId'=>$op_id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }

    public function actionAdd(){
        $this->layout = 'layout1';
        $house = House::find()->where(['parentId'=>0])->asArray()->all();
        if(Yii::$app->request->isPost){
            $session = \Yii::$app->session;
            $res = Yii::$app->request->post();
            $data['author'] = $session['admin']['adminuser'];
            $data['title'] = $res['title'];
            $data['createTime'] = date("Y-m-d");
            $data['content'] = $res['content'];
            $data['cateId'] = 1;
            $data['house_id'] = $res['house_id'];
            $m = new Propertynotice();
            $m->setAttributes($data,false);
            if (!$m->save()) {
                return json_encode(['code'=>-200,'msg'=>'添加失败']);
            }
            return json_encode(['code'=>200,'msg'=>'添加成功']);
        }
        return $this->render('add', [
            'house' => $house
        ]);
    }
}
