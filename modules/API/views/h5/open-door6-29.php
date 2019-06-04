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
    <!--主体内容 (向阳A座)-->
    <div class="open-door cont">
        <div class="sluice">
            <ul class="clearfix">
                <li class="ajax-btn sluice-in1"><a href="javascript:void(0);" class="btn">A1闸机进口</a></li>
                <li class="ajax-btn sluice-out1"><a href="javascript:void(0);" class="btn">A1闸机出口</a></li>
                <li class="ajax-btn sluice-in2"><a href="javascript:void(0);" class="btn">A2闸机进口</a></li>
                <li class="ajax-btn sluice-out2"><a href="javascript:void(0);" class="btn">A2闸机出口</a></li>
                <li class="ajax-btn sluice1"><a href="javascript:void(0);" class="btn">一楼步梯间</a></li>
                <li class="ajax-btn sluice2"><a href="javascript:void(0);" class="btn">负一电梯间</a></li>
                <li class="ajax-btn sluice3"><a href="javascript:void(0);" class="btn">负一步梯间</a></li>
                <li class="ajax-btn sluice4"><a href="javascript:void(0);" class="btn">负二电梯间</a></li>
                <li class="ajax-btn sluice5"><a href="javascript:void(0);" class="btn">负二步梯间</a></li>
            </ul>
        </div>
    </div>
    <div class="mask floor-mask text-center" style="display: none">
        <p class="tip"></p>
    </div>
</div>

<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/fastclick.js')?>
<?=Html::jsFile('/js/open-door1.js')?>
<script>
    $(function() {
        FastClick.attach(document.body);
        // 向阳house_id:6    A座seat_id:29     B座seat_id:30
        // http://www.aiban.com/index.php?r=API/h5/open-door6-29&user_id=1
        var loc = location.href;
        var all_length = loc.length;
        var user_id_n = loc.indexOf("user_id");
        var user_id = loc.substr(user_id_n+8, all_length-user_id_n-1);
        $.ajax({
            url:'/API/api/pass',
            type:'POST',
            dataType:'json',
            data: {
                user_id : user_id,
                house_id: 6,
                seat_id: 29
            },
            success: function (res) {
                var hxkm = res.code;
                var deviceId;
                var floor = '';
                $('.ajax-btn').on('click', function () {
                    var tip_text = "开门";
                    if($('.sluice-in1').hasClass('active')){
                        deviceId = 5002201;
                    } else if($('.sluice-out1').hasClass('active')){
                        deviceId = 5002202;
                    } else if($('.sluice-in2').hasClass('active')){
                        deviceId = 5002205;
                    } else if($('.sluice-out2').hasClass('active')){
                        deviceId = 5002206;
                    } else if($('.sluice1').hasClass('active')){
                        deviceId = 5002218;
                    }  else if($('.sluice2').hasClass('active')){
                        deviceId = 5002211;
                    }  else if($('.sluice3').hasClass('active')){
                        deviceId = 5002212;
                    } else if($('.sluice4').hasClass('active')){
                        deviceId = 5002213;
                    } else if($('.sluice5').hasClass('active')){
                        deviceId = 5002220;
                    }
                   openAjax(deviceId, hxkm, floor, tip_text);
                })

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
                        $('.tip').text(tip_text + "成功")
                    } else if(res.code == 3){
                        $('.tip').text("设备离线")
                    }  else if(res.code == 7){
                        $('.tip').text("没有添加授权")
                    }  else if(res.code == 9){
                        $('.tip').text("设备id错误")
                    } else {
                        $('.tip').text(tip_text + "失败")
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