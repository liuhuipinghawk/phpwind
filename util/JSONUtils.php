<?php
namespace app\util;

use yii\base\Object;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/4
 * Time: 16:00
 */

class JSONUtils extends Object{

    public static function json($code=array(),$status,$message=''){
        if(!is_numeric($code)){
            return '';
        }
        $result = array(
            'code'=>$code,
            'status'=>$status,
            'message'=>$message
        );
        echo json_encode(['code'=>$code,'status'=>$status,'message'=>$message]);
        exit;
    }

}
