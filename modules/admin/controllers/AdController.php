<?php

namespace app\modules\admin\controllers;

use app\models\Admin\Adcate;
use app\models\Admin\AdForm;
use Yii;
use app\models\Admin\Ad;
use app\models\Admin\AdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * AdController implements the CRUD actions for Ad model.
 */
class AdController extends CommonController
{
    /**
     * Lists all Ad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new AdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ad model.
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
     * Creates a new Ad model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new Ad();
        $data = new Adcate();
        $adthumb = new AdForm();
        $datas = $data->getOptions();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $adthumb->imageFile = UploadedFile::getInstance($model,'thumb');
            if($adthumb->upload()){
              $model->thumb = "/uploads/ad/".$adthumb->imageFile->name;
              $model->adName = $post['Ad']['adName'];
              $model->pid = $post['Ad']['pid'];
              $model->url = $post['Ad']['url'];
              $model->createTime = date("Y-m-d H:i:s", time());
              if($model->load($model) || $model->validate()){
                  if($model->save(false)){
                      return $this->redirect(['view', 'id' => $model->adId]);
                  }
              }
            }
        }
        return $this->render('create', [
            'model' => $model,
            'data'=>$datas,
        ]);
    }

    /**
     * Updates an existing Ad model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);
        $data = new Adcate();
        $datas = $data->getOptions();
        $adthumb = new AdForm();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $adthumb->imageFile = UploadedFile::getInstance($model,'thumb');
            if($adthumb->imageFile==null){
                //$model->thumb = "uploads/ad/".$adthumb->imageFile->name;
                $model->adName = $post['Ad']['adName'];
                $model->pid = $post['Ad']['pid'];
                $model->url = $post['Ad']['url'];
                $model->updateTime = date("Y-m-d H:i:s", time());
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->adId]);
                    }
                }
            }else{
                if($adthumb->upload()){
                    $model->thumb = "/uploads/ad/".$adthumb->imageFile->name;
                    $model->adName = $post['Ad']['adName'];
                    $model->pid = $post['Ad']['pid'];
                    $model->url = $post['Ad']['url'];
                    $model->updateTime = date("Y-m-d H:i:s", time());
                    if($model->load($model) || $model->validate()){
                        if($model->save(false)){
                            return $this->redirect(['view', 'id' => $model->adId]);
                        }
                    }
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
            'data'=>$datas,
        ]);
    }

    /**
     * Deletes an existing Ad model.
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
     * Finds the Ad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
