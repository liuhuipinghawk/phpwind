<?php

namespace app\util;

use yii\base\Object;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/10
 * Time: 10:13
 */
//PHP  order订单号的生成!
class OrderUtils extends Object{
    /**
     * pkcs7补码
     *
     * @param string $string  明文
     * @param int $blocksize Blocksize , 以 byte 为单位
     *
     * @return String
     */
    public static  function build_order_no() {
        /* 选择一个随机的方案 */
        mt_srand((double) microtime() * 1000000);

        /* 年月日 + 6位随机数 */     
        return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }
}