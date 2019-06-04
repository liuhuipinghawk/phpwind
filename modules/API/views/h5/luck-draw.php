<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>兴业周周乐</title>
    <?=Html::cssFile('/css/luck-draw.css?version=3.1')?>
    <style>
        .overflow{
            overflow: hidden;
        }
    </style>
</head>
<body class="luck-draw">
<!--大转盘样式-->
<div class="zp-box" id="zp-box">
    <div class="world-luck"> <img src="/images/world-luck.png?version=3.0"> </div>
    <div class="dp-box">
        <div class="dipan"><img src="/images/dipan.png?version=3.1" class="dipan-img"> </div>
        <div class="zhizhen"><img src="/images/zhizhen.png" class="zhizhen-img"></div>
    </div>
    <div class="award-record"> <img src="/images/award.png?version=3.1"></div>
    <div class="rule"><img src="/images/rule.png?version=3.0"></div>
</div>

<!--遮罩&弹框-->
<div class="mask"></div>
<div class="no-luck">
    <img src="/images/close.png" class="close">
    <p class="text">暂无抽奖活动</p>
    <a href="javascript:void(0);" class="sure_btn" style="left: 33%">确定</a>
</div>
<!-- 抽到奖励弹框 -->
<div class="win-cont">
    <img src="/images/close.png" class="close">
    <p class="texts">恭喜您,中奖啦！<br>双季丰满减红包满1000可用50元</p>
    <a href="javascript:void(0);" class="sure_btn">确定</a>
    <a href="javascript:void(0);" class="share">分享</a>
</div>
<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/jquery.rotate.js')?>
<?=Html::jsFile('/js/public.js')?>
<?=Html::jsFile('/js/luck-draw.js?version=3.0')?>
<script>
    $(function () {
        $(".close").on('click', function() {
            $(".mask").hide();
            $(".luck-draw").removeClass("overflow");
            $(".no-num").hide();
            $(".no-luck").hide();
        });

        // 调取分享方法
        $(".share").on('click', function () {
            getShare();
        });

        // http://106.15.127.161/index.php?r=API/h5/luck-draw&user_id=518&house_id=1
        var loc = location.href;
        var all_length = loc.length;
        var house_id_n = loc.indexOf("house_id");
        var user_id_n = loc.indexOf("user_id");
        var house_id = loc.substr(house_id_n+9, all_length-house_id_n-1);
        var user_id = loc.substr(user_id_n+8, house_id_n-user_id_n-9);

        var lottery_id;
        var nums; //初始次数，由后台传入
        var $btn = $('.dipan-img'); // 旋转的div
        var isture; //是否正在抽奖
        var iTime;
        $.ajax({
            url:'/API/lottery/index',
            type:'POST',
            dataType:'json',
            data:{
                user_id: user_id,
                house_id: house_id
            },
            success: function (res) {
                var status = res.status;
                if (status == 200){
                    var data = res.code;
                    lottery_id = data.lottery_id; //转盘活动ID
                    nums = data.nums;
                } else if(status == -200) {
                    lottery_id = 0;
                    nums = 0
                }
                console.log(nums);
                clearTimeout(iTime);
                iTime = setTimeout(function () {
                    $(".zhizhen").click(function () {
                        if (isture) return; // 如果在执行就退出
                        isture = true; // 标志为 在执行
                        $.ajax({
                            url:'/API/lottery/lottery',
                            type:'POST',
                            dataType:'json',
                            data:{
                                user_id: user_id,
                                house_id: house_id,
                                lottery_id: lottery_id
                            },
                            success:function(res){
                                var status = res.status;
                                if (status == 200){
                                    var data = res.code;
                                    console.log(data);
                                    var award = data.award;
                                    var award_name = data.award_name;
                                    var prosit = "恭喜您，中奖啦!";
                                    var clickfunc = function() {
                                        if(award == "te"){
                                            rotateFunc(210, prosit+'</br>'+award_name);
                                        } else if(award == "can1" || award == "can2"){
                                            rotateFunc(270, prosit+'</br>'+award_name);
                                        } else if(award == "thanks" || award == "kong"){
                                            rotateFunc(330, award_name);
                                        } else if(award == "yi"){
                                            rotateFunc(30, prosit+'</br>'+award_name);
                                        } else if(award == "er"){
                                            rotateFunc(90, prosit+'</br>'+award_name);
                                        } else if(award == "san"){
                                            rotateFunc(150,  prosit+'</br>'+award_name);
                                        }
                                    };
                                    if (nums <= 0) { //当抽奖次数为0的时候执行
                                        $(".mask").show();
                                        $(".luck-draw").addClass("overflow");
                                        $(".no-luck").show();
                                        $(".sure_btn").on('click', function() {
                                            $(".no-luck").hide();
                                            $(".mask").hide();
                                            $(".luck-draw").removeClass("overflow");
                                        });
                                        isture = false;
                                    } else { //还有次数就执行
                                        nums = nums - 1; //执行转盘了则次数减1
                                        if (nums <= 0) {
                                            nums = 0;
                                        }
                                        clickfunc();
                                    }
                                }else if(status == -200){
                                    var message = res.message;
                                    $(".mask").show();
                                    $(".luck-draw").addClass("overflow");
                                    $(".no-luck .text").text(message);
                                    $(".no-luck").show();
                                    $(".sure_btn").on('click', function() {
                                        $(".no-luck").hide();
                                        $(".mask").hide();
                                        $(".luck-draw").removeClass("overflow");
                                    });
                                    isture = false;
                                }

                            }
                        });
                    })
                },100)
            }
        });
        var rotateFunc = function(angle, text) {
            isture = true;
            $btn.stopRotate();
            $btn.rotate({
                angle: 0, //旋转的角度数
                duration: 5000, //旋转时间
                animateTo: angle + 1080, //给定的角度,让它根据得出来的结果加上1440度旋转
                callback: function() {
                    isture = false; // 标志为 执行完毕
                    $(".texts").html(text);
                    $(".mask").show();
                    $(".luck-draw").addClass("overflow");
                    $(".win-cont").show();
                    $(".close").on('click', function() {
                        $(".mask").hide();
                        $(".luck-draw").removeClass("overflow");
                        $(".win-cont").hide();
                    });
                    $(".sure_btn").on('click', function() {
                        $(".mask").hide();
                        $(".luck-draw").removeClass("overflow");
                        $(".win-cont").hide();
                    });
                }
            });
        };
    })
</script>
</body>
</html>