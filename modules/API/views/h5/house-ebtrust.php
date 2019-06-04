<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
	    <title>房屋委托</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	    <meta name="format-detection" content="telephone=no,email=no,adress=no">
	    <meta name="author" content="he">
	    <meta name="description" content="是一个出租写字楼、公寓、商铺的专业平台">
	    <meta name="keywords" content="正e租">
	    <link rel="stylesheet" href="../dist/css/weui.css">
	    <link rel="stylesheet" href="../dist/css/jquery-weui.css">
	    <link rel="stylesheet" type="text/css" href="../dist/css/house-entrust.css"/>
	    <script>
	        /*设定html字体大小*/
	        var deviceWidth = document.documentElement.clientWidth;
	        if(deviceWidth > 640) deviceWidth = 640;
	        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
	    </script>
	</head>
	<body>
		<!--头部-->
	   	<!--<header class="bar">
	        <a href="javascript:;" onclick="javascript:history.back(-1);" class="icon pull-left"><img src="images/back_orange.png" width="11"></a>
	        <h1 class="title">工商服务</h1>
	    </header>-->
	    <div class="weui-cells weui-cells_form">
	    	<div class="weui-cell">
			    <div class="weui-cell__hd"><label class="weui-label">楼盘</label></div>
			    <div class="weui-cell__bd house-id">
			      	<input id="house-id" class="weui-input" type="hidden" value="1" required="required">
			      	<div style="text-align: center;"></div>
			      	<ul>
			      		<li class="house-id-on"></li>
			      	</ul>
			    </div>
			</div>
			<div class="weui-cell">
			    <div class="weui-cell__hd"><label class="weui-label">房屋类型</label></div>
			    <div class="weui-cell__bd">
			    	<input id="house-type" class="weui-input" type="hidden" value="1" required="required">
			    	<label class="house-type-on"><a href="javascript:;"></a><span>写字楼</span></label>
					<label><a href="javascript:;"></a><span>公寓</span></label>
					<label><a href="javascript:;"></a><span>商铺</span></label>
			    </div>
			</div>
			<div class="weui-cell">
			    <div class="weui-cell__hd"><label class="weui-label">房屋面积</label></div>
			    <div class="weui-cell__bd">
			      	<input id="area" class="weui-input" type="text" placeholder="请输入房屋面积" required="required">
			    </div>
			</div>
			<div class="weui-cell">
			    <div class="weui-cell__hd"><label class="weui-label">房屋地址</label></div>
			    <div class="weui-cell__bd">
			      	<input id="address" class="weui-input" type="text" placeholder="请输入房屋地址" required="required">
			    </div>
			</div>
			<div class="weui-cell">
			    <div class="weui-cell__hd"><label class="weui-label">联系人</label></div>
			    <div class="weui-cell__bd">
			      	<input id="name" class="weui-input" type="text" placeholder="请输入联系人" required="required">
			    </div>
			</div>
			<div class="weui-cell">
			    <div class="weui-cell__hd"><label class="weui-label">联系电话</label></div>
			    <div class="weui-cell__bd">
			      	<input id="tel" class="weui-input" type="tel" pattern="[0-9]*" placeholder="请输入联系电话" required="required">
			    </div>
			</div>
			
		</div>
		<div class="weui-btn-area my-btn">
			<a href="javascript:;" class="weui-btn weui-btn_primary" id="submit">提交</a>
		</div>
		<script src="../dist/js/jquery-2.1.4.js" type="text/javascript" charset="utf-8"></script>
		<script src="../dist/js/jquery-weui.js" type="text/javascript" charset="utf-8"></script>
		<?=Html::jsFile('/js/public.js')?>
		<script type="text/javascript">
			//遍历楼盘
			$.ajax({
				type:"get",
				url:"http://106.15.127.161/index.php?r=API/api/seat",
				async:true,
				success:function(res){
					var data=JSON.parse(res).code;
					$('.house-id div').html(data[0].housename+'&nbsp;&nbsp;>')
					for(var i=0;i<data.length;i++){
						if(i==0){
							$('.house-id li').html(data[i].housename)
							$('.house-id li').attr('house-id',data[i].id)
						}
						else{
							$('.house-id ul').append('<li house-id='+data[i].id+'>'+data[i].housename+'</li>')
						}
					}
				}
			});
			//楼盘选择
			$('.house-id').click(function(){
				$('.house-id ul').css('display','block');
				$('.house-id li').click(function(e){
					$(this).addClass('house-id-on').siblings().removeClass('house-id-on');
					$('.house-id div').html($(this).html()+'&nbsp;&nbsp;>');
					$('.house-id ul').css('display','none');
					$('#house-id').val($(this).attr('house-id'));
					return false
				})
			})
			//房屋类型选择
			$('label').click(function(){
	    		$(this).addClass('house-type-on').siblings().removeClass('house-type-on');
	    		$('#house-type').val($(this).index());
	    	})
	    	$('#submit').click(function(){
	    		var user_id=userInfo()['user_id'];
	    		var house_id=$('#house-id').val();
				var house_type=$('#house-type').val();
				var area=$('#area').val();
				var address=$('#address').val();
				var name=$('#name').val();
				var tel=$('#tel').val();
				if (area == '' || area.length == 0) {
                    $.alert('请输入房屋面积');
                    return;
                }
                else if (address == undefined || address.length == 0) {
                    $.alert('请输入房屋地址');
                    return;
                }
                else if (name == undefined || name.length == 0) {
                    $.alert('请输入联系人');
                    return;
                }
                else if (tel == undefined || tel.length == 0) {
                    $.alert('请输入联系电话');
                    return;
                }
                else if (!(/^1[3|4|5|7|8][0-9]{9}$/.test(tel))) {
                    $.alert('请输入正确的联系电话');
                    return;
                }
                else{
                	$.ajax({
                		type:"post",
                		url:"/index.php?r=API/service/house-entrustment",
                		async:true,
                		data:{
                			'user_id':user_id,
                			'house_id':house_id,
                			'house_type':house_type,
                			'house_area':area,
                			'address':address,
                			'person_name':name,
                			'person_tel':tel,
                		},
                		success:function(res){
                			$.alert({
                				text:JSON.parse(res).message,
                				onOK:function(){
                					var u = navigator.userAgent;
                					if(u.indexOf('Android') > -1 || u.indexOf('Adr') > -1) {
										window.android.backingOut()
									} else if(!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)) {
										CustomJS.backingOut()
									}
                					
                				}
                			})
                		}
                		
                	});
                }
	    	})
		</script>
	</body>
</html>
