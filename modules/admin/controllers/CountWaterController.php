<?php

namespace app\modules\admin\controllers;

use app\models\Admin\CountWaterattr;
use app\models\Admin\House;
use Yii;
use app\models\Admin\CountWater;
use app\models\Admin\CountWaterSearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CountWaterController implements the CRUD actions for CountWater model.
 */
class CountWaterController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CountWater models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout='layout1';
        $searchModel = new CountWaterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CountWater model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout='layout1';
        $jquery = CountWaterattr::find()->alias('cw')->select('cw.*,h.housename,a.adminemail')->
        leftJoin('count_water c','c.id = cw.water_id')->
        leftJoin('house h','h.id = c.house_id')->leftJoin('admin a','a.adminid = cw.user_id')->
        where(['cw.water_id'=>$id]);
        $count = $jquery->count();
        $pagination = new Pagination(['totalCount'=>$count]);
        $data = $jquery
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('id desc')
            ->asArray()
            ->all();
        return $this->render('view', [
            'data' => $data,
            'pagination'=>$pagination
        ]);
    }

    /**
     * Creates a new CountWater model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout='layout1';
        $model = new CountWater();
        $m = new House();
        $data = $m->find()->where(['parentId'=>0])->all();
        array_unshift($data,['id'=>0,'housename'=>'请选择楼盘','parentId'=>0]);
        $model->create_time = time();
        $session = \Yii::$app->session;
        $model->user_id = $session['admin']['adminid'];
        if(Yii::$app->request->post()){
            $stall = Yii::$app->request->post();
            $house_id = $stall['CountWater']['house_id'];
            $r = $model->find()->where(['house_id'=>$house_id])->asArray()->count();
            if($r!=0){
                return $this->render('create', [
                    'model' => $model,
                    'data'=>$data,
                ]);
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'data'=>$data,
            ]);
        }
    }

    /**
     * Updates an existing CountWater model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout='layout1';
        $model = $this->findModel($id);
        $m = new House();
        $model->create_time = time();
        $session = \Yii::$app->session;
        $model->user_id = $session['admin']['adminid'];
        $data = $m->find()->where(['parentId'=>0])->all();
        array_unshift($data,['id'=>0,'housename'=>'请选择楼盘','parentId'=>0]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'data'=>$data,
            ]);
        }
    }

    /**
     * Deletes an existing CountWater model.
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
     * Finds the CountWater model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CountWater the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CountWater::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /*
     * 月报添加
     */
    public function actionAdd(){
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $session = Yii::$app->session;
            $data['user_id'] = $session['admin']['adminid'];
            $data['create_time'] = strtotime(date("Y-m-d",time()));
            $data['meter_time'] = strtotime($data['meter_time']);
            $data['time'] = strtotime(date('Y-m',strtotime($data['time'])));
            $m = new CountWaterattr();
            $res = $m->find()->where(['water_id'=>$data['water_id'],'time'=>$data['time']])->asArray()->one();
            if($res!=""){
                return $this->redirect(['add','water_id'=>$data['water_id']]);
            }
            $m->setAttributes($data,false);
            if (!$m->save()) {
                return $this->redirect(['view','id'=>$data['water_id']]);
            }
            return $this->redirect(['view','id'=>$data['water_id']]);
        }
        $this->layout='layout1';
        $water_id = empty(Yii::$app->request->get()['water_id']) ? '' : Yii::$app->request->get()['water_id'];
        return $this->render('add',[
            'water_id'=>$water_id,
        ]);
    }
    public function actionDel($id,$water_id)
    {
        CountWaterattr::deleteAll(['id'=>$id]);

        return $this->redirect(['view','id'=>$water_id]);
    }
}
