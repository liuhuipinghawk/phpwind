<?php

namespace app\modules\API\controllers;

use app\API\models\article;
use app\API\models\Certification;
use app\API\models\Commont;
use app\API\models\Headavatar;
use app\API\models\Like;
use app\API\models\Order;
use app\API\models\OrderForm;
use app\API\models\Profile;
use app\API\models\Propertynotice;
use app\API\models\Maintenancetype;
use app\API\models\Suggestion;
use app\API\models\WyOrder;
use app\models\Admin\ArticleLike;
use app\models\Admin\InspectionArea;
use app\util\JSONUtils;
use app\util\MessageUtil;
use app\util\OrderUtils;
use yii\web\Controller;
use app\API\models\User;
use app\API\models\City;
use app\API\models\House;
use app\API\models\Idcard;
use app\API\models\Idcardover;
use app\API\models\WorkCard;
use app\API\models\Atlas;
use Yii;
use yii\base\Object;
use app\models\Admin\Log;
use app\models\Admin\Smscode;
use app\util\MagicCrypt;
use app\models\Admin\PriceTag;
header('Access-Control-Allow-Origin:*');
/**
 * API代码的编写
 */
class ApiController extends Controller
{
    public $enableCsrfValidation = false;

    //发送验证码! 1.注册 2.忘记密码 3.修改手机号
    public function actionSendCode()
    {

        $data = array();
        $data = new \ArrayObject($data);
        echo json_encode(['status'=>-200,'message'=>'请升级爱办APP至最新版本','code'=>$data]);exit;
        // $tell = Yii::$app->request->get('tell');
        // if (empty($tell)) {
        //         echo json_encode([
        //             'code' => $data,
        //             'status' => 502,
        //             'message' => '手机号不为空！',
        //         ]);
        //         exit;
        //     } else {  
        //     $code = rand(1111, 9999);
        //     $content = "爱办APP温馨提示,您的验证码:" . $code . "【爱办APP】";
        //     //检查session是否开启
        //     if (!Yii::$app->session->isActive) {
        //         Yii::$app->session->open();
        //     }
        //     $signup_sms_time = Yii::$app->session->get('login_sms_time');
        //     //60秒内不能重复发送!
        //     if (time() - $signup_sms_time < 60) {
        //                 echo json_encode([
        //                     'code' => $data,
        //                     'status' => 500,
        //                     'message' => '六十秒之内不能重复发送验证码，请六十秒后在发送！',
        //                 ]);
        //                 exit;
        //      } else {
        //             $result = MessageUtil::send($tell, $content);
        //             if ($result) {
        //                     //验证码和短信发送时间存储session
        //                     Yii::$app->session->set('login_sms_code', $code);
        //                     Yii::$app->session->set('login_sms_time', time());
        //                     echo json_encode([
        //                         'code' => $data,
        //                         'status' => 200,
        //                         'message' => '短信发送成功！',
        //                     ]);
        //                     exit;
        //             } else {
        //                     echo json_encode([
        //                         'code' => $data,
        //                         'status' => 404,
        //                         'message' => '短信发送失败！',
        //                     ]);
        //                     exit;
        //                 }
        //             }
        //     }
    }

    // //发送验证码! 1.注册 2.忘记密码 3.修改手机号
    // public function actionSendCode1()
    // {
    //     $data = array();
    //     $data = new \ArrayObject($data);
    //     $tell = Yii::$app->request->get('tell');
    //     $type = Yii::$app->request->get('type');
    //     if (empty($tell)) {
    //         echo json_encode([ 
    //             'code' => $data,
    //             'status' => 502,
    //             'message' => '手机号不为空！',
    //         ]);
    //         exit;
    //     } else {
    //         $code = rand(1111, 9999);
    //         $content = "爱办APP温馨提示,您的验证码:" . $code . "【爱办APP】";
    //         //检查session是否开启
    //         if (!Yii::$app->session->isActive) {
    //             Yii::$app->session->open();
    //         }
    //         //注册
    //         if($type==1){
    //             $signup_sms_time = Yii::$app->session->get('login_sms_time');
    //             //60秒内不能重复发送!
    //             if (time() - $signup_sms_time < 60) {
    //                 echo json_encode([
    //                     'code' => $data,
    //                     'status' => 500,
    //                     'message' => '六十秒之内不能重复发送验证码，请六十秒后在发送！',
    //                 ]);
    //                 exit;
    //             } else {
    //                 $user = User::find()->where(array('Tell'=>$tell))->asArray()->one();
    //                 if(!empty($user)){
    //                     echo json_encode([
    //                         'code' => $data,
    //                         'status' => -200,
    //                         'message' => $tell.'已注册,请更换手机号！',
    //                     ]);
    //                     exit;
    //                 }else{
    //                     $result = MessageUtil::send($tell, $content);
    //                     if ($result) {
    //                         //验证码和短信发送时间存储session
    //                         Yii::$app->session->set('login_sms_code', $code);
    //                         Yii::$app->session->set('login_sms_time', time());
    //                         echo json_encode([
    //                             'code' => $data,
    //                             'status' => 200,
    //                             'message' => '短信发送成功！',
    //                         ]);
    //                         exit;
    //                     } else {
    //                         echo json_encode([
    //                             'code' => $data,
    //                             'status' => 404,
    //                             'message' => '短信发送失败！',
    //                         ]);
    //                         exit;
    //                     }
    //                 }
    //           }
    //           //忘记密码
    //         }elseif ($type==2){
    //             $signup_sms_time = Yii::$app->session->get('login_sms_time');
    //             //60秒内不能重复发送!
    //             if (time() - $signup_sms_time < 60){
    //                 echo json_encode([
    //                     'code' => $data,
    //                     'status' => 500,
    //                     'message' => '六十秒之内不能重复发送验证码，请六十秒后在发送！',
    //                 ]);
    //                 exit;
    //             } else {
    //                     $result = MessageUtil::send($tell, $content);
    //                     if ($result) {
    //                         //验证码和短信发送时间存储session
    //                         Yii::$app->session->set('login_sms_code', $code);
    //                         Yii::$app->session->set('login_sms_time', time());
    //                         echo json_encode([
    //                             'code' => $data,
    //                             'status' => 200,
    //                             'message' => '短信发送成功！',
    //                         ]);
    //                         exit;
    //                     } else {
    //                         echo json_encode([
    //                             'code' => $data,
    //                             'status' => 404,
    //                             'message' => '短信发送失败！',
    //                         ]);
    //                         exit;
    //                     }
    //             }
    //             // 修改手机号
    //         }else{
    //             $signup_sms_time = Yii::$app->session->get('login_sms_time');
    //             //60秒内不能重复发送!
    //             if (time() - $signup_sms_time < 60) {
    //                 echo json_encode([
    //                     'code' => $data,
    //                     'status' => 500,
    //                     'message' => '六十秒之内不能重复发送验证码，请六十秒后在发送！',
    //                 ]);
    //                 exit;
    //             } else {
    //                 $user = User::find()->where(array('Tell'=>$tell))->asArray()->one();
    //                 if(!empty($user)){
    //                     echo json_encode([
    //                         'code' => $data,
    //                         'status' => -200,
    //                         'message' => $tell.'此手机号已存在，请更换新的手机号!',
    //                     ]);
    //                     exit;
    //                 } else {
    //                     $result = MessageUtil::send($tell, $content);
    //                     if ($result) {
    //                         //验证码和短信发送时间存储session
    //                         Yii::$app->session->set('login_sms_code', $code);
    //                         Yii::$app->session->set('login_sms_time', time());
    //                         echo json_encode([
    //                             'code' => $data,
    //                             'status' => 200,
    //                             'message' => '短信发送成功！',
    //                         ]);
    //                         exit;
    //                     } else {
    //                         echo json_encode([
    //                             'code' => $data,
    //                             'status' => 404,
    //                             'message' => '短信发送失败！',
    //                         ]);
    //                         exit;
    //                     }
    //                 }
    //             }
    //         }
    //     }
    // }

    /**
     * 发送验证码 1.注册 2.忘记密码
     * @Author   tml
     * @DateTime 2018-06-07
     * @return   [type]     [description]
     */
    public function actionSendCode1()
    {
        $data = array();
        $data = new \ArrayObject($data);
        $tell = Yii::$app->request->get('tell');
        $type = Yii::$app->request->get('type');
        if (empty($tell)) {
            echo json_encode(['code'=>$data,'status'=>-200,'message'=>'手机号不能为空']);exit;
        }
        if (empty($type) || !in_array($type,[1,2])) {
            echo json_encode(['code'=>$data,'status'=>-200,'message'=>'参数错误']);exit;
        }
        $user = User::find()->where(['Tell'=>$tell])->asArray()->one();
        if ($type == 1 && $user) {
            echo json_encode(['code'=>$data,'status'=>-200,'message'=>'该手机号已注册，不可重复注册']);exit;
        }
        if ($type == 2 && empty($user)) {
            echo json_encode(['code'=>$data,'status'=>-200,'message'=>'该账号不存在，不可找回密码']);exit;
        }
        // $session = Yii::$app->session;
        // // $session = yii::$app->session;
        // $send_time = 0;
        // if ($session->has($tell)) {
        //     $send_time = $session['send_time'];
        // }
        // if (time() - $send_time < 60) {
        //     echo json_encode(['code' => $data,'status' => 500,'message' => '六十秒之内不能重复发送验证码，请六十秒后在发送！']);exit;
        // }
        // $code = rand(1111, 9999);
        // $content = "爱办APP温馨提示,您的验证码:" . $code . "【爱办APP】";
        // $ret = MessageUtil::send($tell, $content);
        // $ret = 1;
        // if ($ret) {
        //     $session['tel_'.$tell] = [
        //         'send_code' => $code,
        //         'send_time' => time(),
        //         'expire_time' => time() + 3600
        //     ];
        //     // var_dump($session['tel_'.$tell]);exit;
        //     echo json_encode(['code' => $data,'status' => 200,'message' => '短信发送成功！']);exit;
        // }
        $smscode = Smscode::find()->where(['mobile'=>$tell])->asArray()->one();
        if ($smscode && (time()-$smscode['send_time']) < 60) {
            echo json_encode(['code' => $data,'status' => -200,'message' => '六十秒之内不能重复发送验证码，请六十秒后在发送！']);exit;
        }
        if($smscode['num'] > 4 && date('Ymd', $smscode['send_time']) == date('Ymd')){
            echo json_encode(['code' => $data,'status' => -200,'message' => '每天获取验证码不能超过5次']);exit;
        }
        $code = rand(1111, 9999);
        $ret = 0;
        if ($smscode) {
            if(date('Ymd', $smscode['send_time']) != date('Ymd')){
                $ret = Smscode::updateAll(['sms_code'=>$code,'send_time'=>time(),'num'=> 1],['mobile'=>$tell]);
            }else{
                $ret = Smscode::updateAll(['sms_code'=>$code,'send_time'=>time(),'num'=> $smscode['num'] + 1],['mobile'=>$tell]);
            }
        } else {
            $smscodeM = new Smscode();
            $smscodeM->mobile = $tell;
            $smscodeM->sms_code = (string)$code;
            $smscodeM->send_time = time();
            $smscodeM->num = 1;
            $ret = $smscodeM->save();
        }
        if ($ret) {
            $content = "爱办APP温馨提示,您的验证码:" . $code . "【爱办APP】";
            $res = MessageUtil::send($tell, $content);
            if ($res) {
                echo json_encode(['code' => $data,'status' => 200,'message' => '短信发送成功！']);exit;
            }
        }
        echo json_encode(['code' => $data,'status' => 404,'message' => '短信发送失败！']);exit;
    }

    public function actioninit()
    {
        $data = array();
        $session = \Yii::$app->session;
        if(empty($session['userinfo']) || $session['userinfo']['expire_time'] < time()){
            echo json_encode([
                'code' =>$data,
                'status' => 205,
                'message' => '登录时间已过期，请重新登录'
            ]);
            exit;
        }
    }

