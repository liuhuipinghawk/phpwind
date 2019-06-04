<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>写字楼商铺公寓</title>
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
                    <li><a href="" class="text-gary block">陈寨</a></li>
                    <li><a href="" class="text-gary block">东风路</a></li>
                    <li><a href="" class="text-gary block">东三街</a></li>
                    <li><a href="" class="text-gary block">丰产路</a></li>
                    <li><a href="" class="text-gary block">东风路</a></li>
                    <li><a href="" class="text-gary block">东三街</a></li>
                    <li><a href="" class="text-gary block">丰产路</a></li>
                    <li><a href="" class="text-gary block">东风路</a></li>
                    <li><a href="" class="text-gary block">东三街</a></li>
                    <li><a href="" class="text-gary block">丰产路</a></li>
                    <li><a href="" class="text-gary block">东风路</a></li>
                    <li><a href="" class="text-gary block">东三街</a></li>
                    <li><a href="" class="text-gary block">丰产路</a></li>
                    <li><a href="" class="text-gary block">东风路</a></li>
                    <li><a href="" class="text-gary block">东三街</a></li>
                    <li><a href="" class="text-gary block">丰产路</a></li>
                </ul>
            </li>
            <li><a href="javascript:;" class="block">金水区</a>
                <ul class="select-list-child bg-white" style="display: none">
                    <li><a href="" class="text-gary block">不限</a></li>
                    <li><a href="" class="text-gary block">北环路</a></li>
                    <li><a href="" class="text-gary block">博颂路</a></li>
                    <li><a href="" class="text-gary block">晨旭路</a></li>
                    <li><a href="" class="text-gary block">陈寨</a></li>
                    <li><a href="" class="text-gary block">东风路</a></li>
                </ul>
            </li>
            <li><a href="javascript:;" class="block">二七区</a></li>
            <li><a href="javascript:;" class="block">管城区</a></li>
            <li><a href="javascript:;" class="block">惠济区</a></li>
            <li><a href="javascript:;" class="block">郑东新区</a></li>
            <li><a href="javascript:;" class="block">高新区</a></li>
            <li><a href="javascript:;" class="block">经开区</a></li>
            <li><a href="javascript:;" class="block">航空港区</a></li>
            <li><a href="javascript:;" class="block">上街区</a></li>
            <li><a href="javascript:;" class="block">金水区</a></li>
            <li><a href="javascript:;" class="block">金水区</a></li>
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
            </a>
            <a href="house-detail.html" class="weui-media-box weui-media-box_appmsg bg-white margin-top">
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="../dist/images/zu.jpg">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title text-black ellipsis">正商建正东方中心 370㎡</h4>
                    <div class="desc-cont text-gary margin-small-top">
                        <p class="base ellipsis"><span>3/25层</span> ·  <span>西北</span> ·  <span>2015年房龄</span></p>
                        <p class="desc ellipsis"><span>郑东新区-商鼎路</span><span>简易装修</span></p>
                        <div class="price">
                            <p class="price-base text-black"><span class="text-orange">面议</span></p>
                        </div>
                    </div>
                    <div class="line margin-small-top"></div>
                    <p class="metro text-gary margin-small-top">临近地铁1号线郑州东站</p>
                </div>
            </a>
            <a href="house-detail.html" class="weui-media-box weui-media-box_appmsg bg-white margin-top">
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="../dist/images/zu.jpg">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title text-black ellipsis">正商建正东方中心 370㎡</h4>
                    <div class="desc-cont text-gary margin-small-top">
                        <p class="base ellipsis"><span>3/25层</span> ·  <span>西北</span> ·  <span>2015年房龄</span></p>
                        <p class="desc ellipsis"><span>郑东新区-商鼎路</span><span>简易装修</span></p>
                        <div class="price">
                            <p class="price-base text-black"><span class="text-orange">面议</span></p>
                        </div>
                    </div>
                    <div class="line margin-small-top"></div>
                    <p class="metro text-gary margin-small-top">临近地铁1号线郑州东站</p>
                </div>
            </a>
            <a href="house-detail.html" class="weui-media-box weui-media-box_appmsg bg-white margin-top">
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="../dist/images/zu.jpg">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title text-black ellipsis">正商建正东方中心 370㎡</h4>
                    <div class="desc-cont text-gary margin-small-top">
                        <p class="base ellipsis"><span>3/25层</span> ·  <span>西北</span> ·  <span>2015年房龄</span></p>
                        <p class="desc ellipsis"><span>郑东新区-商鼎路</span><span>简易装修</span></p>
                        <div class="price">
                            <p class="price-base text-black"><span class="text-orange">面议</span></p>
                        </div>
                    </div>
                    <div class="line margin-small-top"></div>
                    <p class="metro text-gary margin-small-top">临近地铁1号线郑州东站</p>
                </div>
            </a>
            <a href="house-detail.html" class="weui-media-box weui-media-box_appmsg bg-white margin-top">
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="../dist/images/zu.jpg">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title text-black ellipsis">正商建正东方中心 370㎡</h4>
                    <div class="desc-cont text-gary margin-small-top">
                        <p class="base ellipsis"><span>3/25层</span> ·  <span>西北</span> ·  <span>2015年房龄</span></p>
                        <p class="desc ellipsis"><span>郑东新区-商鼎路</span><span>简易装修</span></p>
                        <div class="price">
                            <p class="price-base text-black"><span class="text-orange">面议</span></p>
                        </div>
                    </div>
                    <div class="line margin-small-top"></div>
                    <p class="metro text-gary margin-small-top">临近地铁1号线郑州东站</p>
                </div>
            </a>
            <a href="house-detail.html" class="weui-media-box weui-media-box_appmsg bg-white margin-top">
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="../dist/images/zu.jpg">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title text-black ellipsis">正商建正东方中心 370㎡</h4>
                    <div class="desc-cont text-gary margin-small-top">
                        <p class="base ellipsis"><span>3/25层</span> ·  <span>西北</span> ·  <span>2015年房龄</span></p>
                        <p class="desc ellipsis"><span>郑东新区-商鼎路</span><span>简易装修</span></p>
                        <div class="price">
                            <p class="price-base text-black"><span class="text-orange">面议</span></p>
                        </div>
                    </div>
                    <div class="line margin-small-top"></div>
                    <p class="metro text-gary margin-small-top">临近地铁1号线郑州东站</p>
                </div>
            </a>-->
        </div>
    </div>
	<div class="weui-loadmore" style="display: none;">
        <i class="weui-loading"></i>
        <span class="weui-loadmore__tips">正在加载</span>
    </div>

