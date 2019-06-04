<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '房屋交付收费列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
	<h1><?=$this->title?></h1>
	<p>
		<a class="btn btn-success" href="<?=Url::to(['house-data/add-house-charge'])?>">新增数据</a>
	</p>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">项目</th>
				<th style="text-align: center;">应收金额</th>
				<th style="text-align: center;">已收金额</th>
				<th style="text-align: center;">当前收取金额</th>
				<th style="text-align: center;">未收取金额</th>
				<th style="text-align: center;">金额收费率</th>
				<th style="text-align: center;">应收户数</th>
				<th style="text-align: center;">已收户数</th>
				<th style="text-align: center;">当前收取户数</th>
				<th style="text-align: center;">未收户数</th>
				<th style="text-align: center;">户数收费率</th>
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
					<td><?=$v['house_name'].'-'.$v['seat_name'].'-'.($v['house_type'] == 1 ? '写字楼' : ($v['house_type'] == 2 ? '商铺' : ($v['house_type'] == 3 ? '公寓' : ($v['house_type'] == 4 ? '停车位' : ($v['house_type'] == 5 ? '储藏间' : '其他'))))) ?></td>
					<td><?=$v['total_money']?></td>
					<td><?=$v['get_money']?></td>
					<td><?=$v['current_money']?></td>
					<td><?=$v['unget_money']?></td>
					<td><?=$v['total_money'] == '0.00' ? '--' : round(($v['get_money']/$v['total_money'])*100,2)?>%</td>
					<td><?=$v['total_nums']?></td>
					<td><?=$v['get_nums']?></td>
					<td><?=$v['current_nums']?></td>
					<td><?=$v['unget_nums']?></td>
					<td><?=empty($v['total_nums']) ? '--' : round(($v['get_nums']/$v['total_nums'])*100,2)?>%</td>
					<td><?=date('Y-m-d H:i',$v['add_time'])?></td>
					<td><?php if($v['edit_time']) echo date('Y-m-d H:i:s',$v['edit_time']); else echo '--'; ?></td>
					<td><?=$v['true_name']?></td>
					<td>
						<a href="/admin/house-data/add-house-charge?id=<?=$v['id']?>">编辑</a> &nbsp;&nbsp;
						<a href="javascript:void(0);" onclick="doDel(<?=$v['id']?>)">删除</a> &nbsp;&nbsp;
					</td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="15">暂无相关数据</td>
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
				url:'/admin/house-data/ajax-do-del-charge',
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