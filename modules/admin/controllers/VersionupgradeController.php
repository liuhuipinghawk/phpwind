<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Admin\VersionUpgrade;
use app\models\Admin\App;
use app\models\Admin\VersionUpgradeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * VersionUpgradeController implements the CRUD actions for VersionUpgrade model.
 */
class VersionupgradeController extends CommonController
{

    /**
     * Lists all VersionUpgrade models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new VersionUpgradeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VersionUpgrade model.
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
     * Creates a new VersionUpgrade model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new VersionUpgrade();
        $data = APP::find()->asArray()->all();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model->app_id = $post['VersionUpgrade']['app_id'];
            $model->status = $post['VersionUpgrade']['status'];
            $model->type = $post['VersionUpgrade']['type'];
            $model->version_code = $post['VersionUpgrade']['version_code'];
            $model->apk_url = $post['VersionUpgrade']['apk_url'];
            $model->upgrade_point = $post['VersionUpgrade']['upgrade_point'];
            $model->create_time = time();
            if($model->load($model) || $model->validate()){
                if($model->save(false)){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }else{
                var_dump($model->getErrors());
                exit;
            }

        }
        return $this->render('create', [
            'model' => $model,
            'data'=>$data,
        ]);
    }

    /**
     * Updates an existing VersionUpgrade model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $data = APP::find()->asArray()->all();
        $model = $this->findModel($id);
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model->app_id = $post['VersionUpgrade']['app_id'];
            $model->status = $post['VersionUpgrade']['status'];
            $model->type = $post['VersionUpgrade']['type'];
            $model->version_code = $post['VersionUpgrade']['version_code'];
            $model->apk_url = $post['VersionUpgrade']['apk_url'];
            $model->upgrade_point = $post['VersionUpgrade']['upgrade_point'];
            $model->update_time = time();    
            if($model->load($model) || $model->validate()){
                if($model->save(false)){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }else{
                var_dump($model->getErrors());
                exit;
            }

        }
        return $this->render('update', [
            'model' => $model,
            'data'=>$data,
        ]);
    }

    /**
     * Deletes an existing VersionUpgrade model.
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
     * Finds the VersionUpgrade model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VersionUpgrade the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VersionUpgrade::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
