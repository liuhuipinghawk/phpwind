<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<title>企业申请</title>
		<?=Html::cssFile('css/weui.css')?>
	    <?=Html::cssFile('css/jquery-weui.css')?>
	    <?=Html::cssFile('css/common.css')?>
	    <?=Html::cssFile('css/club.css')?>
	    <?=Html::jsFile('/js/jquery-2.1.4.js')?>
	    <?=Html::jsFile('/js/fastclick.js')?>
	    <?=Html::jsFile('/js/common.js')?>
	    <?=Html::jsFile('/js/jquery-weui.js')?>
	    <?=Html::jsFile('/js/public.js')?>
	    <script>
	        /*设定html字体大小*/
	        var deviceWidth = document.documentElement.clientWidth;
	        if(deviceWidth > 640) deviceWidth = 640;
	        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';
	    </script>
	</head>
	<body>
		<div class="join">
			<div class="weui-cells weui-cells_form">
				<div class="weui-cell">
				    <div class="weui-cell__hd"><label class="weui-label">LOGO</label></div>
				    <div class="weui-cell__bd">
				      	<div class="pull-right" id="logo">
				            <input id="uploaderInput" class="weui-uploader__input" type="file" accept="image/png,image/jpg" multiple="" onchange="upload(this.files)">
				        </div>
				    </div>
				</div>
				<div class="weui-cell">
				    <div class="weui-cell__hd"><label class="weui-label">公司名称</label></div>
				    <div class="weui-cell__bd">
				      	<input id="company" class="weui-input" type="text" placeholder="请输入公司名称" required="required">
				    </div>
				</div>
				<div class="weui-cell">
				    <div class="weui-cell__hd"><label class="weui-label">法人姓名</label></div>
				    <div class="weui-cell__bd">
				      	<input id="name" class="weui-input" type="text" placeholder="请输入法人姓名" required="required">
				    </div>
				</div>
				<div class="weui-cell">
				    <div class="weui-cell__hd"><label class="weui-label">联系电话</label></div>
				    <div class="weui-cell__bd">
				      	<input id="mobile" class="weui-input" type="tel" pattern="[0-9]*" placeholder="请输入联系电话" required="required">
				    </div>
				</div>
				<div class="weui-cell">
				    <div class="weui-cell__hd"><label class="weui-label">详细地址</label></div>
				    <div class="weui-cell__bd">
				      	<input id="address" class="weui-input" type="text" placeholder="请输入详细地址" required="required">
				    </div>
				</div>
			</div>
			<div class="weui-btn-area">
				<a href="javascript:" class="weui-btn weui-btn_primary" id="submit">提交</a>
			</div>
		</div>	
		<script type="text/javascript">
			var user_id=userInfo()['user_id'];
			var image='';
			function upload(files){
				if(files.length){
					var fileObj = files[0];
		            var form = new FormData();
		            form.append("uploadfile", fileObj); 
			        $.ajax({
			        	type:"post",
			        	url:"/index.php?r=API/club/upload",
			        	cache:false,         //不设置缓存
				        processData: false,  // 不处理数据
				        contentType: false,
			        	data:form,
			        	datatype:'json',
			        	success:function(res){
			        		res=JSON.parse(res);
					  		image=res.code;
					  		$('#logo').css({background:'url('+image+') 50% 50%',backgroundSize:'cover'})
			        	},
			        	error:function(res){
			        		console.log(res)
			        	}
			        });
				}
			}
			$('#submit').click(function(){
				var company=$('#company').val();
				var name=$('#name').val();
				var mobile=$('#mobile').val();
				var address=$('#address').val();
				if (image == '' || image.length == 0) {
                    $.alert('请上传LOGO');
                    return;
                }
				else if (company == undefined || company.length == 0) {
                    $.alert('请上传公司名称');
                    return;
                }
                else if (name == undefined || name.length == 0) {
                    $.alert('请上传法人姓名');
                    return;
                }
                else if (mobile == undefined || mobile.length == 0) {
                    $.alert('请上传联系电话');
                    return;
                }
                else if (!(/^1[3|4|5|7|8][0-9]{9}$/.test(mobile))) {
                    $.alert('请上传正确的联系电话');
                    return;
                }
                else if (address == undefined || address.length == 0) {
                    $.alert('请上传详细地址');
                    return;
                }
				$.ajax({
					type:"post",
					url:"/index.php?r=API/club/add",
					data:{
						'user_id':user_id,
						'company':company,
						'name':name,
						'mobile':mobile,
						'address':address,
						'image':image
					},
					success:function(res){
						res=JSON.parse(res);
						console.log(res)
				  		var status=res.status;
						if(status==200){
							$.alert({
								title: '审核中',
								text: '您添加的企业申请信息，客服正在审核中，请耐心等待',
								onOK: function () {
								    window.location='/index.php?r=API/h5/club-index'
								}
							})
						}
						else{
							$.alert({
								title: status,
								text: res.message,
								onOK: function () {
									
								}
							})
						}
					}
				});
			})
			
//			
			
		</script>
	</body>
</html>