</div>
<script src="../dist/js/jquery-2.1.4.js"></script>
<script src="../dist/js/jquery-weui.js"></script>
<script src="../dist/js/fastclick.js"></script>
<script src="../dist/js/common.js"></script>
<script>
	var pagenum=1,pagesize=6,region_id=1,house_type=1,price='0-1',space='0-50',age='0-2';
	add();
	var loading = false;  //状态标记
    $(document.body).infinite().on("infinite", function() {
        if(loading) return;
        loading = true;
        pagenum++;
        $('.weui-loadmore').css({display:'block'});
        setTimeout(function() {
        	add();
            loading = false;
        }, 1000);   //模拟延迟
    });
	//区域信息加载
	$.ajax({
		type:"post",
		url:"/index.php?r=API/lease/get-region",
		async:true,
		success:function(res){
			var data=JSON.parse(res).code;
			console.log(data)
			data=[{
				"region_id": "1",
				"region_name": "金水区",
				"parent_id": "0",
				"child": [{
					"region_id": "11",
					"region_name": "北环路",
					"parent_id": "1"
				}, {
					"region_id": "12",
					"region_name": "博颂路",
					"parent_id": "1"
				}, {
					"region_id": "13",
					"region_name": "晨旭路",
					"parent_id": "1"
				}, {
					"region_id": "14",
					"region_name": "陈寨",
					"parent_id": "1"
				}, {
					"region_id": "15",
					"region_name": "大石桥",
					"parent_id": "1"
				}, {
					"region_id": "16",
					"region_name": "东风路",
					"parent_id": "1"
				}, {
					"region_id": "17",
					"region_name": "东明路",
					"parent_id": "1"
				}, {
					"region_id": "18",
					"region_name": "东三街",
					"parent_id": "1"
				}, {
					"region_id": "19",
					"region_name": "丰产路",
					"parent_id": "1"
				}, {
					"region_id": "20",
					"region_name": "丰乐路",
					"parent_id": "1"
				}, {
					"region_id": "21",
					"region_name": "丰庆路",
					"parent_id": "1"
				}, {
					"region_id": "22",
					"region_name": "福彩路",
					"parent_id": "1"
				}, {
					"region_id": "23",
					"region_name": "广电南路",
					"parent_id": "1"
				}, {
					"region_id": "24",
					"region_name": "国基路",
					"parent_id": "1"
				}, {
					"region_id": "25",
					"region_name": "红专路",
					"parent_id": "1"
				}, {
					"region_id": "26",
					"region_name": "花卉市场",
					"parent_id": "1"
				}, {
					"region_id": "27",
					"region_name": "黄河路",
					"parent_id": "1"
				}, {
					"region_id": "28",
					"region_name": "花园路",
					"parent_id": "1"
				}, {
					"region_id": "29",
					"region_name": "经七路",
					"parent_id": "1"
				}, {
					"region_id": "30",
					"region_name": "经三路",
					"parent_id": "1"
				}, {
					"region_id": "31",
					"region_name": "金水路",
					"parent_id": "1"
				}]
				}, {
					"region_id": "2",
					"region_name": "中原区",
					"parent_id": "0",
					"child": []
				}, {
					"region_id": "3",
					"region_name": "二七区",
					"parent_id": "0",
					"child": [{
						"region_id": "32",
						"region_name": "碧云路",
						"parent_id": "3"
					}, {
						"region_id": "33",
						"region_name": "政通路",
						"parent_id": "3"
					}, {
						"region_id": "34",
						"region_name": "大学南路",
						"parent_id": "3"
					}, {
						"region_id": "35",
						"region_name": "长江路",
						"parent_id": "3"
					}, {
						"region_id": "36",
						"region_name": "大学路",
						"parent_id": "3"
					}, {
						"region_id": "37",
						"region_name": "大学中路",
						"parent_id": "3"
					}, {
						"region_id": "38",
						"region_name": "德化街",
						"parent_id": "3"
					}, {
						"region_id": "39",
						"region_name": "福华街",
						"parent_id": "3"
					}, {
						"region_id": "40",
						"region_name": "郑密路",
						"parent_id": "3"
					}, {
						"region_id": "41",
						"region_name": "富田大厦",
						"parent_id": "3"
					}]
				}, {
					"region_id": "4",
					"region_name": "管城区",
					"parent_id": "0",
					"child": []
				}, {
					"region_id": "5",
					"region_name": "惠济区",
					"parent_id": "0",
					"child": []
				}, {
					"region_id": "6",
					"region_name": "郑东新区",
					"parent_id": "0",
					"child": []
				}, {
					"region_id": "7",
					"region_name": "高新区",
					"parent_id": "0",
					"child": []
				}, {
					"region_id": "8",
					"region_name": "经开区",
					"parent_id": "0",
					"child": []
				}, {
					"region_id": "9",
					"region_name": "航空港区",
					"parent_id": "0",
					"child": []
				}, {
					"region_id": "10",
					"region_name": "上街区",
					"parent_id": "0",
					"child": []
				}];
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
	})
	//面积筛选
	$('#space>li').click(function(e){
		e.stopPropagation();
		space=$(this).children('a').attr('space');
		add();
		pagenum=0;
		$('#space').css({display:'none'});
		$('.mask').css({display:'none'});
		$('body').removeClass('mask-body')
	})
	//房龄筛选
	$('#age>li').click(function(e){
		e.stopPropagation();
		age=$(this).children('a').attr('age');
		add();
		pagenum=0;
		$('#age').css({display:'none'});
		$('.mask').css({display:'none'});
		$('body').removeClass('mask-body')
	})
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
				data= [{
		"publish_id": "1",
		"house_type": "1",
		"house_id": "1",
		"region_id": "11",
		"subway_id": "34",
		"price": "800",
        "unit": "月",
		"space": "45",
		"age": "2016",
		"floor": "18\/33",
		"deco_id": "1",
		"orien_id": "1",
		"house_desc": "...",
		"address": "......",
		"person": "小番薯",
		"person_tel": "18039180216",
		"status": "1",
		"is_del": "0",
		"publish_time": "0",
		"publish_user": "0",
		"house_name": "正商国际广场",
		"station_name": "北三环",
		"subway_name": "2号线",
		"deco_name": "毛坯",
		"orien_name": "东",
		"imgs": [{
			"img_id": "1",
			"publish_id": "1",
			"img_path": "...",
			"tag": "up"
		}, {
			"img_id": "2",
			"publish_id": "1",
			"img_path": "...",
			"tag": "down"
		}, {
			"img_id": "3",
			"publish_id": "1",
			"img_path": "...",
			"tag": "left"
		}, {
			"img_id": "4",
			"publish_id": "1",
			"img_path": "...",
			"tag": "right"
		}, {
			"img_id": "5",
			"publish_id": "1",
			"img_path": "...",
			"tag": "front"
		}, {
			"img_id": "6",
			"publish_id": "1",
			"img_path": "...",
			"tag": "back"
		}]
	}]
				if(data.length!=0){
					$('.zu-list-panel .weui-panel__bd').empty()
				}
				for(i=0;i<data.length;i++){
					$('.zu-list-panel .weui-panel__bd').append(
						'<a href="house-detail.html?data='+data[i].publish_id+'"'+'class="weui-media-box weui-media-box_appmsg bg-white margin-top">'+
							'<div class="weui-media-box__hd">'+
								'<img class="weui-media-box__thumb" src="'+data[i].imgs[0].img_path+'">'
							+'</div>'+
							'<div class="weui-media-box__bd">'+
			                    '<h4 class="weui-media-box__title text-black ellipsis">'+data[i].house_name+'</h4>'+
			                    '<div class="desc-cont text-gary margin-small-top">'+
			                        '<p class="base ellipsis"><span>'+data[i].floor+'</span> ·  <span>'+data[i].orien_name+'层</span> ·  <span>房龄：'+data[i].age+'</span></p>'+
			                        '<p class="desc ellipsis"><span>'+data[i].address+'</span><span>'+data[i].deco_name+'</span></p>'+
			                        '<div class="price">'+
			                            '<p class="price-base text-black"><span class="text-orange">面议</span></p>'+
			                        '</div>'+
			                    '</div>'+
			                    '<div class="line margin-small-top"></div>'+
			                    '<p class="metro text-gary margin-small-top">临近地铁'+data[i].subway_name+data[i].station_name+'站</p>'+
			                '</div>'
						+'</a>'
					)
				}
			},
			error:function(res){
				console.log(res)
			}
		});
	}
</script>
</body>
</html>