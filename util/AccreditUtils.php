<?php
namespace app\util;

class AccreditUtils
{
    //编码程序
    public static function AccreditCode($random_no, $no, $endTime_no)
    {
        try {
            $random = new \PNIString($random_no);
            $card = new \PNIString($no);
            $endTime = new \PNIString($endTime_no);

            $str = "";
            $str = str_pad($str, 25, "\0");
            $str = new \PNIString($str);

            /* 输入参数：Random[]-4字节随机数代表条码号,如A1B2C3D4
             * 输入参数：card[]-4字节用来生成条码的业主卡号(或业主手机号后9位转换成16进制数据)
             *          如手机号13824337255,后9位转换成十六进制数据为31226367
                        注：只有业主卡号在门禁上有权限，生成的二维码才有权限
             * 输入参数：EndTime[]-条码使用结束时间（年月日时分秒）170925113000(17年09月25日11时30分00秒)
             * 输出参数：str[]-长度共12字节数据,即24位条码数据，如1FAE6EFA30CF6F8FA1B2C3D4
             */
            $quard = new \PNIFunction(\PNIDataType::CHAR, 'QrenCode', 'libsoquard.so');
            $quard($random, $card, $endTime, $str);       
            $str = $str->getValue();
            return strtoupper($str);
        } catch (\PNIException $e) {
            // var_dump($e);
            return "";
        } catch (\PNIException $e) {
            // var_dump($e);
            return "";
        }
    }
}
?>
