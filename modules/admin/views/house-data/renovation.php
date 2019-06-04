<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '装修办理列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
	<h1><?=$this->title?></h1>
	<p>
		<a class="btn btn-success" href="<?=Url::to(['house-data/add-renovation'])?>">新增数据</a>
	</p>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">项目</th>
				<th style="text-align: center;">已办理装修户数</th>
				<th style="text-align: center;">已验收户数</th>
				<th style="text-align: center;">已退保证金户数</th>
				<th style="text-align: center;">正在装修户数</th>
				<th style="text-align: center;">当前申请装修户数</th>
				<th style="text-align: center;">装修率</th>
				<th style="text-align: center;">添加时间</th>
				<th style="text-align: center;">修改时间</th>
				<th style="text-align: center;">添加人</th>
				<th style="text-align: center; width: 200px;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if($list): ?>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td><?=$v['id']?></td>
					<td><?=$v['house_name'].'-'.$v['seat_name'].'-'.($v['house_type'] == 1 ? '写字楼' : ($v['house_type'] == 2 ? '商铺' : '公寓')) ?></td>
					<td><?=$v['renovation_nums']?></td>
					<td><?=$v['check_nums']?></td>
					<td><?=$v['return_nums']?></td>
					<td><?=$v['nowing_nums']?></td>
					<td><?=$v['current_nums']?></td>
					<td><?=$v['zxl']?></td>
					<td><?=date('Y-m-d H:i',$v['add_time'])?></td>
					<td><?php if($v['edit_time']) echo date('Y-m-d H:i:s',$v['edit_time']); else echo '--'; ?></td>
					<td><?=$v['true_name']?></td>
					<td>
						<a href="/admin/house-data/add-renovation?id=<?=$v['id']?>">编辑</a> &nbsp;&nbsp;
						<a href="javascript:void(0);" onclick="doDel(<?=$v['id']?>)">删除</a> &nbsp;&nbsp;
					</td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="11">暂无相关数据</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
	<?php
		echo LinkPager::widget([
		    'pagination' => $pagination,
		]);
	?>
</div>

<script type="text/javascript">
	function doDel(id)
	{
		if (confirm('确定要删除吗?')) {
			if (id == undefined || parseInt(id) == 0) {
				alert('参数错误');return false;
			}
			$.ajax({
				type:'post',
				dataType:'json',
				url:'/admin/house-data/ajax-do-del-renovation',
				data:{
					id:id
				},
				success:function(res){
					if (res.code == 200) {
						alert(res.msg);
						location.reload();
					} else {
						alert(res.msg);return false;
					}
				}
			});
		}
	}
</script>