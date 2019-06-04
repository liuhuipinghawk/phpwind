<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>绿植租赁</title>
    <?=Html::cssFile('/css/weui.min.css')?>  
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
        <div class="select-list">
            <div class="weui-flex text-center border-bottom">
                <div class="weui-flex__item">
                    <a href="javascript:;" class="text-gary block select-btn-all">全部</a>
                </div>
                <div class="weui-flex__item">
                    <a href="javascript:;" class="text-gary select-btn block">功效</a>
                    <span class="img-down"><img src="/images/select_down.png" ></span>
                    <span class="img-up active"><img src="/images/select_up.png" ></span>
                    <div class="price-select select-drop">
                        <ul id="plants">
                            <li data-id="0" class="active"><a href="javascript:void(0);" class="block text-gary">全部</a> </li>
                        </ul>
                    </div>
                </div>
                <div class="weui-flex__item">
                    <a href="javascript:;" class="text-gary select-btn block" amallink-event="leftmenu_show">类型</a>
                    <span class="img-down"><img src="/images/select_down.png" ></span>
                    <span class="img-up active"><img src="/images/select_up.png" ></span>
                     <div class="sort-select pro-left-menu">
                        <p class="title">适用面积</p>
                        <ul id="area">
                            <!--<li data-id="0" class="active"><a href="javascript:void(0);" class="block text-gary">全部</a> </li>-->
                        </ul>
                        <p class="title">盆栽类型</p>
                        <ul id="pot">
                           <!-- <li data-id="0" class="active"><a href="javascript:void(0);" class="block text-gary">全部</a> </li>-->
                        </ul>
                        <p class="title">绿植寓意</p>
                        <ul id="implication">
                           <!-- <li data-id="0" class="active"><a href="javascript:void(0);" class="block text-gary">全部</a> </li>-->
                        </ul>
                        <p class="title">摆放位置</p>
                        <ul id="opsition">
                            <!--<li data-id="0" class="active"><a href="javascript:void(0);" class="block text-gary">全部</a> </li>-->
                        </ul>
                        <div class="bottom-btn">
                            <a href="#" class="bottom-btn-btn" amallink-event="reset_select">重置</a>
                            <a href="#" class="bottom-btn-btn bottom-btn-finish" amallink-event="hide_dropdown_mask">完成</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mask dropdown-mask"  amallink-event="hide_dropdown_mask"></div>
        <div class="weui-panel weui-panel_access plant-list">
            <div class="weui-panel__bd bg-white" id="plant-list">
            	
            </div>
            <div class="weui-loadmore" id="loadmore">
            </div>
        </div>
    </div>

</div>

