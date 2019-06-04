<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no" />
    <title>酒店相册</title>
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
<body ontouchstart>
<div class="wrap">
    <!--主体内容-->
    <div class="app-cont">
        <ul class="hotel-album-list clearfix" id="album-list">
          
        </ul>
    </div>

</div>

<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/jquery-weui.js')?>
<script>
	$(function(){
		$.ajax({
			type:"get",
			url:"index.php?r=API/hotel/get-hotel-imgs",
			dataType: 'json',
			data:{hotel_id: 1},
			success: function(data){
				var album_list = data.code;
				$.each(album_list,function(i, item){
					$('#album-list').append("<li class=\"pull-left\">" +
                        "                <a href=\"#\" class=\"block\">" +
                        "                    <img src='"+ album_list +"' alt=\"\">" +
                        "                </a>" +
                        "            </li>")
				})
			}
		});
	})
</script>
</body>
</html>