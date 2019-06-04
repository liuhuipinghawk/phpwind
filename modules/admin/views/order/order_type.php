<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '区域维修类型列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
	<h1><?=$this->title ?></h1>	
	<p>
		<a class="btn btn-success" href="<?=Url::to(['order/add-order-type'])?>">新增</a>
	</p>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>   
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">维修区域</th>
				<th style="text-align: center;">维修类型</th>
				<th style="text-align: center;">备注</th>
				<th style="text-align: center;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if($list):?>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td><?=$v['id']?></td>
					<td style="text-align: left;"><?=$v['type_name']?></td>
					<td style="text-align: left;"></td>
					<td style="text-align: left;"><?=$v['remark'] ? $v['remark'] : '--'?></td>
					<td>
						<a href="<?=Url::to(['order/add-order-type','id'=>$v['id']])?>" title="编辑">编辑</a>&nbsp;&nbsp;
					</td>
				</tr>
				<?php if ($v['child']): ?>
					<?php foreach ($v['child'] as $kk => $vv): ?>
						<tr>
							<td><?=$vv['id']?></td>
							<td style="text-align: left;">--</td>
							<td style="text-align: left;"><?=$vv['type_name']?></td>
							<td style="text-align: left;"><?=$vv['remark'] ? $vv['remark'] : '--'?></td>
							<td>
								<a href="<?=Url::to(['order/add-order-type','id'=>$vv['id']])?>" title="编辑">编辑</a>&nbsp;&nbsp;
							</td>
						</tr>
					<?php endforeach ?>
				<?php endif ?>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="5">暂无数据</td>
				</tr>
			<?php endif;?>
		</tbody>
	</table>
</div>

<?=Html::jsFile('@web/js/jquery-1.12.4.js')?>

<script type="text/javascript">
	function doDel(order_id)
	{
		if (confirm("确定要删除订单吗？删除之后订单将不可恢复！！！")) {
			$.ajax({
				type:'post',
				dataType:'json',
				url:'/index.php?r=admin/order/ajax-order-del',
				data:{
					order_id:order_id
				},
				success:function(res){
					if (res.code == 200) {
						alert(res.msg);
						location.reload();
					} else {
						alert(res.msg);
						return false;
					}
				}
			});
		}
	}

</script>




