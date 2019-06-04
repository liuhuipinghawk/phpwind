<?php

namespace app\util;

use yii\base\Object;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/10
 * Time: 10:13
 */
//PHP 版DES 加解密算法类
class CBCUtil extends Object{
    /**
     * pkcs7补码
     * @param $string
     * @param int $blocksize
     * @return string
     */
    public static function addPKcsPadding($string,$blocksize = 32){
        $len = strlen($string); //取得字符串
        $pad = $blocksize - ($len % $blocksize); //取得补码的长度
        $string .=str_repeat(chr($pad), $pad); //用ASCII码为补码长度的字符，补足最后一段
        return $string;
    }

    /**
     *  加密然后base64转码
     * @param $str
     * @param $iv
     * @param $key
     * @return string
     */
    public static function aes256cbcEncrypt($str,$iv,$key){
        return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256,$key,self::addPKcsPadding($str)));
    }

    /**
     * 除去pkcs7 padding
     * @param $string
     * @return bool|string
     */
    public static function stripkcs7Padding($string){
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if(preg_match("/$slastc{".$slastc."}/",$string)){
            $string = substr($string,0,strlen($string)-$slast);
            return $string;
        }else{
            return false;
        }
    }

    /**
     *  解密
     * @param $encryptedText
     * @param $iv
     * @param $key
     * @return bool|string
     */
    public static function aes256cbcDecrypt($encryptedText, $iv, $key){
        $encryptedText=base64_decode($encryptedText);
        return self::stripkcs7Padding(mcrypt_decrypt(MCRYPT_RIJNDAEL_256,$key,$encryptedText,MCRYPT_MODE_CBC,$iv));
    }

}