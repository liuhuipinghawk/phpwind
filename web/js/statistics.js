// 选择其他项目
$(".project-menu .other").on("click", function () {
    $(this).parents('.project-menu').siblings('.project-list').removeClass('active-show');
    $(this).addClass('active').siblings().removeClass('active');
    $(this).parents('.select-cont').siblings('.data-total-project').addClass('active-show');
    $(this).parents('.select-cont').siblings('.data-table').find('.tab-total').addClass('active-show');
    $(this).parents('.select-cont').siblings('.data-table').find('.tab-every').removeClass('active-show');

    // 房屋动态统计车位
    $(this).parents('.select-cont').siblings('.dynamic-cont').find('.tab-total').addClass('active-show');
    $(this).parents('.select-cont').siblings('.dynamic-cont').find('.tab-every').removeClass('active-show');

});
// 选择全部项目
$(".project-menu .default").on("click", function () {
    $(this).parents('.project-menu').siblings('.project-list').addClass('active-show');
    $(this).addClass('active').siblings().removeClass('active');
    $(this).parents('.select-cont').siblings('.data-total-project').removeClass('active-show');
    $(this).parents('.select-cont').siblings('.data-table').find('.tab-total').removeClass('active-show');
    $(this).parents('.select-cont').siblings('.data-table').find('.tab-every').addClass('active-show');

    // 房屋动态统计车位
    $(this).parents('.select-cont').siblings('.dynamic-cont').find('.tab-total').removeClass('active-show');
    $(this).parents('.select-cont').siblings('.dynamic-cont').find('.tab-every').addClass('active-show');
});
// 清除日历显示
$(".ul-select li").on("click", function () {
    $(this).parents('.ul-select').siblings('.time-select').addClass('active-show');
    $(this).addClass("active").siblings("li").removeClass("active");
});
// 点击其他日期选择日历展示
$(".ul-select li.time-btn").on("click", function () {
    $(this).parents('.ul-select').siblings('.time-select').removeClass('active-show');
    $(this).siblings('.default').removeClass('active');
});
$(".form_datetime").on("click", function () {
    $(this).parents('.time-select').siblings('.ul-select').children(".time-btn").addClass("active");
});
if($('.ul-select .default').hasClass('active')){
    $(".tab-total").removeClass('active-show');
    $(".tab-every").addClass('active-show');
}
if($('.ul-select .other').hasClass('active')){
    $(".tab-total").addClass('active-show');
    $(".tab-every").removeClass('active-show');
    $('.project-list').removeClass('active-show');

}
// 确定筛选
$(".select-btn .btn-select").on("click", function () {
    if ($(this).parents('.select-btn').siblings('.project-menu').find('.other').hasClass('active')){
        $(this).parents('.select-btn').siblings('.project-list').removeClass('active-show');
    }
});

// 取消筛选
$(".select-btn .btn-cancel").on("click", function () {
    $(this).parents('.select-btn').siblings('.select-list.project-list').addClass('active-show');
    $(this).parents('.select-btn').siblings('.select-list').find(".ul-select li").removeClass("active");
    $(this).parents('.select-btn').siblings('.select-list').find(".ul-select .default").addClass("active");
    $(this).parents('.select-btn').siblings('.select-list').find(".time-select").addClass("active-show");
});

// 房屋动态租赁
$(".tab14").on("click", function () {
    $(".house-data-table-bg").addClass('active-show');
    $(".house-data-table").addClass('active-show');
});
$(".tab11, .tab12, .tab13").on("click", function () {
    $(".house-data-table-bg").removeClass('active-show');
    $(".house-data-table").removeClass('active-show');
});


$("#datetimeStart").datetimepicker({
    format: 'yyyy/mm/dd',
    minView:'month',
    language: 'zh-CN',
    autoclose:true,
    // startDate:new Date()
}).on("click",function(){
    $("#datetimeStart").datetimepicker("setEndDate",$("#datetimeEnd").val())
});
$("#datetimeEnd").datetimepicker({
    format: 'yyyy/mm/dd',
    minView:'month',
    language: 'zh-CN',
    autoclose:true,
    // startDate:new Date()
}).on("click",function(){
    $("#datetimeEnd").datetimepicker("setStartDate",$("#datetimeStart".val()))
});



