<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=yes"/>
    <title id="pro-title">直饮水</title>
    <?=Html::cssFile('/css/weui.css')?>
    <?=Html::cssFile('/css/common.css')?>  
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
    </script>
</head>
<body ontouchstart class="relative">
<div class="wrap">
    <!--主体内容-->
    <div class="app-cont show-page">
        <div class="show-img text-center"  style="font-size: 0">
            <img src="/images/water1.png" class="max-width" alt=""/>
            <img src="/images/water2.png" class="max-width" alt=""/>
            <img src="/images/water3.png" class="max-width" alt=""/>
        </div>
    </div>
    <div class="footer border-top clearfix">
        <a href="tel:400-0000-688" id="telhref">
            <img src="/images/phone-xi.png" width="28" class="pull-left">
            <span class="pull-left phone phone-xi" id="telphone">400-6060-617</span>
        </a>
        <a href="http://xhs.wechat.d-water.com/install/apply?id=18&scrkey=130d17bc9283d42d1a77a177d121a234" class="pull-right book-btn btn-xi">安装申请</a>
    </div>

</div>
<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/fastclick.js')?>
<?=Html::jsFile('/js/public.js')?>
<script>
	$(function(){
        FastClick.attach(document.body);
        var addrID = addressID(); // 获取楼盘id
        window.onload=function () {
            if(addrID == 4){ // 航海广场
                $("#pro-title").html("航海广场直饮水")
                $("#telhref").attr("href", "tel:0371-67872111");
                $("#telphone").html("0371-67872111");
            } else if(addrID == 7){ // 建正东方中心
                $("#pro-title").html("建正东方中心直饮水")
                $("#telhref").attr("href", "tel:0371-88810028");
                $("#telphone").html("0371-88810028");
            } else if(addrID == 8){ // 木华广场
                $("#pro-title").html("木华广场直饮水")
                $("#telhref").attr("href", "tel:0371-55390789");
                $("#telphone").html("0371-55390789");
            } else if(addrID == 40){ // 学府广场
                $("#pro-title").html("学府广场直饮水")
                $("#telhref").attr("href", "tel:0371-88810109");
                $("#telphone").html("0371-88810109");
            }
        };
	})
</script>
</body>
</html>