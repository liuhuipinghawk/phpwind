function stopBubble(e){e&&e.stopPropagation?e.stopPropagation():window.event.cancelBubble=!0}window.onresize=function(){var e=document.documentElement.clientWidth;e>640&&(e=640),document.documentElement.style.fontSize=e/6.4+"px"},$(function(){FastClick.attach(document.body),$(".select-list").on("click","a.select-btn",function(){$(".select-list a.select-btn").removeClass("active"),$(this).addClass("active"),$(".select-drop").hide(),$(this).siblings(".img-up").removeClass("active"),$(this).siblings(".img-down").addClass("active"),$(this).parents().siblings().children(".img-up").addClass("active"),$(this).parents().siblings().children(".img-down").removeClass("active"),$(".pro-left-menu").css("transform","translateX(100%)"),$(this).siblings(".select-drop").show(),$(".dropdown-mask").show(),$("body").addClass("mask-body")}),$(".select-list").on("click","a.select-btn-all",function(){$(".select-drop").hide(),$(".img-up").addClass("active"),$(".img-down").removeClass("active"),$(".pro-left-menu").css("transform","translateX(100%)"),$(".dropdown-mask").hide(),$("body").removeClass("mask-body")}),$(".select-drop ul").on("click","li",function(){$(this).addClass("active").siblings().removeClass("active"),$(".select-drop").fadeOut(),$(".dropdown-mask").fadeOut(),$(this).parents(".select-drop").siblings(".img-up").addClass("active"),$(this).parents(".select-drop").siblings(".img-down").removeClass("active"),$("body").removeClass("mask-body")}),$(".pro-left-menu ul").on("click","li",function(){$(this).addClass("active")})}),function(e){var s=function(){};s.prototype.define=function(e){e(function(e,s){amallink_pro[e]=s})},e.amallink_pro=new s}(window),amallink_pro.define(function(e){var s={leftmenu_show:function(){$(".left-mask").stop().fadeIn(100),$(".pro-left-menu").css("transform","translateX(0)"),$("body").addClass("mask-body")},hide_dropdown_mask:function(){$(".pro-left-menu").css("transform","translateX(100%)"),$(".select-drop").slideUp(100),$(".dropdown-mask").fadeOut(100),$(".img-up").addClass("active"),$(".img-down").removeClass("active"),$(".select-pro").removeClass("active"),$("body").removeClass("mask-body")},reset_select:function(){$(this).parents(".bottom-btn").siblings("ul").children("li").removeClass("active")}},t={},n=function(){$("body").on("click","*[amallink-event]",function(e){var t=$(this),n=t.attr("amallink-event");s[n]&&s[n].call(this,t,e)})};n.prototype.on=function(e,s){return"function"==typeof s&&(t[e]?t[e].push(s):t[e]=[s]),this},e("pro_obj",new n)});