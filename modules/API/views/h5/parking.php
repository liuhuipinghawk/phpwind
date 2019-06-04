<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>车位租赁</title>
    <?=Html::cssFile('/css/weui.css')?>
    <?=Html::cssFile('/css/jquery-weui.css')?>
    <?=Html::cssFile('/css/calendar.css')?>
    <?=Html::cssFile('/css/common.css')?>
    <?=Html::cssFile('/css/com_new.css')?>
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
    </script>
</head>
<body ontouchstart>
<div class="wrap">
    <!--主体内容-->
    <div class="app-cont parking-detail">
        <div class="detail-img text-center">
            <img src="/images/car_banner_two.png" class="max-width" alt="" id="park_img">
        </div>
        <div class="margin-cont park-select">
            <ul class="text-gary park-desc">
                <li class="arrow"><span class="m-title">选择楼盘项目</span> <span class="m-dec"><input type="text" placeholder="选择楼盘项目" id='project' onfocus='this.blur();'/></span></li>
                <li class="arrow"><span class="m-title">选择楼盘座号</span> <span class="m-dec"><input type="text" placeholder="选择楼盘座号" id='num'  onfocus='this.blur();'/></span></li>
                <li><span class="m-title">输入您的姓名</span> <span class="m-dec"><input type="text" placeholder="请输入您的姓名" id="person_name" /></span></li>
                <li><span class="m-title">输入您的电话</span> <span class="m-dec"><input type="text" placeholder="请输入您的电话" id="person_tel" /></span></li>
                <li class="arrow">
                    <span class="m-title">选择租赁时间</span>
                    <span class="m-dec">
                        <input type="text" placeholder="请选择租赁时间" readonly class="open-popup" data-target="#time" id="selectMoney" onfocus='this.blur();'/>
                    </span>
                </li>
            </ul>
            <a href="javascript:void(0);" class="book-btn clearfix">立即预约</a>

        </div>
    </div>
    <!--    租赁选择列表-->

