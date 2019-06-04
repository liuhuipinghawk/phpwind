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
    <title>酒店详情介绍</title>
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
    <div class="app-cont about-hotel">
    	<div id="hotel-about"></div>
        <div class="hotel-facilities margin-top bg-white padding-cont padding-top">
            <p class="title font-size-15 border-bottom padding-small-bottom">酒店设施</p>
            <ul class="clearfix margin-big-top text-gary" id="hotel-facilities"></ul>
        </div>
    </div>

</div>
<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/jquery-weui.js')?>
<script>
    $(function () {
        // 酒店详情介绍
        $.ajax({
            url: "/index.php?r=API/hotel/get-hotel-detail",
            type: "get",
            async:false,
            data: {hotel_id:1},
            dataType: 'json',
            success: function(data){
                var hotel_about = data.code;
                 $('#hotel-about').html("<div class=\"header\">" +
                        "            <p class=\"title\">"+ hotel_about.hotel_name +"</p><p class=\"tips\">豪华酒店 | 商务出行</p><p class=\"tel\"><img src=\"/images/tel.png\" alt='"+ hotel_about.hotel_name +"'></p>" +
                        "        </div>" +
                        "        <div class=\"about-list padding-top padding-bottom bg-white padding-cont\">" +
                        "            <ul class=\"text-gary clearfix\">" +
                        "                <li>开业时间：<span>"+ hotel_about.open_year +"</span></li>\n" +
                        "                <li>装修时间：<span>"+ hotel_about.update_year +"</span></li>\n" +
                        "                <li>入住时间：<span>"+ hotel_about.in_time +"</span></li>\n" +
                        "                <li>离店时间：<span>"+ hotel_about.leave_time +"</span></li>\n" +
                        "                <li>酒店楼层：<span>"+ hotel_about.hotel_star +"</span></li>\n" +
                        "                <li>客房总数：<span>"+ hotel_about.total_rooms +"</span></li>\n" +
                        "            </ul>" +
                        "            <div class=\"describe margin-top\">" +
                        "                <p class=\"limit-show no-limit\">正商国际广场位居紧邻航海路与未来大道，东接郑东新区及国家经济技术开发区，距中州大道约1公里、机场高速约1.5公里，西接中心城区，处于该区域的核心位置。正商国际广场总占地面积4.8万平方米，总建筑面积约20万平方米，总投资20亿元，集大型商场、星级酒店、高档写字楼于一体</p>" +
                        "                <a href=\"#\" class=\"block text-center show-btn margin-top\"><img src=\"/images/download.png\" width=\"18\"></a>" +
                        "            </div>" +
                        "        </div>")
            }
        });
        
        
	     $('.show-btn').click(function () {
	        $(this).siblings('p').removeClass();
	        $(this).hide();
	     });
	     
	     // 酒店设施
       $.ajax({
       	url:"index.php?r=API/hotel/get-facilities",
       	type:"get",   
       	data: {hotel_id: 1},
       	dataType: 'json',
       	success: function(data){
       		var fac_list = data.code;
     		$.each(fac_list, function(i, item) {
     			$('#hotel-facilities').append("<li><img src='"+ item.faci_icon +"'>" +
                      "                    <p>"+ item.faci_name +"</p></li>")
     			});
       		}
       });
        
    })
</script>
</body>
</html>