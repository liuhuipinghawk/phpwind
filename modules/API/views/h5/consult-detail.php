<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<title>新闻详情</title>
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
            .message-detail{font-size: 0.26rem;}
            .message-detail .title{font-size: 0.3rem;}
            .message-detail .time{font-size: 0.24rem;line-height: 0.52rem;}
            .message-detail .detail-content img{max-width: 100% !important;}
        </style>
	</head>
	<body class="bg-white">
		<!--<header class="bar">
	        <a href="javascript:;" onclick="javascript:history.back(-1);" class="icon pull-left"><img src="../dist/images/back.png" width="11"></a>
	        <h1 class="title">消息详情</h1>
	    </header>-->
		<div class="wrap message-detail" id="message-detail">
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

            // 获取消息详情id
            // var loc = "http://106.15.127.161/index.php?r=API/h5/message-detail&pNoticeId=116";
            // var loc = location.href;
            // var n1 = loc.length;
            // var n2 = loc.indexOf("Id"); //返回某个指定的字符串值在字符串中首次出现的位置
            // var id = loc.substr(n2+3, n1-n2-1);

            $.ajax({
                type:"get",
                url:"http://106.15.127.161/index.php?r=API/api/newslist",
                dataType: 'json',
                data: {articleid: 18},
                success: function(res){
                    var data = res.code;
                    console.log(data);
                    $("#message-detail").html("<div class=\"cont\" style=\"padding: 10px 15px;\">" +
                        "                <p class=\"time text-center text-muted\">"+data.createTime+" </p>" +
                        "                <div class=\"detail-content margin-small-top\">"+data.content+"</div>" +
                        "            </div>")
                }
            });

        })
    </script>
	</body>
</html>
