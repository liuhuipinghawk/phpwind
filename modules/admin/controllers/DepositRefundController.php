<?php
/**
 * User: qilin
 * Date: 2018/5/8
 * Time: 14:56
 */
namespace app\modules\admin\controllers;


use app\models\Admin\DepositRefund;
use app\models\Admin\House;
use yii\data\Pagination;
use yii\web\Controller;
use Yii;

Class DepositRefundController extends Controller{

    public function actionIndex(){
        $this->layout = 'layout1';
        $username = empty(Yii::$app->request->get()['username']) ? '' : Yii::$app->request->get()['username'];
        $house_id = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
        $mobile = empty(Yii::$app->request->get()['mobile']) ? '' : Yii::$app->request->get()['mobile'];
        $jquery = DepositRefund::find()->alias('d')->select('u.TrueName,d.*,h.housename,h1.housename as seatname')->
        leftJoin('user u', 'u.id = d.user_id')->leftJoin('house h', 'h.id = d.house_id')->leftJoin('house h1', 'h1.id = d.seat_id');
        if (!empty($username)) {
            $jquery = $jquery->andWhere(['like', 'd.name', $username]);
        }
        if (!empty($house_id)) {
            $jquery = $jquery->andWhere(['like', 'd.house_id', $house_id]);
        }
        if (!empty($mobile)) {
            $jquery = $jquery->andWhere(['like', 'd.mobile', $mobile]);
        }
        $count = $jquery->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $data = $jquery
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('d.id desc')
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
        $res = DepositRefund::deleteAll(['id'=>$op_id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }
    public function actionSh(){
        $op_id = empty(Yii::$app->request->post()['op_id']) ? 0 : Yii::$app->request->post()['op_id'];
        $res = DepositRefund::updateAll(['status' => 2], ['id'=>$op_id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }
}