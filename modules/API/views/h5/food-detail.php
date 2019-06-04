<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>美食详情</title>
    <?=Html::cssFile('/css/weui.css')?>  
    <?=Html::cssFile('/css/jquery-weui.css')?>  
    <?=Html::cssFile('/layui/css/layui.css')?> 
    <?=Html::cssFile('/css/h-f-com.css')?>
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
    </script>
</head>
<body ontouchstart class="relative">
<div class="wrap">
    <!--头部-->
    <!--<header class="bar">-->
    <!--<a href="javascript:;" onclick="javascript:history.back(-1);" class="icon pull-left"><img src="../dist/images/back.png" width="11"></a>-->
    <!--<h1 class="title">直饮水</h1>-->
    <!--</header>-->
    <!--主体内容-->
    <div class="app-cont show-page">
        <div class="show-img text-center">
            <img src="/images/food_detail.jpg" alt="" class="max-width">
        </div>
    </div>
    <div class="footer border-top clearfix">
        <img src="/images/phone-orange.png" width="28" class="pull-left"><span class="pull-left phone phone-orange">400-888-888</span>
        <a href="#" class="pull-right book-btn btn-house">立即预约</a>
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
        <li><p>预约成功后，工作人员会尽快与您确认需求或者拨打客服电话：<span class="text-orange">400-6060-617</span></p></li>
    </ul>
    <a href="javascript:void(0);" id="btn-book" class="book book-house block text-center">立即预约</a>
</div>
<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/jquery.cookie.js')?>
<?=Html::jsFile('/js/public.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<script>
    $(function () {
        layui.use('layer', function() {
            var $ = layui.jquery,
                layer = layui.layer;
            $('.book-btn').click(function () {
                $('body').addClass('mask-body');
                layer.open({
                    area: '90%'
                    ,title: false
                    ,resize: false
                    ,type: 1
                    ,content:$('.book-tip')
                    ,cancel: function(){
                        $('body').removeClass('mask-body');
                    }
                })
            });
        });

        //预约
        $('#btn-book').click(function(){
            var person_name = $('#person_name').val();
            var person_tel  = $('#person_tel').val();
            if (person_name == undefined || person_name.length == 0) {
                layer.msg('请输入联系人姓名',{time: 1500});
                return false;
            }
            if (person_tel == undefined || person_tel.length == 0) {
                layer.msg('请输入联系方式',{time: 1500});
                return false;
            }
            if (!(/^1[3|4|5|7|8][0-9]{9}$/.test(person_tel))) {
                layer.msg('请输入正确联系方式',{time: 1500});
                return false;
            }

//            $.ajax({
//                url:'/index.php?r=API/service/service-order',
//                type:'post',
//                dataType:'json',
//                data:{
//                    order_type:3,
//                    person_name:person_name,
//                    person_tel:person_tel
//                },
//                success:function(res){
//                    if (res.status == 205) {
//                        layer.msg('用户信息已丢失，请重新登录',{time: 1500});
//                        // 重新调取登录接口
//                        missLogin();
//                    }else if (res.status == 200) {
//                        layer.msg('预约成功',{time: 1500});
//                        location.reload();
//                    } else {
//                        layer.msg(res.message,{time: 1500});
//                        return false;
//                    }
//                }
//            });

        });

    });

</script>
</body>
</html>