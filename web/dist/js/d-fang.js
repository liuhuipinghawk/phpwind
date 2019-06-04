var div = document.getElementById('container');
// 底部基础信息3D路径
$(document).on('click', '.bas-desc-list', function (e) {
    $(this).addClass('active').siblings().removeClass('active');
    $(this).parents('.bas-desc').siblings('.room-list').addClass('swiper-room');
    $(this).parents('.bas-desc').siblings().find('.room-swiper').removeClass('active');
    // e.stopPropagation();
    e.preventDefault();
    var imgsrc = $(this).children('.d-house').attr("src");
    var PSV = new PhotoSphereViewer({
        panorama: imgsrc,
        container: div,
        size: {
            width: '100%',
            height: screen.availHeight
        },
        theta_offset: 1000,   //旋转速度
        time_anim: 3000,
        loading_msg: '加载中……'
    });
});
$(document).on('click', '.bas-desc-list:last-child', function (e) {
    $(this).parents('.bas-desc').siblings().removeClass('swiper-room');
    $(this).siblings().removeClass('active');
    e.preventDefault();
});

// 房源3D路径
$(document).on('click', '.room-swiper', function (e) {
    $(this).addClass('active').siblings().removeClass('active');
    e.preventDefault();
    var imgsrc = $(this).children('.d-house').attr("src");
    var PSV = new PhotoSphereViewer({
        panorama: imgsrc,
        container: div,
        time_anim: 3000,
        loading_msg: '加载中……'
    });
});
