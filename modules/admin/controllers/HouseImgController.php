<?php

namespace app\modules\admin\controllers;

use app\models\Admin\HouseForm;
use Yii;
use app\models\Admin\HouseImg;
use app\models\Admin\HouseImgSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * HouseImgController implements the CRUD actions for HouseImg model.
 */
class HouseImgController extends CommonController
{

    /**
     * Lists all HouseImg models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new HouseImgSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HouseImg model.
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
     * Creates a new HouseImg model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new HouseImg();

        $house = new HouseForm();

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $house->imageFile = UploadedFile::getInstance($model,'img_path');
            if($house->upload()){
                $model->img_path = "/uploads/HouseImg/".time().'.'.$house->imageFile->extension;
                $model->publish_id = $_GET['publish_id'];
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->img_id,'publish_id'=>$_GET['publish_id']]);
                    }
                    return false;
                }else{
                    var_dump($model->getErrors());
                    exit;
                }
                return false;
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HouseImg model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);
        $house = new HouseForm();

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $house->imageFile = UploadedFile::getInstance($model,'img_path');
            if($house->upload()){
                $model->img_path = "/uploads/HouseImg/".time().'.'.$house->imageFile->extension;
                $model->publish_id = $_GET['publish_id'];
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->img_id,'publish_id'=>$_GET['publish_id']]);
                    }
                    return false;
                }else{
                    var_dump($model->getErrors());
                    exit;
                }
                return false;
            }
        }
        return $this->render('update', [
                'model' => $model,
            ]);
    }

    /**
     * Deletes an existing HouseImg model.
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
     * Finds the HouseImg model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HouseImg the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HouseImg::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
