<?php
/**
 * User: qilin
 * Date: 2018/1/18
 * Time: 15:26
 */
namespace app\modules\API\controllers;

use Yii;
use app\models\Admin\User;
use app\models\Admin\Club;

/**
 * API代码的编写
 */
class ClubController extends TmlController
{
    /*
     * 判断是否入住
     */
    public function actionJudge(){
        $user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
        if (empty($user_id)) {
            echo json_encode(['status'=>-200,'message'=>'请选择用户身份','code'=>[]]);exit;
        }
//        $club = Club::find()->where(['user_id'=>$user_id])->one();
//        if (empty($club)) {
            echo json_encode(['status'=>200,'message'=>'没有申请入住','code'=>[]]);exit;
//        }else{
//            if($club['status'] == 1){
//                echo json_encode(['status'=>300,'message'=>'审核中','code'=>[]]);exit;
//            }
//            if($club['status'] == 2){
//                echo json_encode(['status'=>400,'message'=>'已入住','code'=>[]]);exit;
//            }
//        }

    }
    /*
     * 申请入住
     */
    public function actionAdd(){
        $user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
        $company = empty($this->post['company']) ? 0 : $this->post['company'];
        $name = empty($this->post['name']) ? 0 : $this->post['name'];
        $mobile = empty($this->post['mobile']) ? 0 : $this->post['mobile'];
        $address = empty($this->post['address']) ? 0 : $this->post['address'];
        $img = empty($this->post['image']) ? 0 : $this->post['image'];
        if (empty($user_id)) {
            echo json_encode(['status'=>-200,'message'=>'请选择用户身份','code'=>[]]);exit;
        }
        if (empty($company)) {
            echo json_encode(['status'=>-200,'message'=>'公司名称不能为空','code'=>[]]);exit;
        }
        if (empty($name)) {
            echo json_encode(['status'=>-200,'message'=>'姓名不能为空','code'=>[]]);exit;
        }
        if (empty($mobile)) {
            echo json_encode(['status'=>-200,'message'=>'手机号不能为空','code'=>[]]);exit;
        }
        if (empty($address)) {
            echo json_encode(['status'=>-200,'message'=>'公司地址不能为空','code'=>[]]);exit;
        }
        if (empty($img)) {
            echo json_encode(['status'=>-200,'message'=>'图片不能为空','code'=>[]]);exit;
        }
        if (!$this->checkMobile($mobile)) {
            echo json_encode(['status'=>-200,'message'=>'手机号不正确','code'=>[]]);exit;
        }
//        $club = Club::find()->where(['user_id'=>$user_id])->one();
//        if (!empty($club)) {
//            echo json_encode(['status'=>-200,'message'=>'已提交过申请','code'=>[]]);exit;
//        }
        $model = new Club();
        $model->company = $company;
        $model->name = $name;
        $model->user_id  = $user_id;
        $model->mobile = $mobile;
        $model->address = $address;
        $model->image = $img;
        $res = $model->save(false);
        if (!$res) {
            echo json_encode(['status'=>-200,'message'=>'入住申请失败','code'=>[]]);exit;
        }
        echo json_encode(['status'=>200,'message'=>'入住成功','code'=>[]]);exit;

    }

    /*
     * 企业展示图上传
     */
    public function actionUpload()
    {
        $base_path = "./uploads/club/"; //接收文件目录
        $base_path1 = "/uploads/club/"; //接收文件目录
        $target_path = $base_path . time();
        $target_path1 = $base_path1 . time();
        $type = '.jpg';
        if (move_uploaded_file ( $_FILES ['uploadfile']['tmp_name'], $target_path.$type)) {
                echo json_encode(['status'=>200,'message'=>'success','code'=>$target_path1.$type]);
                exit;
        } else {
            echo json_encode(['status'=>-200,'message'=>'上传失败，请重新上传','code'=>[]]);exit;
        }
    }
    /*
     * 企业列表
     */
    public function actionList(){
        $pagenum = empty($this->get['pagenum']) ? 1 : $this->get['pagenum'];
        $page_size = 8;
        $data = Club::find()->where(['status'=>2])->asArray()
            ->orderBy('id desc')
            ->offset(($pagenum-1)*$page_size)
            ->limit($page_size)->all();
        if(!$data){
            echo json_encode(['status'=>-200,'message'=>'error','code'=>[]]);exit;
        }
        echo json_encode(['status'=>200,'message'=>'success','code'=>$data]);exit;
    }

    public function actionDetails($id){
        $id = $this->get['id'];
        $data = Club::find()->where(['id'=>$id])->asArray()->one();
        if(!$data){
            echo json_encode(['status'=>-200,'message'=>'error','code'=>[]]);exit;
        }
        echo json_encode(['status'=>200,'message'=>'success','code'=>$data]);exit;
    }
}