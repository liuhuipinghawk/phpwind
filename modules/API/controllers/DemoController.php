<?php

namespace app\modules\API\controllers;

use app\util\JSONUtils;
use app\util\MessageUtil;
use yii\web\Controller;
use Yii;

class DemoController extends Controller{

    public $enableCsrfValidation = false;

    ////1.修改手机号 2.注册 3.找回密码
    public function actionSendCode(){
        $data = array();
        //手机号
        $mobiles="18538187569"; //目标手机号码，多个用半角“,”分隔
        $code = rand(1111,9999);
        $content = "打死不要告诉别人,您的验证码：".$code."【兴业APP】";
        //检查session是否开启
        if(!Yii::$app->session->isActive){
            Yii::$app->session->open();
        }
        $signup_sms_time = Yii::$app->session->get('login_sms_time');
        //如果在是否中内不能重复发送！
        if(time()-$signup_sms_time <600){
            echo json_encode([
                'code' =>$data,
                'status' => 500,
                'message' => '十分钟之内不能重复发送验证码，请十分钟在发送！',
            ]);
            exit;
        }else{
            if(MessageUtil::send($mobiles,$content)){     
                //验证码和短信发送时间存储session
                Yii::$app->session->set('login_sms_code',$code);
                Yii::$app->session->set('login_sms_time',time());
                echo json_encode([
                    'code' =>$data,
                    'status' => 200,
                    'message' => '短信发送成功！',
                ]);
                exit;
            }else{
                echo json_encode([
                    'code' =>$data,
                    'status' => 404,
                    'message' => '短信发送失败！',
                ]);
                exit;
            }
        }
    }
    // 操作信息内容!
    public function actionMessage(){
        $rand = rand(0000,9999);
        $content = "打死不要告诉别人,您的验证码：".$rand."! 【兴业APP】";
        var_dump($content);
        exit();
    }
    //头像上传
    public function actionHeaderImg(){
        error_reporting(0);
        $base_path = "./uploads/head/"; //接收文件目录
        $target_path = $base_path .basename ($_FILES ['uploadfile']['name']);
        if (move_uploaded_file ( $_FILES ['uploadfile']['tmp_name'], $target_path )) {
                $array = array ("code" => "1", "message" => $_FILES ['uploadfile']['name'] );
                echo json_encode ( $array );
        } else {
                $array = array ("code" => "0", "message" => "There was an error uploading the file, please try again!".$_FILES ['uploadfile']['error'] );
                echo json_encode ( $array );
        }
    }
    //多图片上传!
    public function actionImages(){
        error_reporting(0);
        $base_path = "./uploads/Order/"; //接收文件目录
        $imgs = array();  //定义一个数组存放上传图片的路径
        $isSave = false;
        if (!file_exists($base_path)) {
            mkdir($base_path);
        }
        foreach ($_FILES["uploadfile"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["uploadfile"]["tmp_name"][$key];
                $name = $_FILES["uploadfile"]["name"][$key];
                $uploadfile = $base_path .basename($name);
                $isSave = move_uploaded_file($tmp_name, $uploadfile);
                if ($isSave){
                    $imgs[]=$uploadfile;
                }
            }
        }
        if ($isSave) {
            $array = array("code" => "1", "message" =>"上传图片成功"
            , "imgUrls" => $imgs);
            echo json_encode($array);
        } else {
            $array = array("code" => "0", "message" => "上传图片失败," . $_FILES ['uploadfile'] ['error']
            , "imgUrls" => $imgs);
            echo json_encode($array);
        }
    }
}
