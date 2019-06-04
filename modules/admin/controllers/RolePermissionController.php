<?php

namespace app\modules\admin\controllers;

use app\API\models\Ad;
use app\models\Admin\Admin;
use app\models\AuthAssignment;
use app\models\AuthAssignments;
use Yii;
use app\models\AuthItem;
use app\models\AuthItmSearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RolePermissionController implements the CRUD actions for AuthItem model.
 */
class RolePermissionController extends CommonController
{

    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new AuthItmSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $id
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
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new AuthItem();
        $date = array(array('id'=>1,'typeName'=>'角色'),array('id'=>2,'typeName'=>'权限'));
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model->name = $post['AuthItem']['name'];
            $model->type = $post['AuthItem']['type'];
            if($post['AuthItem']['type']==1){
                $model->description = "创建了".$post['AuthItem']['name']."角色";
            }else{
                $model->description = "创建了".$post['AuthItem']['name']."许可";
            }
            $model->created_at = time();
            if($model->load($model) || $model->save()){
                return $this->redirect(['view', 'id' => $model->name]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'data'=>$date,
        ]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);
        $date = array(array('id'=>1,'typeName'=>'角色'),array('id'=>2,'typeName'=>'权限'));
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model->name = $post['AuthItem']['name'];
            $model->type = $post['AuthItem']['type'];
            if($post['AuthItem']['type']==1){
                $model->description = "创建了".$post['AuthItem']['name']."角色";
            }else{
                $model->description = "创建了".$post['AuthItem']['name']."许可";
            }
            $model->created_at = time();
            if($model->load($model) || $model->save()){
                return $this->redirect(['view', 'id' => $model->name]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'data'=>$date,
        ]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionUserPermission(){
        $this->layout = "layout1";
        $adminuser = empty(Yii::$app->request->get()['adminuser']) ? '' : Yii::$app->request->get()['adminuser'];
        $adminemail = empty(Yii::$app->request->get()['adminemail']) ? '' : Yii::$app->request->get()['adminemail'];
        //$con = array('');
        $admin = Admin::find();
        if(!empty($adminuser)){
            $admin = $admin->andWhere(['like','adminuser',$adminuser]);
        }
        if(!empty($adminemail)){
            $admin = $admin->andWhere(['like','adminemail',$adminemail]);
        }
        $pages = new Pagination(['totalCount'=>$admin->count(),'pageSize'=>10]);
        $model = $admin->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return $this->render('permissionlist',[
            'pages'=>$pages,
            'model'=>$model
        ]);
    }
    //添加用户角色
    public function actionRoleCreate($id){
        $this->layout = "layout1";
        $model = new AuthAssignments();
        $cate = AuthItem::find()->where(array('type'=>1))->asArray()->all();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model->user_id = $id;
            $model->item_name = $post['AuthAssignments']['item_name'];
            $model->create_at = time();
            if($model->load($model) || $model->save()){
                return $this->redirect(array('role-permission/user-permission'));
            }
        }
        return $this->render('rolecreate',[
            'model'=>$model,
            'data'=>$cate,
        ]);
    }
    //添加用户权限
    public function actionPermissionCreate($id){
        error_reporting( E_ALL&~E_NOTICE );
        $this->layout = "layout1";
        $model = new AuthAssignments();
        $cate = AuthItem::find()->where(array('type'=>2))->asArray()->all();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $item_name = $post['AuthAssignments']['item_name'];
            $key = ['item_name','user_id','create_at'];
            for($i = 0;$i<count($item_name);$i++){
                $model->user_id = $id;
                $model->item_name = $item_name[$i];
                $model->create_at = time();
                $data = array($i=>array('item_name'=>$model->item_name,'user_id'=>$model->user_id,'create_at'=>$model->create_at));
                $res = Yii::$app->db->createCommand()->batchInsert(AuthAssignments::tableName(),$key,$data)->execute();
                echo $res;
                /**if($res){
                    return $this->redirect(array('role-permission/user-permission'));
                }else{
                    var_dump($model->getErrors());
                    exit;
                }**/
            }
            return $this->redirect(array('role-permission/user-permission'));
        }
        return $this->render('permissioncreate',[
            'model'=>$model,
            'data'=>$cate,
        ]);
    }
}
