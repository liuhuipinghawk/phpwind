<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no,email=no,adress=no">
    <title>自助开门</title>
    <?=Html::cssFile('/css/weui.css')?>
    <?=Html::cssFile('/css/jquery-weui.css')?>
    <?=Html::cssFile('/css/common-new1.css')?>
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
    </script>
</head>
<body ontouchstart>
<div class="wrap">
    <!--主体内容(蓝海1栋)-->
    <div class="open-door">
        <div class="weui-tab">
            <div class="weui-navbar">
                <a class="weui-navbar__item weui-bar__item--on" href="#tab1">
                    门禁
                </a>
                <a class="weui-navbar__item" href="#tab2">
                    电梯
                </a>
            </div>
            <div class="weui-tab__bd">
                <div id="tab1" class="weui-tab__bd-item weui-tab__bd-item--active">
                    <div class="division"></div>
                    <div class="sluice">
                        <ul class="clearfix">
                            <li class="ajax-btn sluice-in1"><a href="javascript:void(0);" class="btn">1号闸机进</a></li>
                            <li class="ajax-btn sluice-out1"><a href="javascript:void(0);" class="btn">1号闸机出</a></li>
                            <li class="ajax-btn sluice-in2"><a href="javascript:void(0);" class="btn">2号闸机进</a></li>
                            <li class="ajax-btn sluice-out2"><a href="javascript:void(0);" class="btn">2号闸机出</a></li>
                            <li class="ajax-btn sluice-in3"><a href="javascript:void(0);" class="btn">3号闸机进</a></li>
                            <li class="ajax-btn sluice-out3"><a href="javascript:void(0);" class="btn">3号闸机出</a></li>
                            <li class="ajax-btn sluice1"><a href="javascript:void(0);" class="btn">大堂步梯间</a></li>
                            <li class="ajax-btn sluice2"><a href="javascript:void(0);" class="btn">1楼货梯间</a></li>
                            <li class="ajax-btn sluice3"><a href="javascript:void(0);" class="btn">西步梯</a></li>
                            <li class="ajax-btn sluice4"><a href="javascript:void(0);" class="btn">负一客梯厅</a></li>
                            <li class="ajax-btn sluice5"><a href="javascript:void(0);" class="btn">负一货梯厅</a></li>
                            <li class="ajax-btn sluice6"><a href="javascript:void(0);" class="btn">负二客梯厅</a></li>
                        </ul>
                    </div>
                </div>
                <div id="tab2" class="weui-tab__bd-item">
                    <div class="division"></div>
                    <div class="sluice">
                        <ul class="clearfix">
                            <li class="sluice-btn sluice-a"><a href="javascript:void(0);" class="btn open-popup" data-target="">A梯(高区)</a></li>
                            <li class="sluice-btn sluice-b"><a href="javascript:void(0);" class="btn open-popup" data-target="">B梯(高区)</a></li>
                            <li class="sluice-btn sluice-c"><a href="javascript:void(0);" class="btn open-popup" data-target="">C梯(高区)</a></li>
                            <li class="sluice-btn sluice-d"><a href="javascript:void(0);" class="btn open-popup" data-target="">D梯(低区)</a></li>
                            <li class="sluice-btn sluice-e"><a href="javascript:void(0);" class="btn open-popup" data-target="">E梯(低区)</a></li>
                            <li class="sluice-btn sluice-f"><a href="javascript:void(0);" class="btn open-popup" data-target="">F梯(低区)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div id="floor" class="weui-popup__container">
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal">
        <p class="floor-title">选择楼层</p>
        <div class="sluice floor">
            <ul class="clearfix floor-ul">
<!--                <li class="floor-li active"><a href="javascript:void(0);" class="btn">15</a></li>-->
            </ul>
        </div>
        <a href="javascript:void(0);" class="close-popup floor-close">关闭</a>
    </div>

</div>
<div class="mask floor-mask text-center" style="display: none">
    <p class="tip"></p>
