<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '房屋租赁记录';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
	<h1><?=$this->title?></h1>
	<p>
		<a class="btn btn-success" href="<?=Url::to(['house-lease/add-report'])?>">新增记录</a>
	</p>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">项目</th>
				<th style="text-align: center;">房间号</th>
				<th style="text-align: center;">类型</th>
				<th style="text-align: center;">面积</th>
				<th style="text-align: center;">佣金</th>
				<th style="text-align: center;">添加时间</th>
				<th style="text-align: center;">添加人</th>
				<th style="text-align: center; width: 200px;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if($list): ?>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td><?=$v['report_id']?></td>
					<td><?=$v['house_name'].'-'.$v['seat_name']?></td>
					<td><?=$v['room_num']?></td>
					<td><?=$v['house_type'] == 1 ? '写字楼' : ($v['house_type'] == 2 ? '商铺' : '公寓')?></td>
					<td><?=$v['space']?></td>
					<td><?=$v['get_money']?></td>
					<td><?=date('Y-m-d H:i',$v['add_time'])?></td>
					<td><?=$v['true_name']?></td>
					<td>
						<?php if ($adminid == $v['add_user']): ?>
							<a href="/admin/house-lease/add-report?id=<?=$v['report_id']?>">编辑</a> &nbsp;&nbsp;
							<a href="javascript:void(0);" onclick="doDel(<?=$v['report_id']?>)">删除</a> &nbsp;&nbsp;
						<?php endif ?>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="12">暂无相关数据</td>
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
				url:'/admin/house-lease/ajax-do-del-report',
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