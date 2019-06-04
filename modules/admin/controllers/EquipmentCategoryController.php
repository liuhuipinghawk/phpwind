<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\EquipmentCategory;
use app\models\EquipmentCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EquipmentCategoryController implements the CRUD actions for EquipmentCategory model.
 */
class EquipmentCategoryController extends CommonController
{

    /**
     * Lists all EquipmentCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout="layout1";
        $cate = new EquipmentCategory();
        $catelist = $cate->getTreeList();

        return $this->render('index', [
            'catelist'=>$catelist,
        ]);
    }

    /**
     * Displays a single EquipmentCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout="layout1";
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EquipmentCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout="layout1";
        $model = new EquipmentCategory();
        $cate = $model->getOptions();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->addItem($post)){
                return $this->redirect(['view', 'id' => $model->category_id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'data' => $cate,
        ]);
    }

    /**
     * Updates an existing EquipmentCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout="layout1";
        $model = $this->findModel($id);
        $cate = $model->getOptions();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($model->addItem($post)){
                return $this->redirect(['view', 'id' => $model->category_id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'data'=>$cate,
        ]);
    }

    /**
     * Deletes an existing EquipmentCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $cateIds = EquipmentCategory::find()->where(array('parent_id'=>$id))->asArray()->all();
        if(!empty($cateIds)){
            Yii::$app->getSession()->setFlash('error','子集分类下，存在分类，不能删除!');
            return $this->redirect(['index']);
        }else{
            $this->findModel($id)->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the EquipmentCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EquipmentCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EquipmentCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
