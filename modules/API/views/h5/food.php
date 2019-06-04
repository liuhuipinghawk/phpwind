<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>美食</title>
    <?=Html::cssFile('/css/weui.css')?>
    <?=Html::cssFile('/css/jquery-weui.css')?>
    <?=Html::cssFile('/layui/css/layui.css')?>
    <?=Html::cssFile('/css/common.css')?>
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
    </script>
</head>
<body ontouchstart class="relative">
<div class="wrap">
    <!--主体内容-->
    <div class="app-cont show-page">
        <div class="show-img text-center">
            <img src="" alt="" class="max-width"  id="food_img">
        </div>
    </div>
    <div class="footer border-top clearfix">
        <img src="/images/phone-plant.png" class="pull-left" style="width: 20px;margin-top: 15px">
        <span class="pull-left phone phone-plant" id="food_phone">400-6060-617</span>
        <a href="javascript:void(0);" class="pull-right book-btn btn-plant" style="padding: 5px 20px;margin-top: 10px">立即预约</a>
    </div>

</div>
<!--弹出框-->
<div class="book-tip box-content" style="display: none">
    <ul class="book-list">
        <li>
            <input type="text" id="person_name" placeholder="联系人姓名">
        </li>
        <li>
            <input type="text" id="person_tel" placeholder="联系人电话">
        </li>
        <li><p>预约成功后，工作人员会尽快与您确认需求~或者拨打客服电话：<span class="text-warning" id="book_phone">400-6060-617</span></p></li>
    </ul>
    <a href="#" class="book block text-center" id="btn-book">立即预约</a>
</div>
<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/jquery.cookie.js')?>
<?=Html::jsFile('/js/fastclick.js')?>
<?=Html::jsFile('/js/public.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<script>
    $(function(){
        FastClick.attach(document.body);
        var addrID = addressID(); // 获取楼盘id
        window.onload=function () {
            if (addrID == 1){ // 国际广场（御状元）
                // $("#food_phone, #book_phone").html("0371-53330299");
                $("#food_img").attr('src', '/images/f-yzy.jpg');
            } else if(addrID == 4){ // 航海广场（薇觅cakes烘焙工作室）
                // $("#food_phone, #book_phone").html("13673639943");
                $("#food_img").attr('src', '/images/f-cakes.jpg');
            } else if(addrID == 7){ // 建正东方中心（风波庄）
                // $("#food_phone, #book_phone").html("13663852163");
                $("#food_img").attr('src', '/images/f-fbz.jpg');
            } else if(addrID == 8){ // 木华广场（n多寿司）
                // $("#food_phone, #book_phone").html("18037151080");
                $("#food_img").attr('src', '/images/f-ss.jpg');
            } else if(addrID == 38){ // 佳世阁（萧三河洛面）
                // $("#food_phone, #book_phone").html("13007530993");
                $("#food_img").attr('src', '/images/f-hlm.jpg');
            } else if(addrID == 40){ // 学府广场（闷菜青年）
                // $("#food_phone, #book_phone").html("15690852665");
                $("#food_img").attr('src', '/images/f-mcqn.jpg');
            }
        };
        layui.use('layer', function() {
            var $ = layui.jquery,
                layer = layui.layer;
            $('.book-btn').click(function () {
                $('body').addClass('mask-body');
                // 调取默认用户信息
                userInfo();
                layer.open({
                    area: '90%'
                    ,title: false
                    ,resize: false
                    ,type: 1
                    ,content:$('.book-tip')
                    ,cancel: function(){
                        $('body').removeClass('mask-body');
                    }
                });
            });
        });
        //预约
        $('#btn-book').click(function(){
            var person_name = $('#person_name').val();
            var person_tel  = $('#person_tel').val();
            if (person_name == undefined || person_name.length == 0) {
                layer.msg('请输入联系人姓名',{time: 2000});
                return false;
            }
            if (person_tel == undefined || person_tel.length == 0) {
                layer.msg('请输入联系方式',{time: 2000});
                return false;
            }
            if (!(/^1[3|4|5|7|8][0-9]{9}$/.test(person_tel))) {
                layer.msg('请输入正确联系方式',{time: 2000});
                return false;
            }
            $.ajax({
                url:'/index.php?r=API/service/service-order',
                type:'post',
                dataType:'json',
                data:{
                    order_type:13,
                    person_name:person_name,
                    person_tel:person_tel
                },
                success:function(res){
                    if (res.status == 205) {
                        layer.msg('用户信息已丢失，请重新登录',{time: 2000});
                        // 重新调取登录接口
                        missLogin();
                    }else if (res.status == 200) {
                        layer.msg('预约成功',{time: 2000});
                        location.reload();
                    } else {
                        layer.msg(res.message,{time: 2000});
                        return false;
                    }
                }
            });
        });
    })
</script>
</body>
</html>