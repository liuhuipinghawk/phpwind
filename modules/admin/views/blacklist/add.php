<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '添加黑名单';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::cssFile('/layout/css/bootstrap.min.css')?>
<?=Html::cssFile('/css/site.css')?>
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<br>
<div class="container-fluid">
	<form class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label">手机号</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="phone" name="phone" value="">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">备注</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="remark" name="remark" value="">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">项目</label>
			<div class="col-sm-10">
			<select class="form-control" id="house_id" name="house_id">
				<option value="">选择楼盘</option>
				<?php if (!empty($house)): ?>
					<?php foreach ($house as $k => $v): ?>
						<option value="<?=$v['id'] ?>"><?=$v['housename'] ?></option>
					<?php endforeach ?>
				<?php endif ?>
			</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="button" class="btn btn-success btn-default btn_submit">提交</button>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	$(function(){
		$('.btn_submit').click(function(){
			var phone    = $('#phone').val();
			var remark = $('#remark').val();
			var house_id = $('#house_id').val();
			if (phone == undefined || phone.length == 0) {
				alert('请输入手机号');return false;
			}
			if (house_id == undefined || house_id.length == 0) {
				alert('请选择项目');return false;
			}
			var data = {};
			data.phone    = phone;
			data.remark = remark;
			data.house_id = house_id;
			$.post('/index.php?r=admin/blacklist/do-add',data,function(res){
				if (res.code == 200) {
					alert(res.msg);
					parent.location.reload();
				} else {
					alert(res.msg);
					return false;
				}
			},'JSON');
		});
	});
</script>