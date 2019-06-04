<?php

namespace app\modules\wappay\controllers;

use app\models\UserLoginRequestParam;
use app\util\CURLUtils;
use app\util\RSAUtils;
use app\util\Crypt3DesUtil;
use app\util\AccreditUtils;
use Yii;
use yii\web\Controller;

/**
 * 富士接口文档!
 * 接口文档
 */
class DefaultController extends Controller
{
    public $enableCsrfValidation = false;
    public $Result = '';
    public $UserCode='';
    public $Token='';
    /**
     * 授权登陆!
     * paramData=%s&propertyCode=%s&platformType=%s&serviceName=%s
     * @return string
     */
    public function actionUserLogin()
    {
        //私钥
        $private_key = Yii::$app->params['PRIVATE_KEY_STR'];
        //需要加密的字段
        $data = array(
            'thridCode'=>Yii::$app->params['PROPERTY_CODE'],
            'thridType'=>4,
            'timestamp'=>time(),
        );
        $data = json_encode($data);
        //加密程序
        $paramData = RSAUtils::pikeyEncrypt($private_key,$data);
        //服务名称
        $serverName = "/UsersLogin/WebPayUserLogin";
        $data_string = array(
            'paramData'=>$paramData,
            'platformType'=>1,
            'propertyCode'=>Yii::$app->params['PROPERTY_CODE'],
            'serviceName'=>$serverName,
        );
        $data_string = json_encode($data_string);
        $curl = "http://auth.fujica.com.cn/api/Authentic/UserLogin";
        //提交数据！
        $result = CURLUtils::_request_json($curl,$data_string);
        $result = json_decode($result,true);
        if($result['code'] == 200){
            $Result = $result['result'];
            $this->Result = $Result;
            $tokenstr = json_decode($result['result'],true);
            $Token = $tokenstr['token'];
            $UserCode = $tokenstr['userCode'];
            $this->UserCode = $UserCode;
            $token = RSAUtils::pikeyDecrypt($private_key,$Token);
            $this->Token = $token;
            $array = array(
                'token'=> $this->Token,
                'usercode'=> $this->UserCode,
                'result'=> $this->Result
            );
            return $array;
        }else{
            return fase;
        }
    }

    //签名
    public function actionSign(){
        $user = $this->actionUserLogin();
        $time = time();
        $token = $user['token'];
        $userCode = $user['usercode'];
        $sign ="timestamp=".$time."&token=".$token."&userCode=".$userCode;
        $sign = md5($sign);
        return $sign;
    }
    //random系统函数的编写
    public function actionRandno($length=8){
        $chars = '0123456789ABCDEF';
        $str = '';
        for ($i = 0; $i<$length; $i++){
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    public function actionCode(){
        $data = array();
        $data = new \ArrayObject($data);
        $random = Yii::$app->request->get('ranno');
        //$random = 'A1B2C3D4';
        $card = Yii::$app->request->get('tell');
        //$card = '13824337255';
        $EndTime = Yii::$app->request->get('endtime');
        //$EndTime = '2017-11-07 18:05:32';
        $EndTime = strtotime($EndTime);
        //$EndTime = "1510049535";   
        $EndTime =date("ymdHis",$EndTime);
        if(empty($random) || empty($card) || empty($EndTime)){
            echo json_encode([
                'code' => $data,
                'status' => 502,
                'message' => '参数不为空！',
            ]);
            exit;
        }else{
            $code = AccreditUtils::AccreditCode($random,$card,$EndTime);
            echo json_encode([
                'code' => $code,
                'status' => 200,
                'message' => '二维码生成成功！',
            ]);
            exit;
        }         
        /**$random = Yii::$app->request->get('ranno');
        $card = Yii::$app->request->get('tell');
        $EndTime = Yii::$app->request->get('endtime');
        if(empty($random) || empty($card) || empty($EndTime)){
            echo json_encode([
                'code'=>'参数不为空!',
            ]);
            exit();
        }else{   
            $code = AccreditUtils::AccreditCode($random,$card,$EndTime); 
            echo json_encode(['code'=>$code]);
            exit();
        }**/
    }
    /**
     * 人员到访授权
     * 先登录在获取值。
     */
    public function actionBusinesProperty(){
        $user =  $this->actionUserLogin();
        $sign = $this->actionSign();
        $random = $this->actionRandno();
        $card = Yii::$app->request->get('proprietorPhone');
        $EndTime =Yii::$app->request->get('endTime');
        $code = AccreditUtils::AccreditCode($random,$card,$EndTime);
        echo json_encode(['code'=>$code]);
        exit;
        //参数添加
        $data = array(
            'proprietorHouse'=>Yii::$app->request->post('proprietorHouse'),
            'proprietorPhone'=>$card,
            'visitorName'=>Yii::$app->request->post('visitorName'),
            'vistorsQuantity'=>Yii::$app->request->post('vistorsQuantity'),
            'visitTime'=>Yii::$app->request->post('visitTime'),
            'inoutQuantity'=>Yii::$app->request->post('inoutQuantity'),
            'endTime'=>$EndTime,
            'accreditCode'=>$random,
            'sign'=>$sign,
            'userCode'=>$user['usercode'],
            'timestamp'=>date("Y-m-d H:i:s", time()));
        $data = json_encode($data);
        var_dump($data);
          exit;
        $cipher_text = Crypt3DesUtil::encryptText($data, $user['token'], $iv);
        var_dump($cipher_text);
        //$paramData = CBCUtil::encode($data,$user['token']);
        //echo $paramData , "<br>";
        exit;
        //服务名称
        $serverName = "/api/Authentic/BusinessWebPay";
        //$serverName = "/Property/ApiVisitorAccredit";
        $data_string = array(
            'paramData'=>$paramData,
            'serviceName'=>$serverName,
            'userCode'=>$user['usercode'],
        );
        $data_string = json_encode($data_string);
        $curl = "http://auth.fujica.com.cn/api/Authentic/BusinessProperty";
        //提交数据！
        $result = CURLUtils::_request_json($curl,$data_string);
        $result = json_decode($result,true);
        var_dump($result);
        exit;
    }

    public function actionAdd(){

        return $this->render('add');
    }

}
