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
    <!--头部-->
<!--    <header class="head-bar cont">-->
<!--        <a href="javascript:;" onclick="javascript:history.back(-1);" class="inline-block back-img">-->
<!--        <img src="/images/back_white.png" class="max-width">-->
<!--        </a>-->
<!--        <h1 class="title ellipsis">访客预约</h1>-->
<!--    </header>-->
    <!--主体内容 (向阳A座)-->
    <div class="open-door cont">
        <div class="expiration text-center" style="display: none">
            <img src="/images/loseefficacy.png" class="max-width expiration-img">
            <p class="expiration-text">温馨提示：该链接已失效，请重新生成访客链接</p>
        </div>

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
        <p class="tip">开门成功</p>
    </div>
</div>


<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/fastclick.js')?>
<?=Html::jsFile('/js/open-door1.js')?>
<script>
    $(function() {
        FastClick.attach(document.body);
        // 向阳house_id:6    A座seat_id:29     B座seat_id:30
        // http://www.aiban.com/index.php?r=API/h5/visitor-book6-29&token=IwD5eClUcgo4DFrHaPsutsPpzNX54e8fRGYnM02LrSz6K2kzyS5pxFAnAVhRUp/K8kJupDAfkkonzPYSI7yJk8Fls7GwtEWc75XOZS99mgo=&end_time=1534758520
        var loc = location.href;
        // 微信分享
        var all_length = loc.length;
        var token_n = loc.indexOf("token"); //返回某个指定的字符串值在字符串中首次出现的位置
        var end_time_n = loc.indexOf("end_time");
        var token = loc.substr(token_n+6, end_time_n-token_n-7);
        var end_time = loc.substr(end_time_n+9, all_length-end_time_n-9);
        if (loc.indexOf("from") != -1){ // !=-1 含有    ==-1不含有
            var from_n = loc.indexOf("from");
            end_time = loc.substr(end_time_n+9, from_n-end_time_n-10);
        } else if(loc.indexOf("from") == -1 && loc.indexOf("nsukey") != -1){
            var nsukey_n = loc.indexOf("nsukey");
            end_time = loc.substr(end_time_n+9, nsukey_n-end_time_n-10);
        } else if(loc.indexOf("appinstall") != -1){
            var appinstall_n = loc.indexOf("appinstall");
            end_time = loc.substr(end_time_n+9, appinstall_n-end_time_n-10);
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
        } else {
            $('.expiration').hide();
            $('.sluice').show();
        }

        var deviceId;
        var floor = '';
        $('.ajax-btn').on('click', function (){
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
            openAjax(deviceId, token, floor, tip_text);
        });

        function openAjax(deviceId, token, floor, tip_text) {
            $.ajax({
                url:'http://test.haoxiangkaimen.cn/api/ZSDeviceControl',
                type:'get',
                dataType:'json',
                data:{
                    deviceId : deviceId,
                    HXKM:  token,
                    floor: floor,
                    type: 2
                },
                success: function (res) {
                    console.log(res);
                    if (res.code == 1){
                        $('.tip').text(tip_text + "成功")
                    } else if(res.code == 3){
                        $('.tip').text("设备离线")
                    } else if(res.code == 4){
                        $('.tip').text("密钥错误")
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