    /**
     * 用户注册
     * @Author   tml
     * @DateTime 2018-06-07
     * @return   [type]     [description]
     */
    public function actionRegister()
    {
        $data = array();
        $data = new \ArrayObject($data);
        $tell = Yii::$app->request->get('tell');
        $code = Yii::$app->request->get('code');
        $password = Yii::$app->request->get('password');
        if (empty($tell) || empty($code) || empty($password)) {
            echo json_encode(['code' => $data,'status' => 404,'message' => '所请求的资源不存在']);exit;
        }
        $pattern = "/^1[3456789]\d{9}$/";
        if (!preg_match($pattern, $tell)) {
            echo json_encode(['code' => $data,'status' => 401,'message' => '手机号格式不正确']);exit;
        }
        // $session = Yii::$app->session;        
        // // $session = yii::$app->session;
        // if (!$session->has('tel_'.$tell)) {
        //     echo json_encode(['code' => $data,'status' => -200,'message' => '请使用注册手机号获取验证码']);exit;
        // }
        // $send_code = $session['tel_'.$tell]['send_code'] ? $session['tel_'.$tell]['send_code'] : '';
        // $send_time = $session['tel_'.$tell]['send_time'] ? $session['tel_'.$tell]['send_time'] : 0;
        // //判断验证码是否正确
        // if ($code != $send_code) {
        //     echo json_encode(['code' => $data,'status' => -200,'message' => '验证码不正确']);exit;
        // }
        // //判断验证码是否过期
        // $time = time();
        // if ($time - $send_time > 180) {
        //     $remark = 'tel=>'.$tell.',time=>'.$time.',send_time=>'.$send_time.',message=>验证码已过期，请重新获取';
        //     $this->addLog('注册',0,0,$method='api/register',$remark);
        //     echo json_encode(['code' => $data,'status' => -200,'message' => '验证码已过期，请重新获取']);exit;
        // }
        
        // 校验短信验证码
        $smscode = Smscode::find()->where(['mobile'=>$tell])->asArray()->one();
        if (empty($smscode)) {
            echo json_encode(['code' => $data,'status' => -200,'message' => '请使用注册手机号获取短信验证码']);exit;
        }
        if ($smscode && (time()-$smscode['send_time']) > 300) {
            echo json_encode(['code' => $data,'status' => -200,'message' => '短信验证码已失效，请重新获取']);exit;
        }
        if ($smscode['sms_code'] != $code) {
            echo json_encode(['code' => $data,'status' => -200,'message' => '短信验证码错误']);exit;
        }
        
        //判断手机号是否注册
        $user = User::find()->where(['Tell'=>$tell])->asArray()->one();
        if ($user) {
            echo json_encode(['code' => $data,'status' => -200,'message' => '该账号已经存在，不可重复注册']);exit;
        }
        $model = new User;
        $model->Tell = $tell;
        $model->PassWord = md5(md5($password));
        $model->CreateTime = date("Y-m-d H:i:s", time());
        $model->Status = 1;
        // $model->CateId = 1;  
        if ($model->load($model) || $model->save()) {
            $this->actionLoginNew($tell, $password);
        }
    }

    // /**
    //  * 注册API的代码
    //  * 逻辑修改
    //  *http://192.168.100.110/index.php?r=API/api/register
    //  */
    // public function actionRegister()
    // {
    //     $data = array();
    //     $data = new \ArrayObject($data);
    //     $signup_sms_code = intval(Yii::$app->session->get('login_sms_code'));
    //     $signup_sms_time = Yii::$app->session->get('login_sms_time');
    //     //取得两个值
    //     $tell = Yii::$app->request->get('tell');
    //     $code = Yii::$app->request->get('code');
    //     $password = Yii::$app->request->get('password');
    //     $pattern = "/^1[345789]\d{9}$/";
    //     //判断两个值不为空！
    //     if (empty($tell) || empty($password) || empty($tell)) {
    //         echo json_encode([
    //             'code' => $data,
    //             'status' => 404,
    //             'message' => '所请求的资源不存在!'
    //         ]);
    //         exit;
    //     } elseif (strlen($tell) > 11) {
    //         echo json_encode([
    //             'code' => $data,
    //             'status' => 400,
    //             'message' => '手机号码不能大于11位!'
    //         ]);
    //         exit;
    //     } elseif (time() - $signup_sms_time > 600) {
    //         echo json_encode([
    //             'code' => $data,
    //             'status' => 402,
    //             'message' => '验证码失效，请重新获取！'
    //         ]);
    //         exit;
    //     } elseif ($signup_sms_code != $code) {
    //         //十分钟内有效!
    //         echo json_encode([
    //             'code' => $data,
    //             'status' => 406,
    //             'message' => '验证码不正确!'
    //         ]);
    //         exit;
    //     } else if (strlen($tell) < 10) {
    //         echo json_encode([
    //             'code' => $data,
    //             'status' => 403,
    //             'message' => '手机号码不能小于11位!'
    //         ]);
    //         exit;
    //     } else if (!preg_match($pattern, $tell)) {
    //         echo json_encode([
    //             'code' => $data,
    //             'status' => 401,
    //             'message' => '手机号码格式不正确!'
    //         ]);
    //         exit;
    //     } else {
    //         $modeltell = User::find()->where(array('Tell' => $tell))->one();
    //         if (empty($modeltell)) {
    //             $model = new User;
    //             $model->Tell = $tell;
    //             $model->PassWord = md5(md5($password));
    //             $model->CreateTime = date("Y-m-d H:i:s", time());
    //             $model->Status = 1;
    //             $model->CateId = 1;  
    //             if ($model->load($model) || $model->save()) {
    //                 $this->actionLoginNew($tell, $password);
    //             }
    //         } else {
    //             echo json_encode([
    //                 'code' => $data,
    //                 'status' => 405,
    //                 'message' => '请换个手机号' . $tell . '已注册过!'
    //             ]);
    //             exit;
    //         }
    //     }
    // }
    
    /**
     * 忘记密码
     * @Author   tml
     * @DateTime 2018-06-20
     * @return   [type]     [description]
     */
    public function actionForgetPassword()
    {
        $data = array();
        $data = new \ArrayObject($data);
        $tell = Yii::$app->request->get('tell');
        $code = Yii::$app->request->get('code');
        $password = Yii::$app->request->get('password');
        if (empty($tell) || empty($code) || empty($password)) {
            echo json_encode(['code' => $data,'status' => 404,'message' => '所请求的资源不存在']);exit;
        }
        $pattern = "/^1[3456789]\d{9}$/";
        if (!preg_match($pattern, $tell)) {
            echo json_encode(['code' => $data,'status' => 401,'message' => '手机号格式不正确']);exit;
        }
        // $session = Yii::$app->session;        
        // if (!$session->has('tel_'.$tell)) {
        //     echo json_encode(['code' => $data,'status' => -200,'message' => '请使用注册手机号获取验证码']);exit;
        // }
        // $send_code = $session['tel_'.$tell]['send_code'] ? $session['tel_'.$tell]['send_code'] : '';
        // $send_time = $session['tel_'.$tell]['send_time'] ? $session['tel_'.$tell]['send_time'] : 0;
        // //判断验证码是否正确
        // if ($code != $send_code) {
        //     echo json_encode(['code' => $data,'status' => -200,'message' => '验证码不正确']);exit;
        // }
        // //判断验证码是否过期
        // $time = time();
        // if ($time - $send_time > 180) {
        //     $remark = 'tel=>'.$tell.',time=>'.$time.',send_time=>'.$send_time.',message=>验证码已过期，请重新获取';
        //     $this->addLog('找回密码',0,0,$method='api/forget-password',$remark);
        //     echo json_encode(['code' => $data,'status' => -200,'message' => '验证码已过期，请重新获取']);exit;
        // }
        
        // 校验短信验证码
        $smscode = Smscode::find()->where(['mobile'=>$tell])->asArray()->one();
        if (empty($smscode)) {
            echo json_encode(['code' => $data,'status' => -200,'message' => '请使用注册手机号获取短信验证码']);exit;
        }
        if ($smscode && (time()-$smscode['send_time']) > 300) {
            echo json_encode(['code' => $data,'status' => -200,'message' => '短信验证码已失效，请重新获取']);exit;
        }
        if ($smscode['sms_code'] != $code) {
            echo json_encode(['code' => $data,'status' => -200,'message' => '短信验证码错误']);exit;
        }

        //判断手机号是否注册
        $user = User::find()->where(['Tell'=>$tell])->asArray()->one();
        if (empty($user)) {
            echo json_encode(['code' => $data,'status' => -200,'message' => '该手机号不存在，不可进行找回密码操作']);exit;
        }
        $ret = User::updateAll(['PassWord' => md5(md5($password)),'UpdateTime'=>date('Y-m-d H:i:s',time())], ['Tell' => $tell]);
        if ($ret) {
            echo json_encode(['status'=>200,'message'=>'密码修改成功','code'=>[]]);exit;
        }
        echo json_encode(['status'=>-200,'message'=>'密码修改失败','code'=>[]]);exit;
    }

    // //忘记密码
    // public function actionForgetPassword()
    // {
    //     $data = array();
    //     $data = new \ArrayObject($data);
    //     $tell = Yii::$app->request->get('tell');
    //     $code = Yii::$app->request->get('code');
    //     $password = Yii::$app->request->get('password');
    //     if (Yii::$app->session->isActive) {
    //         Yii::$app->session->open();
    //     }
    //     $signup_sms_code = intval(Yii::$app->session->get('login_sms_code'));
    //     $signup_sms_time = Yii::$app->session->get('login_sms_time');
    //     $pattern = "/^1[345789]\d{9}$/";
    //     if (empty($tell) || empty($code) || empty($password)) {
    //         echo json_encode([
    //             'code' => $data,
    //             'status' => 404,
    //             'message' => '所请求的资源不存在!'
    //         ]);
    //         exit;
    //     } elseif (strlen($tell) > 11) {
    //         echo json_encode([
    //             'code' => $data,
    //             'status' => 400,
    //             'message' => '手机号码不能大于11位!'
    //         ]);
    //         exit;
    //     } elseif (time() - $signup_sms_time > 600) {
    //         echo json_encode([
    //             'code' => $data,
    //             'status' => 402,
    //             'message' => '验证码失效，请重新获取！'
    //         ]);
    //         exit;
    //     } elseif ($signup_sms_code != $code) {
    //         //十分钟内有效!
    //         echo json_encode([
    //             'code' => $data,
    //             'status' => 406,
    //             'message' => '验证码不正确！!'
    //         ]);
    //         exit;
    //     } else if (strlen($tell) < 10) {
    //         echo json_encode([
    //             'code' => '',
    //             'status' => 403,
    //             'message' => '手机号码不能小于11位!'
    //         ]);
    //         exit;
    //     } else if (!preg_match($pattern, $tell)) {
    //         echo json_encode([
    //             'code' => '',
    //             'status' => 401,
    //             'message' => '手机号码格式不正确!'
    //         ]);
    //         exit;
    //     } else {
    //         User::updateAll(['PassWord' => md5(md5($password))], ['Tell' => $tell]);
    //         echo json_encode([
    //             'code' => [],
    //             'status' => 200,
    //             'message' => '密码修改成功！'
    //         ]);
    //         exit;
    //     }
    // }

    public function actionDemo(){
        var_dump(Yii::$app->session['userinfo']['tell']);exit;
    }

