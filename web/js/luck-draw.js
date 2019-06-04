$(".close").on('click', function() {
    $(".mask").hide();
    $(".no-num").hide();
    $(".no-luck").hide();
});
//抽奖代码
$(function() {
    //获得当前<ul>
    var $uList = $(".winning-record ul");
    var timer = null;
    $uList.hover(function() {  //触摸清空定时器
            clearInterval(timer);
        },
        function() { //离开启动定时器
            timer = setInterval(function() {
                    scrollList($uList);
                },
                1200);
        }).trigger("mouseleave"); //自动触发触摸事件
    //滚动动画
    function scrollList(obj) {
        var scrollHeight = $("ul li:first").height();   //获得当前<li>的高度
        $uList.stop().animate({  //滚动出一个<li>的高度
                marginTop: -scrollHeight
            }, 600,
            function() {
                $uList.css({ //动画结束后，将当前<ul>marginTop置为初始值0状态，再将第一个<li>拼接到末尾。
                    marginTop: 0
                }).find("li:first").appendTo($uList);
            });
    }

});