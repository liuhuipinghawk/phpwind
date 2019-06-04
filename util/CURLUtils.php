<?php

namespace app\util;

use yii\base\Object;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/9
 * Time: 16:54
 */

class CURLUtils extends Object{
    /**
     * 不能带json的
     * curl 方法
     * @param type $curl
     * @param type $https
     * @param type $method
     * @param type $data
     * @return type
     */
    public static function _request($curl,$https = true, $method='GET', $data = null){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $curl);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if($https){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if($method =='POST'){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        }
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

    /**
     * json方式提交数据！
     * @param $curl
     * @param $data_string
     */
    public static function _request_json($curl,$data_string){
        $ch = curl_init($curl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($ch);
        return $result;
    }

}