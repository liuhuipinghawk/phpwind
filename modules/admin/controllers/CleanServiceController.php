<?php

namespace app\modules\admin\controllers;

use app\models\CleanBaspeak;
use app\models\CleanForm;
use Yii;
use app\models\CleanService;
use app\models\CleanServiceSearch;
use app\models\CleanCategory;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CleanServiceController implements the CRUD actions for CleanService model.
 */
class CleanServiceController extends CommonController
{


    /**
     * Lists all CleanService models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new CleanServiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CleanService model.
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
     * Creates a new CleanService model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new CleanService();
        $data = new CleanCategory();
        $cate = $data->getOptions();
        $thumb = new CleanForm();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $thumb->imageFile = UploadedFile::getInstance($model,'thumb');
            if($thumb->upload()){
                $model->thumb = "/uploads/clean/".$thumb->imageFile->name;
                $model->clean_name = $post['CleanService']['clean_name'];
                $model->pid = $post['CleanService']['pid'];
                $model->price = $post['CleanService']['price'];
                $model->content = $post['CleanService']['content'];
                $model->create_time = time();
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->clean_id]);
                    }
                    return false;
                }
                return false;
            }
        }
        return $this->render('create', [
            'model' => $model,
            'data'=>$cate,
        ]);
    }

    /**
     * Updates an existing CleanService model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);
        $data = new CleanCategory();
        $cate = $data->getOptions();
        $thumb = new CleanForm();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $thumb->imageFile = UploadedFile::getInstance($model,'thumb');
            if($thumb->imageFile==null){
                //$model->thumb = "uploads/clean/".$thumb->imageFile->name;
                $model->clean_name = $post['CleanService']['clean_name'];
                $model->pid = $post['CleanService']['pid'];
                $model->price = $post['CleanService']['price'];
                $model->content = $post['CleanService']['content'];
                $model->update_time = time();
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->clean_id]);
                    }
                    return false;
                }
                return false;
            }else{
                if($thumb->upload()){
                    $model->thumb = "/uploads/clean/".$thumb->imageFile->name;
                    $model->clean_name = $post['CleanService']['clean_name'];
                    $model->pid = $post['CleanService']['pid'];
                    $model->price = $post['CleanService']['price'];
                    $model->content = $post['CleanService']['content'];
                    $model->update_time = time();
                    if($model->load($model) || $model->validate()){
                        if($model->save(false)){
                            return $this->redirect(['view', 'id' => $model->clean_id]);
                        }
                        return false;
                    }
                    return false;
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'data'=>$cate,
        ]);
       /** if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->clean_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }**/
    }

    /**
     * Deletes an existing CleanService model.
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
     * Finds the CleanService model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CleanService the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CleanService::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     *室内保洁预约
     */
    public function actionCleanPaspeak(){
        $this->layout="layout1";
        //$userId = Yii::$app->request->get('id');
        //$searchModel = new UserSearch();
        //$data = array('in','certification.Status',array('1','2','3'));
        //$data = array('certification.UserId'=>$userId);
        $list = CleanBaspeak::find();
        $pages = new Pagination(['totalCount'=>$list->count(),'pageSize' => '5']);
        $model =$list->offset($pages->offset)->limit($pages->limit)->orderBy('baspeak_time asc')->asArray()->all();
        return $this->render('paskeak',[
            'model' => $model,
            'pages'=>$pages,
        ]);
    }
}
