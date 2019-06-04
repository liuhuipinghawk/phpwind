<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<title>入驻企业</title>
		<?=Html::cssFile('css/weui.css')?>
	    <?=Html::cssFile('css/jquery-weui.css')?>
	    <?=Html::cssFile('css/common.css')?>
	    <?=Html::cssFile('css/club.css')?>
	    <?=Html::jsFile('/js/jquery-2.1.4.js')?>
	    <?=Html::jsFile('/js/fastclick.js')?>
	    <?=Html::jsFile('/js/common.js')?>
	    <?=Html::jsFile('/js/jquery-weui.js')?>
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
		<div class="wrap member">
			<div class="weui-panel weui-panel_access">
			    <!--<div class="weui-panel__hd">图文组合列表</div>-->
			    <div class="weui-panel__bd" id="list"></div>
			  	<div class="weui-loadmore">
	                <i class="weui-loading"></i>
	                <span class="weui-loadmore__tips">正在加载</span>
	            </div>
			  	<script type="text/javascript">
			  		//初始化数据
			  		$.ajax({
			  			type:"get",
			  			data:"pagenum=1",
			  			url:"/index.php?r=API/club/list",
			  			success:function(res){
			  				res=JSON.parse(res);
			  				var data=res.code;
			  				// console.log(res);
//			  				if(res.status==-200){
//			  					$('#list').html('<img src="img/no-member.png" alt="暂无成员加入" />')
//			  				}
			  				$.each(data, function(i,item) {
			  					$('#list').append(
			  						'<a href="index.php?r=API/h5/business-detail&id='+item.id+'" class="weui-media-box weui-media-box_appmsg">'
			  							+'<div class="weui-media-box__hd">'
			  								+'<img class="weui-media-box__thumb" src="'	+item.image+'">'
			  							+'</div>'
			  							+'<div class="weui-media-box__bd">'
			  								+'<h4 class="weui-media-box__title">'+item.company+'</h4>'
			  								+'<p class="weui-media-box__desc">入驻时间:'+item.create_time+'</p>'
			  							+'</div>'
			  						+'</a>'
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
					  			url:"/index.php?r=API/club/list",
					  			success:function(res){
					  				res=JSON.parse(res);
					  				var data=res.code;
					  				console.log(data)
					  				if(data.length==0){$('.weui-loadmore').html("没有更多了")}
					  				$.each(data, function(i,item) {
					  					$('#list').append(
                                            '<a href="index.php?r=API/h5/business-detail&id='+item.id+'" class="weui-media-box weui-media-box_appmsg">'
					  							+'<div class="weui-media-box__hd">'
					  								+'<img class="weui-media-box__thumb" src="'	+item.image+'">'
					  							+'</div>'
					  							+'<div class="weui-media-box__bd">'
					  								+'<h4 class="weui-media-box__title">'+item.company+'</h4>'
					  								+'<p class="weui-media-box__desc">入驻时间:'+item.create_time+'</p>'
					  							+'</div>'
                                            +'</a>'
					  					)
					  				});
					  			},
					  			error:function(res){
					  				console.log(res)
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
