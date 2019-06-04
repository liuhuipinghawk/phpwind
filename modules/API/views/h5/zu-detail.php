<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>房源详情</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no,email=no,adress=no">
    <meta name="author" content="he">
    <meta name="description" content="是一个出租写字楼、公寓、商铺的专业平台">
    <meta name="keywords" content="正e租">
    <link rel="stylesheet" href="../dist/css/weui.css">
    <link rel="stylesheet" href="../dist/css/jquery-weui.css">
    <link rel="stylesheet" href="../dist/css/swiper.min.css">
    <link rel="stylesheet" href="../dist/css/common.css">
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
    </script>
</head>
<body ontouchstart>
<div class="wrap">
    <div class="content-detail">
        <!--  焦点图  -->
        <div class="swiper-container swiper-auto swiper-detail">
            <div class="swiper-wrapper clearfix">
                <!--<div class="swiper-slide text-center">
                    <a href="#"><img src="../dist/images/de_banner.jpg" class="max-width"></a>
                </div>-->
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <div class="bg-white cont price-dec" style="margin-top: -5px">
            <div class="text-black price-scenery" id="full-sce-app">

            </div>
            <div class="weui-flex cont-tb">
                <div class="weui-flex__item text-center">
                    <p class="text-gary">面积</p>
                    <p class="text-black margin-small-top"><span id="space"></span>㎡</p>
                </div>
                <div class="weui-flex__item text-center">
                    <p class="text-gary">楼层</p>
                    <p class="text-black margin-small-top"><span id="floor"></span></p>
                </div>
                <div class="weui-flex__item text-center">
                    <p class="text-gary">房屋朝向</p>
                    <p class="text-black margin-small-top"><span id="orien"></span></p>
                </div>
                <div class="weui-flex__item text-center">
                    <p class="text-gary">装修</p>
                    <p class="text-black margin-small-top"><span id="deco"></span></p>
                </div>
            </div>
            <div class="house-title cont-tb text-gary block" id="name_address">

            </div>
        </div>
        <ul class="bg-white cont margin-top base-desc text-gary cont-tb" id="cont_tb">
<!--            <li class="detail-title margin-small-bottom text-black">基本信息</li>-->
<!--            <li><span class="text-black">租金</span>押二付三，物业费9.8元/平方米/月</li>-->
<!--            <li><span class="text-black">年代</span><span id="age"></span>年</li>-->
<!--            <li><span class="text-black">商圈</span>商鼎路</li>-->
<!--            <li><span class="text-black">地铁</span><span id="subway_name"></span>>><span id="station_name"></span></li>-->
        </ul>
        <div class="detail-desc margin-top cont cont-tb bg-white">
            <p class="detail-title text-black">房源概况</p>
            <p class="desc text-gary margin-top" id="house_desc"></p>
        </div>
    </div>
    <div class="footer border-top clearfix">
        <img src="/images/phone-buss.png" width="28" class="pull-left"><a id="person_tel_a" class="pull-left phone phone-buss"></a>
        <a href="javascript:void(0);" class="pull-right book-btn btn-buss" id="btn">立即预约</a>
    </div>
    <!--弹出框-->
    <div class="mask dropdown-mask" zyz-event="hide_dropdown_mask" style="display: none"></div>
    <div class="book-tip box-content" style="display: none">
        <ul class="book-list">
            <li>
                <input type="text" id="person_name" placeholder="联系人姓名">
            </li>
            <li>
                <input type="text" id="person_tel" placeholder="联系人电话">
            </li>
            <!--<li><p>预约成功后，工作人员会尽快与您确认需求或者拨打客服电话：<span class="text-bluest">400-6060-617</span></p></li>-->
        </ul>
        <a href="javascript:void(0);" id="btn-book" class="book book-buss block font-size-15 text-center">立即预约</a>
    </div>
    <style type="text/css">
        .swiper-container{
            max-height: 4.2rem;
        }
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            padding: 0 10px;
            width: 100%;
            height: 52px;
            background: #FFF;
        }
        .footer img {
            margin-top: 12px;
            width: 26px;
        }
        .footer .phone {
            margin-left: 8px;
            font-size: 21px;
            line-height: 52px;
        }
        .footer .book-btn {
            padding: 6px 25px;
            margin-top: 8px;
            border-radius: 3px;
            color: #FFF;
            font-size: 16px;
        }
        .footer .book-btn.btn-buss {
            background: #6f88a9!important;
        }
        .footer .phone.phone-buss {
            color: #6f88a9!important;
        }
        .mask{
            top: 0;
        }
        .book-tip.box-content{
            width: 90%;
            position: fixed;
            top: 30%;
            left: 5%;
            background: #fff;
            z-index: 2;
        }
        .book-tip .book-list {
            padding: 50px 20px 20px;
        }
        .book-tip li {
            margin-bottom: .25rem;
        }
        .book-tip li:first-child input {
            background: url(/images/mi.png) 6px no-repeat;
        }
        .book-tip li:nth-child(2) input {
            background: url(/images/tell.png) 6px no-repeat;
        }
        .book-tip input {
            border-bottom: 1px solid #ddd;
            width: 100%;
            line-height: .56rem;
            padding: .15rem 0 0 .85rem;
            background-size: .45rem!important;
            font-size: .26rem!important;
        }
        .book-tip .book.book-buss {
            background: #6f88a9;
        }
        .book-tip .book {
            margin: 20px auto 0;
            background: #f18f36;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            width: 100%;
            font-size: .26rem;
            line-height: .65rem;
            color: #FFF;
        }
        .font-size-15 {
            font-size: 15px;
        }

    </style>

