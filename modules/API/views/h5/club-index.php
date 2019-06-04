<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<title>企业家俱乐部</title>
		<?=Html::cssFile('css/weui.css')?>
	    <?=Html::cssFile('css/jquery-weui.css')?>
	    <?=Html::cssFile('css/common.css')?>
	    <?=Html::cssFile('css/club.css')?>
	    <?=Html::jsFile('/js/jquery-2.1.4.js')?>
	    <?=Html::jsFile('/js/fastclick.js')?>
	    <?=Html::jsFile('/js/common.js')?>
	    <?=Html::jsFile('/js/jquery-weui.js')?>
	    <?=Html::jsFile('/js/swiper.js')?>
	    <?=Html::jsFile('/js/public.js')?>
	    <script>
	        /*设定html字体大小*/
	        var deviceWidth = document.documentElement.clientWidth;
	        if(deviceWidth > 640) deviceWidth = 640;
	        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
	    </script>
	</head>
	<body>
		<!--<header class="bar">
	        <a href="javascript:;" onclick="javascript:history.back(-1);" class="icon pull-left"><img src="../dist/images/back.png" width="11"></a>
	        <h1 class="title">工商服务</h1>
	    </header>-->
	    <div class="wrap index">
			<div class="swiper-container" id="banner">
				<div class="swiper-wrapper">
					
				</div>
				<!--<div class="swiper-pagination"></div>-->
			</div>
			<script type="text/javascript" charset="utf-8">
				//banner数据初始化
				$.ajax({
					url: "/index.php?r=API/ad/index",
				    type: "GET",
				    success:function(res){
				    	res=JSON.parse(res);
				    	var data=res.code;
				    	var flag=false;
				    	console.log(res)
				    	$.each(data, function(i, item){
				    		if(i==(data.length-1)){flag=true}
				    		$('.swiper-wrapper').append(
				    			'<div class="swiper-slide relative">'
				    				+'<img src="'+item.thumb+'" alt="'+item.adName+'" class="max-width"/>'
//				    				+'<div class="title">'+item.adName+'</div>'
				    			+'</div>'
				    		)
				    		//swiper初始化
							if(flag){
								$("#banner").swiper({
									autoplay:3000,
									loop:true
								})
							}
				    	})
				    }
				})
				
			</script>
		
			<div class="enterbar">
				<ul>
					<li>
						<a href="/index.php?r=API/h5/club-dec">
							<img src="img/list1.png" alt="生活圈简介" />
							<p>生活圈简介</p>
						</a>
					</li>
					<li id='join'>
						<a href="javascript:">
							<img src="img/list2.png" alt="企业申请" />
							<p>企业申请</p>
						</a>
					</li>
					<li>
						<a href="/index.php?r=API/h5/club-member">
							<img src="img/list3.png" alt="入驻企业" />
							<p>入驻企业</p>
						</a>
					</li>
					<li>
						<a href="/index.php?r=API/h5/club-news">
							<img src="img/list4.png" alt="往期回顾" />
							<p>往期回顾</p>
						</a>
					</li>
				</ul>
			</div>
			<div class="weui-panel weui-panel_access">
			    <div class="weui-panel__hd">企业资讯</div>
			    <div class="weui-panel__bd">
			    	
			  	</div>
			  	<script type="text/javascript">
			  		//资讯数据加载
			  		$.ajax({
			  			type:"get",
			  			url:"/index.php?r=API/article/news",
			  			success:function(res){
			  				res=JSON.parse(res);
			  				var data=res.code;
			  				$.each(data, function(i,item) {
			  					$('.weui-panel__bd').append(
			  						'<a href="'+item.url+'" class="weui-media-box weui-media-box_appmsg">'
			  							+'<div class="weui-media-box__bd">'
			  								+'<h4 class="weui-media-box__desc">'+item.title+'</h4>'
			  								+'<div class=""><span>'+item.createTime+'</span><span class="pull-right">'+''+'</span></div>'
			  							+'</div>'
			  							+'<div class="weui-media-box__hd">'
			  								+'<img class="weui-media-box__thumb" src="'+item.thumb+'">'
			  							+'</div>'
			  					)
			  				});
			  			}
			  		});
//			  		$.ajax({
//			  			type:"get",
//			  			url:"/index.php?r=API/article/index",
//			  			success:function(res){
//			  				res=JSON.parse(res);
//			  				var data=res.code;
//			  				$('.enterbar li a').eq(0).attr('href',data.url)
//			  			}
//			  		})
			  	</script>
			  	<script type="text/javascript">
			  		var user_id=userInfo()['user_id'];
			  		$('#join').click(function(){
			  			$.ajax({
			  				type:"post",
			  				url:"/index.php?r=API/club/judge",
			  				data:'user_id='+user_id,
			  				success:function(res){
			  					res=JSON.parse(res);
			  					var status=res.status;
			  					if(status==200){
			  						window.location='/index.php?r=API/h5/club-join'
			  					}
			  					else if(status==300){
			  						$.alert({
			  							title:"审核中",
			  							text:'您添加的企业申请信息，客服正在审核中，请耐心等待'
			  						})
			  					}
			  					else if(status==400){
			  						$.alert({
			  							title:"已加入",
			  							text:'您已加入企业家俱乐部，无需再次申请'
			  						})
			  					}
			  					else if(status==205){
			  						$.alert({
			  							text:'用户信息已丢失，请重新登录'
			  						})
			  						missLogin();
			  					}
			  				}
			  			});
			  		})
			  	</script>
			</div>
		</div>
	</body>
</html>
