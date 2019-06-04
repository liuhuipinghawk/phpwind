<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>自助开门</title>
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
    <!--主体内容-->
    <div class="open-door cont">
        <div class="sluice">
            <p class="title">选择门禁</p>
            <ul class="clearfix">
                <li><a href="javascript:void(0)" class="btn sluice-in">1号闸机进口</a></li>
                <li><a href="javascript:void(0)" class="btn sluice-out">1号闸机出口</a></li>
            </ul>
        </div>

        <div class="elevator">
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
        <p class="tip">选择楼层成功</p>
    </div>
</div>

<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/fastclick.js')?>
<?=Html::jsFile('/js/open-door.js')?>
<script>
    $(function() {
        FastClick.attach(document.body);
        // 调取楼盘用户信息
        // userInfo();

        //  var loc = "http://106.15.127.161/index.php?r=API/h5/open-door1&user_id=1&house_id=2&seat_id=21";
        var loc = location.href;
        var all_length = loc.length;
        var seat_id_n = loc.indexOf("seat_id"); //返回某个指定的字符串值在字符串中首次出现的位置
        var house_id_n = loc.indexOf("house_id");
        var user_id_n = loc.indexOf("user_id");
        var seat_id = loc.substr(seat_id_n+8, all_length-seat_id_n-1);
        var house_id = loc.substr(house_id_n+9, seat_id_n-house_id_n-10);
        var user_id = loc.substr(user_id_n+8, house_id_n-user_id_n-9);
        // alert("楼座ID seat_id="+ seat_id + ";;;;;;;楼盘ID house_id="+ house_id + ";;;;;;;用户ID user_id="+ user_id);

        var lime_floor = 15;
        for(var i = 1;i <= lime_floor; ++i){
            $('.floor-ul').append('<li class="floor-li"><a href="javascript:void(0)" class="btn">'+i+'</a></li>');
        }

// 选择楼层
        $('.floor-li').on('click', function () {
            $(this).addClass('active');
            $(this).siblings().removeClass('active');
        });

        $.ajax({
            url:'/API/api/pass',
            type:'POST',
            dataType:'json',
            data:{
                user_id : user_id,
                house_id: house_id,
                seat_id: seat_id
            },
            success: function (res) {
                var hxkm = res.code;
                var deviceId;
                var floor;
                $('.sluice-in, .sluice-out, .floor-li').on('click', function () {
                    if($('.sluice-in').hasClass('active')){
                        deviceId = 5002101;
                        floor = '';
                        var header_text = "开门"
                    } else if($('.sluice-out').hasClass('active')){
                        deviceId = 5002102;
                        floor = '';
                        var header_text = "开门"
                    } else if($('.floor-li').hasClass('active')){
                        deviceId = 50021804;
                        floor = $('.floor-li.active .btn').html();
                        var header_text = "选择电梯"
                    } else {
                        floor = ''
                    }
                    $.ajax({
                        url:'http://test.haoxiangkaimen.cn/api/ZSDeviceControl',
                        type:'get',
                        dataType:'json',
                        data:{
                            deviceId : deviceId,
                            HXKM: hxkm,
                            floor: floor,
                            type: 1
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

            }
        });


    });

</script>
</body>
</html>