</div>

<script src="../dist/js/jquery-2.1.4.js"></script>
<script src="../dist/js/jquery-weui.js"></script>
<script src="../dist/js/swiper.js"></script>
<script src="../dist/js/fastclick.js"></script>
<script src="../dist/js/common.js"></script>
<script src="../js/public.js"></script>
<script>
    var publish_id= location.search.substr(location.search.indexOf('publish_id')+11);
    $.ajax({
        type:"post",
        url:"/index.php?r=API/lease/lease-detail",
        async:true,
        data:{
            'publish_id':publish_id
        },
        success:function(res){
            var data=JSON.parse(res).code;
            // console.log(data);
            var img_id = data.img_3d;
            // console.log(img_id);
            document.cookie="imgsrc="+img_id;

            if(img_id == '' || img_id.length == 0){
                $("#full-sce-app").html('<p class="price"><span class="text-orange" id="price">'+data.price+'</span><span id="unit" style="font-size: 0.3rem">'+ data.unit +'</span></p>');
            }else {
                $("#full-sce-app").html('<p class="price"><span class="text-orange" id="price">'+ data.price +'</span><span id="unit" style="font-size: 0.3rem">'+data.unit+'</span></p>' +
                    '<a href="index.php?r=API/h5/zd-fang" class="full-sce"><span><img src="../../dist/images/icon.png" class="max-width sce-img" /> </span>全景看房</a> ')
            }

            for(i=0;i<data.imgs.length;i++){
                $(".swiper-auto .swiper-wrapper").append(
                    '<div class="swiper-slide text-center">'+
                    '<a href="javascript:;"><img src="'+data.imgs[i].img_path+'" class="max-width"></a>'+
                    '</div>'
                )
            }
            $(".swiper-auto").swiper({
                loop: true, //循环
                autoplay: 2000
            });

            $('#name_address').html('<p class="detail-title text-black" id="house_name">'+data.house_name+'</p>' +
                '<p class="address" id="address">'+data.address+'</p>');
            $('#cont_tb').html('<li class="detail-title margin-small-bottom text-black">基本信息</li>' +
                '<li><span class="text-black">年代</span><span id="age">'+data.age+'</span>年</li>' +
                '<li><span class="text-black">地铁</span><span id="subway_name">'+data.subway_name+'</span>>><span id="station_name">'+data.station_name+'</span></li>')

            $("#space").html(data.space);
            $("#floor").html(data.floor);
            $("#orien").html(data.orien_name);
            $("#deco").html(data.deco_name);
            $("#house_desc").html(data.house_desc);


            $("#person_tel_a").html(data.person_tel).attr("href",'tel:'+data.person_tel)
        }
    });
    $('#btn').click(function(){
        $('.mask.dropdown-mask').css({display:'block'});
        $('.book-tip.box-content').css({display:'block'});
        $('body').addClass('mask-body');
        userInfo();
    });
    $('.mask.dropdown-mask').click(function(){
        $('.book-tip.box-content').css({display:'none'});
    });
    $('#btn-book').click(function(){
        var order_type=11;
        var person_name = $('#person_name').val();
        var person_tel  = $('#person_tel').val();
        console.log(person_tel)
        if (person_name == '' || person_name.length == 0) {
            $.alert('请输入联系人姓名');
            return;
        }
        else if (person_tel == '' || person_tel.length == 0) {
            $.alert('请输入联系方式');
            return;
        }
        else if (!(/^1[3|4|5|7|8][0-9]{9}$/.test(person_tel))) {
            $.alert('请输入正确的联系电话');
            return;
        }
        else{
            $.ajax({
                type:"post",
                url:"http://106.15.127.161/index.php?r=API/service/service-order",
                async:true,
                data:{
                    'order_type':order_type,
                    'person_name':person_name,
                    'person_tel':person_tel,
                    'publish_id':publish_id
                },
                success:function(){
                    $('.mask.dropdown-mask').css({display:'none'});
                    $('.book-tip.box-content').css({display:'none'});
                    $('body').removeClass('mask-body');
                    $.alert('预约成功')
                }
            });
        }
    })
</script>
</body>
</html>