    /**
     *登录API的代码
     * http://192.168.100.110/index.php?r=API/api/login
     */
    public function actionLogin($tell = '', $password = '')
    {
        $data = array();
        $data = new \ArrayObject($data);
        if (empty($tell) || empty($password)) {
            echo json_encode([
                'code' => $data,
                'status' => 404,
                'message' => '所请求的资源不存在!'
            ]);
            exit;
        } else if (strlen($tell) > 11) {
            echo json_encode([
                'code' => $data,
                'status' => 400,
                'message' => '手机号码不能大于11位!'
            ]);
            exit;
        } else {
            $userdata= User::find()->select('id as userId,tell,headerImg,nickName,email,trueName,CateId as identity,status,PassWord as password')->where(array('Tell'=>$tell))->asArray()->one();
            //判断是否存在！
            if (empty($userdata)) {
                $datatell = array('tell' => $tell);
                echo json_encode([
                    'code' => $datatell,
                    'status' => 407,
                    'message' => '手机号不存在，请重新注册!'
                ]);
                exit;
            } else if(!empty($userdata)) {
                //$passwordedata = User::find()->where(array('Tell' => $tell))->asArray()->one();
                $data = array('password' => $password);
                //密码不正确！  
                if ($userdata['password'] !== md5(md5($password))) {
                    echo json_encode([
                        'code' => $data,
                        'status' => 408,
                        'message' => '密码不正确！'
                    ]);
                    exit;
                } else if($userdata['password']==md5(md5($password))) {  
                    // //添加登录时间和用户名！ 
                    // session_start();
                    // ini_set('session.save_path','/tmp/');
                    // //6个钟头  
                    // ini_set('session.gc_maxlifetime',21600);
                    // //保存一天  
                    // $lifeTime =24*3600*15;
                    // setcookie(session_name(),session_id(),time()+$lifeTime ,"/");

                    $EditTime = User::updateAll(array('LoginTime' => date("Y-m-d H:i:s", time())), array('id' => $userdata['userId']));

                    $userdata['expire_time'] = time() + 14*24*60*60;
                    $session = yii::$app->session;
                    $session['userinfo'] = $userdata;

                    echo json_encode([
                        'code' => $userdata,
                        'status' => 200,
                        'message' => '登录成功!' 
                    ]);
                    exit;    
                } 
            }
        }
    }

    /**
     * APP登录接口
     * @Author   tml
     * @DateTime 2017-12-15
     * @return   [type]     [description]
     */
    public function actionLoginNew($tel = '',$pass = ''){       
        $return_data = (object)[];
        $post     = Yii::$app->request->post();
        $tell     = empty($post['tell']) ? '' : $post['tell'];
        $password = empty($post['password']) ? '' : $post['password'];
        if (!empty($tel) && !empty($pass)) {
            $tell     = $tel;
            $password = $pass;
        }
        if (!$this->checkMobile($tell)) {
            echo json_encode(['status'=>-200,'message'=>'请输入正确的手机号','code'=>$return_data]);exit;
        }
        if (empty($password)) {
            echo json_encode(['status'=>-200,'message'=>'密码不能为空','code'=>$return_data]);exit;
        }
        $users = User::find()->where(['Tell'=>$tell])->asArray()->all();
        if (empty($users)) {
            echo json_encode(['status'=>-200,'message'=>'用户不存在','code'=>$return_data]);exit;
        }
        if (count($users) > 1) {
            echo json_encode(['status'=>-200,'message'=>'账号异常，请联系管理员','code'=>$return_data]);exit;
        }
        $user = $users[0];
        if ($user['PassWord'] == md5(md5($password))) {
            //修改用户最后登录时间
            User::updateAll(['LoginTime'=>date('Y-m-d H:i:s',time())],['id'=>$user['id']]);
            //保存用户信息到session
            $userinfo['expire_time'] = time() + 7*24*60*60; //设置过期时间
            // $userinfo['expire_time'] = time() + 300; //设置过期时间
            $userinfo['userId']      = $user['id'];
            $userinfo['trueName']    = $user['TrueName'];
            $userinfo['tell']        = $user['Tell'];
            $userinfo['cateId']      = $user['CateId'];
            $userinfo['status']      = $user['Status'];
            $userinfo['headerImg']   = $user['HeaderImg'];
            $session = yii::$app->session;
            $session['userinfo'] = $userinfo;
            //获取用户基础信息，做返回数据
            $userdata = $this->getUserData($user['id']);
            echo json_encode(['status'=>200,'message'=>'登录成功','code'=>$userdata]);exit;
        } 
        echo json_encode(['status'=>-200,'message'=>'密码错误','code'=>$return_data]);exit;
    }

    /**
     * 获取用户信息
     * @Author   tml
     * @DateTime 2017-12-15
     * @return   [type]     [description]
     */
    public function actionGetUserNew(){
        $session = Yii::$app->session;
        if (empty($session['userinfo']) || $session['userinfo']['expire_time'] < time()) {
            echo json_encode(['status'=>205,'message'=>'用户信息丢失，请重新登录','code'=>[]]);exit;
        }
        $user_data = $this->getUserData($session['userinfo']['userId']);
        echo json_encode(['status'=>200,'message'=>'获取用户信息成功','code'=>$user_data]);exit;
    }

    /**
     * 根据用户ID获取用户信息
     * @Author   tml
     * @DateTime 2017-12-15
     * @param    [type]     $user_id [description]
     * @return   [type]              [description]
     */
    public function getUserData($user_id){
        if (empty($user_id)) {
            return [];
        }
        $user = User::find()->select('id as user_id,Tell as tell,HeaderImg as header_img,NickName as nick_name,Email as email,TrueName as true_name,CateId as cate_id,Position as position_id,PostId as post_id,status as certification_status')->where(['id'=>$user_id])->asArray()->one();
        if (!empty($user)) {
            $pass_area = Certification::find()->select('Status,count(CertificationId) as count')->where(['UserId'=>$user_id])->andWhere(['in','Status',[2,3]])->groupBy('Status')->orderBy('Status desc')->asArray()->all();
            if (empty($pass_area)) {
                $user['pass_status'] = 1;
            } else {
                if ($pass_area[0]['Status'] == 3) {
                    $user['pass_status'] = 3;
                } else {
                    $user['pass_status'] = 2;
                }
            }
            //通行区域
            $list = (new \yii\db\Query())
                ->select('c.CertificationId as cert_id,u.TrueName as true_name,u.Company as company,h.id as house_id,h.housename as house_name,h1.id as seat_id,h1.housename as seat_name,c.address,c.Status as status')
                ->from('certification c')
                ->leftjoin('user u','c.UserId=u.id')
                ->leftjoin('house h','c.HouseId=h.id')
                ->leftjoin('house h1','c.SeatId=h1.id')
                ->where(['c.UserId'=>$user_id,'c.Status'=>3])
                ->all();
            $user['pass_area'] = $list;
        }
        return $user;
    }

    /**
     * http://192.168.100.27/index.php?r=API/api/logout
     * 登出！操作！
     */
    public function actionLogout()
    {
        $data = array();
        $data = new \ArrayObject($data);
        yii::$app->session->remove('userinfo');
        if (!isset(yii::$app->session['userinfo']) || Yii::$app->session['expiretime'] < time()) {
            echo json_encode([
                'code' => $data,
                'status' => 200,
                'message' => '退出成功！'
            ]);
            exit;
        }
    }

    /**
     * http://192.168.100.110/index.php?r=API/api/comment-list&articleid=1&pagenum=1
     */
    //获取评论列表
    public function actionCommentList()
    {
//        $this->actioninit();
        $data = array();
        $articleid = Yii::$app->request->get('articleid');
//		$user = yii::$app->session['userinfo'];
        $pageNum = Yii::$app->request->get('pagenum') ? Yii::$app->request->get('pagenum') : 1;
        if (empty($articleid) || empty($pageNum)) {
            echo json_encode([
                'code' => $data,
                'status' => 404,
                'message' => '参数不为空！',
            ]);
            exit;
        }
        if (!isset($pageNum)) {
            $pageNum = 1;
        }
        $pageSize = 6;     
        $where['articleId'] = $articleid;        
		//$where['userId'] = $user['id'];         
        $PageRow = ($pageNum - 1) * $pageSize;
        $comment = Commont::find()->select('commont.content,commont.userId,commont.articleId,user.NickName as userName,user.HeaderImg as headImg,commont.createTime')->join('LEFT JOIN','user','user.id=commont.userId')->where($where)->offset($PageRow)->limit($pageSize)->orderBy('commont.createTime desc')->asArray()->all();
        if (empty($comment)) {
            echo json_encode([     
                'code' => $data,
                'status' => 200,
                'message' => '暂时没数据！',   
            ]);
            exit;
        } else {
            echo json_encode([
                'code' => $comment,
                'status' => 200,
                'message' => '主页数据加载成功！',
            ]);
            exit;
        }
    }

    /**
     * 修改密码!
     *http://192.168.100.27/index.php?r=API/api/mofitypassword&userid=1
     */
    public function actionMofityPassword()
    {
        $this->actioninit();
        $data = array();
        $data = new \ArrayObject($data);
        $userId = $_GET['userid'];
        $repassword = isset($_GET['repassword']) ? $_GET['repassword'] : '';
        $newpassword = isset($_GET['newpassword']) ? $_GET['newpassword'] : '';
        $password = isset($_GET['password']) ? $_GET['password'] : '';
        if (empty($repassword) || empty($newpassword) || empty($password)) {
            echo json_encode([
                'code' => $data,
                'status' => 404,
                'message' => '参数不能为空！'
            ]);
            exit;
        } else {
            if ($newpassword != $password) {
                echo json_encode([
                    'code' => $data,
                    'status' => 202,
                    'message' => '两次密码输入不一致！'
                ]);
                exit;
            } else {
                if (empty($userId)) {
                    echo json_encode([
                        'code' => $data,
                        'status' => 500,
                        'message' => '必须在登录状态下才能修改！'
                    ]);
                    exit;
                } else {  
                    User::updateAll(['PassWord' => md5(md5($password))], ['id' => $userId]);
                    echo json_encode([
                        'code' => $data,
                        'status' => 200,
                        'message' => '密码修改成功！'
                    ]);
                    exit;
                }
            }
        }
    }

    /**
     * http://192.168.100.27/index.php?r=API/api/city
     * 城市区域选择
     */
    public function actionCity()
    {
        $this->actioninit();
        $city = City::find()->asArray()->all();
        echo json_encode([
            'code' => $city,
            'status' => 200,
            'message' => "数据展示成果！"
        ]);
        exit;
    }

    /**
     * http://192.168.100.27/index.php?r=API/api/house&cityid=2
     * 楼盘选择根据城市区域选择！
     */
    public function actionHouse()
    {
        $this->actioninit();
        $data = array();
        $HouseId = Yii::$app->request->get('cityid');
        if (empty($HouseId)) {
            echo json_encode([
                'code' => $data,
                'status' => 404,
                'message' => '地理区域ID不能为空！',
            ]);
            exit;
        } else {
            $houseall = House::find()->where('cityid =:Cityid', ['Cityid' => $HouseId])->asArray()->all();
            if (empty($houseall)) {
                echo json_encode([
                    'code' => $data,
                    'status' => 500,
                    'message' => '该区域暂时没开通！',
                ]);
                exit;
            } else {
                echo json_encode([
                    'code' => $houseall,
                    'status' => 200,
                    'message' => '楼盘数据加载成功！',
                ]);
                exit;
            }
        }
    }

    /**
     *$houseid
     * $pageNum
     * http://192.168.100.27/index.php?r=API/api/index&housenameid=2&pagenum=1
     * 首页新闻资讯数据加载
     * 没条件时加载所有数据，有条件是按条件来加载所需数据！
     * 加载采用分页刷新的形式。
     */
    public function actionIndex()
    {
        $this->actioninit();
        $data = array();
        $houseid = Yii::$app->request->get('housenameid') ? Yii::$app->request->get('housenameid'):0;
        $pageNum = Yii::$app->request->get('pagenum') ? Yii::$app->request->get('pagenum') : 1;
        $type    = Yii::$app->request->get('type') ? Yii::$app->request->get('type') : '';

        if (empty($pageNum)) {
            echo json_encode([
                'code' => $data,
                'status' => 404,
                'message' => '参数不为空！',
            ]);
            exit;
        }
        if (!isset($pageNum)) {
            $pageNum = 1;
        }
        $pageSize = 6;
        //为了兼容王梦可IOS 1.0版本，新增一个type值来区分每页显示的数据条数
        if ($type == 'new') {
            $pageSize = 20; 
        }
        $PageRow = ($pageNum - 1) * $pageSize;
        if($houseid==0){
            $where1 = ['article.cateId'=>[1,2,3]];
            $article = article::find()->select('article.cateId,article.articleId as articleId,article.adminName as adminName,article.headImg as headImg,article.thumb as thumb,article.content as content,article.title as title,article.stars as stars,article.createTime as createTime,article.introduction as introduction,article.point_state as favour,article.comment_count as comment_count,article.url as url,article.houseId as houseId,house.housename as house_name,article.company')->join('LEFT JOIN ','house','house.id = article.houseId')->where($where1)->orderBy('createTime desc')->offset($PageRow)->limit($pageSize)->asArray()->all();
        }else{
            $where['article.houseId'] = $houseid;
            $where1['article.cateId'] = ['in',[1,2,3]];
            $article = article::find()->select('article.cateId,article.articleId as articleId,article.adminName as adminName,article.headImg as headImg,article.thumb as thumb,article.content as content,article.title as title,article.stars as stars,article.createTime as createTime,article.introduction as introduction,article.point_state as favour,article.comment_count as comment_count,article.url as url,article.houseId as houseId,house.housename as house_name,article.company')->join('LEFT JOIN ','house','house.id = article.houseId')->where($where)->orderBy('createTime desc')->offset($PageRow)->limit($pageSize)->asArray()->all();
        }  
        foreach ($article as $k => $v) {
            if ($v['house_name'] == '') {
                $article[$k]['house_name'] = $v['company'];
            }
        }
        // var_dump($article);exit;
        if (empty($article)) {
            echo json_encode([
                'code' => $article,
                'status' => 200,
                'message' => '暂时没数据！',
            ]);
            exit;
        } else {
            echo json_encode([
                'code' => $article,
                'status' => 200,
                'message' => '主页数据加载成功！',
            ]);
            exit;
        }
    }

