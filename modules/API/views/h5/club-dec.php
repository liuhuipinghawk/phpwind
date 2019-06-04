<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<title>企业家俱乐部简介</title>
	    <?=Html::cssFile('css/club.css')?>
	    <?=Html::jsFile('/js/jquery-2.1.4.js')?>
	    <script>
	        /*设定html字体大小*/
	        var deviceWidth = document.documentElement.clientWidth;
	        if(deviceWidth > 640) deviceWidth = 640;
	        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
	    </script>
	</head>
	<body>
		<div class="dec">
			
		</div>
		<script type="text/javascript">
			$.ajax({
				type:"get",
				url:"/index.php?r=API/article/index",
				success:function(res){
					res=JSON.parse(res);
					data=res.code.content;
					console.log(res)
					$('.dec').html(data);
				},
				error:function(res){
					res=JSON.parse(res);
					console.log(res)
				}
			});
		</script>
	</body>
</html>
