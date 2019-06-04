<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>设备详情</title>
    <?=Html::cssFile('/css/weui.css')?>  
    <?=Html::cssFile('/css/jquery-weui.css')?> 
    <?=Html::cssFile('/layui/css/layui.css')?> 
    <?=Html::cssFile('/css/common.css')?> 
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
    </script>
</head>
<body ontouchstart class="relative">
<div class="wrap">
    <!--主体内容-->
    <div class="app-cont office-detail" id="office-detail">
     
    </div>
    <div class="footer border-top clearfix">
        <img src="/images/phone-office.jpg" width="28" class="pull-left"><span class="pull-left phone phone-office">400-6060-617</span>
        <a href="javascript:void(0);" class="pull-right book-btn btn-office">立即预约</a>
    </div>

</div>
<!--弹出框-->
<div class="book-tip box-content" style="display: none">
    <input type="hidden" id="project_name">
    <input type="hidden" id="price">
    <ul class="book-list">
        <li>
            <input type="text" id="person_name" placeholder="联系人姓名">
        </li>
        <li>
            <input type="text" id="person_tel" placeholder="联系人电话">
        </li>
        <li><p>预约成功后，工作人员会尽快与您确认需求或者拨打客服电话：<span class="text-bluer">400-6060-617</span></p></li>
    </ul>
    <a href="javascript:void(0);" id="btn-book" class="book book-office block font-size-15 text-center">立即预约</a>
</div>
<?=Html::jsFile('/js/jquery-2.1.4.js')?>
<?=Html::jsFile('/js/fastclick.js')?>
<?=Html::jsFile('/js/public.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<script>
	// 弹出框
	layui.use('layer', function() {
        var $ = layui.jquery,
            layer = layui.layer;
        $('.book-btn').click(function () {
        	$('body').addClass('mask-body');
        	// 调取默认用户信息
	        userInfo();	
            layer.open({
                area: '90%'
                ,title: false
                ,resize: false
                ,type: 1
                ,content:$('.book-tip')
                ,cancel: function(){
                    $('body').removeClass('mask-body');
                }
            })
        });
   });
	$(function(){
        FastClick.attach(document.body);
		$.ajax({
			type:"get",
			url:"index.php?r=API/organization-api/list",
			dataType: 'json',
			data: {equipment_id: <?php echo Yii::$app->request->get()['equipment_id']?>},
			success: function(data){
				var office_detail = data.code;
				$('#office-detail').html(
					"<div class=\"office-detail-img text-center\">" +
                        "            <img src='"+ office_detail.thumb +"' class=\"max-width\" alt=\"\"/>" +
                        "        </div>" + 
                        "<div class=\"border-top office-title bg-white padding-cont padding-top padding-bottom\">" +
                        "            <p class=\"title\">"+ office_detail.equipment_name +"</p>" +
                        "            <p class=\"price margin-small-top\">"+ office_detail.price +"/月/台</p>" +
                        "            <p class=\"description text-muted margin-small-top\">"+ office_detail.equipment_desc +"</p>" +
                        "        </div>" + 
                        "<div class=\"office-detail-list margin-top bg-white\">" +
                        "            <p class=\"title\">产品参数</p>" +
                        "            <div class=\"line margin-top\"></div>" +
                        "            <div class=\"padding-cont padding-top\">"+ office_detail.content +"</div>" +
                        "        </div>"
				);
				$('.phone-office').html(office_detail.business_telephone);
                $('.text-bluer').html(office_detail.business_telephone);
                $('#project_name').val(office_detail.equipment_name);
                $('#price').val(office_detail.price);
			}
		});

        //预约
        $('#btn-book').click(function(){
            var persion = $('#person_name').val();
            var tell = $('#person_tel').val();
            var equipment_id = <?php echo Yii::$app->request->get()['equipment_id']?>;
            if (persion == undefined || persion.length == 0) {
                layer.msg('请输入联系人姓名',{time: 2000});
                return false;
            }
            if (tell == undefined || tell.length == 0) {
                layer.msg('请输入联系方式',{time: 2000});
                return false;
            }
            if (!(/^1[3|4|5|7|8][0-9]{9}$/.test(tell))) {
                layer.msg('请输入正确联系方式',{time: 2000});
                return false;
            }
            $.ajax({
                url:'/index.php?r=API/service/service-order',
                type:'post',
                dataType:'json',
                data:{
                	order_type:8,
                    person_name:persion,
                    person_tel:tell,
					type_id: equipment_id
                },
                success:function(res){
                	if (res.status == 205) {
                		layer.msg('用户信息已丢失，请重新登录',{time: 2000});
                        // 重新调取登录接口
                		missLogin();
                    }else if (res.status == 200) {
                        layer.msg('预约成功',{time: 2000});
                        location.reload();
                    } else {
                        layer.msg(res.message,{time: 2000});
                        return false;
                    }
                }
            });
        });
	})
</script>
</body>
</html>