<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <link rel="stylesheet" href="/layout/css/bootstrap.min.css">
    <link rel="stylesheet" href="/layout/css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="/layout/font/iconfont.css">
    <link rel="stylesheet" href="/layout/css/login.css">
</head>
<body>
<?php $this->beginBody() ?>

<div class="login-form">
    <div class="top">
        <img src="/images/logo_login.png" alt="logo">
    </div>
<!--    <form class="form-cont" action="/admin/site/login" method="post">-->
    <div class="form-cont">
        <?php $form = \yii\bootstrap\ActiveForm::begin([
            'fieldConfig' => [
                'template' => '{error}{input}',
            ],
        ]); ?>
        <div class="form-area">
            <div class="form-title">
                <h3 class="title">登录</h3>
            </div>
            <div class="group">
                <?php echo $form->field($model,'adminuser')->textInput(['class'=>"form-control","placeholder"=>"请输入账号"]); ?>
                <i class="iconfont icon-weibiaoti2fuzhi12"></i>
            </div>
            <div class="group">
                <?php echo $form->field($model,'adminpass')->passwordInput(['class'=>'form-control','placeholder'=>'请输入密码']) ?>
                <i class="iconfont icon-mima"></i>
            </div>
            <?php echo $form->field($model,'rememberMe')->checkbox([
                'id'=>'remember-me',
                'template'=>'<div class="checkbox checkbox-primary">{input}<label class="checkbox101">记住用户名</label></div>',
            ]); ?>
            <?php echo Html::submitButton('登录',['class'=>"btn btn-lg btn-warning btn-block"]); ?>
        </div>
    <?php \yii\bootstrap\ActiveForm::end(); ?>
    </div>
    <div class="bottom">
        <img src="/images/signup-bg.png" alt="">
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