    /**
     * http://192.168.100.27/index.php?r=API/api/newslist&articleid=1
     * ArticleId文章ID.
     */
    public function actionNewslist()
    {
//        $this->actioninit();
        $data = array();
        $post = yii::$app->request->get();
        $articleId = $post['articleid'];
        $user_id = isset($post['user_id'])?$post['user_id']:'';
        if (empty($articleId)) {
            echo json_encode([
                'code' => $data,
                'status' => 404,
                'message' => '参数不存在！',
            ]);
            exit;
        } elseif (!is_numeric($articleId)) {
            echo json_encode([
                'code' => $data,
                'status' => 401,   
                'message' => '参数不合法！',
            ]);
            exit;
        } else {    
            $articleList = article::find()->select('adminName,headImg,title,content,stars,thumb,createTime,introduction,url,comment_count')->where('articleId=:articleid', ['articleid' => $articleId])->asArray()->one();
            $count = ArticleLike::find()->where(['articleId'=>$articleId,'user_id'=>$user_id])->count();
            if($count == 1){
                $articleList['favour'] = 'true';
            }else{
                $articleList['favour'] = 'false';
            }
            if ($articleList) {         
                echo json_encode([  
                    'code' => $articleList,
                    'status' => 200,
                    'message' => '数据加载成功！',
                ]);
                exit;
            } else {
                echo json_encode([
                    'code' => $articleList,
                    'status' => 200,
                    'message' => '暂时没数据！',
                ]);
                exit;
            }
        }
    }

    /**
     * get
     * http://192.168.100.110/index.php?r=API/api/commont&articleid=1&content=%E5%A5%BD%E5%B0%8F%E5%AD%90
     *评论信息
     */
    public function actionCommont()
    {
        $data = array();
        $data = new \ArrayObject($data);
//        $user = yii::$app->session['userinfo'];
        $user_id = Yii::$app->request->post('user_id');
        $articleid = Yii::$app->request->post('articleid');
        $content = Yii::$app->request->post('content');
        if (empty($articleid)) {
            echo json_encode([
                'code' => $data,
                'status' => 404,
                'message' => '参数不能为空！',
            ]);
            exit;
        } else if (is_int($articleid)) {
            echo json_encode([
                'code' => $data,
                'status' => 407,
                'message' => '参数必须是数字！',
            ]);
            exit;
        } else {
			//$count = Commont::find()->where(array('articleId'=>$_GET['articleid']))->count();
            $all = User::find()->where(array('id' => $user_id))->asArray()->one();
            $Commont = new Commont();
            $Commont->articleId =$articleid;
            $Commont->content = $content;
//            $Commont->userName = $all['NickName'];
//            $Commont->headImg = $all['HeaderImg'];
            $Commont->createTime = date("Y-m-d H:i:s", time());
            $Commont->userId = $user_id;
            if ($Commont->load($Commont) || $Commont->save()) {
                $count = Commont::find()->where(array('articleId'=>$articleid))->count();
				article::updateAll(['comment_count'=>$count],['articleId'=>$articleid]);
                echo json_encode([
                    'code' => $data,
                    'status' => 200,
                    'message' => '评论成功！',
                ]);
                exit;
            }else{
                echo json_encode([
                    'code' => $data,
                    'status' => -200,
                    'message' => '评论过长',
                ]);
            }
        }
    }

    /**
     * get
     * http://192.168.100.27/index.php?r=API/api/like&articleid=1&status=1,2
     * 文章点赞
     */
    public function actionLike()
    {
        $data = array();
        $data = new \ArrayObject($data);
        $user = yii::$app->session['userinfo'];
        $get = yii::$app->request->get();
        $favour = true;
        if (empty($get['articleid'])) {
            echo json_encode([
                'code' => $data,
                'status' => 500,
                'message' => '参数不能为空！',
            ]);
            exit;
        } elseif (is_int($get['articleid'])) {
            echo json_encode([
                'code' => $data,
                'status' => 407,
                'message' => '参数必须是数字！',
            ]);
            exit;
        } else {
            //1.status 点赞，2.取消点赞
            //查询点赞的文章是否存在!
            //$starts = Like::find()->where('articleId =:articleid', ['articleid' => $get['articleid']])->asArray()->one();
            //查询是否有对应的文章
            $Article = article::find()->where('articleId =:articleid', ['articleid' => $get['articleid']])->asArray()->one();      
            $stars = $Article['stars'] + 1;     
			//未点赞,点赞  
			if($Article['point_state']=="flase"){
				article::updateAll(['point_state' =>"true",'stars'=>$stars], ['articleId' => $get['articleid']]);
			    echo json_encode([    
                        'code' => ['favour'=>'true'],
                        'status' => 200,    
                        'message' => '点赞成功！',
                    ]);
                    exit;
			}else{      
			 $starsto = $Article['stars'] - 1;      
			 article::updateAll(['point_state' =>"flase",'stars'=>$starsto], ['articleId' => $get['articleid']]);
			    echo json_encode([        
                        'code' => ['favour'=>'flase'],
                        'status' => 200,    
                        'message' => '取消点赞！',
                    ]);
                    exit;
			}				
            //	
           /** if ($get['status'] == 1) {
                $Start = $Article['stars'] + 1;
                article::updateAll(['point_state' =>2], ['articleId' => $get['articleid']]);
                $like = new Like();
                $like->status = $get['status'];
                $like->voteTime = date("Y-m-d H:i:s", time());
                $like->articleId = $get['articleid'];
                $like->userId = $user['id'];
                if ($like->load($like) || $like->save()) {
                    echo json_encode([
                        'code' => '',
                        'status' => 200,
                        'message' => '点赞成功！',
                    ]);
                    exit;
                }
            } else if ($get['status'] == 2) {
                $Start = $Article['stars'] - 1;
                article::updateAll(['point_state' =>1], ['articleId' => $get['articleid']]);
                Like::updateAll(['status' => 2], ['articleId' => $get['articleid'], 'userId' => $user['id']]);
                echo json_encode([
                    'code' => '',
                    'status' => 404,
                    'message' => '取消点赞！',
                ]);
                exit;
            }**/
        }
    }

    /**
     * 用户协议接口
     * http://192.168.100.110/index.php?r=API/api/user-agressment
     */
    public function actionUserAgressment()
    {
        $all = Propertynotice::find()->select('content,title')->where(array('cateId' => 2))->asArray()->one();
        echo json_encode([
            'code' => $all,
            'status' => 200,
            'message' => '数据加载成功！',
        ]);
        exit;
    }

    /**
     * 物业通告！
     *http://192.168.100.110/index.php?r=API/api/pertynotice&pagenum=1
     */
    public function actionPertynotice()
    {
        $pageNum = yii::$app->request->get('pagenum');
        $pageSize = 5;
        if (!isset($pageNum)) {
            $pageNum = 1;
        }
        $PageRow = ($pageNum - 1) * $pageSize;
        $all = Propertynotice::find()->select('title,author,content,createTime,thumb,pNoticeId,url')->where(array('cateId' => 1))->offset($PageRow)->limit($pageSize)->asArray()->all();
        if ($all) {
            foreach ($all as $k => $v) {
                $all[$k]['url'] ='/index.php?r=mobile/default/proery-notice&id='.$all[$k]['pNoticeId'].'&cateid=1';
            }
        }
        if (empty($all)) {
            echo json_encode([
                'code' => $all,
                'status' => 200,
                'message' => '暂时没数据！',
            ]);
            exit;
        } else {
            echo json_encode([
                'code' => $all,
                'status' => 200,
                'message' => '加载数据成功!',
            ]);
            exit;
        }
    }

    /**
     * 消息反馈
     *
     */
    public function actionSuggestion()
    {
        $post    = Yii::$app->request->post();
        $type    = empty($post['type']) ? 0 : $post['type'];
        $content = empty($post['content']) ? '' : $post['content'];
        $title = empty($post['title']) ? '' : $post['title'];
        $user_id = empty($post['user_id']) ? '' : $post['user_id'];
        if (empty($type)) {
            echo json_encode(['status'=>-200,'message'=>'参数错误']);exit;
        }
        if (empty($content)) {
            echo json_encode(['status'=>-200,'message'=>'内容不能为空']);exit;
        }
        if (empty($user_id)) {
            echo json_encode(['status'=>-200,'message'=>'用户id不能为空']);exit;
        }
        if (mb_strlen($content,'UTF8') > 200) {
            echo json_encode(['status'=>-200,'message'=>'内容最多不能超过200字符']);exit;
        }
        $model = new Suggestion;
        $model->userId = $user_id;
        $model->type   = $type;
        $model->suggestionContent = $content;
        $model->create_time = time();
        if($type == 1 || $type == 3){
            $model->title = $title;
        }
        if ($model->load($model) || $model->save()) {
            echo json_encode(['status'=>200,'message'=>'谢谢您的反馈，我们会再接再厉！']);
            exit;
        }
    }

    /**
     * http://192.168.100.110/index.php?r=API/api/editturename&turename=%E7%8E%8B%E5%A4%A7%E9%94%A4
     * 修改真实姓名
     */
    public function actionEditTurename()
    {
        $data = array();
        $data = new \ArrayObject($data);
        $post = yii::$app->request->get();
        $userId = $_GET['userid'];
        //判断是否存在！
        User::updateAll(['TrueName' => $post['turename']], ['id' => $userId]);
        echo json_encode([
            'code' => $data,
            'status' => 200,
            'message' => '真实姓名修改成功！'
        ]);
        exit;

    }

    /**
     * 修改昵称
     * http://192.168.100.27/index.php?r=API/api/editnickname&nickname=%E5%A4%A7%E5%B8%88%E9%A3%8E%E8%8C%83
     */
    public function actionEditNickname()
    {
        $data = array();
        $data = new \ArrayObject($data);
        $post = yii::$app->request->get();
        $userId = $_GET['userid'];
        //判断是否存在！
        User::updateAll(['NickName' => $post['nickname']], ['id' => $userId]);
        echo json_encode([
            'code' => $data,
            'status' => 200,
            'message' => '昵称修改成功！'
        ]);
        exit;
    }

    /**
     * 修改个人邮箱
     */
    public function actionEditEmail()
    {
        $data = array();
        $data = new \ArrayObject($data);
        $post = yii::$app->request->get();
        $userId = $_GET['userid'];
        //判断是否存在！
        User::updateAll(['Email' => $post['email']], ['id' => $userId]);
        echo json_encode([
            'code' => $data,
            'status' => 200,
            'message' => '个人邮箱修改成功！'
        ]);
        exit;
    }

