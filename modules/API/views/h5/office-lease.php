<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>办公设备租赁</title>
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
        <div class="select-list select-list-office">
            <div class="weui-flex text-center border-bottom">
                <div class="weui-flex__item">
                    <a href="javascript:;" class="text-gary select-btn block">台式机</a>
                    <span class="img-down"><img src="/images/select_down.png" ></span>
                    <span class="img-up active"><img src="/images/select_up.png" ></span>
                    <div class="sort-select select-drop">
                        <ul id="computer"></ul>
                    </div>
                </div>
                <div class="weui-flex__item">
                    <a href="javascript:;" class="text-gary select-btn block">笔记本</a>
                    <span class="img-down"><img src="/images/select_down.png" ></span>
                    <span class="img-up active"><img src="/images/select_up.png" ></span>
                    <div class="sort-select select-drop">
                        <ul id="notebook"></ul>
                    </div>
                </div>
                <div class="weui-flex__item">
                    <a href="javascript:;" class="text-gary select-btn block">打印机</a>
                    <span class="img-down"><img src="/images/select_down.png" ></span>
                    <span class="img-up active"><img src="./images/select_up.png" ></span>
                    <div class="sort-select select-drop">
                        <ul id="printer"></ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mask dropdown-mask"  amallink-event="hide_dropdown_mask"></div>
        <div class="weui-panel weui-panel_access office-list">
            <div class="weui-panel__bd" id="office-list">
              
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
<script>
	$(function(){
        FastClick.attach(document.body);
		$('#office-list').html('<div class="weui-loadmore before-load"><i class="weui-loading"></i></div>');		
		setTimeout(function(){
			$('#office-list').html('');
			loadList(1);
		}, 200)
		
        //台式机
        $.get('/index.php?r=API/organization-api/category&pid=1',function(res){
            if (res.status == 200) {
                $category = res.code.children;
                $.each($category,function(i,item){
                    $('#computer').append("<li><a href=\"/index.php?r=API/h5/office-lease&pagenum=1&pid="+item.category_id+"\" class=\"block text-gary\">"+item.category_name+"</a> </li>");
                });                
            }
        },'JSON');
        //笔记本
        $.get('/index.php?r=API/organization-api/category&pid=2',function(res){
            if (res.status == 200) {
                $category = res.code.children;
                $.each($category,function(i,item){
                    $('#notebook').append("<li><a href=\"/index.php?r=API/h5/office-lease&pagenum=1&pid="+item.category_id+"\" class=\"block text-gary\">"+item.category_name+"</a> </li>");
                });                
            }
        },'JSON');
        //打印机
        $.get('/index.php?r=API/organization-api/category&pid=3',function(res){
            if (res.status == 200) {
                $category = res.code.children;
                $.each($category,function(i,item){
                    $('#printer').append("<li><a href=\"/index.php?r=API/h5/office-lease&pagenum=1&pid="+item.category_id+"\" class=\"block text-gary\">"+item.category_name+"</a> </li>");
                });                
            }
        },'JSON');

		
	});

    //加载数据
    function loadList(pagenum){
        var sdata = {};
        sdata.pagenum = pagenum;
        sdata.pid     = <?php echo empty(Yii::$app->request->get()['pid']) ? 0 : Yii::$app->request->get()['pid'];?>;

        $.ajax({
            type:"get",
            url:"index.php?r=API/organization-api/index",
            dataType: 'json',
            data:sdata,
            success: function(data){
                var office_list = data.code;
                if(office_list.length == 0){
                    if (pagenum == 1) {
                        $('#loadmore').html("<p class=\"loaderdown\">—— 暂无数据 ——</p>");
                    } else {
                        $('#loadmore').html("<p class=\"loaderdown\">—— 已加载所有数据 ——</p>");
                    }                    
                } else{   
                    loading = false;                
                    if (pagenum == 1) {
                        $('#plant-list').html('');
                    }
                    $.each(office_list, function(i, item) {
                        $('#office-list').append("<a href=\"index.php?r=API/h5/office-detail&equipment_id="+item.equipment_id+"\" class=\"weui-media-box weui-media-box_appmsg\">" +
                            "                    <div class=\"weui-media-box__hd\">" +
                            "                        <img class=\"weui-media-box__thumb\" src='"+ item.thumb +"' alt=\"\">" +
                            "                    </div>" +
                            "                    <div class=\"weui-media-box__bd\">" +
                            "                        <h4 class=\"weui-media-box__title\">"+ item.equipment_name +"</h4>" +
                            "                        <p class=\"weui-media-box__type\">"+ item.equipment_desc +"</p>" +
                            "                        <p class=\"weui-media-box__price font-weight\">¥"+ item.price +"台/月</p>" +
                            "                    </div>" +
                            "                </a>")
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