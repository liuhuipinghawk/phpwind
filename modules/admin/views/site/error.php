<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\Alert;

AppAsset::register($this);
AppAsset::addCss($this,"/css/umeditor/themes/default/css/umeditor.css");
AppAsset::addScript($this,"/css/umeditor/third-party/template.min.js");
AppAsset::addScript($this,"/css/umeditor/umeditor.config.js");
AppAsset::addScript($this,"/css/umeditor/umeditor.min.js");
AppAsset::addScript($this,"/css/umeditor/lang/zh-cn/zh-cn.js");

?>
<div class="container" style="margin-top:-1px;margin-left: 200px;">
<?php
if(Yii::$app->getSession()->hasFlash('permission')){
    echo Alert::widget([
        'options' => [
            'class' => 'alert-success', //这里是提示框的class
        ],
        'body' => Yii::$app->getSession()->getFlash('permission'), //消息体
    ]);
}
?>
</div>
