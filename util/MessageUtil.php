<?php

namespace app\util;

use yii\base\Object;
//1.修改手机号 2.注册 3.找回密码
class MessageUtil extends Object{
    const url = 'https://dx.ipyy.net/smsJson.aspx';
    public static function  send($mobiles,$content){  
        $body=array(
            'action'=>'send',
            'userid'=>'',
            'account'=>'ZZ00146',
            'password'=>'ZZ0014655',
            'mobile'=>$mobiles,
            'extno'=>'',
            'content'=>$content,
            'sendtime'=>''
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    //用户缴费通知!
    public static function paymentnotice($mobiles,$content){
        $body=array(
            'action'=>'send',
            'userid'=>'',
            'account'=>'ZZ00220',
            'password'=>'ZZ0022000',
            'mobile'=>$mobiles,
            'extno'=>'',
            'content'=>$content,
            'sendtime'=>''
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
