<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Admin\Maintenancetype;
use app\models\Admin\MaintenancetypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MaintenancetypeController implements the CRUD actions for Maintenancetype model.
 */
class MaintenancetypeController extends CommonController
{

    /**
     * Lists all Maintenancetype models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new MaintenancetypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Maintenancetype model.
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
     * Creates a new Maintenancetype model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new Maintenancetype();
        $cate = $model->getOptions();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->addItem($post)){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                var_dump($model->getErrors());
                exit;
            }
        }
        return $this->render('create', [
            'model' => $model,
            'data' => $cate,
        ]);
    }

    /**
     * Updates an existing Maintenancetype model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);
        $cate = $model->getOptions();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->addItem($post)){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                var_dump($model->getErrors());
                exit;
            }
        }
        return $this->render('update', [
            'model' => $model,
            'data' => $cate,
        ]);        
    }

    /**
     * Deletes an existing Maintenancetype model.
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
     * Finds the Maintenancetype model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Maintenancetype the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)   
    {
        if (($model = Maintenancetype::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
