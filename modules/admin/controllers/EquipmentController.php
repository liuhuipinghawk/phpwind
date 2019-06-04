<?php

namespace app\modules\admin\controllers;

use app\API\models\House;
use app\models\EquipmentCategory;
use app\models\EquipmentForm;
use Yii;
use app\models\Equipment;
use app\models\EquipmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * EquipmentController implements the CRUD actions for Equipment model.
 */
class EquipmentController extends CommonController
{

    /**
     * Lists all Equipment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new EquipmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Equipment model.
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
     * Creates a new Equipment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new Equipment();
        $cate = new EquipmentCategory();
        $data = $cate->getOptions();
        $thumb = new EquipmentForm();
        $m = new House();
        $house = $m->find()->where(['parentId'=>0])->all();
        array_unshift($house,['id'=>0,'housename'=>'请选择楼盘','parentId'=>0]);
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $thumb->imageFile = UploadedFile::getInstance($model,'thumb');
            if($thumb->upload()){
                $model->equipment_name = $post['Equipment']['equipment_name'];
                $model->business_telephone = $post['Equipment']['business_telephone'];
                $model->equipment_desc = $post['Equipment']['equipment_desc'];
                $model->pid = $post['Equipment']['pid'];
                $model->price = $post['Equipment']['price'];
                $model->thumb =  "/uploads/equipment/".$thumb->imageFile->name;
                $model->content = $post['Equipment']['content'];
                $model->house_id = $post['Equipment']['house_id'];
                $model->create_time = time();
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->equipment_id]);
                    }
                    return false;
                }
                return false;
            }
        }
        return $this->render('create', [
            'model' => $model,
            'data'=>$data,
            'house'=>$house,
        ]);
    }

    /**
     * Updates an existing Equipment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);
        $cate = new EquipmentCategory();
        $data = $cate->getOptions();
        $thumb = new EquipmentForm();
        $m = new House();
        $house = $m->find()->where(['parentId'=>0])->all();
        array_unshift($house,['id'=>0,'housename'=>'请选择楼盘','parentId'=>0]);
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $thumb->imageFile = UploadedFile::getInstance($model,'thumb');
            if($thumb->imageFile ==null){
                $model->equipment_name = $post['Equipment']['equipment_name'];
                $model->business_telephone = $post['Equipment']['business_telephone'];
                $model->equipment_desc = $post['Equipment']['equipment_desc'];
                $model->pid = $post['Equipment']['pid'];
                $model->price = $post['Equipment']['price'];
                //$model->thumb =  "uploads/equipment/".$thumb->imageFile->name;
                $model->content = $post['Equipment']['content'];
                $model->create_time = time();
                $model->house_id = $post['Equipment']['house_id'];
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->equipment_id]);
                    }
                    return false;
                }else{
                    var_dump($model->getErrors());
                    exit;
                }
                return false;
            }else{
                if($thumb->upload()){
                    $model->equipment_name = $post['Equipment']['equipment_name'];
                    $model->business_telephone = $post['Equipment']['business_telephone'];
                    $model->equipment_desc = $post['Equipment']['equipment_desc'];
                    $model->pid = $post['Equipment']['pid'];
                    $model->price = $post['Equipment']['price'];
                    $model->thumb =  "/uploads/equipment/".$thumb->imageFile->name;
                    $model->content = $post['Equipment']['content'];
                    $model->house_id = $post['Equipment']['house_id'];
                    $model->create_time = time();
                    if($model->load($model) || $model->validate()){
                        if($model->save(false)){
                            return $this->redirect(['view', 'id' => $model->equipment_id]);
                        }
                        return false;
                    }else{
                        var_dump($model->getErrors());
                        exit;
                    }
                    return false;
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'data'=>$data,
            'house'=>$house,
        ]);
    }

    /**
     * Deletes an existing Equipment model.
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
     * Finds the Equipment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Equipment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Equipment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
