<?php 
	use yii\helpers\Html;

	$this->title = '修改密码';
	$this->params['breadcrumbs'][] = $this->title;
 ?>

<?=Html::jsFile('/js/jquery-1.12.4.js')?>

<div>
	<h1><?=$this->title ?></h1>
    <form>
        <div class="form-group">
            <input type="password" class="form-control" style="width: 250px;" id="new_password" name="new_password" placeholder="请输入新密码" value="">
        </div>
        <button type="button" id="btn_submit" class="btn btn-default">提交</button>
    </form>
</div>

<script type="text/javascript">
	$(function(){
		$('#btn_submit').click(function(){
			var newpass = $('#new_password').val();
			if (newpass == undefined || newpass.length == 0) {
				alert('请输入新密码');return false;
			}
			$.ajax({
				type:'post',
				dataType:'json',
				url:'/admin/sys/ajax-update-password',
				data:{
					newpass:newpass
				},
				success:function(res){
					if (res.code == 200) {
						alert(res.msg);
					} else {
						alert(res.msg);return false;
					}
				}
			});
		});
	});
</script>

