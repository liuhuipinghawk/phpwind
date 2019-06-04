<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>房屋租赁</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="format-detection" content="telephone=no,email=no,adress=no">
    <meta name="author" content="he">
    <meta name="description" content="是一个出租写字楼、公寓、商铺的专业平台">
    <meta name="keywords" content="正e租">
    <link rel="stylesheet" href="../dist/css/weui.css">
    <link rel="stylesheet" href="../dist/css/jquery-weui.css">
    <link rel="stylesheet" href="../dist/css/common.css">
    <style type="text/css">
    	.zu-list-panel{
			padding-top: 0.6rem;
		}
		.weui-flex-select{
			top: 0;
		}
		.weui-flex-select .select-list .select-list-child{
			top: 0.63rem;
		}
    </style>
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
    </script>
</head>
<body ontouchstart>
<div class="wrap">
    <!--头部-->
    <!--<header class="header-search head-bar bg-white">-->
    <!--<a href="javascript:;" onclick="javascript:history.back(-1);" class="inline-block back-img">
        <img src="../dist/images/back_orange.png" class="max-width">
    </a>-->
    <!--<a href="search.html" class="search pull-right block">
        <form action="" class="search-from">
            <input type="search" placeholder="请输入您想找得房源名称、楼盘或地址" class="search-input"/>
        </form>
        <span class="search-btn"><img src="../dist/images/search.png"></span>
    </a>-->
	<!--</header>-->

    <!--筛选-->
    <div class="weui-flex weui-flex-select bg-white" id="select">
    <div class="weui-flex__item text-center select-btn">
        <span class="main-menu text-black">区域</span>
        <img src="../dist/images/show_down.png" class="span-img">
        <ul class="select-list select-menu-list" style="display: none" id="address">
            <!--<li><a href="javascript:;" class="block">不限</a></li>-->
            <!--<li class="active"><a href="javascript:;" class="block">金水区</a>
                <ul class="select-list-child bg-white" style="display: none">
                    <li><a href="" class="text-gary block">不限</a></li>
                    <li class="active"><a href="" class="text-gary block">北环路</a></li>
                    <li><a href="" class="text-gary block">博颂路</a></li>
                    <li><a href="" class="text-gary block">晨旭路</a></li>
            </li>
            <li><a href="javascript:;" class="block">金水区</a>
                <ul class="select-list-child bg-white" style="display: none">
                    <li><a href="" class="text-gary block">不限</a></li>
                    <li><a href="" class="text-gary block">北环路</a></li>
                </ul>
            </li>
            <li><a href="javascript:;" class="block">二七区</a></li>
            <li><a href="javascript:;" class="block">金水区</a></li>-->

        </ul>
    </div>
    <div class="weui-flex__item text-center select-btn">
        <span class="main-menu text-black">价格</span>
        <img src="../dist/images/show_down.png" class="span-img">
        <ul class="select-list select-menu-list" style="display: none" id="price">
           <!--<li class="price-range">
               <input type="text" class="price-min">
               <span class="text-black">-</span>
               <input type="text" class="price-max">
               <a href="javascript:;" class="price-btn">确定</a>
           </li>-->
            <!--<li class="active"><a href="javascript:;" class="block">不限</a></li>-->
            <li class="active"><a href="javascript:;" class="block" house_type="1">写字楼</a>
            	<ul class="select-list-child bg-white">
            		<li><a href="javascript:;" class="text-gary block" price="0-1">0-1元/天/㎡</a></li>
		            <li><a href="javascript:;" class="text-gary block" price="1-1.5">1-1.5元/天/㎡</a></li>
		            <li><a href="javascript:;" class="text-gary block" price="1.5-2">1.5-2元/天/㎡</a></li>
		            <li><a href="javascript:;" class="text-gary block" price="2-2.5">2-2.5元/天/㎡</a></li>
		            <li><a href="javascript:;" class="text-gary block" price="2.5-3">2.5-3元/天/㎡</a></li>
		            <li><a href="javascript:;" class="text-gary block" price="3-9999">3元/天/㎡以上</a></li>
            	</ul>
            </li>
            <li><a href="javascript:;" class="block" house_type="2">公寓</a>
            	<ul class="select-list-child bg-white" style="display: none">
            		<li><a href="javascript:;" class="text-gary block" price="0-1">0-1元/天/㎡</a></li>
		            <li><a href="javascript:;" class="text-gary block" price="1-1.5">1-1.5元/天/㎡</a></li>
		            <li><a href="javascript:;" class="text-gary block" price="1.5-2">1.5-2元/天/㎡</a></li>
		            <li><a href="javascript:;" class="text-gary block" price="2-2.5">2-2.5元/天/㎡</a></li>
		            <li><a href="javascript:;" class="text-gary block" price="2.5-3">2.5-3元/天/㎡</a></li>
		            <li><a href="javascript:;" class="text-gary block" price="3-9999">3元/天/㎡以上</a></li>
            	</ul>
            </li>
            <li><a href="javascript:;" class="block" house_type="3">商铺</a>
            	<ul class="select-list-child bg-white" style="display: none">
            		<li><a href="javascript:;" class="text-gary block" price="0-1">0-1元/天/㎡</a></li>
		            <li><a href="javascript:;" class="text-gary block" price="1-1.5">1-1.5元/天/㎡</a></li>
		            <li><a href="javascript:;" class="text-gary block" price="1.5-2">1.5-2元/天/㎡</a></li>
		            <li><a href="javascript:;" class="text-gary block" price="2-2.5">2-2.5元/天/㎡</a></li>
		            <li><a href="javascript:;" class="text-gary block" price="2.5-3">2.5-3元/天/㎡</a></li>
		            <li><a href="javascript:;" class="text-gary block" price="3-9999">3元/天/㎡以上</a></li>
            	</ul>
            </li>
        </ul>
    </div>
    <div class="weui-flex__item text-center select-btn">
        <span class="main-menu text-black">面积</span>
        <img src="../dist/images/show_down.png" class="span-img">
        <ul class="select-list bg-white" style="display: none" id="space">
            <!--<li class="active"><a href="javascript:;" class="block">不限</a></li>-->
            <li><a href="javascript:;" class="block" space="0-50">50㎡以下</a></li>
            <li><a href="javascript:;" class="block" space="50-100">50-100㎡</a></li>
            <li><a href="javascript:;" class="block" space="100-200">100-200㎡</a></li>
            <li><a href="javascript:;" class="block" space="200-300">200-300㎡</a></li>
            <li><a href="javascript:;" class="block" space="300-500">300-500㎡</a></li>
            <li><a href="javascript:;" class="block" space="500-1000">500-1000㎡</a></li>
            <li><a href="javascript:;" class="block" space="1000-9999">1000㎡以上</a></li>
        </ul>
    </div>
    <div class="weui-flex__item text-center select-btn">
        <span class="main-menu text-black">房龄</span>
        <img src="../dist/images/show_down.png" class="span-img">
        <ul class="select-list bg-white" style="display: none" id="age">
            <!--<li class="active"><a href="javascript:;" class="block">不限</a></li>-->
            <li><a href="javascript:;" class="block" age="0-2">2年以下</a></li>
            <li><a href="javascript:;" class="block" age="2-5">2-5年</a></li>
            <li><a href="javascript:;" class="block" age="5-10">5-10年</a></li>
            <li><a href="javascript:;" class="block" age="10-9999">10年以上</a></li>
        </ul>
    </div>

