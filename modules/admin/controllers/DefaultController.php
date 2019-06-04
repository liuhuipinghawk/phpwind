<?php

namespace app\modules\admin\controllers;



/**
 * Default controller for the `admin` module
 */
class DefaultController extends CommonController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $data['uname'] = php_uname();//系统类型版本号
        $data['php_sapi'] = php_sapi_name();//获取PHP运行方式
        $data['php_version'] = PHP_VERSION;//php版本号
        $data['zend_version'] = Zend_Version(); //zend版本号
        $data['service'] = $_SERVER['SERVER_SOFTWARE'];//获取服务器解译引擎
        $data['http_accept_language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];//获取服务器语言
        $data['server_port'] = $_SERVER['SERVER_PORT'];//获取服务器web端口
        $data['server_protocol'] = $_SERVER['SERVER_PROTOCOL'];//获取请求页面时通信协议的名称和版本
        $data['http_post'] = $_SERVER["HTTP_HOST"];//获取域名或IP
        $data['free_space'] = round((disk_free_space(".")/(1024*1024)),2).'M';//剩余空间
        $data['upload_max_filesize'] = ini_get('upload_max_filesize');//上传附件限制
        $data['execution_time'] = ini_get('max_execution_time').'秒';//执行时间限制
        $data['service_time'] = date("Y年n月j日 H:i:s");//服务器时间
        $data['njtime'] = gmdate("Y年n月j日 H:i:s",time()+8*3600);//北京时间
        return $this->render('index',[
            'data'=>$data,
        ]);
    }
}
