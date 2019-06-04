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
    <title>酒店列表</title>
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
    <!--主体内容-->
    <div class="app-cont">
        <!--选择列表-->
        <div class="select-list">
            <div class="weui-flex text-center border-bottom">
                <div class="weui-flex__item">
                    <a href="javascript:;" class="text-gary select-btn block">我附近</a>
                    <span class="img-down"><img src="/images/select_down.png" ></span>
                    <span class="img-up active"><img src="/images/select_up.png" ></span>
                    <!--我附近下拉列表-->
                    <div class="nearby-select select-drop text-gary">
                        <div class="near-list">
                            <p class="title">附近</p>
                            <ul class="clearfix">
                                <li><a href="#" class="block">500m</a> </li>
                                <li><a href="#" class="block">800m</a> </li>
                                <li><a href="#" class="block">100m</a> </li>
                            </ul>
                        </div>
                        <div class="near-list">
                            <p class="title title-circle">商圈</p>
                            <ul class="clearfix"> 
                            	<li><a href="#" class="block">500m</a> </li>
                                <li><a href="#" class="block">800m</a> </li>
                                <li><a href="#" class="block">100m</a> </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="weui-flex__item">
                    <a href="javascript:;" class="text-gary select-btn block">星级</a>
                    <span class="img-down"><img src="/images/select_down.png" ></span>
                    <span class="img-up active"><img src="/images/select_up.png" ></span>
                    <!--星级/价格下拉列表-->
                    <div class="price-select select-drop">
                        <p class="title">星级</p>
                        <ul id="brand"></ul>
                    </div>
                </div>
                <div class="weui-flex__item">
                    <a href="javascript:;" class="text-gary select-btn block">排序</a>
                    <span class="img-down"><img src="/images/select_down.png" ></span>
                    <span class="img-up active"><img src="/images/select_up.png" ></span>
                    <!--排序下拉列表-->
                    <div class="sort-select select-drop">
                        <ul>
                            <li class="active"><a href="#" class="block text-black">距离优先</a> </li>
                            <li><a href="#" class="block text-black">低价优先</a> </li>
                            <li><a href="#" class="block text-black">高价优先</a> </li>
                            <li><a href="#" class="block text-black">人气优先</a> </li>
                        </ul>
                    </div>
                </div>
                <div class="weui-flex__item">
                    <a href="javascript:;" class="text-gary select-btn block">筛选</a>
                    <span class="img-down"><img src="/images/select_down.png" ></span>
                    <span class="img-up active"><img src="/images/select_up.png" ></span>
                    <!--筛选列表-->
                    <div class="price-select select-drop">
                        <p class="title">星级</p>
                        <ul>
                            <li><a href="#" class="block text-gary">经济型</a> </li>
                            <li><a href="#" class="block text-gary">舒适/三星</a> </li>
                            <li><a href="#" class="block text-gary">高档/四星</a> </li>
                            <li><a href="#" class="block text-gary">豪华/五星</a> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mask dropdown-mask"  amallink-event="hide_dropdown_mask"></div>
        <!--酒店列表-->
        <div class="weui-panel weui-panel_access hotel-list">
            <div class="weui-panel__bd" id="hotel-list"></div>
        </div>
        <!--加载-->
        <!--<div class="weui-loadmore"> <i class="weui-loading"></i><span class="weui-loadmore__tips">loading……</span></div>-->
    </div>
</div>
<!-- 回顶部 -->
<a class="to-top"><img src="/images/up.png" class="max-width" /></a>
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/jquery.toTop.min.js')?>
<?=Html::jsFile('/js/fastclick.js')?>
<?=Html::jsFile('/js/common.js')?>
<script>
    $(function () {
        $('.to-top').toTop();
        
        // 酒店品牌
        $.ajax({
            url: "/index.php?r=API/hotel/get-brand",
            type: "get",
            async:false,
            dataType: 'json',
            success: function(data){
                var brand_name = data.code;
                $.each(brand_name, function(i, item){
                    $('#brand').append("<li><a href=\"#\" class=\"block text-gary\">"+ item.brand_name + "</a> </li>");
                });
            }
        });

		// 酒店列表
        $.ajax({
            url: "/index.php?r=API/hotel/get-hotel-list",
            type: "get",
            async:false,
            dataType: 'json',
            success: function(data){
                var hotel_list = data.code;
                $.each(hotel_list, function(i, item){
                    $('#hotel-list').append("<a href=\"index.php?r=API/h5/hotel-detail\" class=\"weui-media-box weui-media-box_appmsg\">" +
                        "<div class=\"weui-media-box__hd\">" +
                        "<img class=\"weui-media-box__thumb\" src='/"+ item.hotel_img +"' alt='"+ item.hotel_name +"' >" +
                        "</div>" +
                        "<div class=\"weui-media-box__bd\">" +
                        "<h4 class=\"weui-media-box__title\">"+ item.hotel_name +"</h4>" +
                        "<p class=\"weui-media-box__star\">" +
                        "<img src=\"/images/star.jpg\" width=\"75\">" +
                        "<span class=\"text-warning\">"+ item.comment +"</span></p>" +
                        "<p class=\"weui-media-box__type\">"+ item.hotel_star + "|" + item.hotel_star +"</p>" +
                        "<p class=\"weui-media-box__address\">" +
                        "<img src=\"/images/address.png\" width=\"10\">" + "距离你" + item.distance + "m" +"</p>" +
                        "<p class=\"weui-media-box__price\"><span class=\"text-orange\">"+ "¥"+ item.price +"</span>" + "起" + "</p></div>" +
                        "</a>");
                });
            }
        });
    });
</script>

</body>
</html>