</div>
<div id="time" class='weui-popup__container popup-bottom time_select'>
</div>
<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/jquery-weui.js')?>
<?=Html::jsFile('/js/fastclick.js')?>
<?=Html::jsFile('/js/public.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<script>
    $(function(){
        FastClick.attach(document.body);
        layui.use('layer', function() {
            var $ = layui.jquery,
                layer = layui.layer;
        });
        // 调取默认用户信息
        userInfo();
        //加载楼盘信息
        defaultLoad(0,'new');

        $('#project').change(function(){
            $("#selectMoney").val("");
            var pid = $(this).data('values');
            if (pid != undefined) {
                defaultLoad(pid);
            }
            var house_id = $('#project').data('values'); // 楼盘ID
            if(house_id == 3){ // 和谐  平面车位600一个月    机械车位500一个月  （ 3个月起租）
                $("#park_img").attr('src', '/images/car_banner_two.png');
                $("#time").html("<div class=\"weui-popup__overlay\"></div>" +
                    "        <div class=\"weui-popup__modal\">" +
                    "            <div class=\"toolbar\"><div class=\"toolbar-inner\"><h1 class=\"title\">租赁时间</h1></div></div>" +
                    "            <div class=\"modal-content\">" +
                    "                <div class=\"weui-cells parking-cells\">" +
                    "                    <div class=\"weui-cell\"><div class=\"weui-cell__hd\"><p>平面车位(含服务费)</p></div>" +
                    "                        <div class=\"weui-cell__bd\"><p>¥ <span id=\"total_price1\">600</span></p></div>" +
                    "                        <div class=\"weui-cell__ft\">" +
                    "                            <div class=\"weui-count\">" +
                    "                                <a class=\"weui-count__btn weui-count__decrease decrease1\"></a>" +
                    "                                <input class=\"weui-count__number\" type=\"number\" value=\"1\" readonly />" +
                    "                                <a class=\"weui-count__btn weui-count__increase increase1\"></a>" +
                    "                            </div>" +
                    "                        </div>" +
                    "                    </div>" +
                    "                    <div class=\"weui-cell\"><div class=\"weui-cell__hd\"><p>机械车位(含服务费)</p></div>" +
                    "                        <div class=\"weui-cell__bd\"><p>¥ <span id=\"total_price2\">0</span></p></div>" +
                    "                        <div class=\"weui-cell__ft\">" +
                    "                            <div class=\"weui-count\">" +
                    "                                <a class=\"weui-count__btn weui-count__decrease decrease2\"></a>" +
                    "                                <input class=\"weui-count__number\" type=\"number\" value=\"0\" readonly />" +
                    "                                <a class=\"weui-count__btn weui-count__increase increase2\"></a>" +
                    "                            </div>" +
                    "                        </div>" +
                    "                    </div>" +
                    "                </div>" +
                    "            </div>" +
                    "            <div class=\"toolBottom\">" +
                    "                <div class=\"pull-left\" id=\"bottomTip\">平面、机械车位3个月起售</div>" +
                    "                <a href=\"javascript:;\" class=\"pull-right close-popup sure_btn\">确定</a>" +
                    "            </div>" +
                    "        </div>");
                //    平面车位
                var MAX1 = 36, MIN1 = 0, MonPrice1 = 600;
                $('.decrease1').click(function (e) {
                    var $input = $(e.currentTarget).parent().find('.weui-count__number');
                    var number = parseInt($input.val() || "0") - 1;
                    if (number < MIN1) number = MIN1;
                    $input.val(number);
                    $("#total_price1").html(MonPrice1*number);
                });
                $('.increase1').click(function (e) {
                    var $input = $(e.currentTarget).parent().find('.weui-count__number');
                    var number = parseInt($input.val() || "0") + 1;
                    if (number > MAX1) number = MAX1;
                    $input.val(number);
                    $("#total_price1").html(MonPrice1*number);
                });
                //    机械车位
                var MAX2 = 36, MIN2 = 0, MonPrice2 = 500;
                $('.decrease2').click(function (e) {
                    var $input = $(e.currentTarget).parent().find('.weui-count__number');
                    var number = parseInt($input.val() || "0") - 1;
                    if (number < MIN2) number = MIN2;
                    $input.val(number);
                    $("#total_price2").html(MonPrice2*number);
                });
                $('.increase2').click(function (e) {
                    var $input = $(e.currentTarget).parent().find('.weui-count__number');
                    var number = parseInt($input.val() || "0") + 1;
                    if (number > MAX2) number = MAX2;
                    $input.val(number);
                    $("#total_price2").html(MonPrice2*number);
                });
                $(".sure_btn").click(function () {
                    var month1 = parseInt($("#total_price1").html())/MonPrice1;
                    var month2 = parseInt($("#total_price2").html())/MonPrice2;
                    if(month1 < 3 && month1 != 0){
                        layer.msg('平面车位3个月起租',{time: 2000});
                        return false;
                    }
                    if(month2 < 3 && month2 != 0){
                        layer.msg('机械车位3个月起租',{time: 2000});
                        return false;
                    }
                    if (month1 ==0 && month2 == 0){
                        layer.msg('车位3个月起租',{time: 2000});
                        return false;
                    }
                    var show_month1 = "平面" + month1 + "个月";
                    var show_month2 = "；机械" + month2 + "个月";
                    $('#selectMoney').val(show_month1 + show_month2);
                });

            } else if(house_id == 2 || house_id == 38 || house_id ==47){ // 蓝海，佳世阁，汇都  600/月(3+1，3个月起)
                $("#park_img").attr('src', '/images/car_banner.png');
                $("#time").html("<div class=\"weui-popup__overlay\"></div>" +
                    "        <div class=\"weui-popup__modal\">" +
                    "            <div class=\"toolbar\"><div class=\"toolbar-inner\"><h1 class=\"title\">租赁时间</h1></div></div>" +
                    "            <div class=\"modal-content\">" +
                    "                <div class=\"weui-cells parking-cells\">" +
                    "                    <div class=\"weui-cell\"><div class=\"weui-cell__hd\"><p>平面车位(含服务费)</p></div>" +
                    "                        <div class=\"weui-cell__bd\"><p>¥ <span id=\"total_price1\">600</span></p></div>" +
                    "                        <div class=\"weui-cell__ft\">" +
                    "                            <div class=\"weui-count\">" +
                    "                                <a class=\"weui-count__btn weui-count__decrease decrease1\"></a>" +
                    "                                <input class=\"weui-count__number\" type=\"number\" value=\"1\" readonly />" +
                    "                                <a class=\"weui-count__btn weui-count__increase increase1\"></a>" +
                    "                            </div>" +
                    "                        </div>" +
                    "                    </div>" +
                    "                </div>" +
                    "            </div>" +
                    "            <div class=\"toolBottom\">" +
                    "                <div class=\"pull-left\" id=\"bottomTip\"><p class='active_p'><span class='active_tip'>活动</span>买三个月送一个月</br>平面车位3个月起售</p></div>" +
                    "                <a href=\"javascript:;\" class=\"pull-right close-popup sure_btn\">确定</a>" +
                    "            </div>" +
                    "        </div>");
                //    平面车位
                var MAX1 = 36, MIN1 = 1, MonPrice1 = 600;
                $('.decrease1').click(function (e) {
                    var $input = $(e.currentTarget).parent().find('.weui-count__number');
                    var number = parseInt($input.val() || "0") - 1;
                    if (number < MIN1) number = MIN1;
                    $input.val(number);
                    $("#total_price1").html(MonPrice1*number);
                });
                $('.increase1').click(function (e) {
                    var $input = $(e.currentTarget).parent().find('.weui-count__number');
                    var number = parseInt($input.val() || "0") + 1;
                    if (number > MAX1) number = MAX1;
                    $input.val(number);
                    $("#total_price1").html(MonPrice1*number);
                });
                $(".sure_btn").click(function () {
                    var month1 = parseInt($("#total_price1").html())/MonPrice1;
                    if (month1 < 3){
                        layer.msg('3个月起租',{time: 2000});
                        return false;
                    }
                    var show_month1 = "平面" + month1 + "个月 ";
                    $('#selectMoney').val(show_month1);
                });

            } else if(house_id == 7 || house_id ==8){ // 木华， 建正   600/月
                $("#park_img").attr('src', '/images/car_banner_two.png');
                $("#time").html("<div class=\"weui-popup__overlay\"></div>" +
                    "        <div class=\"weui-popup__modal\">" +
                    "            <div class=\"toolbar\"><div class=\"toolbar-inner\"><h1 class=\"title\">租赁时间</h1></div></div>" +
                    "            <div class=\"modal-content\">" +
                    "                <div class=\"weui-cells parking-cells\">" +
                    "                    <div class=\"weui-cell\"><div class=\"weui-cell__hd\"><p>平面车位(含服务费)</p></div>" +
                    "                        <div class=\"weui-cell__bd\"><p>¥ <span id=\"total_price1\">600</span></p></div>" +
                    "                        <div class=\"weui-cell__ft\">" +
                    "                            <div class=\"weui-count\">" +
                    "                                <a class=\"weui-count__btn weui-count__decrease decrease1\"></a>" +
                    "                                <input class=\"weui-count__number\" type=\"number\" value=\"1\" readonly />" +
                    "                                <a class=\"weui-count__btn weui-count__increase increase1\"></a>" +
                    "                            </div>" +
                    "                        </div>" +
                    "                    </div>" +
                    "                </div>" +
                    "            </div>" +
                    "            <div class=\"toolBottom\">" +
                    "                <div class=\"pull-left\" id=\"bottomTip\">更多优惠请关注爱办app</div>" +
                    "               <a href=\"javascript:;\" class=\"pull-right close-popup sure_btn\">确定</a>" +
                    "            </div>" +
                    "        </div>");
                //    平面车位
                var MAX1 = 36, MIN1 = 1, MonPrice1 = 600;
                $('.decrease1').click(function (e) {
                    var $input = $(e.currentTarget).parent().find('.weui-count__number');
                    var number = parseInt($input.val() || "0") - 1;
                    if (number < MIN1) number = MIN1;
                    $input.val(number);
                    $("#total_price1").html(MonPrice1*number);
                });
                $('.increase1').click(function (e) {
                    var $input = $(e.currentTarget).parent().find('.weui-count__number');
                    var number = parseInt($input.val() || "0") + 1;
                    if (number > MAX1) number = MAX1;
                    $input.val(number);
                    $("#total_price1").html(MonPrice1*number);
                });
                $(".sure_btn").click(function () {
                    var month1 = parseInt($("#total_price1").html())/MonPrice1;
                    var show_month1 = "平面" + month1 + "个月 ";
                    $('#selectMoney').val(show_month1);
                });
            } else if(house_id ==6){ // 向阳  500/月
                $("#time").html("<div class=\"weui-popup__overlay\"></div>" +
                    "        <div class=\"weui-popup__modal\">" +
                    "            <div class=\"toolbar\"><div class=\"toolbar-inner\"><h1 class=\"title\">租赁时间</h1></div></div>" +
                    "            <div class=\"modal-content\">" +
                    "                <div class=\"weui-cells parking-cells\">" +
                    "                    <div class=\"weui-cell\"><div class=\"weui-cell__hd\"><p>平面车位(含服务费)</p></div>" +
                    "                        <div class=\"weui-cell__bd\"><p>¥ <span id=\"total_price1\">500</span></p></div>" +
                    "                        <div class=\"weui-cell__ft\">" +
                    "                            <div class=\"weui-count\">" +
                    "                                <a class=\"weui-count__btn weui-count__decrease decrease1\"></a>" +
                    "                                <input class=\"weui-count__number\" type=\"number\" value=\"1\"  readonly />" +
                    "                                <a class=\"weui-count__btn weui-count__increase increase1\"></a>" +
                    "                            </div>" +
                    "                        </div>" +
                    "                    </div>" +
                    "                </div>" +
                    "            </div>" +
                    "            <div class=\"toolBottom\">" +
                    "                <div class=\"pull-left\" id=\"bottomTip\">更多优惠请关注爱办app</div>" +
                    "               <a href=\"javascript:;\" class=\"pull-right close-popup sure_btn\">确定</a>" +
                    "            </div>" +
                    "        </div>");
                //    平面车位
                var MAX1 = 36, MIN1 = 1, MonPrice1 = 500;
                $('.decrease1').click(function (e) {
                    var $input = $(e.currentTarget).parent().find('.weui-count__number');
                    var number = parseInt($input.val() || "0") - 1;
                    if (number < MIN1) number = MIN1;
                    $input.val(number);
                    $("#total_price1").html(MonPrice1*number);
                });
                $('.increase1').click(function (e) {
                    var $input = $(e.currentTarget).parent().find('.weui-count__number');
                    var number = parseInt($input.val() || "0") + 1;
                    if (number > MAX1) number = MAX1;
                    $input.val(number);
                    $("#total_price1").html(MonPrice1*number);
                });
                $(".sure_btn").click(function () {
                    var month1 = parseInt($("#total_price1").html())/MonPrice1;
                    var show_month1 = "平面" + month1 + "个月 ";
                    $('#selectMoney').val(show_month1);
                });
            }
        });

        //预约
        $('.book-btn').click(function(){
            var house_id = $('#project').data('values'); // 楼盘ID
            var seat_id  = $('#num').data('values'); // 楼盘座号ID
            var person_name = $('#person_name').val(); // 联系人姓名
            var person_tel  = $('#person_tel').val(); // 联系方式
            var order_type = $('#selectMoney').val(); // 租赁时间

            if (house_id == undefined || house_id.length == 0) {
                layer.msg('请选择楼盘',{time: 2000});
                return false;
            }
            if (seat_id == undefined || seat_id.length == 0) {
                layer.msg('请选择楼盘座号',{time: 2000});
                return false;
            }
            if (person_name == undefined || person_name.length == 0) {
                layer.msg('请输入您的姓名',{time: 2000});
                return false;
            }
            if (person_tel == undefined || person_tel.length == 0) {
                layer.msg('请输入您的电话',{time: 2000});
                return false;
            }
            if (!(/^1[3|4|5|7|8][0-9]{9}$/.test(person_tel))) {
                layer.msg('请输入正确联系方式',{time: 2000});
                return false;
            }
            if (order_type == undefined || order_type.length == 0) {
                layer.msg('请选择租赁时间',{time: 2000});
                return false;
            }

            $.post('/index.php?r=API/service/carport-order',{
                house_id:house_id,
                seat_id:seat_id,
                person_name:person_name,
                person_tel:person_tel,
                order_type:order_type
            },function(res){
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
            },'JSON');
        });

        $('#num, #selectMoney').click(function(){
            var house_id = $('#project').data('values');
            if (house_id == '' || house_id == undefined) {
                layer.msg('请先选择楼盘项目',{time: 2000});
                return false;
            }
        });
    });

    function defaultLoad(pid){
        $.ajax({
            type:"post",
            url:"/index.php?r=API/service/get-house-by-pid",
            dataType: 'json',
            data:{city_id: 1, pid: pid},
            success: function(data){
                var house_list = data.code;
                var len = house_list.length;
                var items = [];
                if (len > 0) {
                    for(i=0;i<len;i++){
                        var item = {};
                        item.title = house_list[i]['house_name'];
                        item.value = house_list[i]['house_id'];
                        items.push(item);
                    }
                }
                if (pid == 0) {
                    $('#project').select({
                        title:'选择楼盘项目',
                        items:items
                    });
                } else {
                    $('#num').select('update',{
                        items:items
                    });
                    $('#num').val('');
                    $('#num').data('values','');
                }
            }
        });
    }

</script>
</body>
</html>