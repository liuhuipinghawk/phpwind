<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<title>企业详情</title>
		<?=Html::cssFile('css/weui.css')?>
	    <?=Html::cssFile('css/jquery-weui.css')?>
	    <?=Html::cssFile('css/common.css')?>
	    <script>
	        /*设定html字体大小*/
	        var deviceWidth = document.documentElement.clientWidth;
	        if(deviceWidth > 640) deviceWidth = 640;
	        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
	    </script>
        <style>
            .business-detail{font-size: 0.26rem;}
            .business-detail .title{font-size: 0.3rem;}
            .business-detail .time{font-size: 0.24rem;line-height: 0.52rem;}
            .business-detail .detail-content img{max-width: 100% !important;}
        </style>
	</head>
	<body class="bg-white">
		<!--<header class="bar">
	        <a href="javascript:;" onclick="javascript:history.back(-1);" class="icon pull-left"><img src="../dist/images/back.png" width="11"></a>
	        <h1 class="title">企业详情</h1>
	    </header>-->
		<div class="wrap business-detail" id="business-detail">
            <div class="weui-loadmore">
                <i class="weui-loading"></i>
                <span class="weui-loadmore__tips">正在加载</span>
            </div>

		</div>

        <?=Html::jsFile('/js/jquery-2.1.4.js')?>
        <?=Html::jsFile('/js/jquery-weui.js')?>
        <?=Html::jsFile('/js/fastclick.js')?>
    <script>
        $(function () {
            FastClick.attach(document.body);
            $.ajax({
                type:"get",
                url:"/API/club/details",
                dataType: 'json',
                data: {id: <?php echo Yii::$app->request->get()['id']?>},
                success: function(res){
                    var data = res.code;
                    // console.log(data);
                    $("#business-detail").html("            <div class=\"cont\" style=\"padding: 10px 15px;\">" +
                        "                <h3 class=\"title text-center\">"+data.company+"</h3>" +
                        "                <p class=\"time text-center text-muted\">"+data.create_time+" </p>" +
                        "                <div class=\"detail-content\">"+data.content+"</div>" +
                        "            </div>")
                }
            });

        })
    </script>
	</body>
</html>
