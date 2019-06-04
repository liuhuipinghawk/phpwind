<?php

namespace app\modules\admin\controllers;

use app\models\Admin\House;
use Yii;
use app\models\Admin\InOut;
use yii\web\Controller;
use yii\data\Pagination;

/**
 * InOutController implements the CRUD actions for InOut model.
 */
class InOutController extends Controller
{
    public function actionIndex()
    {
        $this->layout = 'layout1';
        $username = empty(Yii::$app->request->get()['username']) ? '' : Yii::$app->request->get()['username'];
        $house_id = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
        $mobile = empty(Yii::$app->request->get()['mobile']) ? '' : Yii::$app->request->get()['mobile'];
        $jquery = InOut::find()->select('u.TrueName,in_out.*,h.housename')->leftJoin('user u', 'u.id = in_out.user_id')->leftJoin('house h', 'h.id = in_out.house_id');
        if (!empty($username)) {
            $jquery = $jquery->andWhere(['like', 'in_out.username', $username]);
        }
        if (!empty($house_id)) {
            $jquery = $jquery->andWhere(['like', 'in_out.house_id', $house_id]);
        }
        if (!empty($mobile)) {
            $jquery = $jquery->andWhere(['like', 'in_out.mobile', $mobile]);
        }
        $count = $jquery->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $data = $jquery
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('in_out.id desc')
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
        $res = InOut::deleteAll(['id'=>$op_id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }
    public function actionSh(){
        $op_id = empty(Yii::$app->request->post()['op_id']) ? 0 : Yii::$app->request->post()['op_id'];
        $res = InOut::updateAll(['status' => 2], ['id'=>$op_id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }
}