</div>

<div class="mask dropdown-mask" zyz-event="hide_dropdown_mask" style="display: none"></div>

    <div class="weui-panel weui-panel_access zu-list-panel">
        <div class="weui-panel__bd">
            <!--<a href="house-detail.html" class="weui-media-box weui-media-box_appmsg bg-white margin-bottom">
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="../dist/images/zu.jpg">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title text-black ellipsis">正商建正东方中心 370㎡</h4>
                    <div class="desc-cont text-gary margin-small-top">
                        <p class="base ellipsis"><span>3/25层</span> ·  <span>西北</span> ·  <span>2015年房龄</span></p>
                        <p class="desc ellipsis"><span>郑东新区-商鼎路</span><span>简易装修</span></p>
                        <div class="price">
                            <p class="price-base text-black"><span class="text-orange">2</span>元/天/㎡</p>
                            <p class="price-sum text-orange">总价：22200元</p>
                        </div>
                    </div>
                    <div class="line margin-small-top"></div>
                    <p class="metro text-gary margin-small-top">临近地铁1号线郑州东站</p>
                </div>
            </a>-->
        </div>
    </div>
	<div class="weui-loadmore" id="loadmore">
        <i class="weui-loading"></i>
        <span class="weui-loadmore__tips">正在加载</span>
    </div>

