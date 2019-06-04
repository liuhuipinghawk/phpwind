<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Admin\UserRole;
use app\models\Admin\UserRoleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserRoleController implements the CRUD actions for UserRole model.
 */
class UserRoleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserRole models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new UserRoleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserRole model.
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
     * Creates a new UserRole model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new UserRole();
        $list = $model->find()->where(['status'=>1,'pid'=>0])->select(['id','name'])->all();
        array_unshift($list,['id'=>0,'name'=>'如果添加的是三级菜单请选择父类菜单']);
        $column = [['id'=>1,'name'=>'用户数据管理'],['id'=>2,'name'=>'新闻广告管理'],['id'=>3,'name'=>'增值服务管理'],['id'=>4,'name'=>'物业服务管理'],['id'=>5,'name'=>'系统设置管理'],['id'=>6,'name'=>'物业数据统计管理']];
        array_unshift($column,['id'=>0,'name'=>'如果添加的是二级菜单请选择父类菜单']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'list'=>$list,
                'column'=>$column
            ]);
        }
    }

    /**
     * Updates an existing UserRole model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);
        $list = $model->find()->where(['status'=>1])->select(['id','name'])->all();
        array_unshift($list,['id'=>0,'name'=>'如果添加的是三级菜单请选择父类菜单']);
        $column = [['id'=>1,'name'=>'用户数据管理'],['id'=>2,'name'=>'新闻广告管理'],['id'=>3,'name'=>'增值服务管理'],['id'=>4,'name'=>'物业服务管理'],['id'=>5,'name'=>'系统设置管理'],['id'=>6,'name'=>'物业数据统计管理']];
        array_unshift($column,['id'=>0,'name'=>'如果添加的是二级菜单请选择父类菜单']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'list'=>$list,
                'column'=>$column
            ]);
        }
    }

    /**
     * Deletes an existing UserRole model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->layout = "layout1";
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserRole model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserRole the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $this->layout = "layout1";
        if (($model = UserRole::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
