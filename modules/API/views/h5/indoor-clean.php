<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>室内清洁</title>
    <?=Html::cssFile('/css/weui.css')?>  
    <?=Html::cssFile('/css/jquery-weui.css')?> 
    <?=Html::cssFile('/css/common.css')?>
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
    </script>
</head>
<body ontouchstart class="relative bg-white">
<div class="wrap">
    <!--主体内容-->
    <div class="app-cont indoor-clean">
        <div class="weui-tab evaluation-tab">
            <div class="weui-navbar">
                <a class="weui-navbar__item weui-bar__item--on" href="#tab1">石材养护</a>
                <a class="weui-navbar__item" href="#tab2">室内保洁</a>
                <a class="weui-navbar__item" href="#tab3">甲醛治理</a>
            </div>
            <div class="weui-tab__bd">
                <div id="tab1" class="weui-tab__bd-item weui-tab__bd-item--active">
                    <div class="evaluation-tab">
                        <div class="content text-center" style="font-size: 0">
                            <img src="/images/curing1.png" class="max-width">
                            <img src="/images/curing2.png" class="max-width">
                            <img src="/images/curing3.png" class="max-width">
                        </div>
                        <div class="footer border-top clearfix">
                            <img src="/images/phone-shicai.png" width="28" class="pull-left"><span class="pull-left phone phone-shicai">400-6060-617</span>
                            <a href="javascript:void(0);" class="pull-right book-btn btn-shicai">立即预约</a>
                        </div>
                    </div>
                </div>
                <div id="tab2" class="weui-tab__bd-item">
                    <div class="evaluation-tab">
                        <div class="content text-center"  style="font-size: 0">
                            <img src="/images/clean1.png" class="max-width">
                            <img src="/images/clean2.png" class="max-width">
                            <img src="/images/clean3.png" class="max-width">
                            <img src="/images/clean4.png" class="max-width">
                        </div>
                        <div class="footer border-top clearfix">
                            <img src="/images/phone-shinei.png" width="28" class="pull-left"><span class="pull-left phone phone-shinei">400-6060-617</span>
                            <a href="javascript:void(0);" class="pull-right book-btn btn-shinei">立即预约</a>
                        </div>
                    </div>
                </div>
                <div id="tab3" class="weui-tab__bd-item">
                    <div class="evaluation-tab">
                        <div class="content text-center"  style="font-size: 0">
                            <img src="/images/arofene1.png" class="max-width">
                            <img src="/images/arofene2.png" class="max-width">
                            <img src="/images/arofene3.png" class="max-width">
                            <img src="/images/arofene4.png" class="max-width">
                            <img src="/images/arofene5.png" class="max-width">
                            <img src="/images/arofene6.png" class="max-width">
                        </div>
                        <div class="footer border-top clearfix">
                            <img src="/images/phone-jia.png" width="28" class="pull-left"><span class="pull-left phone phone-jia">400-6060-617</span>
                            <a href="javascript:void(0);" class="pull-right book-btn btn-jia">立即预约</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>
<!--石材弹出框-->
<div class="book-tip book-shi-cai box-content" style="display: none">
    <ul class="book-list">
        <li><input type="text" id="sc_person_name" placeholder="联系人姓名"></li>
        <li><input type="text" id="sc_person_tel" placeholder="联系人电话"> </li>
        <li><p>预约成功后，工作人员会尽快与您确认需求或者拨打客服电话：<span class="text-shicai">400-6060-617</span></p></li>
    </ul>
    <a href="javascript:void(0);" data-tag="sc" class="book book-shicai block font-size-15 text-center btn-book">立即预约</a>
</div>
<!--室内弹出框-->
<div class="book-tip book-shi-nei box-content" style="display: none">
    <ul class="book-list">
        <li><input type="text" id="sn_person_name" placeholder="联系人姓名"></li>
        <li><input type="text" id="sn_person_tel" placeholder="联系人电话"> </li>
        <li><p>预约成功后，工作人员会尽快与您确认需求或者拨打客服电话：<span class="text-shinei">400-6060-617</span></p></li>
    </ul>
    <a href="javascript:void(0);" data-tag="sn" class="book book-shinei block font-size-15 text-center btn-book">立即预约</a>
