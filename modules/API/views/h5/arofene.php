<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>甲醛治理</title>
    <?=Html::cssFile('/layui/css/layui.css')?> 
    <?=Html::cssFile('/css/weui.css')?>  
    <?=Html::cssFile('/css/jquery-weui.css')?>  
    <?=Html::cssFile('/css/common.css')?>  
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
    </script>
</head>
<body ontouchstart>
<div class="wrap">
    <!--头部-->
    <header class="bar">
        <a href="javascript:;" onclick="javascript:history.back(-1);" class="icon pull-left"><img src="/images/back.png" width="11"></a>
        <h1 class="title" id="header-title">甲醛治理</h1>
    </header>
    <!--主体内容-->
    <div class="app-cont show-page">
        <div class="show-img text-center">
            <img src="/images/arofene.jpg" alt="" class="max-width">
        </div>
    </div>
    <div class="footer border-top clearfix">
        <img src="/images/phone-jia.png" width="28" class="pull-left"><span class="pull-left phone phone-jia">400-888-888</span>
        <a href="#" class="pull-right book-btn btn-jia">立即预约</a>
    </div>

</div>
<!--弹出框-->
<div class="book-tip box-content" style="display: none">
    <ul class="book-list">
        <li>
            <input type="text" placeholder="联系人姓名">
        </li>
        <li>
            <input type="text" placeholder="联系人电话">
        </li>
        <li><p>预约成功后，工作人员会尽快与您确认需求~或者拨打客服电话：<span class="text-green">400-733-5500</span></p></li>
    </ul>
    <a href="#" class="book book-jia block font-size-15 text-center">立即预约</a>
</div>
<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<script>
	$(function(){
		layui.use('layer', function() {
        var $ = layui.jquery,
            layer = layui.layer;
	        $('.book-btn').click(function () {
	            layer.open({
	                area: '90%'
	                ,title: false
	                ,resize: false
	                ,type: 1
	                ,content:$('.book-tip')
	                ,cancel: function(){
	                    //右上角关闭回调
	                }
	            })
	        });
	    })
	})
</script>
</body>
</html>