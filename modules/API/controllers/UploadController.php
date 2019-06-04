<?php

namespace  app\modules\API\controllers;

use app\API\models\Ad;
use app\API\models\User;
use app\API\models\HeadForm;
use Yii;
use yii\rest\ActiveController;
use yii\web\Controller;
use yii\web\UploadedFile;

/***
 * 头像上传！
 * API接口！，
 * Class UploadController
 * @package app\modules\API\controllers
 */

class UploadController extends Controller
{
    public $enableCsrfValidation = false;
    //头像上传！
    public function actionUpload()
    {
        $data = array();
        $data = new \ArrayObject($data);
        error_reporting(0);
        $base_path = "./uploads/head/"; //接收文件目录
        $base_path1 = "/uploads/head/"; //接收文件目录
        $target_path = $base_path . basename ( $_FILES ['uploadfile']['name'] );
        $target_path1 = $base_path1 . basename ( $_FILES ['uploadfile']['name'] );
        if (move_uploaded_file ( $_FILES ['uploadfile']['tmp_name'], $target_path )) {   
            $user =User::updateAll(['HeaderImg'=>$target_path1],['id'=>$_POST['userId']]);
            $img = User::find()->where(array('id'=>$_POST['userId']))->Asarray()->one();  			
            if($user){             
                echo json_encode([
                    'code'=>$img['HeaderImg'],         
                    'status'=>200, 
                    'message'=>'上传成功!',           
                ]);
                exit;
            }
        } else {   
            echo json_encode([
                'code'=>$data,
                'status'=>402,
                'message'=>'文件上次失败，请重新上传!',
            ]);
            exit;
        }
    }

    /**
     * get方式传值
     * 1.图片轮播
     * 2.首次加载的加载图
     * http://192.168.100.27/index.php?r=API/upload/picture&cateid=1
     * 图片轮播
     */
    public function actionPicture(){
        $post = yii::$app->request->get();
        $cateId = $post['cateid'];
        if(empty($cateId)){
            echo json_encode([
                'code'=>'',
                'status'=>403,
                'message'=>'参数不为空！',
            ]);
            exit;
        }else if(!is_numeric($cateId)){
            echo json_encode([
                'code'=>'',
                'status'=>405,
                'message'=>'参数必须是数字！',
            ]);
            exit;
        }else{
            $all  = Ad::find()->where('pid =:parentId',['parentId'=>$cateId])->limit(3)->orderBy('createTime desc')->asArray()->all();
            if(empty($all)){
                echo json_encode([
                    'code'=>$all,
                    'status'=>500,
                    'message'=>'图片不存在！',
                ]);
                exit;
            }else{
                echo json_encode([
                    'code'=>$all,
                    'status'=>200,
                    'message'=>'图片加载成功！',
                ]);
                exit;
            }
        }
    }

    /**
     * 图片上传
     * @Author   tml
     * @DateTime 2018-05-11
     * @return   [type]     [description]
     */
    public function actionUploadImg(){
        $img = empty($_FILES['img']) ? [] : $_FILES['img'];
        if (!$img) {
            echo json_encode(['code'=>-200,'msg'=>'未接收到图片']);exit;
        }

        if ($img['error'] > 0) {
            echo json_encode(['code'=>-200,'msg'=>'文件错误']);exit;
        }

        $dir = Yii::$app->request->post('dir','default');
        $path = 'uploads/'.$dir.'/'.date('Ymd',time()).'/';

        $suffix = strrchr($img['name'], '.');
        if (strtolower($suffix) != '.jpg' && strtolower($suffix) != '.jpeg' && strtolower($suffix) != '.png' && strtolower($suffix) != '.gif') {
            echo json_encode(['code'=>-200,'msg'=>'图片格式错误']);exit;
        }
        if ($img['size'] > 1024*1024*2) {
            echo json_encode(['code'=>-200,'msg'=>'图片大小不可超过2M']);exit;
        }
        
        if (!is_dir($path)) {
            mkdir($path,0777,true);
        }
        
        $tmp = $img['tmp_name'];

        $filename = date('His',time()).rand(1000,9999).$suffix;
        $url = $path.$filename;

        $res = move_uploaded_file($tmp, $url);//将图片文件移到该目录下

        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'上传成功','url'=>'/'.$url]);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'上传失败']);exit;
    }
}
