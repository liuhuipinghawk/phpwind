<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\FlowerCategory;
use app\models\FlowerCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FlowerCategoryController implements the CRUD actions for FlowerCategory model.
 */
class FlowerCategoryController extends CommonController
{

    /**
     * Lists all FlowerCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new FlowerCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $cate = new FlowerCategory();
        $catelist = $cate->getTreeList();

        return $this->render('index', [
            'catelist'=>$catelist,
        ]);
    }

    /**
     * Displays a single FlowerCategory model.
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
     * Creates a new FlowerCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new FlowerCategory();
        $data = $model->getOptions();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->addItem($post)){
                return $this->redirect(['view', 'id' => $model->category_id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'data'=>$data,
        ]);
    }

    /**
     * Updates an existing FlowerCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);
        $data = $model->getOptions();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->addItem($post)){
                return $this->redirect(['view', 'id' => $model->category_id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'data'=>$data,
        ]);
    }

    /**
     * Deletes an existing FlowerCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $cateIds = FlowerCategory::find()->where(array('parent_id'=>$id))->asArray()->all();
        if(!empty($cateIds)){
            Yii::$app->getSession()->setFlash('error','子集分类下，存在分类，不能删除!');
            return $this->redirect(['index']);
        }else{
            $this->findModel($id)->delete();
        }
        return $this->redirect(['index']);
    }  

    /**
     * Finds the FlowerCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FlowerCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FlowerCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
