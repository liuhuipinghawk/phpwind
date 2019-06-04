window.onresize = function(){
    /*设定html字体大小*/
    var deviceWidth = document.documentElement.clientWidth;
    if(deviceWidth > 640) deviceWidth = 640;
    document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
};


// 获取楼盘，楼座信息
function userInfo() {
    var u = navigator.userAgent;
    var userHouse;
    var user_id;
    var house_id;
    var seat_id;
    if(u.indexOf('Android') > -1 || u.indexOf('Adr') > -1) {
        // 安卓端调取默认信息
        userHouse = window.android.userHouse();
        userHouse = eval("(" + userHouse + ")");// 字符串(string)转json
        userHouse = JSON.parse(userHouse);
        user_id = userHouse['user_id'];
        house_id = userHouse['house_id'];
        seat_id = userHouse['seat_id'];
    } else if(!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)) {
        //iOS端调取默认信息
        userHouse = CustomJS.userHouse();
        user_id = userHouse['user_id'];
        house_id = userHouse['house_id'];
        seat_id = userHouse['seat_id'];
    }
    return userInfo;
}


/*阻止冒泡*/
function stopBubble(e) {
    if ( e && e.stopPropagation )
        e.stopPropagation();
    else
        window.event.cancelBubble = true;
}
$(function(){
// 点击闸机
    $('.sluice .btn').on('click', function () {
        $(this).parent().siblings().children('.btn').removeClass('active');
        $(this).addClass('active');
    });

// 点击电梯
    $('.elevator .btn').on('click', function () {
        $(this).addClass('active');
        $('.floor').removeClass('hide');
    });



});
