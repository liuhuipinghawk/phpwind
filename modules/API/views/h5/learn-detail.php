<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>学习园地详情</title>
    <?=Html::cssFile('/css/weui.min.css')?>
    <?=Html::cssFile('/css/jquery-weui.css')?>
    <?=Html::cssFile('/layui/css/layui.css')?>
    <?=Html::cssFile('/css/learn-com.css')?>
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
    </script>
</head>
<body ontouchstart class="relative">
<div class="wrap">
    <!--头部-->
    <header class="bar">
        <a href="javascript:;" onclick="javascript:history.back(-1);" class="icon pull-left"><img src="/images//back.png" width="11"></a>
        <h1 class="title">详情</h1>
        <a href="/user/test/xxxx.docx" download="文件名.pdf" class="down-icon pull-right text-black" id="down-href">下载</a>
    </header>
    <!--主体内容-->
    <div class="app-cont app-evaluate-cont">
        <div class="base-cont" id="detail-cont">
            <!--加载-->
            <div class="weui-loadmore" style="margin: 0 auto">
                <i class="weui-loading"></i>
                <span class="weui-loadmore__tips">loading……</span>
            </div>
        </div>
        <div class="base-cont evaluate-cont margin-top">
            <p class="main-title">评价列表</p>
            <div id="evaluate-list">
                <!--加载-->
                <div class="weui-loadmore">
                    <i class="weui-loading"></i>
                    <span class="weui-loadmore__tips">loading……</span>
                </div>
            </div>
        </div>


    </div>
    <!--加载-->

    <div class="evaluate-footer base-cont clearfix">
        <div class="pull-left text-gary evaluate-zan">
            <span>赞</span>
            <span><img src="/images/zan.png" width="18" class="personal-zan" id="personal-zan"></span>
        </div>
        <div class="pull-left evaluate-input">
            <input type="text" placeholder="写评论">
        </div>
        <a href=javascript:; class="send-btn text-gary pull-right" id="send-eval">发送</a>
    </div>
</div>
<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/fastclick.js')?>
<?=Html::jsFile('/js/jquery-weui.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<?=Html::jsFile('/js/learn-com.js')?>
<?=Html::jsFile('/js/public.js')?>
<script>
    $(function () {
        // 详情
        $.ajax({
            url:" /API/learn/learn",
            type:"post",
            data:{
              //id: <?php //echo Yii::$app->request->get()['id']?>//,
                id: 1,
                user_id: 1
            },
            dataType: 'json',
            success: function(data){
                var base_cont = data.code;
                var is_like = base_cont.is_like;
                if (is_like == 0){
                    $("#personal-zan").attr('src', "/images/zan.png")
                }else if(is_like == 1){
                    $("#personal-zan").attr('src', "/images/zan-active.png")
                }
                var down_href = base_cont.upload;
                $("#down-href").attr({"href": down_href, "download": base_cont.title });
                $("#detail-cont").html("<p class=\"title\">"+ base_cont.title +"</p>" +
                    "            <div class=\"tip text-gary\"><span class=\"time\">"+ base_cont.create_time +"</span>|<span class=\"down-num\">下载："+ base_cont.download_num+"</span></div>" +
                    "            <div class=\"content\">"+ base_cont.content +"</div>" +
                    "            <div class=\"tip-num text-gary clearfix\">" +
                    "                <div class=\"pull-left\">阅读："+ base_cont.read_num +"</div>" +
                    "                <div class=\"pull-right\"><span class=\"zan-num\"><img src=\"/images/zan.png\"></span> <span id=\"zan-num\">"+ base_cont.like_num +"</span>" +
                    "<span class=\"evaluate-num\"><img src=\"/images/evaluate.png\"></span> <span id=\"evaluate-num\">"+ base_cont.comment_num+"</span></div>" +
                    "            </div>")
            }
        });

        // 评论列表
        function evalList(){
            $.ajax({
                url:"/API/learn/comment-list",
                type:"post",
                data:{
                    id: <?php echo Yii::$app->request->get()['id']?>
                },
                dataType: 'json',
                success: function(data){
                    var eval_list = data.code;
                    $('#evaluate-list').html("");
                    $.each(eval_list, function(i, item) {
                        var nick_name = item.nick_name;
                        if (nick_name == undefined || nick_name == null || nick_name == ''){
                            nick_name = "匿名用户";
                        }else {
                            nick_name = item.nick_name;
                        }
                        var head_img = item.header_img;
                        if (head_img == undefined || head_img == null || head_img == ''){
                            head_img = "/images/default.png";
                        }else {
                            head_img = item.head_img;
                        }
                        $('#evaluate-list').append("<div class=\"evaluate-panel clearfix\" >" +
                            "                <div class=\"header clearfix\">" +
                            "                    <div class=\"pull-left text-gary header-img\"><span><img src='"+ head_img +"'></span><span class=\"margin-small-left\">"+ nick_name +"</span></div>" +
                            "                </div>" +
                            "                <div class=\"evaluate-cont\">"+ item.comment +"<p class=\"time text-gary\">"+ item.add_time +"</p>" +
                            "                </div>" +
                            "            </div>")
                    });
                }
            });
        }
        evalList();

        // 弹出框
        layui.use('layer', function() {
            var $ = layui.jquery,
                layer = layui.layer;
            $("#send-eval").on('click', function () {
                var eval_value = $('.evaluate-input input').val();
                var evaluateNum = $("#evaluate-num").text();
                if (eval_value.length == 0){
                    layer.msg("评论内容不能为空")
                }else{
                    $.ajax({
                        url: "/API/learn/do-comment",
                        type: "post",
                        data: {
                            id: <?php echo Yii::$app->request->get()['id']?>,
                            user_id: 1,
                            comment: eval_value
                        },
                        dataType: 'json',
                        success: function () {
                            $('.evaluate-input input').val('');
                            evaluateNum++;
                            $("#evaluate-num").text(evaluateNum);
                            layer.msg("评论成功");
                            evalList();
                        }
                    })
                }
            });
            $('.personal-zan').on('click', function () {
                var type;
                var imgSrc = $(this).attr('src');
                var zanNum = $("#zan-num").text();
                if(imgSrc == "/images/zan-active.png"){
                    $(this).attr('src', "/images/zan.png");
                    type = 2;
                    zanNum--;
                    $("#zan-num").text(zanNum);
                    layer.msg("取消点赞")
                }else if(imgSrc == "/images/zan.png"){
                    $(this).attr('src', "/images/zan-active.png");
                    type = 1;
                    zanNum++;
                    $("#zan-num").text(zanNum);
                    layer.msg("点赞成功")
                }
                $.ajax({
                    url: "/API/learn/do-like",
                    type: "post",
                    data: {
                        id: <?php echo Yii::$app->request->get()['id']?>,
                        user_id: 1,
                        type: type
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                    }
                })
            });
        });
        // 下载接口
        $("#down-href").on('click', function () {
            $.ajax({
                url: "/API/learn/do-download",
                type: "post",
                data: {
                    id: <?php echo Yii::$app->request->get()['id']?>
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                }
            })
        })
    })
</script>
</body>
</html>