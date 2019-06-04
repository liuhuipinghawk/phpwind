<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<title>往期回顾</title>
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
		<div class="swiper-container" id="banner">
			<div class="swiper-wrapper">
				
			</div>
			<!--<div class="swiper-pagination"></div>-->
		</div>
		<script type="text/javascript" charset="utf-8">
			//banner数据初始化
				$.ajax({
					url: "/index.php?r=API/article/banner",
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
				    				+'<a href='+item.url+'>'
					    				+'<img src="'+item.thumb+'" alt="'+item.title+'" class="max-width"/>'
					    				+'<div class="title">'+item.title+'</div>'
					    			+'</a>'
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
				    },
				    error:function(res){
				    	console.log(res)
				    }
				})
		</script>
		<div class="news">
			<div class="weui-panel weui-panel_access">
			    <!--<div class="weui-panel__hd">图文组合列表</div>-->
			    <div class="weui-panel__bd" id="list"></div>
			  	<div class="weui-loadmore">
	                <i class="weui-loading"></i>
	                <span class="weui-loadmore__tips">正在加载</span>
	            </div>
			  	<script type="text/javascript">
			  		$.ajax({
			  			type:"get",
			  			data:"pagenum=1",
			  			url:"/index.php?r=API/article/list",
			  			success:function(res){
			  				res=JSON.parse(res);
			  				var data=res.code;
			  				console.log(data)
			  				$.each(data, function(i,item) {
			  					$('#list').append(
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
			  			},
			  			error:function(res){
			  				console.log(res)
			  			}
			  		});
			  	</script>
			  	<script>
			  		var pageNum=1;
				    var loading = false;  //状态标记
				    $(document.body).infinite().on("infinite", function() {
				        if(loading) return;
				        loading = true;
				        pageNum++;
				        $('.weui-loadmore').css({display:'block'});
				        setTimeout(function() {
				        	$.ajax({
					  			type:"get",
					  			data:"pagenum="+pageNum,
					  			url:"/index.php?r=API/article/list",
					  			success:function(res){
					  				res=JSON.parse(res);
					  				var data=res.code;
					  				if(data.length==0){$('.weui-loadmore').html("没有更多了")}
					  				$.each(data, function(i,item) {
					  					$('#list').append(
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
				            loading = false;
				        }, 1000);   //模拟延迟
				    });
				</script>
			</div>
		</div>
	</body>
</html>