<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/fastclick.js')?>
<?=Html::jsFile('/js/jquery-weui.js')?>
<?=Html::jsFile('/js/common.js')?>
<?=Html::jsFile('/js/public.js')?>
<script>
    var addrID = addressID();

	$(function(){
		$('#plant-list').html('<div class="weui-loadmore before-load"><i class="weui-loading"></i></div>');
        loadList(1);
		// 功效选择
		$.ajax({
        	url:"index.php?r=API/flower-api/plants",
        	type:"get",
        	dataType: 'json',
        	success: function(data){
				var plants_list = data.code;
				$.each(plants_list, function(i, item) {
					$('#plants').append(
						" <li data-id=\""+item.plants_id+"\"><a href=\"javascript:void(0);\" class=\"block text-gary\">"+ item. plants_name +"</a> </li>"
					)
				});
			}
    	});        
        //适用面积
        $.ajax({
            url:"index.php?r=API/flower-api/area",
            type:"get",
            dataType: 'json',
            success: function(data){
            var area_list = data.code;
            $.each(area_list, function(i, item) {
                $('#area').append(
                    "<li data-id=\""+item.area_id+"\"><a href=\"javascript:void(0);\" class=\"block text-gary\">"+ item. area_name +"</a> </li>"
                    )
                });
            }
        });		
		//盆栽类型
		$.ajax({
        	url:"index.php?r=API/flower-api/pot",
        	type:"get",
        	dataType: 'json',
        	success: function(data){
			var area_list = data.code;
			$.each(area_list, function(i, item) {
				$('#pot').append(
                    "<li data-id=\""+item.pot_id+"\"><a href=\"javascript:void(0);\" class=\"block text-gary\">"+ item. pot_name +"</a> </li>"
					)
				});
			}
    	});        
        //盆栽寓意
        $.ajax({
            url:"index.php?r=API/flower-api/implication",
            type:"get",
            dataType: 'json',
            success: function(data){
            var area_list = data.code;
            $.each(area_list, function(i, item) {
                $('#implication').append(
                    "<li data-id=\""+item.implication_id+"\"><a href=\"javascript:void(0);\" class=\"block text-gary\">"+ item. implication_name +"</a> </li>"
                    )
                });
            }
        });        
        //摆放位置
        $.ajax({
            url:"index.php?r=API/flower-api/position",
            type:"get",
            dataType: 'json',
            success: function(data){
            var area_list = data.code;
            $.each(area_list, function(i, item) {
                $('#opsition').append(
                    "<li data-id=\""+item.opsition_id+"\"><a href=\"javascript:void(0);\" class=\"block text-gary\">"+ item. opsition_name +"</a> </li>"
                    )
                });
            }
        });	
        //筛选
        $('.select-drop ul').on('click','li',function(){
        	$('#plant-list').html('<div class="weui-loadmore before-load"><i class="weui-loading"></i></div>');
            loadList(1);
        });
        $('.bottom-btn-finish').on('click',function(){
        	$('#plant-list').html('<div class="weui-loadmore before-load"><i class="weui-loading"></i></div>');
            loadList(1);
        });
        //全部
        $('.select-btn-all').click(function(){
        	$('#plant-list').html('<div class="weui-loadmore before-load"><i class="weui-loading"></i></div>');
            location.reload();
        });
		
	});

    function loadList(pagenum){
        var sdata = {};
        sdata.pagenum = pagenum;
        sdata.plants_id   = $('#plants').find('li.active').data('id');
        sdata.pot_id      = $('#pot').find('li.active').data('id');
        sdata.implication_id = $('#implication').find('li.active').data('id');
        sdata.area_id     = $('#area').find('li.active').data('id');
        sdata.opsition_id = $('#opsition').find('li.active').data('id');
        sdata.house_id = addrID;
        // 列表
        $.ajax({
            type:"get",
            url:"index.php?r=API/flower-api/index",
            dataType: 'json',
            data:sdata,
            success: function(data){
                var plant_list = data.code;
                if(plant_list.length == 0){
                    if (pagenum == 1) {
                        $('#loadmore').html("<p class=\"loaderdown\">—— 暂无数据 ——</p>");
                        $('#plant-list').html('');
                    } else {
                        $('#loadmore').html("<p class=\"loaderdown\">—— 已加载所有数据 ——</p>");
                    } 
                } else{   
                    loading = false;               	
                    if (pagenum == 1) {
                        $('#plant-list').html('');
                    }
                    $.each(plant_list, function(i, item) {
                        $('#plant-list').append("<a href=\"index.php?r=API/h5/plant-detail&flower_id="+item.flower_id+"\" class=\"weui-media-box weui-media-box_appmsg\">" +
                            "                    <div class=\"weui-media-box__hd\">" +
                            "                        <img class=\"weui-media-box__thumb\" src='"+ item.thumb +"' alt=\"\">" +
                            "                    </div>" +
                            "                    <div class=\"weui-media-box__bd\">" +
                            "                        <h4 class=\"weui-media-box__title\">"+ item. flower_name+"</h4>" +
                            "                        <p class=\"weui-media-box__desc margin-small-top\">"+ item.flower_desc +"</p>" +
                            "                        <p class=\"weui-media-box__price margin-small-top\">¥"+ item.price +"元/月</p>" +
                            "                    </div>" +
                            "                </a>");
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