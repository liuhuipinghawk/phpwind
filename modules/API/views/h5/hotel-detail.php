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
    <title>酒店详情</title>
    <?=Html::cssFile('/css/weui.css')?>  
    <?=Html::cssFile('/css/jquery-weui.css')?>
    <?=Html::cssFile('/layui/css/layui.css')?>  
    <?=Html::cssFile('/css/calendar.css')?>    
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
    <div class="app-cont hotel-detail" id="hotel-detail">
    	<div id="hotel-top"></div>
    	<div id="checkinout" class="checkinout bg-white margin-top">
            <div id="firstSelect" style="width:100%;">
                <div class="Date_lr" style="float:left;">
                    <P>入住</p>
                    <input id="startDate" class="startDate" type="text" value=""style="" readonly>
                </div>
                <div class="Date_lr" style="float:right;">
                    <p>离店</p>
                    <input id="endDate" class="endDate" type="text" value="" style="" readonly>
                </div>
                <span class="span21">共<span class="NumDate">1</span>晚</span>
            </div>
        </div>
        <div class="mask_calendar"><div class="calendar"></div></div>
    	<div id="room-list"></div>
    </div>
</div>

<!-- 弹框 -->
<div class="book-type box-content" id="room-tan" style="display: none">

</div>
<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<?=Html::jsFile('/js/date.js')?>
<?=Html::jsFile('/js/project-data.js')?>

<script>
    layui.use('layer', function() {
        var $ = layui.jquery,
            layer = layui.layer;
        $('.book-btn').click(function () {
        	$('body').addClass('mask-body');
            layer.open({
                area: '96%'
                ,title: '精致大床房'
                ,resize: false
                ,type: 1
                ,content:$('.book-type')
                ,cancel: function(){
                    $('body').removeClass('mask-body');
                }
            })
        });
    });
    
     $(function () {
        // 酒店详情
        $.ajax({
            url: "/index.php?r=API/hotel/get-hotel",
            type: "get",
            async:false,
            data: {hotel_id:1},
            dataType: 'json',
            success: function(data){
                var hotel_detail = data.code;
                var hotel_room = hotel_detail.room_list;
                 $('#hotel-top').append("<div class=\"detail-img text-center\">" +
                        "            <img src='"+ hotel_detail.hotel_img +"' alt=\"\" class=\"max-width\">" +
                        "            <p class=\"hotel-title\">"+ hotel_detail.hotel_name +"</p>" +
                        "            <a href=\"index.php?r=API/h5/hotel-album\" class=\"img-num block text-white\">40&nbsp;张</a>" +
                        "        </div>" +
                        "        <a href=\"index.php?r=API/h5/hotel-evaluation\" class=\"bg-white block padding-cont detail-star text-muted border-bottom\">" +
                        "            <img src=\"/images/star.jpg\" width=\"85\" class=\"pull-left margin-top\">" +
                        "            <span class=\"pull-left text-warning\">&nbsp;5.0分</span>" +
                        "            <span class=\"pull-left\">&nbsp;&nbsp;98%的用户好评</span>" +
                        "            <span class=\"pull-right\">900人评价</span>" +
                        "        </a>"+
                        "        <a href=\"index.php?r=API/h5/hotel-about\" class=\"bg-white block padding-cont detail-address text-muted\">" +
                        "            <p class=\"title\">"+ hotel_detail.address +"</p>" +
                        "            <p class=\"distance\">距您\<"+ hotel_detail.distance +"&nbsp;&nbsp;&nbsp;管城区</p>" +
                        "            <span class=\"pull-right address-detail\">详情</span>" +
                        "        </a>")
                $.each(hotel_room, function(i, item){
                	$('#room-list').append("<div class=\"book-list padding-cont border-bottom clearfix\">" +
                        "                <p class=\"pull-left\">" + item.room_name +"</p>" +
                        "                <div class=\"pull-right\">" +
                        "                    <span class=\"text-orange font-weight price\">¥"+ item.price +"</span>" +
                        "                    <a href=\"#\" class=\"book-btn\" id=\"book-btn\">预订</a>" +
                        "                </div>" +
                        "            </div>")
                })       
            }
        });
        
        // 弹框
        $("#book-btn").click(function(){
        	$.ajax({
	        	url:"index.php?r=API/hotel/get-room-detail",
	        	type:"get",
	        	async:false,
	        	data: {room_id: 2},
	        	dataType: 'json',
	        	success: function(data){
	        		var room_detail = data.code[0];
	        		$('#room-tan').html(
	        			"<div class=\"book-img text-center bg-white\">" +
                        "        <img src='"+ room_detail.room_img +"'  alt=\"\" class=\"max-width\">" +
                        "    </div>" +
                        "    <ul class=\"text-muted clearfix\">" +
                        "        <li>床型<span class=\"text-black padding-big-left\">"+ room_detail.bed_type +"</span></li>" +
                        "        <li>早餐<span class=\"text-black padding-big-left\">"+ room_detail.breakfast +"</span></li>" +
                        "        <li>上网<span class=\"text-black padding-big-left\">"+ room_detail.wifi +"</span></li>" +
                        "        <li>窗户<span class=\"text-black padding-big-left\">"+ room_detail.room_window +"</span></li>" +
                        "        <li>可住<span class=\"text-black padding-big-left\">"+ room_detail.to_live +"</span></li>" +
                        "        <li>卫浴<span class=\"text-black padding-big-left\">"+ room_detail.bathroom +"</span></li>" +
                        "        <li>楼层<span class=\"text-black padding-big-left\">"+ room_detail.floor +"</span></li>" +
                        "        <li>面积<span class=\"text-black padding-big-left\">"+ room_detail.room_space +"</span></li>" +
                        "    </ul>" +
                        "    <a href=\"index.php?r=API/h5/hotel-book\" class=\"book block font-size-15 text-center\">立即预订</a>")
        		}
        	})
        })
        
        
         
        
        
    })

</script>

</body>
</html>