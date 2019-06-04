<?php
/**
 * User: qilin
 * Date: 2019/5/6
 * Time: 14:59
 */
namespace app\modules\API\controllers;

use app\API\models\User;
/**
 * API代码的编写
 */
class UserController extends TmlController
{
    /*
     * 公众号用户注册
     */
    public function actionRegister(){
        $Tell   = empty($this->post['Tell']) ? 0 : $this->post['Tell'];
        $PassWord   = empty($this->post['PassWord']) ? 0 : $this->post['PassWord'];
        $TrueName = empty($this->post['TrueName']) ? 0 : $this->post['TrueName'];
        $Company = empty($this->post['Company']) ? '' : $this->post['Company'];
        if(empty($Tell) || empty($PassWord) || empty($TrueName) || empty($Company)){
            echo json_encode(['code' => -200,'message' => '缺少参数']);exit;
        }
        if (!$this->checkMobile($Tell)) {
            echo json_encode(['code' => -200,'message' => '手机号格式不正确']);exit;
        }
        //判断手机号是否注册
        $user = User::find()->where(['Tell'=>$Tell])->asArray()->one();
        if ($user) {
            echo json_encode(['code' => -200,'message' => '该账号已经存在，不可重复注册']);exit;
        }
        $model = new User;
        $model->Tell = $Tell;
        $model->PassWord = md5(md5($PassWord));
        $model->CreateTime = date("Y-m-d H:i:s", time());
        $model->TrueName = $TrueName;
        $model->Company = $Company;
        $model->Status = 2;
        $model->CateId = 2;
        if ($model->load($model) || $model->save()) {
            echo json_encode(['status'=>200,'message'=>'注册成功']);exit;
        }
        echo json_encode(['status'=>-200,'message'=>'注册失败']);exit;
    }
}