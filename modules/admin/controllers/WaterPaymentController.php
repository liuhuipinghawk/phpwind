<?php

namespace app\modules\admin\controllers;

use app\models\Admin\House;
use Yii;
use app\models\Admin\WaterPayment;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

/**
 * WaterPaymentController implements the CRUD actions for WaterPayment model.
 */
class WaterPaymentController extends CommonController
{

    /**
     * Lists all WaterPayment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $water_consumption = empty(Yii::$app->request->get()['water_consumption']) ? '' : Yii::$app->request->get()['water_consumption'];
        $status     = empty(Yii::$app->request->get()['status']) ? 0 : Yii::$app->request->get()['status'];
        $pay_type     = empty(Yii::$app->request->get()['pay_type']) ? "" : Yii::$app->request->get()['pay_type'];
        $house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
		$data = array('in','w.status',array('1','2','3'));
        $session = \Yii::$app->session;
        $list = explode(',',$session['admin']['house_ids']);
        $jquery = (new \yii\db\Query())->select('w.*,u.account_id,u.room_num,h.housename,h1.housename as seatname,user.TrueName,user.Tell')->from('water_payment w')->
        leftJoin('user_account u','u.account_id = w.account_id')->leftJoin('house h','h.id = u.house_id')->leftJoin('house h1','h1.id = u.seat_id')->
        leftJoin('user','user.id = w.user_id')->
        where($data)->andWhere(['in','u.house_id',$list]);
        if (!empty($house_id)) {
            $jquery = $jquery->andWhere(['u.house_id'=>$house_id]);
        }
        if(!empty($water_consumption)){
            $jquery = $jquery->andWhere(['w.water_consumption'=>$water_consumption]);
        }
        if(!empty($status)){
            $jquery = $jquery->andWhere(['w.status'=>$status]);
        }
        if(!empty($pay_type)){
            if($pay_type == 3){
                $pay_type = 0;
            }
            $jquery = $jquery->andWhere(['w.pay_type'=>$pay_type]);
        }
        $count = $jquery->count();
        $pagination = new Pagination(['totalCount'=>$count],10);

        $list = $jquery->offset($pagination->offset)->limit($pagination->limit)->orderBy('w.create_time desc')->all();
        $house = House::find()->where(['parentId'=>0])->asArray()->all();
        return $this->render('index', [
            'pagination'=>$pagination,
            'list'=>$list,
            'house'=>$house,
        ]);
    }

    /**
     * Displays a single WaterPayment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = "layout1";
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WaterPayment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new WaterPayment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WaterPayment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->order_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WaterPayment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WaterPayment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WaterPayment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WaterPayment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionDel(){
        $order_id = empty(Yii::$app->request->post()['order_id']) ? 0 : Yii::$app->request->post()['order_id'];
        if (empty($order_id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $res = WaterPayment::deleteAll(['order_id'=>$order_id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }
}
