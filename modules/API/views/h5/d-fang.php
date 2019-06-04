<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>3D看房详情</title>
    <meta name="viewport" content="initial-scale=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="../../dist/css/jquery-weui.css">
    <link rel="stylesheet" href="../../dist/css/swiper.min.css">
    <link rel="stylesheet" href="../../dist/css/d-fang.css">
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';

    </script>
</head>
<body ontouchstart>
<div id="container"></div>
<!--房源-->
<div class="swiper-container room-list swiper-room">
    <div class="swiper-wrapper" id="room-list"></div>
</div>
<div class="swiper-container bas-desc">
    <div class="swiper-wrapper" id="main-list"></div>
</div>

<script src="../../dist/js/three.min.js"></script>
<script src="../../dist/js/photo-sphere-viewer.min.js"></script>
<script src="../../dist/js/swiper.min.js"></script>
<script src="../../dist/js/jquery-2.1.4.js"></script>
<script src="../../dist/js/fastclick.js"></script>

<?=Html::jsFile('/js/common.js')?>

<script>
    $(document).ready(function () {
        $('.bas-desc-list').addClass('active');
    });
    $(function () {
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 'auto',
            spaceBetween: 0
        });

        // var loc = "http://106.15.127.161/API/h5/d-fang?id=1";
        var loc = location.href;
        var n1 = loc.length;
        var n2 = loc.indexOf("id");
        var id = loc.substr(n2+3, n1-n2-1);
        // console.log(id);
        // alert(id);

        var div = document.getElementById('container');
        $.ajax({
            type: "post",
            url:  "/API/lease/showings",
            dataType: 'json',
            data:{house_id: id},
            success: function (data) {
                var build_list = data.code;
                var length = build_list.length;
                // console.log(length);
                var room_list = build_list[length-1].rooms;
                var imgsrc = build_list[length-1].img_path; // 获取默认3D图片
                var PSV = new PhotoSphereViewer({
                    panorama: imgsrc,
                    container: div,
                    size: {
                      width: '100%',
                      height: screen.availHeight
                    },
                    theta_offset: 1000,   //旋转速度
                    time_anim: 3000,
                    loading_msg: '加载中……'
                });
                $.each(build_list, function (i, item) {
                    $("#main-list").append(
                        '<a href="#" class="swiper-slide bas-desc-list block">' +
                        '<img src="'+item.img_thumb+'" class="max-width"><p class="bas-desc-text">'+ item.type_name +'</p>' +
                        '<img src="'+item.img_path+'" class="d-house" style="display: none">' +
                        '</a>'
                    );
                });
                $.each(room_list, function (i, item) {
                    $("#room-list").append(
                        '<a href="#" class="swiper-slide room-swiper block">' +
                        '<img src="'+ item.img_thumb +'" class="max-width"><p class="swiper-text">'+ item.room_num +'室</p>' +
                        '<img src="'+item.img_path+ '" class="d-house" style="display: none">' +
                        '</a>'
                    )
                });

                // 房源默认选中展示
                $('.bas-desc-list:last-child').addClass('active');

            }
        });



    });
</script>
<script src="../../dist/js/d-fang.js"></script>
</body>
</html>