</div>
<script src="../dist/js/jquery-2.1.4.js"></script>
<script src="../dist/js/jquery-weui.js"></script>
<script src="../dist/js/fastclick.js"></script>
<script src="../dist/js/common.js"></script>
<script>
    // var pagenum=1,pagesize=6,region_id=1,house_type=1,price='0-1',space='0-50',age='0-2';
	var pagenum=1,pagesize=6,region_id=0,house_type=0,price='',space='',age='';
	add();
	//区域信息加载
	$.ajax({
		type:"post",
		url:"/index.php?r=API/lease/get-region",
		async:true,
		success:function(res){
			var data=JSON.parse(res).code;
			
			//一级区域加载
			for(var i=0;i<data.length;i++){
				if(i==0){
					$('#address').append(
						'<li class="active"><a href="javascript:;" class="block" region_id='+data[i].region_id+'>'+data[i].region_name+'</a>'+
							'<ul class="select-list-child bg-white" style="display: none"></ul>'
						+'</li>'
					)
				}
				else{
					$('#address').append(
						'<li><a href="javascript:;" class="block" region_id='+data[i].region_id+'>'+data[i].region_name+'</a>'+
							'<ul class="select-list-child bg-white" style="display: none"></ul>'
						+'</li>'
					)
				}
			}
			$('#address>li').click(function(e){
				$(this).addClass('active').siblings().removeClass('active');
				$(this).siblings().children('ul').css({display:'none'});
				//二级区域加载
				for(i=0;i<data[$(this).index()].child.length;i++){
					$(this).children('ul').append(
						'<li><a href="javascript:;" class="text-gary block" region_id='+data[$(this).index()].child[i].region_id+'>'+data[$(this).index()].child[i].region_name+'</a></li>'
					).css({display:'block'})
				};
				//区域点击筛选
				if(data[$(this).index()].child.length==0){
					region_id=$(this).children('a').attr('region_id');
					add();
					pagenum=0;
					$('#address').css({display:'none'});
					$('.mask').css({display:'none'});
					$('body').removeClass('mask-body');
					return false;
				}
				else{
					$('#address>li li').click(function(e){
						e.stopPropagation();
						region_id=$(this).children('a').attr('region_id');
						add();
						pagenum=0;
						$('#address').css({display:'none'});
						$('.mask').css({display:'none'});
						$('body').removeClass('mask-body')
					})
				}
			})
		}
	});
	//价格筛选
	$('#price>li').click(function(){
		$(this).addClass('active').siblings().removeClass('active');
		$(this).siblings().children('ul').css({display:'none'});
		$(this).children('ul').css({display:'block'});
		house_type=$(this).children('a').attr('house_type');
		$('#price>li li').click(function(e){
			e.stopPropagation();
			price=$(this).children('a').attr('price');
			add();
			pagenum=0;
			$(this).parent('ul').css({display:'block'})
			$('#price').css({display:'none'});
			$('.mask').css({display:'none'});
			$('body').removeClass('mask-body')
		})
	});
	//面积筛选
	$('#space>li').click(function(e){
		e.stopPropagation();
		space=$(this).children('a').attr('space');
		add();
		pagenum=0;
		$('#space').css({display:'none'});
		$('.mask').css({display:'none'});
		$('body').removeClass('mask-body')
	});
	//房龄筛选
	$('#age>li').click(function(e){
		e.stopPropagation();
		age=$(this).children('a').attr('age');
		add();
		pagenum=0;
		$('#age').css({display:'none'});
		$('.mask').css({display:'none'});
		$('body').removeClass('mask-body')
	});
	function add(){
		$.ajax({
			type:"post",
			url:"/index.php?r=API/lease/lease-list",
			async:true,
			data:{
				'pagenum':pagenum,
				'pagesize':pagesize,
				'region_id':region_id,
				'house_type':house_type,
				'price':price,
				'space':space,
				'age':age
			},
			success:function(res){
				var data=JSON.parse(res).code;
				if(data.length == 0){
                    if (pagenum == 1) {
                        $('#loadmore').html("<p class=\"loaderdown\">—— 暂无数据 ——</p>");
                        $('.zu-list-panel .weui-panel__bd').html('');
                    } else {
                        $('#loadmore').html("<p class=\"loaderdown\">—— 已加载所有数据 ——</p>");
                    }
				} else {
                    loading = false;
                    if (pagenum == 1) {
                        $('.zu-list-panel .weui-panel__bd').html('');
                    }
                    $.each(data, function (i, item) {
                        $('.zu-list-panel .weui-panel__bd').append(
                            '<a href="/index.php?r=API/h5/zu-detail&publish_id='+item.publish_id+'"'+'class="weui-media-box weui-media-box_appmsg bg-white margin-top">'+
                            '<div class="weui-media-box__hd">'+
                            '<img class="weui-media-box__thumb" src="'+item.imgs[0].img_path+'">'
                            +'</div>'+
                            '<div class="weui-media-box__bd">'+
                            '<h4 class="weui-media-box__title text-black ellipsis">'+item.house_name+'</h4>'+
                            '<div class="desc-cont text-gary margin-small-top">'+
                            '<p class="base ellipsis"><span>'+item.floor+'</span> ·  <span>'+item.orien_name+'层</span> ·  <span>房龄：'+item.age+'</span></p>'+
                            '<p class="desc ellipsis"><span>'+item.address+'</span><span>'+item.deco_name+'</span></p>'+
                            '<div class="price">'+
                            '<p class="price-base text-black"><span class="text-orange">面议</span></p>'+
                            '</div>'+
                            '</div>'+
                            '<div class="line margin-small-top"></div>'+
                            '<p class="metro text-gary margin-small-top">临近地铁'+item.subway_name+item.station_name+'站</p>'+
                            '</div>'
                            +'</a>'
                        )
                    });
                }

			},
			error:function(res){
				console.log(res)
			}
		});
	}

    var loading = false;  //状态标记
    $(document.body).infinite().on("infinite", function() {
        if(loading) return;
        loading = true;
        pagenum++;
        // $('.weui-loadmore').css({display:'block'});
        setTimeout(function() {
            add();
            loading = false;
        }, 1500);   //模拟延迟
    });
</script>
</body>
</html>