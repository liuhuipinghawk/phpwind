<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>学习园地</title>
    <?=Html::cssFile('/css/weui.min.css')?>  
    <?=Html::cssFile('/css/jquery-weui.css')?> 
    <?=Html::cssFile('/css/learn-com.css')?> 
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
    <!--头部-->
    <header class="bar">
        <a href="javascript:;" onclick="javascript:history.back(-1);" class="icon pull-left"><img src="/images//back.png" width="11"></a>
        <h1 class="title">学习园地</h1>
    </header>
    <!--主体内容-->
    <div class="app-cont">
        <div class="swiper-container train-banner">
            <div class="swiper-wrapper" id="learn-swiper">
<!--                <div class="swiper-slide"><img src="/images/banner.jpg" class="max-width"></div>-->
            </div>
            <!-- 如果需要分页器 -->
            <div class="swiper-pagination"></div>
        </div>

        <div class="select-list">
            <div class="weui-flex text-center border-bottom">
                <div class="weui-flex__item">
                    <a href="javascript:;" class="text-gary select-drop-btn block">类型&nbsp;<img src="/images/select_down.png"></a>
                    <div class="sort-select select-drop">
                        <ul id="type-list">
                            <li data-id="0" class="active"><a href="javascript:void(0);" class="block text-gary">全部</a>
                        </ul>
                    </div>
                </div>
                <div class="weui-flex__item">
                    <a href="javascript:;" class="text-gary select-switch-btn block" id="read-btn">阅读次数&nbsp;<img src="/images/select_down.png"></a>
                </div>
                <div class="weui-flex__item">
                    <a href="javascript:;" class="text-gary select-switch-btn block" id="download-btn">下载次数&nbsp;<img src="/images/select_down.png"></a>
                </div>
            </div>
        </div>
        <div class="mask dropdown-mask"  amallink-event="hide_dropdown_mask"></div>
        <div class="train-list clearfix" id="train-list">


        </div>
        <div class="weui-loadmore" id="loadmore">

        </div>
    </div>
</div>

<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/fastclick.js')?>
<?=Html::jsFile('/js/jquery-weui.js')?>
<?=Html::jsFile('/js/swiper.js')?>
<?=Html::jsFile('/js/learn-com.js')?>
<?=Html::jsFile('/js/public.js')?>
<script>
    $(".sort-select").on('click', 'li', function () {
        $(this).siblings().removeClass("active");
        $(this).addClass("active");
        $(this).parents('.sort-select').hide();
        $('.dropdown-mask').fadeOut(100);
        $('body').removeClass('mask-body');
    });
	$(function(){
		var mySwiper = new Swiper ('.swiper-container', {
	        loop: true, // 循环模式选项
	        pagination: '.swiper-pagination',
	        paginationClickable: true,
	        autoplay: 2500,
	        observer: true,//修改swiper自己或子元素时，自动初始化swiper
			observeParents: true//修改swiper的父元素时，自动初始化swiper
	    });
		// 轮播banner
		$.ajax({
			url:" /API/learn/recommend",
			type:"post",
			dataType: 'json',
			success: function(data){
				var banner_list = data.code;
				$.each(banner_list, function(i, item) {
					$("#learn-swiper").append("<div class=\"swiper-slide\"><img src='"+ item.image +"' class=\"max-width\"></div>")
				});
			}
		});

		$('#train-list').html('<div class="weui-loadmore before-load"><i class="weui-loading"></i></div>');
        loadList(1);

		// 类型选择
		$.ajax({
        	url:"/API/learn/get-type",
        	type:"post",
        	dataType: 'json',
        	success: function(data){
				var type_list = data.code;
				$.each(type_list, function(i, item) {
					$('#type-list').append(
						" <li data-id=\""+item.id+"\"><a href=\"javascript:void(0);\" class=\"block text-gary\">"+ item. name +"</a> </li>"
					)
				});
			}
    	});
        //筛选
        $('.select-drop ul').on('click','li',function(){
            $('#train-list').html('<div class="weui-loadmore before-load"><i class="weui-loading"></i></div>');
            loadList(1);
        });
        $('#read-btn').on('click', function () {
            $('#train-list').html('<div class="weui-loadmore before-load"><i class="weui-loading"></i></div>');
            loadList(1, 'read');
        });
        $('#download-btn').on('click', function () {
            $('#train-list').html('<div class="weui-loadmore before-load"><i class="weui-loading"></i></div>');
            loadList(1, 'download');
        });
	});
    function loadList(pagenum ,orderby){
        var sdata = {};
        sdata.type  = $('#type-list').find('li.active').attr('data-id');
        sdata.orderby = orderby;
        sdata.page = pagenum;
        sdata.page_size = '6';
        console.log(sdata);

        // 列表
        $.ajax({
            type:"POST",
            url:"/API/learn/learn-list",
            dataType: 'json',
            data:sdata,
            success: function(data){
                var learn_list = data.code;
                console.log(learn_list);
                if(learn_list.length == 0){
                    if (pagenum == 1) {
                        $('#loadmore').html("<p class=\"loaderdown\">—— 暂无数据 ——</p>");
                        $('#train-list').html('');
                    } else {
                        $('#loadmore').html("<p class=\"loaderdown\">—— 已加载所有数据 ——</p>");
                    } 
                } else{   
                    loading = false;               	
                    if (pagenum == 1) {
                        $('#train-list').html('');
                    }
                    $.each(learn_list, function(i, item) {
                        $('#train-list').append("<a href=\"index.php?r=API/h5/learn-detail&id="+item.id+"\" class=\"train-panel block\">" +
                            "                <p class=\"title text-black\">"+ item.title +"</p>" +
                            "                <div class=\"panel-img\">" +
                            "                    <img src='"+ item.image +"' class=\"max-width\">" +
                            "                </div>" +
                            "                <div class=\"tip-cont text-gary clearfix\">" +
                            "                    <div class=\"pull-left\">" +
                            "                        <span class=\"label\">"+ item.type_name +"</span>" +
                            "                        <span>"+ item.create_time +"</span>" +
                            "                    </div>\n" +
                            "                    <div class=\"pull-right\">" +
                            "                        <span class=\"see-num\">"+ item.read_num +"<img src=\"/images/see.png\"></span>" +
                            "                        <span class=\"evaluate-num\">"+ item.comment_num +"<img src=\"/images/evaluate.png\"></span>" +
                            "                    </div>" +
                            "                </div>" +
                            "            </a>");
                    });
                }
            }
        });
    }
    
    
    var loading = false;  //状态标记
    var pagenum = 1;
    $(document.body).infinite().on("infinite", function() {
        if(loading) return;
        loading = true;
        setTimeout(function() {
                pagenum++;
        		loadList(pagenum);
        }, 1500);   //模拟延迟
    });
</script>

</body>
</html>