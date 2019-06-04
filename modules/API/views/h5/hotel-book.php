<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no" />
    <title>酒店预订</title>
    <?=Html::cssFile('/css/weui.css')?>  
    <?=Html::cssFile('/css/jquery-weui.css')?>
    <?=Html::cssFile('/css/calendar.css')?>    
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
    <!--主体内容-->
    <div class="app-cont hotel-detail">
        <div class="detail-img text-center">
            <img src="/images/detail.jpg" alt="" class="max-width">
        </div>
        <div class="margin-cont h-hotel">
            <div class="bg-white padding-cont border-radius-big">
                <div class="hotel-header padding-small-top border-bottom padding-bottom">
                    <p class="name">H酒店(郑州航海路店)</p>
                    <ul class="serve-list">
                        <li><span><img src="/images/wifi.png" alt=""></span>无线</li>
                        <li><span><img src="/images/stop.png" alt=""></span>停车</li>
                        <li><span><img src="/images/restaurant.png" alt=""></span>餐厅</li>
                    </ul>
                    <ul class="text-muted">
                        <li>2017年开业</li>
                        <li>2017年装修</li>
                        <li>豪华酒店 |上午出行</li>
                    </ul>
                    <p class="score text-muted"><span class="text-warning">5.0</span></br>好评</p>
                </div>
                <div class="entry-detail padding-bottom margin-top margin-bottom block text-black clearfix">
                    <p class="title text-black">精致豪华大床房</p>
                    <div id="checkinout" class="checkinout h-checkinout text-black">
                        <div id="firstSelect" style="width:100%;">
                            <div class="">
                                <span>入住：</span>
                                <input id="startDate" type="text" value=""style="" readonly>
                            </div>
                            <div class="">
                                <span>离店：</span>
                                <input id="endDate" type="text" value="" style="" readonly>
                            </div>
                            <span class="span21 span22">共<span class="NumDate">1</span>晚</span>
                        </div>
                    </div>
                    <p class="text-muted clearfix">大床 | 含双早 | 有WIFI</p>
                    <div class="mask_calendar">
                        <div class="calendar"></div>
                    </div>
            </div>
        </div>
            <div class="margin-top bg-white padding-cont border-radius-big">
                <ul class="text-gary hotel-desc">
                    <li class="arrow"><span class="m-title">房间数</span> <span class="m-dec"><input type="text" placeholder="1间" id='room'/></span></li>
                    <li><span class="m-title">入住人</span> <span class="m-dec"><input type="text" placeholder="姓名"/></span></li>
                    <li><span class="m-title">联系方式</span> <span class="m-dec"><input type="text" placeholder="132132"/></span></li>
                    <li class="arrow"><span class="m-title">预计到店</span> <span class="m-dec"><input type="text" placeholder="23:59之前(不影响酒店留房)" id='time'/></span></li>
                    <li>&nbsp;</li>
                    <li class="clearfix">
                        <p class="pull-left price text-black">¥200</p>
                        <a href="#" class="btn pull-right">确定下单</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/jquery-weui.js')?>
<?=Html::jsFile('/js/fastclick.js')?>
<?=Html::jsFile('/js/date.js')?>
<?=Html::jsFile('/js/project-data.js')?>
<script>
    $("#room").picker({
        title: "房间数",
        cols: [{textAlign: 'center',
                values: ['1间', '2间', '3间', '4间']}]});
    $("#time").picker({
        title: "预计到店时间",
        cols: [{textAlign: 'center',
                values: ['22:59', '21:59', '20:59', '19:59']}]});
    $(function(){
    	
    })
</script>
</body>
</html>