</div>
<!--甲醛弹出框-->
<div class="book-tip book-jia-quan box-content" style="display: none">
    <ul class="book-list">
        <li><input type="text" id="jq_person_name" placeholder="联系人姓名"></li>
        <li><input type="text" id="jq_person_tel" placeholder="联系人电话"> </li>
        <li><p>预约成功后，工作人员会尽快与您确认需求或者拨打客服电话：<span class="text-green">400-6060-617</span></p></li>
    </ul>
    <a href="javascript:void(0);" data-tag="jq" class="book book-jia block font-size-15 text-center btn-book">立即预约</a>
</div>
<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/jquery-weui.js')?>
<?=Html::jsFile('/js/fastclick.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<script>
    $(function(){
        FastClick.attach(document.body);
        layui.use('layer', function() {
            var $ = layui.jquery,
                layer = layui.layer;
            // 石材
            $('.btn-shicai').click(function () {
            	$('body').addClass('mask-body');
            	// 调取默认用户信息
	        	var u = navigator.userAgent;
				if(u.indexOf('Android') > -1 || u.indexOf('Adr') > -1) {
					// 安卓端调取默认信息
					var userInfo = window.android.userInfo();
					userJson = eval("(" + userInfo + ")"); // 字符串(string)转json
					$('#sc_person_name').val(userJson['true_name']);
					$('#sc_person_tel').val(userJson['tell']);
				} else if(!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)) {
					//iOS端调取默认信息	        		
					var userInfo = CustomJS.userInfo();
					$('#sc_person_name').val(userInfo['true_name']);
					$('#sc_person_tel').val(userInfo['tell']);
				}
                layer.open({
                    area: '90%'
                    ,title: false
                    ,resize: false
                    ,type: 1
                    ,content:$('.book-shi-cai')
                    ,cancel: function(){
                        $('body').removeClass('mask-body');
                    }
                })
            });
            // 室内
            $('.btn-shinei').click(function () {
            	$('body').addClass('mask-body');
            	// 调取默认用户信息
	        	var u = navigator.userAgent;
				if(u.indexOf('Android') > -1 || u.indexOf('Adr') > -1) {
					// 安卓端调取默认信息
					var userInfo = window.android.userInfo();
					userJson = eval("(" + userInfo + ")"); // 字符串(string)转json
					$('#sn_person_name').val(userJson['true_name']);
					$('#sn_person_tel').val(userJson['tell']);
				} else if(!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)) {
					//iOS端调取默认信息	        		
					var userInfo = CustomJS.userInfo();
					$('#sn_person_name').val(userInfo['true_name']);
					$('#sn_person_tel').val(userInfo['tell']);
				}
                layer.open({
                    area: '90%'
                    ,title: false
                    ,resize: false
                    ,type: 1
                    ,content:$('.book-shi-nei')
                    ,cancel: function(){
                        $('body').removeClass('mask-body');
                    }
                })
            });
            // 甲醛
            $('.btn-jia').click(function () {
            	$('body').addClass('mask-body');
            	// 调取默认用户信息
	        	var u = navigator.userAgent;
				if(u.indexOf('Android') > -1 || u.indexOf('Adr') > -1) {
					// 安卓端调取默认信息
					var userInfo = window.android.userInfo();
					userJson = eval("(" + userInfo + ")"); // 字符串(string)转json
					$('#jq_person_name').val(userJson['true_name']);
					$('#jq_person_tel').val(userJson['tell']);
				} else if(!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)) {
					//iOS端调取默认信息	        		
					var userInfo = CustomJS.userInfo();
					$('#jq_person_name').val(userInfo['true_name']);
					$('#jq_person_tel').val(userInfo['tell']);
				}
                layer.open({
                    area: '90%'
                    ,title: false
                    ,resize: false
                    ,type: 1
                    ,content:$('.book-jia-quan')
                    ,cancel: function(){
                        $('body').removeClass('mask-body');
                    }
                })
            });
        });
        $('.btn-book').click(function(){
            var tag = $(this).data('tag');
            var order_type = 0; 
            if (tag == 'sc') {//石材养护
                order_type = 4;
            } else if (tag == 'sn') {//室内保洁
                order_type = 5;
            } else if (tag == 'jq') {//甲醛治理
                order_type = 6;
            }
            var person_name = $('#'+tag+'_person_name').val();
            var person_tel  = $('#'+tag+'_person_tel').val();
            if (order_type == 0) {
                layer.msg('参数错误',{time: 2000});
                return false;
            }
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
                    order_type:order_type,
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
    });
</script>
</body>
</html>