<?php

namespace app\modules\admin\controllers;

use app\models\Admin\GroupRole;
use app\models\Admin\User;
use app\models\Admin\UserRole;
use Yii;
use app\models\Admin\Group;
use app\models\Admin\GroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends Controller
{
    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new GroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Group model.
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
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new Group();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Group model.
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
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findRoleModel1($id){
        if (($model = GroupRole::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findRoleModel($id){
        $data = array('group_id'=>$id);
        $list = GroupRole::find()->select('group_id,role_id')->where($data)->asArray()->all();
        return $list;
    }

    /**
     * 分配权限
     * @Author   tml
     * @DateTime 2018-03-09
     * @return   [type]     [description]
     */
    public function actionGetRole()
    {
        $this->layout = "layout1";
        $get = Yii::$app->request->get();
        $group_id = empty($get['id']) ? 0 : $get['id'];
        $group_role = GroupRole::find()->select(['role_id'])->where(['group_id'=>$group_id])->column();
        // var_dump($group_role);exit;

        $model = new UserRole();
        $gr_list = $model->getTreeList();
        return $this->render('get-role',[
            'gr_list'=>$gr_list,
            'group_role'=>$group_role
        ]);
    }

    // public function actionGetRole(){
    //     $this->layout = "layout1";
    //     $model = new UserRole();
    //     $rolename = $model->getTreeList();
    //     return $this->render('get-role',['rolename'=>$rolename]);
    // }
    //group_id
    // public function actionUpdateRole($id){
    //     $this->layout = "layout1";
    //     $models = new UserRole();
    //     $rolename = $models->getTreeList();
    //     return $this->render('get-group',['rolename'=>$rolename]);
    // }

    // public function actionAjaxUpdate(){
    //     $role_id = Yii::$app->request->get('role_id');
    //     $group_id = Yii::$app->request->get('group_id');
    //     $role_ids = explode(',',$role_id);
    //     $key = ['group_id','role_id','create_time'];
    //     if(empty($group_id)){
    //         echo json_encode([
    //             'code'=>[],
    //             'status'=>-200,
    //             'message'=>'修改数据失败！'
    //         ]);
    //         exit;
    //     }else{
    //         for($index=0;$index<count($role_ids);$index++){
    //             $data = array($index=>array('group_id'=>$group_id,'role_id'=>$role_ids[$index],'create_time'=>time()));
    //             $return = Yii::$app->db->createCommand()->update('user_group_role',$key,$data)->execute();
    //         }
    //         echo json_encode([
    //             'code'=>[],
    //             'status'=>200,
    //             'message'=>'修改数据成功！'
    //         ]);
    //         exit;
    //     }
    // }

    // public function actionDeleteRole(){
    //     $this->layout = "layout1";
    //     $id = Yii::$app->request->get('id');
    //     $role = GroupRole::find()->where(array('group_id'=>$id))->asArray()->all();
    //     return $this->render('get-group-role',['role'=>$role]);
    // }

    // public function actionAjaxDel(){
    //     $role_id = Yii::$app->request->get('role_id');
    //     $group_id = Yii::$app->request->get('group_id');
    //     $role_ids = explode(',',$role_id);
    //     if(empty($group_id)){
    //         echo json_encode([
    //             'code'=>[],
    //             'status'=>-200,
    //             'message'=>'添加数据失败！'
    //         ]);
    //         exit;
    //     }else{
    //         for($index=0;$index<count($role_ids);$index++){
    //             //$data = array($index=>array('group_id'=>$group_id,'role_id'=>$role_ids[$index]));
    //             $data['group_id'] = $group_id;
    //             $data['role_id'] = $role_ids[$index];
    //             $return = Yii::$app->db->createCommand()->delete('user_group_role',$data)->execute();
    //         }
    //         echo json_encode([
    //             'code'=>[],
    //             'status'=>200,
    //             'message'=>'添加数据成功！'
    //         ]);
    //         exit;
    //     }

    // }

    // public function actionAjaxGroup(){
    //     $role_id = Yii::$app->request->get('role_id');
    //     $group_id = Yii::$app->request->get('group_id');
    //     $role_ids = explode(',',$role_id);
    //     $key = ['group_id','role_id','create_time'];
    //     if(empty($group_id)){
    //         echo json_encode([
    //             'code'=>[],
    //             'status'=>-200,
    //             'message'=>'添加数据失败！'
    //         ]);
    //         exit;
    //     }else{
    //         for($index=0;$index<count($role_ids);$index++){
    //             $data = array($index=>array('group_id'=>$group_id,'role_id'=>$role_ids[$index],'create_time'=>time()));
    //             $return = Yii::$app->db->createCommand()->batchInsert('user_group_role',$key,$data)->execute();
    //         }
    //         echo json_encode([
    //             'code'=>[],
    //             'status'=>200,
    //             'message'=>'添加数据成功！'
    //         ]);
    //         exit;
    //     }
    // }
    
    /**
     * ajax分配权限
     * @Author   tml
     * @DateTime 2018-03-09
     * @return   [type]     [description]
     */
    public function actionAjaxGroup()
    {
        $post = Yii::$app->request->post();
        $group_id = empty($post['group_id']) ? 0 : $post['group_id'];
        $role_id = empty($post['role_id']) ? '' : $post['role_id'];
        if (empty($group_id) || empty($role_id)) {
            echo json_encode(['status'=>-200,'message'=>'参数错误']);exit;
        }
        //先删除已存在的权限配置
        GroupRole::deleteAll(['group_id'=>$group_id]);
        //批量插入
        $role_arr = explode(',',$role_id);
        $data = [];
        foreach ($role_arr as $v) {
            array_push($data,array($group_id,$v,time()));
        }
        $res = Yii::$app->db->createCommand()->batchInsert('user_group_role',['group_id','role_id','create_time'],$data)->execute();
        if ($res) {
            echo json_encode(['status'=>-200,'message'=>'权限分配成功']);exit;
        }
        echo json_encode(['status'=>-200,'message'=>'权限分配失败']);exit;
    }
}
