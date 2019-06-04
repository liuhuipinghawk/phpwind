<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>访客预约</title>
    <?=Html::cssFile('/css/weui.css')?>
    <?=Html::cssFile('/css/common-new.css')?>
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
    </script>
</head>
<body ontouchstart class="bg-orange">
<div class="wrap">
    <!--头部-->
    <header class="head-bar cont">
        <a href="javascript:;" onclick="javascript:history.back(-1);" class="inline-block back-img">
        <img src="/images/back_white.png" class="max-width">
        </a>
        <h1 class="title ellipsis">访客预约</h1>
    </header>
    <!--主体内容-->
    <div class="open-door cont" style="padding-top: 0.8rem">
        <div class="expiration text-center" style="display: none">
            <img src="/images/loseefficacy.png" class="max-width expiration-img">
            <p class="expiration-text">温馨提示：该链接已失效，请重新生成访客链接</p>
        </div>

        <div class="sluice padding-top">
            <p class="title">选择门禁</p>
            <ul class="clearfix">
                <li><a href="javascript:void(0)" class="btn sluice-in">1号闸机进口</a></li>
                <li><a href="javascript:void(0)" class="btn sluice-out">1号闸机出口</a></li>
            </ul>
        </div>

        <div class="elevator hide">
            <p class="title">选择电梯</p>
            <ul class="clearfix">
                <li><a href="javascript:void(0)" class="btn">D梯(低区)</a></li>
            </ul>
        </div>
        <div class="floor hide">
            <p class="title">选择楼层</p>
            <ul class="clearfix floor-ul">
                <!--                <li class="floor-li"><a href="#" class="btn">1</a></li>-->
            </ul>
        </div>

    </div>
    <div class="mask floor-mask text-center" style="display: none">
        <p class="tip">开门成功</p>
    </div>
</div>


<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/fastclick.js')?>
<?=Html::jsFile('/js/open-door.js')?>
<script>
    $(function() {
        FastClick.attach(document.body);
        // http://106.15.127.161/index.php?r=API/h5/visitor-book&token=cpnoMIiWI2dVAicSV35CEgcnkXDL9BIgSbhOeZZTERWLFoYVLwyXKnEbsEI4rLFNK29ui/DsofGQLS3Hu8b72Q==&end_time=1532920815&house_id=1&seat_id=30
        var loc = location.href;
// www.aiban.com/index.php?r=API/h5/visitor-book&token=IwD5eClUcgo4DFrHaPsutsPpzNX54e8fRGYnM02LrSz6K2kzyS5pxFAnAVhRUp/K8kJupDAfkkonzPYSI7yJk8Fls7GwtEWc75XOZS99mgo=&end_time=1534758520&house_id=6&seat_id=29
     // 微信分享
        var token_n = loc.indexOf("token"); //返回某个指定的字符串值在字符串中首次出现的位置
        var end_time_n = loc.indexOf("end_time");
        var house_id_n = loc.indexOf("house_id");
        var seat_id_n = loc.indexOf("seat_id");
        var token = loc.substr(token_n+6, end_time_n-token_n-7);
        var end_time = loc.substr(end_time_n+9, house_id_n-end_time_n-10);
        var house_id = loc.substr(house_id_n+9, seat_id_n-house_id_n-10);
        var seat_id;
        var all_length = loc.length;
        seat_id = loc.substr(seat_id_n+8, all_length-seat_id_n-8);
        if (loc.indexOf("from") != -1){ // !=-1 含有    ==-1不含有
            var from_n = loc.indexOf("from");
            seat_id = loc.substr(seat_id_n+8, from_n-seat_id_n-9);
        } else if(loc.indexOf("from") == -1 && loc.indexOf("nsukey") != -1){
            var nsukey_n = loc.indexOf("nsukey");
            seat_id = loc.substr(seat_id_n+8, nsukey_n-seat_id_n-9);
        } else if(loc.indexOf("appinstall") != -1){
            var appinstall_n = loc.indexOf("appinstall");
            seat_id = loc.substr(seat_id_n+8, appinstall_n-seat_id_n-9);
        }
        console.log(seat_id);
        if (house_id == 2){ // 蓝海2 向阳6
            $(".elevator").removeClass("hide");
        }

       function timest() {
            var tmp = Date.parse( new Date() ).toString();
            tmp = tmp.substr(0,10);
            return tmp;
        }
        var timestamp = timest();
        if (timestamp > end_time){
            $('.expiration').show();
            $('.sluice').hide();
            $('.elevator').hide();
        } else {
            $('.expiration').hide();
            $('.sluice').show();
            $('.elevator').show();
        }

        var lime_floor = 15;
        for(var i = 1;i <= lime_floor; ++i){
            $('.floor-ul').append('<li class="floor-li"><a href="javascript:void(0)" class="btn">'+i+'</a></li>');
        }

        // 选择楼层
        $('.floor-li').on('click', function () {
            $(this).addClass('active');
            $(this).siblings().removeClass('active');
        });

        var deviceId;
        var floor;
        var header_text = "开门";
        $('.sluice-in, .sluice-out, .floor-li').on('click', function (){
            if(house_id == 2&&seat_id == 21){ //蓝海1栋
                if($(".sluice-in").hasClass('active')){
                    deviceId = 5002101;
                } else if($('.sluice-out').hasClass('active')){
                    deviceId = 5002102;
                }else if($('.floor-li').hasClass('active')){
                    deviceId = 50021804;
                    floor = $('.floor-li.active .btn').html();
                    header_text = "选择电梯"
                }
            }
            if(house_id == 2&&seat_id == 22){ //蓝海2栋
                if($(".sluice-in").hasClass('active')){
                    deviceId = 5002103;
                }else if($('.sluice-out').hasClass('active')){
                    deviceId = 5002104;
                }
            }
            if(house_id == 6&&seat_id == 29){ //向阳6 A座
                if($(".sluice-in").hasClass('active')){
                    deviceId = 5002201;
                } else if($('.sluice-out').hasClass('active')){
                    deviceId = 5002202;
                }
            }
            if(house_id == 6&&seat_id == 30){ //向阳6 B座
                if($(".sluice-in").hasClass('active')){
                    deviceId = 5002203;
                } else if($('.sluice-out').hasClass('active')){
                    deviceId = 5002204;
                }
            }
            $.ajax({
                url:'http://test.haoxiangkaimen.cn/api/ZSDeviceControl',
                type:'get',
                dataType:'json',
                data:{
                    deviceId : deviceId,
                    HXKM: token,
                    floor: floor,
                    type: 2
                },
                success:function(res){
                    console.log(res);
                    if (res.code == 1){
                        $('.tip').text(header_text + "成功")
                    } else {
                        $('.tip').text(header_text + "失败")
                    }
                    $('.sluice-in, .sluice-out').removeClass('active');
                    setTimeout(function () {
                        $('.floor-mask').fadeIn();
                    },10);
                    setTimeout(function () {
                        $('.floor-mask').fadeOut()
                    }, 100);

                }
            });
        });

    });

</script>
</body>
</html>