<?php
/**
 * User: mumu
 * Date: 2018/1/26
 * Time: 9:07
 */

namespace app\modules\wappay\controllers;


use app\util\CURLUtils;
use app\util\RSAUtils;
use yii\web\Controller;

class VisitorController extends Controller {
    public $enableCsrfValidation = false;
    protected $host;
    public function init()
    {
        $this->host = 'http://1t8457h122.imwork.net/Api/';
    }
    public function actionSign(){
        $appid = \Yii::$app->params['appid'];
        $secret = \Yii::$app->params['secret'];
        $pricate_key = \Yii::$app->params['PRIVATE_KEY'];
        // 准备请求参数
        $data = array();
        $data['SmallCode'] = "G100000001S100000001";
        $data['SmallCodeId'] = "small_B6g1016AeF2Dg5g6GIe67GFE4444";
        $data['OwnerOpenId'] = "oT74Iv953x4bK6k99etRfIY6B6M4";
        $data['OwnerPhone'] = "13714055538";
        $datastr = json_encode($data,true);
        //时间戳
        $timestamp = time();
        // 拼接签名参数
        $signparam = "param=".$datastr."&secret=".$secret."&timestamp=".$timestamp;
        // 签名
        $sign = RSAUtils::signForSha($signparam,$pricate_key);
        $curl = $this->host."public/OwnerBindPhone";
        //绑定业主
        $data = "param=".$datastr."&sign=".$sign."&timestamp=".$timestamp;
        $result = CURLUtils::_request_json($curl,$data);
        var_dump($result);


    }

}