</div>
<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/jquery-weui.js')?>
<?=Html::jsFile('/js/fastclick.js')?>
<?=Html::jsFile('/js/open-door1.js')?>
<script>
    $(function() {
        FastClick.attach(document.body);
        $(".open-popup").click(function () {
            $("#floor").popup();
        });
        // 蓝海house_id:2        1栋seat_id:21     2栋seat_id:22
        // http://www.aiban.com/index.php?r=API/h5/open-door6-29&user_id=1
        // http://www.aiban.com/index.php?r=API/h5/open-door2-21&user_id=1#tab1
        var loc = location.href;
        var user_id_n = loc.indexOf("user_id");
        var tab_n = loc.indexOf("tab");
        var user_id = loc.substr(user_id_n+8, tab_n-user_id_n-9);
        $.ajax({
            url:'/API/api/pass',
            type:'POST',
            dataType:'json',
            data: {
                user_id : user_id,
                house_id: 2,
                seat_id: 21
            },
            success: function (res) {
                var hxkm = res.code;
                var deviceId;
                var floor = '';
                $('.ajax-btn').on('click', function () {
                    var tip_text = "开门";
                    if($('.sluice-in1').hasClass('active')){
                        deviceId = 5002101;
                    } else if($('.sluice-out1').hasClass('active')){
                        deviceId = 5002102;
                    } else if($('.sluice-in2').hasClass('active')){
                        deviceId = 5002103;
                    } else if($('.sluice-out2').hasClass('active')){
                        deviceId = 5002104;
                    } else if($('.sluice-in3').hasClass('active')){
                        deviceId = 5002105;
                    } else if($('.sluice-out3').hasClass('active')){
                        deviceId = 5002106;
                    } else if($('.sluice1').hasClass('active')){
                        deviceId = 5002111;
                    } else if($('.sluice2').hasClass('active')){
                        deviceId = 5002112;
                    } else if($('.sluice3').hasClass('active')){
                        deviceId = 5002117;
                    } else if($('.sluice4').hasClass('active')){
                        deviceId = 5002118;
                    } else if($('.sluice5').hasClass('active')){
                        deviceId = 5002119;
                    } else if($('.sluice6').hasClass('active')){
                        deviceId = 5002120;
                    }
                    openAjax(deviceId, hxkm, floor, tip_text);
                });

                $('.sluice-btn').on('click', function () {
                    if($('.sluice-a').hasClass('active') || $('.sluice-b').hasClass('active') || $('.sluice-c').hasClass('active')){
                        $('.floor-ul').html('');
                        $('.floor-ul').html('<li class="floor-li"><a href="javascript:void(0);" class="btn">1</a></li>');
                        var lime_floor = 28;
                        for(var i = 15;i <= lime_floor; ++i){
                            $('.floor-ul').prepend('<li class="floor-li"><a href="javascript:void(0)" class="btn">'+i+'</a></li>');
                        }
                    }else if($('.sluice-d').hasClass('active') || $('.sluice-e').hasClass('active') || $('.sluice-f').hasClass('active')){
                        $('.floor-ul').html('');
                        var lime_floor = 15;
                        for(var i = 1;i <= lime_floor; ++i){
                            $('.floor-ul').prepend('<li class="floor-li"><a href="javascript:void(0)" class="btn">'+i+'</a></li>');
                        }
                    }
                    if($('.sluice-a').hasClass('active')){
                        deviceId = 50021801;
                    } else if($('.sluice-b').hasClass('active')){
                        deviceId = 50021802;
                    } else if($('.sluice-c').hasClass('active')){
                        deviceId = 50021803;
                    } else if($('.sluice-d').hasClass('active')){
                        deviceId = 50021804;
                    } else if($('.sluice-e').hasClass('active')){
                        deviceId = 50021805;
                    } else if($('.sluice-f').hasClass('active')){
                        deviceId = 50021806;
                    }
                });
                $('.floor-ul').on('click', '.floor-li', function () {
                    var tip_text = "选择电梯";
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');
                    floor = $('.floor-li.active .btn').html();
                    openAjax(deviceId, hxkm, floor, tip_text);
                });
            }
        });


        function openAjax(deviceId, hxkm, floor, tip_text) {
            $.ajax({
                url:'http://test.haoxiangkaimen.cn/api/ZSDeviceControl',
                type:'get',
                dataType:'json',
                data:{
                    deviceId : deviceId,
                    HXKM:  hxkm,
                    floor: floor,
                    type: 1
                },
                success: function (res) {
                    console.log(res);
                    if (res.code == 1){
                        $('.tip').text(tip_text +"成功")
                    } else if(res.code == 3){
                        $('.tip').text("设备离线")
                    }  else if(res.code == 7){
                        $('.tip').text("没有添加授权")
                    }  else if(res.code == 9){
                        $('.tip').text("设备id错误")
                    } else {
                        $('.tip').text(tip_text +"失败")
                    }
                    $('.ajax-btn').removeClass('active');
                    setTimeout(function () {
                        $('.floor-mask').fadeIn();
                    },10);
                    setTimeout(function () {
                        $('.floor-mask').fadeOut()
                    }, 100);
                }
            })
        }

    });
</script>
</body>
</html>