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
    <title>用户评价</title>
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
        <div class="weui-tab evaluation-tab">
            <div class="weui-navbar">
                <a class="weui-navbar__item weui-bar__item--on" href="#tab1">全部(300)</a>
                <a class="weui-navbar__item" href="#tab2">晒图(100)</a>
                <a class="weui-navbar__item" href="#tab3">低分(100)</a>
                <a class="weui-navbar__item" href="#tab4">最新</a>
            </div>
            <div class="weui-tab__bd">
                <div id="tab1" class="weui-tab__bd-item weui-tab__bd-item--active">
                    <div class="evaluation-tab bg-white padding-cont">
                        <div class="list border-bottom padding-top">
                            <a href="#" class="keyword">卫生干净&nbsp;100</a>
                            <a href="#" class="keyword">卫生干净&nbsp;100</a>
                            <a href="#" class="keyword">卫生干净&nbsp;100</a>
                            <a href="#" class="keyword">卫生干净&nbsp;100</a>
                            <a href="#" class="keyword">卫生干净&nbsp;100</a>
                        </div>
                        <div class="weui-panel weui-panel_access">
                            <div class="weui-panel__bd border-bottom">
                                <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg clearfix">
                                    <div class="weui-media-box__hd">
                                        <img class="weui-media-box__thumb" src="/images/album.jpg" alt="">
                                    </div>
                                    <div class="weui-media-box__bd">
                                        <h4 class="weui-media-box__title text-warning">小洞洞 <span class="pull-right text-muted">精致大床房</span></h4>
                                        <p class="text-gary">打分&nbsp;<img src="/images/star.jpg" width="80"></p>
                                        <p class="weui-media-box__desc margin-top text-black">#性价高#性价高#性价高#性价高#性价高#性价高</p>
                                        <div class="swiper-container margin-top">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <img src="/images/album.jpg" alt="">
                                                </div>
                                                <div class="swiper-slide">
                                                    <img src="/images/album.jpg" alt="">
                                                </div>

                                            </div>
                                        </div>
                                        <p class="text-muted margin-top">2017-11-11入住，2017-11-11发表</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="tab2" class="weui-tab__bd-item">
                    
                </div>
                <div id="tab3" class="weui-tab__bd-item">
                 
                </div>
                <div id="tab4" class="weui-tab__bd-item">
                   
                </div>
            </div>
        </div>


    </div>

</div>


<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/jquery-weui.js')?>
<?=Html::jsFile('/js/swiper.js')?>
<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 'auto',
        spaceBetween: 10
    });
</script>
</body>
</html>