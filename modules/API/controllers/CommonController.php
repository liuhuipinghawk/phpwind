<?php

namespace app\modules\API\controllers;

use app\API\models\app;
use app\API\models\VersionUpgrade;
use yii\web\Controller;

/**
 * 处理接口公共业务！
 * Class CommonController
 * @package app\modules\API\controllers
 */
class CommonController extends Controller{
    public $enableCsrfValidation = false;
    public $params;
    public $app;
    public function check(){
        $this->params['app_id'] = $appId = isset($_GET['app_id']) ? $_GET['app_id'] : '';
        $this->params['version_code'] = $versionId = isset($_GET['version_code']) ? $_GET['version_code'] : '';
        $this->params['type'] = $type = isset($_GET['type']) ? $_GET['type'] : '';
        if(!is_string($appId) || !is_string($versionId) || !is_string($type)){
            echo json_encode([
                'code'=>'',
                'status'=>401,
                'message'=>'参数不合法！',
            ]);
        }
        // 判断app是否需要加密
       $this->app = $this->getApp($appId);
       if(!$this->app){
            echo json_encode([
                'code'=>'',
                'status'=>402,
                'message'=>'app_id不存在！',
            ]);
            exit();
        }
    }
    public function getApp($appId){
      $result = app::find()->where(array('id'=>$appId,'status'=>1))->asArray()->one();
      return $result;
    }

    public function getversionUpgrade($app_id){
        $result = VersionUpgrade::find()->select('app_id,version_code,type,apk_url,upgrade_point')->where(array('app_id'=>$app_id,'status'=>1))->orderBy('create_time desc')->asArray()->all();
        return $result;
    }

    // public function init()
    // {
    //     $session = \Yii::$app->session;
    //     if(empty($session['userinfo']) || $session['userinfo']['expire_time'] < time()){
    //         echo json_encode([
    //             'code' =>[],
    //             'status' => 205,
    //             'message' => '登录时间已过期，请重新登录'
    //         ]);
    //         exit;
    //     }
    // }
}