    /**
     * 修改手机号
     */
    public function actionEditPhone()
    {
        $data = array();
        $data = new \ArrayObject($data);
        $user = yii::$app->session['userinfo'];
        $id = $user['userId'];
        $tell = Yii::$app->request->get('tell');
        $code = Yii::$app->request->get('code');
        $codetell = User::find()->where(array('Tell'=>$tell))->asArray()->one();
        if(!empty($codetell)){
            echo json_encode([
                'code' => $data,
                'status' => 405,
                'message' => '手机号修改失败!'
            ]);
            exit;
        }else{
            if (Yii::$app->session->isActive) {
                Yii::$app->session->open();
            }
            $signup_sms_code = intval(Yii::$app->session->get('login_sms_code'));
            $signup_sms_time = Yii::$app->session->get('login_sms_time');
            $pattern = "/^1[3456789]\d{9}$/";
            if (empty($tell) || empty($code)) {
                echo json_encode([
                    'code' => $data,
                    'status' => 404,
                    'message' => '所请求的资源不存在!'
                ]);
                exit;
            } elseif (strlen($tell) > 11) {
                echo json_encode([
                    'code' => $data,
                    'status' => 400,
                    'message' => '手机号码不能大于11位!'
                ]);
                exit;
            }elseif (time() - $signup_sms_time > 600) {
                echo json_encode([
                    'code' => $data,
                    'status' => 402,
                    'message' => '验证码失效，请重新获取！'
                ]);
                exit;
            } elseif ($signup_sms_code != $code) {
                //十分钟内有效!
                echo json_encode([
                    'code' => $data,
                    'status' => 406,
                    'message' => '验证码不正确！!'
                ]);
                exit;
            } else if (strlen($tell) < 10) {
                echo json_encode([
                    'code' => $data,
                    'status' => 403,
                    'message' => '手机号码不能小于11位!'
                ]);
                exit;
            } else if (!preg_match($pattern, $tell)) {
                echo json_encode([
                    'code' => $data,
                    'status' => 401,
                    'message' => '手机号码格式不正确!'
                ]);
                exit;
            } else {
                User::updateAll(['Tell' => $tell], ['id' => $id]);
                echo json_encode([
                    'code' => $data,
                    'status' => 200,
                    'message' => '手机号修改成功！'
                ]);
                exit;
            }
        }
    }

    /**
     * http://192.168.100.27/index.php?r=API/api/houselist
     * 需要展示的数据API
     */
    public function actionHouselist()
    {
        $HouseList = House::find()->select('id,housename')->asArray()->all();
        echo json_encode([
            'code' => $HouseList,
            'status' => 200,
            'message' => '楼盘数据加载成功！',
        ]);
        exit;
    }

