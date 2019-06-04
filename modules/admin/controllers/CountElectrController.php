<?php

namespace app\modules\admin\controllers;

use app\models\Admin\CountElectrattr;
use app\models\Admin\House;
use Yii;
use app\models\Admin\CountElectr;
use app\models\Admin\CountElectrSearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CountElectrController implements the CRUD actions for CountElectr model.
 */
class CountElectrController extends Controller
{
    /**
     * @inheritdoc
     */
    public $enableCsrfValidation = false;
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
     * Lists all CountElectr models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout='layout1';
        $searchModel = new CountElectrSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CountElectr model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout='layout1';
        $jquery = CountElectrattr::find()->alias('ce')->select('ce.*,h.housename,a.adminemail')->
        leftJoin('count_electr c','c.id = ce.electr_id')->
        leftJoin('house h','h.id = c.house_id')->leftJoin('admin a','a.adminid = ce.user_id')->
        where(['ce.electr_id'=>$id]);
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
     * Creates a new CountElectr model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout='layout1';
        $model = new CountElectr();
        $m = new House();
        $data = $m->find()->where(['parentId'=>0])->all();
        array_unshift($data,['id'=>0,'housename'=>'请选择楼盘','parentId'=>0]);
        $model->create_time = time();
        $session = \Yii::$app->session;
        $model->user_id = $session['admin']['adminid'];
        if(Yii::$app->request->post()){
            $stall = Yii::$app->request->post();
            $house_id = $stall['CountElectr']['house_id'];
            $r = $model->find()->where(['house_id'=>$house_id])->asArray()->count();
            if($r!=0){
                return $this->render('index', [
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
     * Updates an existing CountElectr model.
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
     * Deletes an existing CountElectr model.
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
     * Finds the CountElectr model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CountElectr the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CountElectr::findOne($id)) !== null) {
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
            $m = new CountElectrattr();
            $res = $m->find()->where(['electr_id'=>$data['electr_id'],'time'=>$data['time']])->asArray()->one();
            if($res!=""){
                return $this->redirect(['add','electr_id'=>$data['electr_id']]);
            }
            $m->setAttributes($data,false);
            if (!$m->save()) {
                return $this->redirect(['view','id'=>$data['electr_id']]);
            }
            return $this->redirect(['view','id'=>$data['electr_id']]);
        }
        $this->layout='layout1';
        $electr_id = empty(Yii::$app->request->get()['electr_id']) ? '' : Yii::$app->request->get()['electr_id'];
        return $this->render('add',[
            'electr_id'=>$electr_id,
        ]);
    }
    public function actionDel($id,$electr_id)
    {
        CountElectrattr::deleteAll(['id'=>$id]);

        return $this->redirect(['view','id'=>$electr_id]);
    }
}
