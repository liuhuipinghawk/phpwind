<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */
?>
<style>
    .site-error{
        width: 100%;
        height: 100%;
        background: #007bc1;
        position: fixed;
        left: 0;
        bottom: 0;
        top: 0;
        z-index: 10000;
        text-align: center;
        overflow-y: scroll;
        overflow-x: hidden;
    }
    .error-img{
        width: 80%;
        max-width: 1180px;
        margin: 45px auto;
    }
    .error-img img{
        max-width: 100%;
    }
    .btn-back{
        color: #ffffff;
        font-size: 20px;
        border: 1px solid #ffffff;
        padding: 10px 80px;
    }
    .btn-back:hover{
        text-decoration: none;
        color: #ffffff;
    }
</style>
<div class="site-error">
    <div class="error-img">
        <img src="/images/404.jpg">
    </div>
    <a href="/" class="btn-back">返回首页</a>
</div>
