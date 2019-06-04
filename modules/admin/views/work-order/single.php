<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '派单-维修师傅列表';
$this->params['breadcrumbs'][] = ['label' => '订单列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::cssFile('/layout/css/bootstrap.min.css')?>
<?=Html::cssFile('/css/site.css')?>
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<h1><?=$this->title ?></h1>
<br>
<?php
$house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
$repair_name = empty(Yii::$app->request->get()['repair_name']) ? '' : Yii::$app->request->get()['repair_name'];
$op_id = empty(Yii::$app->request->get()['op_id']) ? '' : Yii::$app->request->get()['op_id'];
?>
<div class="container-fluid">
	<form class="form-inline" action="/admin/work-order/single">
		<input type="hidden" name="op_id" value="<?=Yii::$app->request->get()['op_id'] ?>">
		<div class="form-group">
			<select class="form-control" id="house_id" name="house_id">
				<option value="">请选择项目</option>
				<?php foreach ($house as $k => $v): ?>
					<option value="<?=$v['id']?>" <?php if ($v['id']==$house_id) echo 'selected'; ?> ><?=$v['housename']?></option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" id="repair_name" name="repair_name" placeholder="维修师傅姓名" value="<?=$repair_name?>">
		</div>
		<button type="submit" class="btn btn-default">查询</button>
	</form>
	<p>
		<input type="checkbox" name="send_msg" id="send_msg" checked="true">是否发送短信
		<span style="color:red;">注：默认勾选给维修师傅发送短信通知</span>
	</p>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
		<tr>
			<th style="text-align: center;">真实姓名</th>
			<th style="text-align: center;">联系方式</th>
			<th style="text-align: center;">订单量</th>
			<th style="text-align: center; width: 150px;">操作</th>
		</tr>
		</thead>
		<tbody>
		<?php if($repairs):?>
			<?php foreach($repairs as $k => $v): ?>
				<tr>
					<td><?= Html::encode("{$v['TrueName']}") ?></td>
					<td><?= Html::encode("{$v['Tell']}") ?></td>
					<td>
						进行中：<?php echo $v['status3']?>单<br>
						未接单：<?php echo $v['status2']?>单
					</td>
					<td style="width: 150px;">
						<a href="javascript:void(0);" class="confirm" data-uid="<?=$v['id']?>" title="派单">确定派单</a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php else:?>
			<tr><td colspan="4">暂无维修师傅可供选择</td></tr>
		<?php endif;?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$(function(){
		$(".confirm").click(function(){
			if (confirm("确定要进行派单任务吗？")) {
				var order_id = <?=$op_id ?>;
				var user_id = $(this).data("uid");
				if (user_id == undefined || user_id.length == 0) {
					alert("参数错误");
					return false;
				}
				if (order_id == undefined || order_id.length == 0) {
					alert("参数错误");
					return false;
				}
				$.post("<?=Url::to(['work-order/do-single'])?>",{
					'order_id':order_id,
					'user_id':user_id
				},function(res){
					if (res.code == 200) {
						alert(res.msg);
						location.href = '/admin/work-order/index';
					} else {
						alert(res.msg);
						return false;
					}
				},"JSON");
			}
		});
	});
</script>