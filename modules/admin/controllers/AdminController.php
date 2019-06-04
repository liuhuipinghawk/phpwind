<?php

namespace app\modules\admin\controllers;

use app\models\Admin\AdminForm;
use app\models\Admin\UserRole;
use Yii;
use app\models\Admin\Admin;
use app\models\Admin\User;
use app\models\Admin\AdminSearch;
use app\models\Admin\House;
use app\models\Admin\Group;

use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends CommonController
{

    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
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
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $adminForm = new AdminForm();
        $model = new Admin();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $adminForm->imageFile = UploadedFile::getInstance($model,'headerImg');
            if($adminForm->upload()){
                $model->headerImg =  "/uploads/admin/".$adminForm->imageFile->name;
                $model->adminuser = $post['Admin']['adminuser'];
                $model->adminpass = md5($post['Admin']['password']);
                $model->adminemail = $post['Admin']['adminemail'];
                $model->house_ids = empty($post['Admin']['house_ids']) ? '' : implode(',', $post['Admin']['house_ids']);
                $model->group_id = $post['Admin']['group_id'];
                $model->password = $post['Admin']['password'];
                $model->createtime = date("Y-m-d H:i:s", time());
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->adminid]);
                    }
                    return false;
                }
                return false;
            }
        }
        $house_list = House::find()->where(['parentId'=>0])->asArray()->all();
        $house = [];
        foreach ($house_list as $k => $v) {
            $house[$v['id']] = $v['housename'];
        }
        $group_list = Group::find()->select('id,name')->asArray()->all();
        $group = [];
        foreach ($group_list as $k => $v) {
            $group[$v['id']] = $v['name'];
        }
        return $this->render('create', [
            'model' => $model,
            'house' => $house,
            'group' => $group
        ]);
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $adminForm = new AdminForm();
        $model = $this->findModel($id);
        $model->house_ids = explode(',',$model->house_ids);
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $adminForm->imageFile = UploadedFile::getInstance($model,'headerImg');
            if($adminForm->imageFile==null){
                //$model->headerImg =  "uploads/admin/".$adminForm->imageFile->name;
                $model->adminuser = $post['Admin']['adminuser'];
                $model->adminpass = md5($post['Admin']['password']);
                $model->adminemail = $post['Admin']['adminemail'];
                $model->house_ids = empty($post['Admin']['house_ids']) ? '' : implode(',', $post['Admin']['house_ids']);
                $model->group_id = $post['Admin']['group_id'];
                $model->password = $post['Admin']['password'];
                $model->createtime = date("Y-m-d H:i:s", time());
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->adminid]);
                    }
                    return false;
                }
                return false;
            }else{
                if($adminForm->upload()){
                    $model->headerImg =  "/uploads/admin/".$adminForm->imageFile->name;
                    $model->adminuser = $post['Admin']['adminuser'];
                    $model->adminpass = md5($post['Admin']['password']);
                    $model->adminemail = $post['Admin']['adminemail'];
                    $model->house_ids = empty($post['Admin']['house_ids']) ? '' : implode(',', $post['Admin']['house_ids']);
                    $model->group_id = $post['Admin']['group_id'];
                    $model->password = $post['Admin']['password'];
                    $model->createtime = date("Y-m-d H:i:s", time());
                    if($model->load($model) || $model->validate()){
                        if($model->save(false)){
                            return $this->redirect(['view', 'id' => $model->adminid]);
                        }
                        return false;
                    }
                    return false;
                }
            }
        }

        $house_list = House::find()->where(['parentId'=>0])->asArray()->all();
        $house = [];
        foreach ($house_list as $k => $v) {
            $house[$v['id']] = $v['housename'];
        }
        $group_list = Group::find()->select('id,name')->asArray()->all();
        $group = [];
        foreach ($group_list as $k => $v) {
            $group[$v['id']] = $v['name'];
        }
        return $this->render('update', [
            'model' => $model,
            'house' => $house,
            'group' => $group
        ]);
    }

    /**
     * Deletes an existing Admin model.
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
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionCertification(){  
        $query = User::find()->select('seat.name,house.housename,user.id,user.HouseId,user.NickName,user.TrueName,user.Address,user.IdCard,user.IdCardOver,user.WorkCard,user.Company,user.HeaderImg')->join('LEFT JOIN','house','house.id = user.HouseId')->join('LEFT JOIN','seat','seat.id = user.Seat')->where(array('Status'=>1))->asArray()->all();
        var_dump($query);  
        /**return $this->render('index', [
            'searchModel' => $query,
            'dataProvider' => $query,
        ]);**/
    }
    /*
     * 栏目管理
     * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
     */
    public function actionRole(){
        $group_role = Yii::$app->session['admin']['group_role'];
        $fid = empty(Yii::$app->request->post()['fid']) ? 1 : Yii::$app->request->post()['fid'];
        $menu_list = UserRole::find()->where(['status'=>1,'pid'=>0,'fid'=>$fid])->andWhere(['id'=>explode(',',$group_role)])->asArray()->all();
        return json_encode(['code'=>200,'data'=>$menu_list]);
    }
    public function actionRoleAjax(){
        $group_role = Yii::$app->session['admin']['group_role'];
        $id = empty(Yii::$app->request->post()['id']) ? "" : Yii::$app->request->post()['id'];
        if(!$id){
            return json_encode(['code'=>-200,'data'=>'参数错误']);
        }
        $menu_list = UserRole::find()->where(['status'=>1,'pid'=>$id])->andWhere(['id'=>explode(',',$group_role)])->asArray()->all();
        return json_encode(['code'=>200,'data'=>$menu_list]);
    }
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
}
