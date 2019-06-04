<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Admin\House;
use app\models\Admin\HouseSearch;
use app\models\Admin\City;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HouseController implements the CRUD actions for House model.
 */
class HouseController extends CommonController
{

    /**
     * Lists all House models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new HouseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $cate = new House();
        $catelist = $cate->getTreeList();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'catelist'=>$catelist,
        ]);
    }

    /**
     * Displays a single House model.
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
     * Creates a new House model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new House();
        $cate = $model->getOptions();
        $city =City::find()->Asarray()->all();
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
            'city'=>$city,
        ]);
    }

    /**
     * Updates an existing House model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);
        $cate = $model->getOptions();
        $city =City::find()->Asarray()->all();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->addItem($post)){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'data'=>$cate,
            'city'=>$city,   
        ]);
    }

    /**
     * Deletes an existing House model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $cateIds = House::find()->where(array('parentId'=>$id))->asArray()->all();
        if(!empty($cateIds)){
            Yii::$app->getSession()->setFlash('error','子集分类下，存在分类，不能删除!');
            return $this->redirect(['index']);
        }else{
            $this->findModel($id)->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the House model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return House the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = House::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
