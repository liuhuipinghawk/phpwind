<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="cache-control" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>中奖纪录</title>
    <?=Html::cssFile('css/weui.css')?>
    <?=Html::cssFile('css/jquery-weui.css')?>
    <?=Html::cssFile('/css/luck-draw.css?version=3.0')?>
</head>
<body class="luck-draw luck-list">
<!--大转盘样式-->
<div class="zp-box" id="zp-box">
    <div class="weui-loadmore" style="min-height: 100%;">
        <i class="weui-loading"></i>
        <span class="weui-loadmore__tips" style="color: #ffffff">正在加载</span>
    </div>

</div>

<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<script>
    $(function () {
        $.ajax({
            url:'/API/lottery/award-record',
            type:'POST',
            dataType:'json',
            success: function (res) {
                $("#zp-box").html("    <div class=\"rule-title\">" +
                    "        <img src=\"/images/rule-title.png?version=3.2\">" +
                    "    </div>" +
                    "    <div class=\"award-title\">" +
                    "        <p>中奖记录</p>" +
                    "    </div>" +
                    "    <div class=\"award-list\">" +
                    "        <ul id=\"award-list\"></ul>" +
                    "    </div>" +
                    "    <div class=\"award-record\" style=\"margin-top: 10px\">" +
                    "        <img src=\"/images/rule-list.png?version=3.0\">" +
                    "    </div>");
                var data_array = res.code;
                // console.log(data_array);
                if (data_array.length < 1){
                    $(".award-list").html("<p style='text-align: center;margin-top: 25px;'>--暂无中奖纪录--</p>")
                } else {
                    $.each(data_array, function (i, item) {
                        var mobile = item.mobile.replace(/(\d{3})\d{4}(\d{4})/, '$1****$2');
                        var substring = item.award_name.indexOf("-");
                        var award_name = item.award_name.substring(0, substring);
                        $("#award-list").append('<li><span class="house">'+ item.house_name +'</span><span class="mobile">'+mobile+'</span><span class="award">'+award_name+'</span></li>')
                    });
                }

                var $uList = $(".award-list ul");
                var timer = null;
                $uList.hover(function() {  //触摸清空定时器
                        clearInterval(timer);
                    },
                    function() { //离开启动定时器
                        timer = setInterval(function() {
                                scrollList($uList);
                            },
                            1200);
                    }).trigger("mouseleave"); //自动触发触摸事件
                //滚动动画
                function scrollList(obj) {
                    var scrollHeight = $("ul li:first").height();   //获得当前<li>的高度
                    $uList.stop().animate({  //滚动出一个<li>的高度
                            marginTop: -scrollHeight
                        }, 600,
                        function() {
                            $uList.css({ //动画结束后，将当前<ul>marginTop置为初始值0状态，再将第一个<li>拼接到末尾。
                                marginTop: 0
                            }).find("li:first").appendTo($uList);
                        });
                }
            }
        })
    })

</script>
</body>
</html>