// 兼容性判断
var liWidth = $(".data-echarts li").width();
if(liWidth < 310){
    $(".data-echarts li").removeClass();
    $(".data-echarts li").addClass('limit-width7');
}
if(liWidth < 290){
    $(".data-echarts li").removeClass();
    $(".data-echarts li").addClass('limit-width6');
}
if(liWidth < 270){
    $(".data-echarts li").removeClass();
    $(".data-echarts li").addClass('limit-width5');
}
if(liWidth < 250){
    $(".data-echarts li").removeClass();
    $(".data-echarts li").addClass('limit-width4');
}
if(liWidth < 230){
    $(".data-echarts li").removeClass();
    $(".data-echarts li").addClass('limit-width3');
}
if(liWidth < 210){
    $(".data-echarts li").removeClass();
    $(".data-echarts li").addClass('limit-width2');
}
if(liWidth < 190){
    $(".data-echarts li").removeClass();
    $(".data-echarts li").addClass('limit-width1');
}
if(liWidth < 170){
    $(".data-echarts li").removeClass();
    $(".data-echarts li").addClass('limit-width0');
}


// 数据字体控制
var clientWidth = document.body.clientWidth;
if (clientWidth < 1600){
    //房屋租赁--水费--停车缴费--电费统计/房屋动态(装修办理)--房屋动态(动态汇总)--房屋动态(交付率)/房屋动态(交房汇总)
    $(".lease-echarts li, .water-echarts li, .parking-echarts li, .electric-echarts li, .dynamic-echarts li, .charge-echarts li, .apartment-echarts li, .intersect-echarts li").removeClass();
    $(".lease-echarts li, .water-echarts li, .parking-echarts li, .electric-echarts li, .dynamic-echarts li, .charge-echarts li, .apartment-echarts li, .intersect-echarts li").addClass('limit-width5');
}
if (clientWidth < 1440){
    //房屋租赁--水费--停车缴费--电费统计/房屋动态(装修办理)--房屋动态(动态汇总)--房屋动态(交付率)/房屋动态(交房汇总)
    $(".lease-echarts li, .water-echarts li, .parking-echarts li, .electric-echarts li, .dynamic-echarts li, .charge-echarts li, .apartment-echarts li, .intersect-echarts li").removeClass();
    $(".lease-echarts li, .water-echarts li, .parking-echarts li, .electric-echarts li, .dynamic-echarts li, .charge-echarts li, .apartment-echarts li, .intersect-echarts li").addClass('limit-width4');
}
if (clientWidth < 1366){
    //房屋租赁--水费--停车缴费--电费统计/房屋动态(装修办理)--房屋动态(动态汇总)--房屋动态(交付率)/房屋动态(交房汇总)
    $(".lease-echarts li, .water-echarts li, .parking-echarts li, .electric-echarts li, .dynamic-echarts li, .charge-echarts li, .apartment-echarts li, .intersect-echarts li").removeClass();
    $(".lease-echarts li, .water-echarts li, .parking-echarts li, .electric-echarts li, .dynamic-echarts li, .charge-echarts li, .apartment-echarts li, .intersect-echarts li").addClass('limit-width3');
}
if (clientWidth < 1280){
    //房屋租赁--水费--停车缴费--电费统计/房屋动态(装修办理)--房屋动态(动态汇总)--房屋动态(交付率)/房屋动态(交房汇总)
    $(".lease-echarts li, .water-echarts li, .parking-echarts li, .electric-echarts li, .dynamic-echarts li, .charge-echarts li, .apartment-echarts li, .intersect-echarts li").removeClass();
    $(".lease-echarts li, .water-echarts li, .parking-echarts li, .electric-echarts li, .dynamic-echarts li, .charge-echarts li, .apartment-echarts li, .intersect-echarts li").addClass('limit-width2');
}
if (clientWidth < 1024){
    //房屋租赁--水费--停车缴费--电费统计/房屋动态(装修办理)--房屋动态(动态汇总)--房屋动态(交付率)/房屋动态(交房汇总)
    $(".lease-echarts li, .water-echarts li, .parking-echarts li, .electric-echarts li, .dynamic-echarts li, .charge-echarts li, .apartment-echarts li, .intersect-echarts li").removeClass();
    $(".lease-echarts li, .water-echarts li, .parking-echarts li, .electric-echarts li, .dynamic-echarts li, .charge-echarts li, .apartment-echarts li, .intersect-echarts li").addClass('limit-width1');
}
if (clientWidth < 960){
    //房屋租赁--水费--停车缴费--电费统计/房屋动态(装修办理)--房屋动态(动态汇总)--房屋动态(交付率)/房屋动态(交房汇总)
    $(".lease-echarts li, .water-echarts li, .parking-echarts li, .electric-echarts li, .dynamic-echarts li, .charge-echarts li, .apartment-echarts li, .intersect-echarts li").removeClass();
    $(".lease-echarts li, .water-echarts li, .parking-echarts li, .electric-echarts li, .dynamic-echarts li, .charge-echarts li, .apartment-echarts li, .intersect-echarts li").addClass('limit-width0');
}




