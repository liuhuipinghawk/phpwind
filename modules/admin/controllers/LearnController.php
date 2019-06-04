<?php

namespace app\modules\admin\controllers;

use app\models\Admin\LearnFrom;
use app\models\Admin\LearnType;
use Yii;
use app\models\Admin\Learn;
use app\models\Admin\LearnSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * LearnController implements the CRUD actions for Learn model.
 */
class LearnController extends Controller
{
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
     * Lists all Learn models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new LearnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Learn model.
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
     * Creates a new Learn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new Learn();
        $type = LearnType::find()->asArray()->all();
        array_unshift($type,['id'=>0,'name'=>'请选择类型']);
        $session = \Yii::$app->session;
        $image = new LearnFrom();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $image->imageFile = UploadedFile::getInstance($model,'image');
            $image->File = UploadedFile::getInstance($model,'upload');
            if($image->upload()){
                $model->image =  "/uploads/learn/".time().'.'.$image->imageFile->extension;
                $model->title = $post['Learn']['title'];
                $model->content = $post['Learn']['content'];
                $model->upload = "/uploads/learn/".time().'.'.$image->File->extension;
                $model->type = $post['Learn']['type'];
                $model->create_time = time();
                $model->adminuser = $session['admin']['adminuser'];
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
            'type'=>$type
        ]);

    }

    /**
     * Updates an existing Learn model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);
        $type = LearnType::find()->asArray()->all();
        array_unshift($type,['id'=>0,'name'=>'请选择类型']);
        $session = \Yii::$app->session;
        $image = new LearnFrom();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $image->imageFile = UploadedFile::getInstance($model,'image');
            $image->File = UploadedFile::getInstance($model,'upload');
            if($image->upload()){
                if($image->imageFile!=null) {
                    $model->image = "/uploads/learn/" . time() . '.' . $image->imageFile->extension;
                }
                if($image->File!=null) {
                    $model->upload = "/uploads/learn/" . time() . '.' . $image->File->extension;
                }
                $model->title = $post['Learn']['title'];
                $model->content = $post['Learn']['content'];
                $model->type = $post['Learn']['type'];
                $model->create_time = time();
                $model->adminuser = $session['admin']['adminuser'];
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'type'=>$type
        ]);
    }

    /**
     * Deletes an existing Learn model.
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
     * Finds the Learn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Learn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Learn::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionStatus(){
        $post = Yii::$app->request->post();
        $id = empty($post['id']) ? 0 : $post['id'];
        if (empty($id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $data = Learn::findOne($id);
        if($data['status'] == 1){
            $res = Learn::updateAll(['status'=>0],['id'=>$id]);
        }else{
            $res = Learn::updateAll(['status'=>1],['id'=>$id]);
        }
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'置顶成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'置顶失败']);exit;
    }
}