    //多图片上传!
    public function actionImages1()
    {
        $data = array();
        $data = new \ArrayObject($data);
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
                $uploadfile = $base_path . basename($name);
                $isSave = move_uploaded_file($tmp_name, $uploadfile);
                if ($isSave) {
                    $imgs[] = $uploadfile;
                    $images = str_replace(".", " ", $imgs);
                    $model = new Atlas();
                    $model->Thumb = json_encode($images);
                    $model->CreateTime = date("Y-m-d H:i:s", time());
                    if ($model->load($model) || $model->save()) {
                        $array = array("code" => $data, "status" => 200, "message" => '上传成功！');
                        echo json_encode($array);
                    } else {
                        $array = array("code" => $data, "status" => 402, "message" =>'"图片上传服务器失败!');
                        echo json_encode($array);
                    }
                }
            }
        }
    }
    //多图片上传
    public function actionImages(){
        $data = array();
        $data = new \ArrayObject($data);
        $base_path = "./uploads/Order/"; //接收文件目录
        $base_path1 = "/uploads/Order/"; //接收文件目录
        $imgs = array();  //定义一个数组存放上传图片的路径
        $isSave = false;
        if (!file_exists($base_path)) {
            mkdir($base_path);
        }

        foreach ($_FILES["uploadfile"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["uploadfile"]["tmp_name"][$key];
                $name = $_FILES["uploadfile"]["name"][$key];
                $uploadfile = $base_path . $name;
                $uploadfile1 = $base_path1 . $name;
                $isSave = move_uploaded_file($tmp_name, $uploadfile);
                if ($isSave){
                    $imgs[]=$uploadfile1;
                }
            }
        }

        if ($isSave) {
            //$images = str_replace("/uploads/Order/".$name, "./uploads/Order/".$name,$imgs);
            //$images = implode(',',array_values($imgs));
            $json = json_encode($imgs);
            //$seri = serialize($json);
            $model = new Atlas();
            $model->Thumb = $json;   
            $model->CreateTime = date("Y-m-d H:i:s", time());
            $model->OrderId ="";
            if ($model->load($model) || $model->save()) {
                $array = array("code" => $data, "status" => 200, "message" => '上传成功！');
                echo json_encode($array);
            } else {
                $array = array("code" => $data, "status" => 402, "message" =>"图片上传服务器失败!");
                echo json_encode($array);
            }
        } else {
            $array = array("code" => $data,'status'=>404,"message" => "上传图片路径错误!,", "imgUrls" => $imgs);
            echo json_encode($array);
        }
    }

    /**
     * 报检报修
     *http://192.168.100.110/index.php?r=API/api/order
     * 添加维修订单。
     */
    public function actionOrder()
    {
        $data = array();
        $data = new \ArrayObject($data);
        $houseId = isset($_GET['houseId']) ? $_GET['houseId'] : '';
        $seatId = isset($_GET['seatId']) ? $_GET['seatId'] : '';
        $roomNum = isset($_GET['roomNum']) ? $_GET['roomNum'] : '';
        $userId = isset($_GET['userId']) ? $_GET['userId'] : '';
        //$company = isset($_GET['company']) ? $_GET['company'] : '';
        //$title = isset($_GET['title']) ? $_GET['title'] : '';
        $content = isset($_GET['content']) ? $_GET['content'] : '';
        $persion = isset($_GET['persion']) ? $_GET['persion'] : '';
        $tell = isset($_GET['tell']) ? $_GET['tell'] : '';
        //$address = isset($_GET['address']) ? $_GET['address'] : '';
        $maintenanceType = isset($_GET['maintenanceType']) ? $_GET['maintenanceType'] : '';
        $areaId = isset($_GET['areaId']) ? $_GET['areaId'] : '';
        $OrderTime = date("Y-m-d H:i:s", time());//订单生成时间
        $thumb = Atlas::find()->orderBy('Id desc')->asArray()->one();
        if(strlen($content)>=600){
            echo json_encode([
                'code' => $data,
                'status' => 208,
                'message' => '内容过长,请重新添加！',
            ]);
            exit;
        }else{
            // 1.判断是否实名认证成功，如果成功就返回正常添加的数据，否则就提示实名认证!
                $model = new Order();
                $model->OrderId = OrderUtils::build_order_no();
                $model->UserId = $userId;
                $model->HouseId = $houseId;
                $model->SeatId = $seatId;
                $model->RoomNum = $roomNum;
                $model->Content = $content;
                $model->Persion = $persion;
                $model->Number = $tell;
                $model->OrderTime = $OrderTime;
                $model->maintenanceType = $maintenanceType;
                $model->area_id = $areaId;
                $model->Status = 1;
                $model->Tumb = $thumb['Thumb'];
                if ($model->load($model) || $model->save()) {
                    echo json_encode([
                        'code' => $data,
                        'status' => 200,
                        'message' => '订单数据添加成功！',
                    ]);
                    exit;
                } else {
                    echo json_encode([
                        'code' => $data,
                        'status' => 404,
                        'message' => '订单数据添加失败！',
                    ]);
                    exit;
                }
        } 
    }

    /**
     * 报检报修
     *http://192.168.100.110/index.php?r=API/api/order1
     * 添加维修订单。
     */
    public function actionOrder1()
    {
        $data = array();
        $data = new \ArrayObject($data);
        $houseId = isset($_POST['houseId']) ? $_POST['houseId'] : '';
        $seatId = isset($_POST['seatId']) ? $_POST['seatId'] : '';
        $roomNum = isset($_POST['roomNum']) ? $_POST['roomNum'] : '';
        $userId = isset($_POST['userId']) ? $_POST['userId'] : '';
        //$company = isset($_GET['company']) ? $_GET['company'] : '';
        //$title = isset($_GET['title']) ? $_GET['title'] : '';
        $content = isset($_POST['content']) ? $_POST['content'] : '';
        $persion = isset($_POST['persion']) ? $_POST['persion'] : '';
        $tell = isset($_POST['tell']) ? $_POST['tell'] : '';
        //$address = isset($_GET['address']) ? $_GET['address'] : '';
        $maintenanceType = isset($_POST['maintenanceType']) ? $_POST['maintenanceType'] : '';
        $areaId = isset($_POST['areaId']) ? $_POST['areaId'] : '';
        $OrderTime = date("Y-m-d H:i:s", time());//订单生成时间
        $pattern = "/^1[3456789]\d{9}$/";
        if(strlen($content)>=600){
            echo json_encode([
                'code' => $data,
                'status' => 208,
                'message' => '内容过长,请重新添加！',
            ]);
            exit;
        }else if (strlen($tell) < 10) {
            echo json_encode([
                'code' => $data,
                'status' => 403,
                'message' => '手机号码不能小于11位!'
            ]);
            exit;
        } else if (!preg_match($pattern, $tell)) {
            echo json_encode([
                'code' => $data,
                'status' => 401,
                'message' => '手机号码格式不正确!'
            ]);
            exit;
        }else{
            error_reporting(0);
            $base_path = "./uploads/Order/"; //接收文件目录
            $base_path1 = "/uploads/Order/"; //接收文件目录
            $imgs = array();  //定义一个数组存放上传图片的路径
            $isSave = false;
            if(!file_exists($base_path)){
                mkdir($base_path);
            }
            foreach ($_FILES["uploadfile"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["uploadfile"]["tmp_name"][$key];
                    $name = $_FILES["uploadfile"]["name"][$key];
                    $uploadfile = $base_path . $name;
                    $uploadfile1 = $base_path1 . $name;
                    $isSave = move_uploaded_file($tmp_name,$uploadfile);
                    if ($isSave){
                        $imgs[]=$uploadfile1;
                    }
                }
            }
            $save = 1;
            if ($save == 1) {
                $json = json_encode($imgs);
//                $Atlas = new Atlas();
//                $Atlas->Thumb = $json;
//                $Atlas->CreateTime = date("Y-m-d H:i:s", time());
//                $Atlas->OrderId =OrderUtils::build_order_no();
//                $Atlas->save();
                $model = new Order();
                $model->OrderId = OrderUtils::build_order_no();
                $model->UserId = $userId;
                $model->HouseId = $houseId;
                $model->SeatId = $seatId;
                $model->RoomNum = $roomNum;
                $model->Content = $content;
                $model->Persion = $persion;
                $model->Number = $tell;
                $model->OrderTime = $OrderTime;
                $model->maintenanceType = $maintenanceType;
                $model->area_id = $areaId;
                $model->Status = 1;
                $nomag = array("/uploads/Order/nomap.jpg");
                $nojsonmag = json_encode($nomag);
                if($json=='[]'){
                    $model->Tumb = $nojsonmag;
                }else{
                    $model->Tumb = $json;
                }
                if ($model->load($model) || $model->save()) {
                    echo json_encode([
                        'code' => $data,
                        'status' => 200,
                        'message' => '订单数据添加成功！',
                    ]);
                    exit;
                } else {
                    echo json_encode([
                        'code' => $data,
                        'status' => 404,
                        'message' => '订单数据添加失败！',
                    ]);
                    exit;
                }
            } else {
                $array = array("code" => $data,'status'=>404,"message" => "上传图片路径错误!,", "imgUrls" => $imgs);
                echo json_encode($array);
                exit;
            }
        }
    }

    //遍历楼盘接口
    public function actionSeat()
    {
        $data = House::find()->select('id,housename')->where(['parentId' => 0])->orderBy('sort asc')->Asarray()->all();
        echo json_encode([
            'code' => $data,
            'status' => 200,
            'message' => '楼盘数据加载成功！',
        ]);
        exit;
    }

    //遍历座号接口
    public function actionSeatList()
    {
        $parentid = Yii::$app->request->get('id');
        $seat = House::find()->select('id,housename')->where(['parentId' => $parentid])->Asarray()->all();
        echo json_encode([
            'code' => $seat,
            'status' => 200,
            'message' => '座号数据加载成功！',
        ]);
        exit;
    }

    //保修类型
    public function actionType()
    {
        $type = Maintenancetype::find()->select('id as TypeId,housename as TypeName')->Asarray()->all();
        echo json_encode([
            'code' => $type,
            'status' => 200,
            'message' => '维修类型数据加载成功！',
        ]);
        exit;
    }

    //维修类型区域
    public function actionInspectionArea(){
        $area = InspectionArea::find()->select('area_id,area_name')->asArray()->all();
        echo json_encode([
            'code' => $area,
            'status' => 200,
            'message' => '维修类型区域数据加载成功！',
        ]);
        exit;
    }

    //遍历楼盘数据
    public function actionOffice()
    {
        $HouseList = House::find()->select('id,housename')->asArray()->all();
        echo json_encode([
            'code' => $HouseList,
            'status' => 200,
            'message' => '楼盘数据加载成功！',
        ]);
        exit;
    }

    //身份证正面
    public function actionCard()
    {
        // $data = array();
        // $data = new \ArrayObject($data);
        // error_reporting(0);
        // $base_path = "./uploads/Card/"; //接收文件目录
        // $target_path = $base_path . basename($_FILES ['uploadfile']['name']);

        // if (move_uploaded_file($_FILES ['uploadfile']['tmp_name'], $target_path)) {
        //     $model = new Idcard();
        //     $model->thumb = $target_path;
        //     $model->createTime = date("Y-m-d H:i:s", time());
        //     if ($model->load($model) || $model->save()) {
        //         $array = array("code" => $data, "status" => 200, "message" => '上传成功！');
        //         echo json_encode($array);
        //     } else {
        //         $array = array("code" => $data, "status" => 402, "message" =>'图片上传服务器失败!');
        //         echo json_encode($array);
        //     }
        // } else {
        //     $array = array("code" => $data, "status" => 404, "message" => "上传失败，请再次上传!");
        //     echo json_encode($array);
        // }

        $img = $_FILES['uploadfile'];
        if ($img['error'] > 0) {
            echo json_encode(['status'=>-200,'message'=>'文件错误','code'=>'']);exit;
        }
        $suffix = strrchr($img['name'], '.');
        if (!in_array(strtolower($suffix), array('.jpg','.jpeg','.png','.gif'))) {
            echo json_encode(['status'=>-200,'message'=>'图片格式错误','code'=>'']);exit;
        }
        if ($img['size'] > 1024*1024*2) {
            echo json_encode(['status'=>-200,'message'=>'图片大小不可超过2M','code'=>'']);exit;
        }
        $user_id = empty(Yii::$app->request->post('userId')) ? 0 : Yii::$app->request->post('userId');
        if (empty($user_id)) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
        }
        $base_path = "uploads/Card/"; //接收文件目录
        if (!is_dir($base_path)) {
            mkdir($base_path,0777,true);
        }
        $target_path = $base_path . basename($img['name']);
        if (move_uploaded_file($img['tmp_name'], $target_path)) {
            $res = User::updateAll(['IdCard'=>$target_path],['id'=>$user_id]);
            if ($res) {
                echo json_encode(['status'=>200,'message'=>'上传成功','code'=>'']);exit;
            }
            echo json_encode(['status'=>-200,'message'=>'数据保存失败','code'=>'']);exit;
        }
        echo json_encode(['status'=>-200,'message'=>'上传失败','code'=>'']);exit;
    }

    //身份证反面
    public function actionCardOver()
    {
        // $data = array();
        // $data = new \ArrayObject($data);
        // error_reporting(0);
        // $base_path = "./uploads/Card/"; //接收文件目录
        // $target_path = $base_path . basename($_FILES ['uploadfile']['name']);
        // if (move_uploaded_file($_FILES ['uploadfile']['tmp_name'], $target_path)) {
        //     $model = new Idcardover();
        //     $model->thumb = $target_path;
        //     $model->createTime = date("Y-m-d H:i:s", time());
        //     if ($model->load($model) || $model->save()) {
        //         $array = array("code" => $data, "status" => 200, "message" => '上传成功！');
        //         echo json_encode($array);
        //     } else {
        //         $array = array("code" => $data, "status" => 402, "message" => '图片上传服务器失败!');
        //         echo json_encode($array);
        //     }
        // } else {
        //     $array = array("code" => $data, "status" => 404, "message" => "上传失败，请再次上传!");
        //     echo json_encode($array);
        // }

        $img = $_FILES['uploadfile'];
        if ($img['error'] > 0) {
            echo json_encode(['status'=>-200,'message'=>'文件错误','code'=>'']);exit;
        }
        $suffix = strrchr($img['name'], '.');
        if (!in_array(strtolower($suffix), array('.jpg','.jpeg','.png','.gif'))) {
            echo json_encode(['status'=>-200,'message'=>'图片格式错误','code'=>'']);exit;
        }
        if ($img['size'] > 1024*1024*2) {
            echo json_encode(['status'=>-200,'message'=>'图片大小不可超过2M','code'=>'']);exit;
        }
        $user_id = empty(Yii::$app->request->post('userId')) ? 0 : Yii::$app->request->post('userId');
        if (empty($user_id)) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
        }
        $base_path = "uploads/Card/"; //接收文件目录
        if (!is_dir($base_path)) {
            mkdir($base_path,0777,true);
        }
        $target_path = $base_path . basename($img['name']);
        if (move_uploaded_file($img['tmp_name'], $target_path)) {
            $res = User::updateAll(['IdCardOver'=>$target_path],['id'=>$user_id]);
            if ($res) {
                echo json_encode(['status'=>200,'message'=>'上传成功','code'=>'']);exit;
            }
            echo json_encode(['status'=>-200,'message'=>'数据保存失败','code'=>'']);exit;
        }
        echo json_encode(['status'=>-200,'message'=>'上传失败','code'=>'']);exit;
    }

    //工牌
    public function actionWorkCard()
    {
        // $data = array();
        // $data = new \ArrayObject($data);
        // error_reporting(0);
        // $base_path = "./uploads/WorkCard/"; //接收文件目录
        // $target_path = $base_path . basename($_FILES ['uploadfile']['name']);
        // if (move_uploaded_file($_FILES ['uploadfile']['tmp_name'], $target_path)) {
        //     $model = new WorkCard();
        //     $model->thumb = $target_path;
        //     $model->createTime = date("Y-m-d H:i:s", time());
        //     if ($model->load($model) || $model->save()) {
        //         $array = array("code" => $data, "status" => 200, "message" => '上传成功！');
        //         echo json_encode($array);
        //     } else {
        //         $array = array("code" => $data, "status" => 402, "message" => '图片上传服务器失败!');
        //         echo json_encode($array);
        //     }
        // } else {
        //     $array = array("code" => $data, "status" => 404, "message" => "上传失败，请再次上传!");
        //     echo json_encode($array);
        // }

        $img = $_FILES['uploadfile'];
        if ($img['error'] > 0) {
            echo json_encode(['status'=>-200,'message'=>'文件错误','code'=>'']);exit;
        }
        $suffix = strrchr($img['name'], '.');
        if (!in_array(strtolower($suffix), array('.jpg','.jpeg','.png','.gif'))) {
            echo json_encode(['status'=>-200,'message'=>'图片格式错误','code'=>'']);exit;
        }
        if ($img['size'] > 1024*1024*2) {
            echo json_encode(['status'=>-200,'message'=>'图片大小不可超过2M','code'=>'']);exit;
        }
        $user_id = empty(Yii::$app->request->post('userId')) ? 0 : Yii::$app->request->post('userId');
        if (empty($user_id)) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
        }
        $base_path = "uploads/Card/"; //接收文件目录
        if (!is_dir($base_path)) {
            mkdir($base_path,0777,true);
        }
        $target_path = $base_path . basename($img['name']);
        if (move_uploaded_file($img['tmp_name'], $target_path)) {
            $res = User::updateAll(['WorkCard'=>$target_path],['id'=>$user_id]);
            if ($res) {
                echo json_encode(['status'=>200,'message'=>'上传成功','code'=>'']);exit;
            }
            echo json_encode(['status'=>-200,'message'=>'数据保存失败','code'=>'']);exit;
        }
        echo json_encode(['status'=>-200,'message'=>'上传失败','code'=>'']);exit;
    }
    //实名认证 1.业主 2.员工 3.工程师傅
    /**
     *判断user里有没有图片，如果没有图片就添加图片及一些参数,
     * 如果有图片，就展示出来，直接添加参数就可以！
     */
    public function actionCertification(){
        $get = Yii::$app->request->get();
        $user_id   = empty($get['UserId']) ? 0 : $get['UserId'];
        $user_type = empty($get['Type']) ? 0 : $get['Type'];
        if (empty($user_id) || empty($user_type) || !in_array($user_type,[1,2,3])) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
        }
        $user = User::find()->where(['id'=>$user_id])->one();
        if (empty($user)) {
            echo json_encode(['status'=>-200,'message'=>'用户不存在','code'=>'']);exit;
        }
        if ($user['Status'] == 3) { //审核通过，（二次通行区域认证）
            if ($user['CateId'] == $user_type) {
                $house_id  = empty($get['HouseId']) ? 0 : $get['HouseId'];
                $seat_id   = empty($get['SeatId']) ? 0 : $get['SeatId'];
                $address   = empty($get['RoomNum']) ? '' : $get['RoomNum'];
                $company   = empty($get['company']) ? '' : $get['company'];
                $depart    = empty($get['Department']) ? '' : $get['Department'];
                $position  = empty($get['Position']) ? '' : $get['Position'];
                $mtype     = empty($get['MaintenanceType']) ? 0 : $get['MaintenanceType'];
                if (empty($house_id) || empty($seat_id)) {
                    echo json_encode(['status'=>-200,'message'=>'楼盘信息不能为空','code'=>'']);exit;
                }
                if ($user_type == 3) {
                    if (empty($mtype)) {
                        echo json_encode(['status'=>-200,'message'=>'维修类型不能为空','code'=>'']);exit;
                    }
                }
                //添加通行区域
                $cert = Certification::find()->where(['UserId'=>$user_id,'HouseId'=>$house_id,'SeatId'=>$seat_id])->all();
                if ($cert) {
                    echo json_encode(['status'=>-200,'message'=>'不可添加重复的通行区域','code'=>'']);exit;
                }
                $model = new Certification();
                $model->UserId  = $user_id;
                $model->HouseId = $house_id;
                $model->SeatId  = $seat_id;
                $model->Address = $address;
                $model->Company = $company;
                $model->Department = $depart;
                $model->Position = $position;
                $model->Maintenancetype = $mtype;
                $model->Status  = 1;
                $model->CreateTime = date('Y-m-d H:i:s',time());
                $model->CateId  = $user_type;
                $res = $model->save();
                if ($res) {
                    echo json_encode(['status'=>200,'message'=>'提交成功，请耐心等待审核...','code'=>'']);exit;
                }
                echo json_encode(['status'=>-200,'message'=>'通行区域添加失败','code'=>'']);exit;
            }
            echo json_encode(['status'=>-200,'message'=>'用户身份有误，请核对','code'=>'']);exit;
        } else if ($user['Status'] == 2) { //审核中
            echo json_encode(['status'=>200,'message'=>'实名认证信息审核中，请耐心等待...','code'=>'']);exit;
        } else { //未认证
            $true_name = empty($get['TrueName']) ? '' : $get['TrueName'];
            $house_id  = empty($get['HouseId']) ? 0 : $get['HouseId'];
            $seat_id   = empty($get['SeatId']) ? 0 : $get['SeatId'];
            $address   = empty($get['RoomNum']) ? '' : $get['RoomNum'];
            $company   = empty($get['Company']) ? '' : $get['Company'];
            $depart    = empty($get['Department']) ? '' : $get['Department'];
            $position  = empty($get['Position']) ? '' : $get['Position'];
            $mtype     = empty($get['MaintenanceType']) ? 0 : $get['MaintenanceType'];
            if (empty($true_name)) {
                echo json_encode(['status'=>-200,'message'=>'真实姓名不能为空','code'=>'']);exit;
            }
            if (empty($house_id) || empty($seat_id)) {
                echo json_encode(['status'=>-200,'message'=>'楼盘信息不能为空','code'=>'']);exit;
            }
            if (empty($address)) {
                echo json_encode(['status'=>-200,'message'=>'房间号不能为空','code'=>'']);exit;
            }
            if ($user_type == 1) { //业主
                if (empty($user['IdCard']) || empty($user['IdCardOver'])) {
                    echo json_encode(['status'=>-200,'message'=>'请上传身份证照片','code'=>'']);exit;
                }
            } else if ($user_type == 2) { //用户
                if (empty($company)) {
                    echo json_encode(['status'=>-200,'message'=>'公司信息不能为空','code'=>'']);exit;
                } 
                if (empty($user['IdCard']) || empty($user['IdCardOver'])) {
                    echo json_encode(['status'=>-200,'message'=>'请上传身份证照片','code'=>'']);exit;
                }
                if (empty($user['WorkCard'])) {
                    echo json_encode(['status'=>-200,'message'=>'请上传工作证照片','code'=>'']);exit;
                }
            } else if ($user_type == 3) { //维修师傅
                if (empty($company)) {
                    echo json_encode(['status'=>-200,'message'=>'公司信息不能为空','code'=>'']);exit;
                }
                if (empty($mtype)) {
                    echo json_encode(['status'=>-200,'message'=>'维修类型不能为空','code'=>'']);exit;
                }  
                if (empty($user['IdCard']) || empty($user['IdCardOver'])) {
                    echo json_encode(['status'=>-200,'message'=>'请上传身份证照片','code'=>'']);exit;
                }
                if (empty($user['WorkCard'])) {
                    echo json_encode(['status'=>-200,'message'=>'请上传工作证照片','code'=>'']);exit;
                }
            }
            //更新实名认证信息
            $con['TrueName']   = $true_name;
            $con['HouseId']    = $house_id;
            $con['Seat']       = $seat_id;
            $con['Address']    = $address;
            $con['CateId']     = $user_type;
            $con['Company']    = $company;
            $con['Department'] = $depart;
            $con['Position']   = $position;
            $con['MaintenanceType'] = $mtype;
            $con['UpdateTime'] = date('Y-m-d H:i:s',time());
            $con['Status']     = 2;
            $res = User::updateAll($con,['id'=>$user_id]);
            if ($res) {
                //添加通行区域信息
                $cert = Certification::find()->where(['UserId'=>$user_id,'HouseId'=>$house_id,'SeatId'=>$seat_id])->all();
                if ($cert) {
                    echo json_encode(['status'=>-200,'message'=>'不可添加重复的通行区域','code'=>'']);exit;
                }
                $model = new Certification();
                $model->UserId  = $user_id;
                $model->HouseId = $house_id;
                $model->SeatId  = $seat_id;
                $model->Address = $address;
                $model->Company = $company;
                $model->Department = $depart;
                $model->Position = $position;
                $model->Maintenancetype = $mtype;
                $model->Status  = 1;
                $model->CreateTime = date('Y-m-d H:i:s',time());
                $model->CateId  = $user_type;
                $res1 = $model->save();
                if ($res1) {
                    echo json_encode(['status'=>200,'message'=>'提交成功，请耐心等待审核...','code'=>'']);exit;
                }
                echo json_encode(['status'=>-200,'message'=>'通行区域添加失败','code'=>'']);exit;
            }
            echo json_encode(['status'=>-200,'message'=>'提交失败','code'=>'']);exit;
        }
    }

    public function actionCertification1()
    {
        $data = array();
        $data = new \ArrayObject($data);
        $type = $_GET['Type'];
        $userId = $_GET['UserId'];
        //$truename = $_GET['TrueName'];
        $houseId = $_GET['HouseId'];
        $seat = $_GET['SeatId'];
        //$roomId = $_GET['roomId'];
        $address = $_GET['RoomNum'];//房间号
        //$company = $_GET['Company'];
        if (empty($type) || empty($userId) || empty($address)) {
            echo json_encode([
                'code' => $data,
                'status' => 500,
                'message' => '参数不为空！',
            ]);
            exit;
        } else {
            $user = User::find()->where(['id' => $userId])->asArray()->one();
            if (empty($user['IdCard']) || empty($user['IdCardOver']) || empty($user['WorkCard'])) {
                $truename = $_GET['TrueName'];
                $tell = $_GET['Tell'];
                $Card = Idcard::find()->orderBy('id desc')->asArray()->one();
                $Cardover = Idcardover::find()->orderBy('id desc')->asArray()->one();
                $Work = WorkCard::find()->orderBy('id desc')->asArray()->one();
                $IdCard = $Card['thumb'];
                $IdCardOver = $Cardover['thumb'];
                $WorkCard = $Work['thumb'];
                if ($type == 1) {
                    //判断是否存在！
                    User::updateAll(['Tell' => $tell, 'TrueName' => $truename, 'IdCard' => $IdCard, 'IdCardOver' => $IdCardOver, 'UpdateTime' => date("Y-m-d H:i:s", time()),'Status'=>2,'CateId'=>1], ['id' => $userId]);
                    $cerfication = new Certification();
                    $cerfication->UserId = $userId;
                    $cerfication->HouseId = $houseId;
                    $cerfication->SeatId = $seat;
                    //$cerfication->roomId = $roomId;
                    $cerfication->Address = $address;
                    $cerfication->CreateTime = date("Y-m-d H:i:s", time());
                    $cerfication->Status = 2;       
                    if ($cerfication->load($cerfication) || $cerfication->save()) {
                        echo json_encode([
                            'code' => $data,
                            'status' => 200,
                            'message' => '添加成功！'
                        ]);
                        exit;
                    }
                    //User::updateAll(['Tell'=>$tell,'TrueName'=>$truename,'HouseId'=>$houseId,'Seat'=>$seat,'Address'=>$address,'IdCard'=>$IdCard,'IdCardOver'=>$IdCardOver,'UpdateTime'=>date("Y-m-d H:i:s", time()),'CateId'=>1],['id'=>$userId]);
                } else if ($type == 2) {
                    $company = $_GET['Company'];
                    //判断是否存在！
                    User::updateAll(['Tell' => $tell, 'TrueName' => $truename, 'IdCard' => $IdCard, 'IdCardOver' => $IdCardOver, 'WorkCard' => $WorkCard, 'UpdateTime' => date("Y-m-d H:i:s", time()),'Status'=>2,'CateId'=>2], ['id' => $userId]);
                    $cerfication = new Certification();
                    $cerfication->UserId = $userId;
                    $cerfication->HouseId = $houseId;
                    $cerfication->SeatId = $seat;
                    //$cerfication->roomId = $roomId;
                    $cerfication->Address = $address;
                    $cerfication->Company = $company;
                    $cerfication->CreateTime = date("Y-m-d H:i:s", time());
                    $cerfication->Status = 2;
                    //$cerfication->CateId = 2;
                    if ($cerfication->load($cerfication) || $cerfication->save()) {
                        echo json_encode([
                            'code' => $data,
                            'status' => 200,
                            'message' => '添加成功！'
                        ]);
                        exit;
                    }
                } else {
                    User::updateAll(['Tell' => $tell, 'TrueName' => $truename, 'IdCard' => $IdCard, 'IdCardOver' => $IdCardOver, 'WorkCard' => $WorkCard, 'UpdateTime' => date("Y-m-d H:i:s", time()),'Status'=>2,'CateId'=>3], ['id' => $userId]);
                    $Department = $_GET['Department'];
                    $Position = $_GET['Position'];
                    $Maintenancetype = $_GET['MaintenanceType'];
                    $cerfication = new Certification();
                    $cerfication->UserId = $userId;
                    $cerfication->HouseId = $houseId;
                    $cerfication->SeatId = $seat;
                    //$cerfication->roomId = $roomId;
                    $cerfication->Address = $address;
                    $cerfication->Department = $Department;
                    $cerfication->Position = $Position;
                    $cerfication->Maintenancetype = $Maintenancetype;
                    $cerfication->CreateTime = date("Y-m-d H:i:s", time());
                    $cerfication->Status = 2;
                    //$cerfication->CateId = 3;
                    if ($cerfication->load($cerfication) || $cerfication->save()) {
                        echo json_encode([
                            'code' => $data,
                            'status' => 200,
                            'message' => '添加成功！'
                        ]);
                        exit;
                    }
                }
            } else {
                $identy = User::find()->where(array('id'=>$userId))->asArray()->one();
                if($identy['CateId']==$type){     
                    if ($type == 1) {
                        //User::updateAll(['UpdateTime' => date("Y-m-d H:i:s", time()),'Status'=>3,'CateId'=>1], ['id' => $userId]);
                        $cerfication = new Certification();
                        $cerfication->UserId = $userId;
                        $cerfication->HouseId = $houseId;
                        $cerfication->SeatId = $seat;
                        //$cerfication->roomId = $roomId;
                        $cerfication->Address = $address;
                        $cerfication->CreateTime = date("Y-m-d H:i:s", time());
                        $cerfication->Status = 2;
                        //$cerfication->CateId = 1;
                        if ($cerfication->load($cerfication) || $cerfication->save()) {
                            echo json_encode([
                                'code' => $data,
                                'status' => 200,
                                'message' => '添加成功！'
                            ]);
                            exit;
                        }
                    } else if ($type == 2) {
                        $company = $_GET['company'];
                        //User::updateAll(['UpdateTime' => date("Y-m-d H:i:s", time()),'Status'=>3,'CateId'=>2], ['id' => $userId]);
                        //$company = $_GET['company'];
                        $cerfication = new Certification();
                        $cerfication->UserId = $userId;
                        $cerfication->HouseId = $houseId;
                        $cerfication->SeatId = $seat;
                        //$cerfication->roomId = $roomId;
                        $cerfication->Address = $address;
                        $cerfication->Company = $company;
                        $cerfication->CreateTime = date("Y-m-d H:i:s", time());
                        $cerfication->Status = 2;
                        //$cerfication->CateId = 2;
                        if ($cerfication->load($cerfication) || $cerfication->save()) {
                            echo json_encode([
                                'code' => $data,
                                'status' => 200,
                                'message' => '添加成功！'
                            ]);
                            exit;
                        }
                    } else {
                        $Department = empty($_GET['department'])?'':$_GET['department'];
                        $Position = empty($_GET['position'])?'':$_GET['position'];
                        $Maintenancetype = empty($_GET['maintenancetype'])?0:$_GET['maintenancetype'];
                        //User::updateAll(['UpdateTime' => date("Y-m-d H:i:s", time()),'Status'=>3,'CateId'=>3], ['id' => $userId]);
                        $cerfication = new Certification();
                        $cerfication->UserId = $userId;
                        $cerfication->HouseId = $houseId;
                        $cerfication->SeatId = $seat;
                        //$cerfication->roomId = $roomId;
                        $cerfication->Address = $address;
                        $cerfication->Department = $Department;
                        $cerfication->Position = $Position;
                        $cerfication->Maintenancetype = $Maintenancetype;
                        $cerfication->CreateTime = date("Y-m-d H:i:s", time());
                        $cerfication->Status = 2;
                        //$cerfication->CateId = 3;
                        if ($cerfication->load($cerfication) || $cerfication->save()) {
                            echo json_encode([
                                'code' => $data,
                                'status' => 200,
                                'message' => '添加成功！'
                            ]);
                            exit;
                        }
                    }
                }else{     
                    echo json_encode([
                        'code' => $data,
                        'status' => 202,
                        'message' => '必须选择统一身份认证！'
                    ]);
                    exit;
                }
            }
        }
    }

    /**
     * 实名认证列表接口
     */
    public function actionCertificationList1()
    {
        $arr = array();
        $id = Yii::$app->request->get('userId');
        $status = Yii::$app->request->get('status');
        if ($status == 0 || $status == '') {
            $certification = Certification::find()->select('user.id as userId,user.trueName,certification.Address as roomNum,certification.company,h.housename as seatName,h.id as seatId,house.housename as houseName,certification.status,certification.HouseId as houseId ')->join('LEFT JOIN', 'user', 'user.id = certification.UserId')->join('LEFT JOIN', 'house', 'house.id = certification.HouseId')->join('LEFT JOIN', 'house AS h', 'h.id = certification.SeatId')->join('LEFT JOIN', 'maintenancetype', 'maintenancetype.id = certification.Maintenancetype')->where(['user.id' => $id])->asArray()->all();
            $jsonobj = json_encode(array('code'=>$certification,'status'=>200,'message'=>'加载所有成功!'));
            echo $jsonobj;
            exit;
        } elseif ($status == 1) {
            $certification = Certification::find()->select('user.id as userId,user.trueName,certification.Address as roomNum,certification.company,h.housename as seatName,h.id as seatId,house.housename as houseName,certification.status,certification.HouseId as houseId')->join('LEFT JOIN', 'user', 'user.id = certification.UserId')->join('LEFT JOIN', 'house', 'house.id = certification.HouseId')->join('LEFT JOIN', 'house AS h', 'h.id = certification.SeatId')->join('LEFT JOIN', 'house AS has', 'has.id = certification.roomId')->join('LEFT JOIN', 'maintenancetype', 'maintenancetype.id = certification.Maintenancetype')->join('LEFT JOIN', 'usercate', 'usercate.id = certification.CateId')->where(['user.id' => $id, 'certification.status' => 1])->asArray()->all();
            $jsonobj = json_encode(array('code'=>$certification,'status'=>200,'message'=>'加载开始实名认证的数据!'));
            echo $jsonobj;
            exit;
        } elseif ($status == 2) {
            $certification = Certification::find()->select('user.id as userId,,user.trueName,certification.Address as roomNum,certification.company,h.housename as seatName,h.id as seatId,house.housename as houseName,certification.status,certification.HouseId as houseId')->join('LEFT JOIN', 'user', 'user.id = certification.UserId')->join('LEFT JOIN', 'house', 'house.id = certification.HouseId')->join('LEFT JOIN', 'house AS h', 'h.id = certification.SeatId')->join('LEFT JOIN', 'house AS has', 'has.id = certification.roomId')->join('LEFT JOIN', 'maintenancetype', 'maintenancetype.id = certification.Maintenancetype')->join('LEFT JOIN', 'usercate', 'usercate.id = certification.CateId')->where(['user.id' => $id, 'certification.status' => 2])->asArray()->all();
            $jsonobj = json_encode(array('code'=>$certification,'status'=>200,'message'=>'加载审核信息数据！'));
            echo $jsonobj;
            exit;
        } elseif ($status == 3) {
            $certification = Certification::find()->select('user.id as userId,user.trueName,certification.Address as roomNum,certification.company,h.housename as seatName,h.id as seatId,house.housename as houseName,certification.status,certification.HouseId as houseId')->join('LEFT JOIN', 'user', 'user.id = certification.UserId')->join('LEFT JOIN', 'house', 'house.id = certification.HouseId')->join('LEFT JOIN', 'house AS h', 'h.id = certification.SeatId')->join('LEFT JOIN', 'house AS has', 'has.id = certification.roomId')->join('LEFT JOIN', 'maintenancetype', 'maintenancetype.id = certification.Maintenancetype')->join('LEFT JOIN', 'usercate', 'usercate.id = certification.CateId')->where(['user.id' => $id, 'certification.status' => 3])->asArray()->all();
            $jsonobj = json_encode(array('code'=>$certification,'status'=>200,'message'=>'加载实名认证结束的数据！'));
            echo $jsonobj;
            exit;
        } else {
            $certification = Certification::find()->select('user.id as userId,user.trueName,certification.Address as roomNum,certification.company,h.housename as seatName,h.id as seatId,house.housename as houseName,certification.status,certification.HouseId as houseId')->join('LEFT JOIN', 'user', 'user.id = certification.UserId')->join('LEFT JOIN', 'house', 'house.id = certification.HouseId')->join('LEFT JOIN', 'house AS h', 'h.id = certification.SeatId')->join('LEFT JOIN', 'house AS has', 'has.id = certification.roomId')->join('LEFT JOIN', 'maintenancetype', 'maintenancetype.id = certification.Maintenancetype')->join('LEFT JOIN', 'usercate', 'usercate.id = certification.CateId')->where(['user.id' => $id, 'certification.status' => 4])->asArray()->all();
            $jsonobj = json_encode(array('code'=>$certification,'status'=>200,'message'=>'加载所有认证失败的数据！'));
            echo $jsonobj;
            exit;
        }
    }

    /**
     * 通行区域列表
     * @Author   tml
     * @DateTime 2017-12-05
     * @return   [type]     [description]
     */
    public function actionCertificationList(){
        $get = Yii::$app->request->get();
        $user_id = empty($get['userId']) ? 0 : $get['userId'];
        $status  = empty($get['status']) ? 0 : $get['status'];
        if (empty($user_id)) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>[]]);exit;
        }
        $con['c.UserId'] = $user_id;
        if (!empty($status)) {
            $con['c.Status'] = $status;
        }
        $list = (new \yii\db\Query())
            ->select('c.CertificationId as certificationId,c.UserId as userId,u.TrueName as trueName,u.Address as roomNum,u.Company as company,c.HouseId as houseId,h.housename as houseName,c.SeatId as seatId,h1.housename as seatName,c.Status as status')
            ->from('certification c')
            ->leftjoin('user u','u.id=c.UserId')
            ->leftjoin('house h','h.id=c.HouseId')
            ->leftjoin('house h1','h1.id=c.SeatId')
            ->where($con)
            ->orderBy('c.Status desc,c.CertificationId asc')
            ->all();
        echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;
    }

    //保健保修列表 status 0 不输入 1.申请中 2.处理 3.订单结束
    public function actionOrderList()
    {
        $this->actioninit();
        $data = array();
        $userId = $_GET['userId'];
        $status = $_GET['status'];
        if (empty($status) || $status == 0) {
            $demo = Order::find()->select('OrderId As order_no')->where(array('UserId' => $userId))->asArray()->all();
            var_dump($demo);
            exit;
            echo json_encode([
                'code' => $demo,
                'status' => 200,
                'message' => '加载所有数据！',
            ]);
            exit;
        } elseif ($status == 1) {
            $demo1 = Order::find()->select('OrderId As order_no')->where(array('UserId' => $userId, 'status' => 1))->asArray()->all();
            if (empty($demo1)) {
                echo json_encode([
                    'code' => $data,
                    'status' => 500,
                    'message' => '未加载到数据！',
                ]);
                exit;
            } else {
                echo json_encode([
                    'code' => $demo1,
                    'status' => 200,
                    'message' => '加载申请中的数据！',
                ]);
                exit;
            }
        } elseif ($status == 2) {
            $demo2 = Order::find()->select('OrderId As order_no')->where(array('UserId' => $userId, 'status' => 2))->asArray()->all();
            if (empty($demo2)) {
                echo json_encode([
                    'code' => $data,
                    'status' => 500,
                    'message' => '未加载到数据！',
                ]);
                exit;
            } else {
                echo json_encode([
                    'code' => $demo2,
                    'status' => 200,
                    'message' => '加载正在处理的数据！',
                ]);
                exit;
            }
        } elseif ($status == 3) {
            $demo3 = Order::find()->select('OrderId As order_no')->where(array('UserId' => $userId, 'status' => 3))->asArray()->all();
            if (empty($demo3)) {
                echo json_encode([
                    'code' => $data,
                    'status' => 500,
                    'message' => '未加载到数据！',
                ]);
                exit;
            } else {
                echo json_encode([
                    'code' => $demo3,
                    'status' => 200,
                    'message' => '加载已完成的数据！',
                ]);
                exit;
            }
        } else {
            echo json_encode([
                'code' => $data,
                'status' => 404,
                'message' => '未知错误！',
            ]);
            exit;
        }
    }

    //状态
    public function actionStatus($id)
    {
        if ($id == 1) {
            return '申请中';
        } elseif ($id == 2) {
            return '处理订单';
        } else {
            return '订单结束';
        }
        return 0;
    }

    //保健报修详情展示
    public function actionOrderView()
    {
        $order = WyOrder::find()->where(array('wyorderId' => $_GET['orderId']))->asArray()->all();
        foreach ($order as $all) {
            $house = House::find()->where(array('id' => $all['houseId']))->asArray()->one();
            $data = array(
                'status' => $this->actionStatus($all['status']),
                'housename' => $house['housename'],
                'orderTime' => $all['orderTime'],
                'content' => $all['content']
            );
            $data = new \ArrayObject($data);
            echo json_encode([
                'code' => $data,
                'status' => 200,
                'message' => '订单数据加载成功！',
            ]);
        }
        exit;
    }

    /**
     *获取用户信息
     * 
     */
    public function actionGetUser()
    {
        $data = array();
        $data = new \ArrayObject($data);
        $user = yii::$app->session['userinfo'];
        $id = $user['userId'];
        if(empty($id)){
            echo json_encode([
                'code' => $data,
                'status' => 500,
                'message' => '重新登录获取userId！',
            ]);
            exit();
          }
        $user= User::find()->select('id as userId,tell,headerImg,nickName,email,trueName,CateId as identity,status')->where(array('id'=>$id))->asArray()->one();
        echo json_encode([
            'code' => $user,
            'status' => 200,
            'message' => '获取用户信息成功！',
        ]);
        exit();
    }

    /**
     * 正则校验手机号格式
     * @Author   tml
     * @DateTime 2017-12-12
     * @param    [type]     $mobile [description]
     * @return   [type]             [description]
     */
    public function checkMobile($mobile){
        return preg_match('/^1[3456789]\d{9}$/', $mobile);
    }

    /**
     * 添加日志记录
     * @Author   tml
     * @DateTime 2018-05-28
     * @param    [type]     $title  [description]
     * @param    [type]     $id     [description]
     * @param    [type]     $status [description]
     * @param    [type]     $method [description]
     */
    public function addLog($title='',$id=0,$status=0,$method='',$remark='')
    {
        $model = new Log();
        $model->log_title = $title;
        $model->log_id = $id;
        $model->log_status = $status;
        $model->log_time = time();
        $model->log_method = $method;
        $model->remark = $remark;
        $model->save();
    }

    /**
     * 蓝海、向阳闸机通行加密
     * @Author   tml
     * @DateTime 2018-07-07
     * @return   [type]     [description]
     */
    public function actionPass()
    {
        $post = \Yii::$app->request->post();
        $user_id  = empty($post['user_id']) ? 0 : $post['user_id'];
        $house_id = empty($post['house_id']) ? 0 : $post['house_id'];
        $seat_id  = empty($post['seat_id']) ? 0 : $post['seat_id'];
        $params = \Yii::$app->params['house_config'][$house_id];
        // $encryptString = $user_id.','.bcmul(time(),1000,0).','.$params['code'].',1,97,97,'.$params[$seat_id]['in'].','.$params[$seat_id]['out'].','.$params[$seat_id]['dt'];
        $encryptString = $user_id.','.bcmul(time(),1000,0).','.$params['code'].',1,97,97,'.implode(',',$params[$seat_id]);
        // var_dump($encryptString);exit;
        $encryptObj = new MagicCrypt(); 
        $ret = $encryptObj->encrypt($encryptString);
        // var_dump($ret);exit;
        echo json_encode(['status'=>200,'code'=>$ret]);exit;
    }

    /**
     * 获取价格标签
     * @Author   tml
     * @DateTime 2018-11-06
     * @return   [type]     [description]
     */
    public function actionGetPriceTag()
    {
        $post = \Yii::$app->request->post();
        $house_id = empty($post['house_id']) ? 0 : $post['house_id'];
        $seat_id = empty($post['seat_id']) ? 0 : $post['seat_id'];
        if (empty($house_id) || empty($seat_id)) {
            echo json_encode(['status'=>200,'code'=>'','message'=>'参数错误']);
        }
        $tag = PriceTag::find()->where(['house_id'=>$house_id,'seat_id'=>$seat_id])->select('tag')->scalar();
        if ($tag) {
            echo json_encode(['status'=>200,'code'=>$tag,'message'=>'success']);exit;
        }
        echo json_encode(['status'=>-200,'code'=>'','message'=>'暂无数据']);exit;
    }
}
   