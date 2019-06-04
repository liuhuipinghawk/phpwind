<?php

namespace app\util;

use  yii\base\Object;

class RSAUtils extends Object{

    //私钥解密
    public static function pikeyDecrypt($privatekey,$token) {
        $pi_key = openssl_pkey_get_private($privatekey);
        $decrypted = '';
        openssl_private_decrypt(base64_decode($token),$decrypted,$pi_key);
        return $decrypted;
    }
    //私钥加密
    public static function pikeyEncrypt($privatekey,$datajson){

       $pi_key = openssl_pkey_get_private($privatekey);
       $encrypted = '';
       openssl_private_encrypt($datajson,$encrypted,$pi_key);
       $encrypted = base64_encode($encrypted);
       return $encrypted;
    }
    // sha1签名
    public static function signForSha($content,$privateKey){

        $signature = "";
        if(function_exists('hash_hmac')){
            $signature = base64_encode(hash_hmac('sha1',$content,$privateKey,true));
        }else{
            $blocksize = 64;
            $hashfunc = 'sha1';
            if(strlen($privateKey) > $blocksize){
                $privateKey = pack('H*',$hashfunc($privateKey));
            }
            $privateKey = str_pad($privateKey,$blocksize,chr(0x00));
            $ipad = str_repeat(chr(0x36),$blocksize);
            $opad = str_repeat(chr(0x5c),$blocksize);
            $hmac = pack(
                'H*', $hashfunc(
                    ($privateKey ^ $opad) . pack(
                        'H*', $hashfunc(
                            ($privateKey ^ $ipad) . $content
                        )
                    )
                )
            );
            $signature = base64_encode($hmac);
        }
        return $signature;
    }

}
