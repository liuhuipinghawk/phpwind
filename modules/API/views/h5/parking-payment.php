<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>停车缴费</title>
    <?=Html::cssFile('/css/weui.css')?>
    <?=Html::cssFile('/css/common.css')?>  
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
    </script>
</head>
<body ontouchstart class="relative bg-white">
<div class="wrap">
    <!--主体内容-->
    <div class="app-cont show-page">
        <div class="text-center">
            <img src="/images/parking1.png" class="max-width" alt=""/>
            <img src="/images/parking2.png" class="max-width" alt=""/>
            <img src="/images/parking3.png" class="max-width" alt=""/>
            <img src="/images/parking4.png" class="max-width" alt=""/>
        </div>
    </div>

</div>
</body>
</html>