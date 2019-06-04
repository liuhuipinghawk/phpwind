<?php 
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '新增';
if ($model) {
	$this->title = '修改';
};

$this->params['breadcrumbs'][] = ['label' => '区域维修类型列表', 'url' => ['order/order-type']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div>
	<h3><?php echo $this->title; ?></h3>
	<form class="form-horizontal">
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">选择区域</label>
            <div class="col-sm-6">
                <select class="form-control" id="parent_id" name="parent_id">
                	<option value="">=选择区域=</option>
                	<?php if ($type): ?>
                		<?php foreach ($type as $k => $v): ?>
                			<option value="<?=$v['id']?>" <?php if ($v['id'] == $model['parent_id']) echo 'selected'; ?>><?=$v['type_name']?></option>
                		<?php endforeach ?>
                	<?php endif ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">类型名称</label>
            <div class="col-sm-6">
                <input type="text" name="type_name" id="type_name" class="form-control" value="<?=$model['type_name']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">备注</label>
            <div class="col-sm-6">
                <input type="text" name="remark" id="remark" class="form-control" value="<?=$model['remark']?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <input type="hidden" id="id" name="id" value="<?php echo $model['id']; ?>">
                <button type="button" class="btn btn-default btn_submit">提交</button>
            </div>
        </div>
    </form>
</div>

<?=Html::jsFile('/js/jquery-1.12.4.js')?>

<script type="text/javascript">
	$(function(){
		$('.btn_submit').click(function(){
			var id = $('#id').val();
			var parent_id = $('#parent_id').val();
			var type_name = $('#type_name').val();
			var remark = $('#remark').val();
			if (type_name == undefined || type_name.length == 0) {
				alert('类型名称不能为空');return false;
			}
			$.ajax({
				type:'post',
				dataType:'json',
				url:'/admin/order/ajax-add-order-type',
				data:{
					id:id,
					parent_id:parent_id,
					type_name:type_name,
					remark:remark
				},
				success:function(res){
					if (res.code == 200) {
						alert(res.msg);
						location.href = '/admin/order/order-type';
					} else {
						alert(res.msg);return false;
					}
				}
			});
		});
	});
</script>