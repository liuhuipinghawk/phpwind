<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>直饮水</title>
    <?=Html::cssFile('/css/weui.css')?>  
    <?=Html::cssFile('/css/jquery-weui.css')?>
    <?=Html::cssFile('/css/h-f-com.css')?>
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
    </script>
</head>
<body ontouchstart class="relative">
<div class="wrap">
    <!--头部-->
    <!--<header class="bar">-->
    <!--<a href="javascript:;" onclick="javascript:history.back(-1);" class="icon pull-left"><img src="../dist/images/back.png" width="11"></a>-->
    <!--<h1 class="title">酒店预订</h1>-->
    <!--</header>-->
    <!--主体内容-->
    <div class="app-cont">
        <!--酒店列表-->
        <div class="weui-panel weui-panel_access hotel-list">
            <div class="weui-panel__bd" id="hotel-list">
                <a href="hotel-detail.html" class="weui-media-box weui-media-box_appmsg">
                    <div class="weui-media-box__hd"><img class="weui-media-box__thumb" src="/images/house.jpg" alt=""></div>
                    <div class="weui-media-box__bd">
                        <h4 class="weui-media-box__title">H酒店(郑州航海路店)</h4>
                        <p class="weui-media-box__tip">评分: <span>5分</span></p>
                        <p class="weui-media-box__type">管城区 | 高档区</p>
                        <p class="weui-media-box__address ellipsis">航海路未来路交叉口</p>
                        <p class="weui-media-box__price"><span class="price">¥200</span>起</p></div>
                </a>
            </div>
        </div>
        <!--加载-->
        <div class="weui-loadmore">
            <i class="weui-loading"></i>
            <span class="weui-loadmore__tips">loading……</span>
        </div>
    </div>
</div>


</body>
</html>