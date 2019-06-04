<?php

namespace app\modules\admin\controllers;

use app\models\FurnitureBaspeak;
use app\models\FurnitureCategory;
use app\models\FurnitureForm;
use Yii;
use app\models\Furniture;
use app\models\FurnitureSearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FurnitureController implements the CRUD actions for Furniture model.
 */
class FurnitureController extends CommonController
{

    /**
     * Lists all Furniture models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new FurnitureSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Furniture model.
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
     * Creates a new Furniture model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new Furniture();
        $data = new FurnitureCategory();
        $cate = $data->getOptions();
        $thumb = new FurnitureForm();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $thumb->imageFile = UploadedFile::getInstance($model,'thumb');
            if($thumb->upload()){
                $model->furniture_name = $post['Furniture']['furniture_name'];
                $model->price = $post['Furniture']['price'];
                $model->pid = $post['Furniture']['pid'];
                $model->thumb = "/uploads/furniture/".$thumb->imageFile->name;
                $model->content = $post['Furniture']['content'];
                $model->create_time = time();
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->furniture_id]);
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
     * Updates an existing Furniture model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);
        $data = new FurnitureCategory();
        $cate = $data->getOptions();
        $thumb = new FurnitureForm();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $thumb->imageFile = UploadedFile::getInstance($model,'thumb');
            if($thumb->imageFile==null){
                //$model->furniture_name = $post['Furniture']['furniture_name'];
                $model->price = $post['Furniture']['price'];
                $model->pid = $post['Furniture']['pid'];
                $model->thumb = "/uploads/furniture/".$thumb->imageFile->name;
                $model->content = $post['Furniture']['content'];
                $model->create_time = time();
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->furniture_id]);
                    }
                    return false;
                }
                return false;
            }else{
                if($thumb->upload()){
                    $model->furniture_name = $post['Furniture']['furniture_name'];
                    $model->price = $post['Furniture']['price'];
                    $model->pid = $post['Furniture']['pid'];
                    $model->thumb = "/uploads/furniture/".$thumb->imageFile->name;
                    $model->content = $post['Furniture']['content'];
                    $model->create_time = time();
                    if($model->load($model) || $model->validate()){
                        if($model->save(false)){
                            return $this->redirect(['view', 'id' => $model->furniture_id]);
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
    }

    /**
     * Deletes an existing Furniture model.
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
     * Finds the Furniture model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Furniture the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Furniture::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     *室内保洁预约
     */
    public function actionFurniturePaspeak(){
        $this->layout="layout1";
        $list = FurnitureBaspeak::find();
        $pages = new Pagination(['totalCount'=>$list->count(),'pageSize' => '5']);
        $model =$list->offset($pages->offset)->limit($pages->limit)->orderBy('paspeak_time asc')->asArray()->all();
        return $this->render('paspeak',[
            'model' => $model,
            'pages'=>$pages,
        ]);
    }
}
