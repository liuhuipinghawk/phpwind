<?php

namespace app\modules\admin\controllers;

use app\models\Admin\House;
use app\models\Admin\StallAttr;
use Yii;
use app\models\Admin\Stall;
use app\models\Admin\StallSearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StallController implements the CRUD actions for Stall model.
 */
class StallController extends Controller
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
     * Lists all Stall models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout='layout1';
        $searchModel = new StallSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Stall model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout='layout1';
        $jquery = StallAttr::find()->alias('sa')->select('sa.*,h.housename,a.adminemail')->leftJoin('stall s','s.id = sa.stall_id')->
            leftJoin('house h','h.id = s.house_id')->leftJoin('admin a','a.adminid = sa.user_id')->
        where(['sa.stall_id'=>$id]);
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
     * Creates a new Stall model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout='layout1';
        $model = new Stall();
        $m = new House();
        $data = $m->find()->where(['parentId'=>0])->all();
        array_unshift($data,['id'=>0,'housename'=>'请选择楼盘','parentId'=>0]);
        $model->time = time();
        $session = \Yii::$app->session;
        $model->user_id = $session['admin']['adminid'];
        if(Yii::$app->request->post()){
            $stall = Yii::$app->request->post();
            $house_id = $stall['Stall']['house_id'];
            $r = $model->find()->where(['house_id'=>$house_id])->asArray()->count();
            if($r!=0){
                return $this->render('create', [
                    'model' => $model,
                    'data'=>$data,
                ]);
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'data'=>$data,
            ]);
        }
    }

    /**
     * Updates an existing Stall model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout='layout1';
        $model = $this->findModel($id);
        $model->time = time();
        $session = \Yii::$app->session;
        $model->user_id = $session['admin']['adminid'];
        $m = new House();
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
     * Deletes an existing Stall model.
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
     * Finds the Stall model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Stall the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Stall::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /*
     * 日报添加
     */
    public function actionAdd(){
        if(Yii::$app->request->isPost){
            $data = Yii::$app->request->post();
            $session = Yii::$app->session;
            $data['user_id'] = $session['admin']['adminid'];
            $data['create_time'] = strtotime(date("Y-m-d",time()));
            $m = new StallAttr();
            $res = $m->find()->where(['stall_id'=>$data['stall_id'],'create_time'=>$data['create_time']])->asArray()->count();
            if($res!=0){
                return $this->redirect(['add','stall_id'=>$data['stall_id']]);
            }
            $m->setAttributes($data,false);
            if (!$m->save()) {
                return $this->redirect(['view','id'=>$data['stall_id']]);
            }
            return $this->redirect(['view','id'=>$data['stall_id']]);
        }
        $this->layout='layout1';
        $stall_id = empty(Yii::$app->request->get()['stall_id']) ? '' : Yii::$app->request->get()['stall_id'];
        return $this->render('add',[
            'stall_id'=>$stall_id
        ]);
    }
}
