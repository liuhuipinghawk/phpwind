<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '基础设施管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="width:80%; margin-left: 20px; display: block; float: left;">
	<h1>基础设施管理</h1>
	<p>
		<a class="btn btn-success" href="<?=Url::to(['hotel/add-facilities'])?>">新增基础设施</a>
	</p>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">所属类型</th>
				<th style="text-align: center;">图标</th>
				<th style="text-align: center;">名称</th>
				<th style="text-align: center;">添加时间</th>
				<th style="text-align: center;">状态</th>
				<th style="text-align: center; width: 150px;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if($list): ?>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td><?= Html::encode("{$v['faci_id']}") ?></td>
					<td><?php if($v['faci_type'] == 1) echo '酒店'; elseif($v['faci_type'] == 2) echo '餐饮';?></td>
					<td><img src="<?php echo $v['faci_icon']; ?>"></td>
					<td><?= Html::encode("{$v['faci_name']}") ?></td>
					<td><?php echo date('Y-m-d H:i:s',$v['add_time']); ?></td>
					<td>
						<?php 
							if ($v['state'] == 1) {
								echo '启用';
							} else if ($v['state'] == 2) {
								echo '禁用';
							}
						?>
					</td>
					<td style="width: 150px;">
						<?php if($v['state'] == 2): ?>
						<a href="<?=Url::to(['hotel/add-facilities','id'=>$v['faci_id']])?>" title="编辑">编辑</a>&nbsp;&nbsp;
						<a href="javascript:void(0);" title="启用" onclick="upState(<?=$v['faci_id']?>,1,'启用')">启用</a>&nbsp;&nbsp;
						<a href="javascript:void(0);" title="删除" onclick="upState(<?=$v['faci_id']?>,-1,'删除')">删除</a>&nbsp;&nbsp;
						<?php endif; ?>

						<?php if($v['state'] == 1): ?>
						<a href="javascript:void(0);" title="禁用" onclick="upState(<?=$v['faci_id']?>,2,'禁用')">禁用</a>&nbsp;&nbsp;
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="7">暂无相关数据</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<script>
	function upState(id,state,tag){
		if (id == undefined || id.length == 0) {
			alert('参数错误');
			return false;
		}
		if (state == undefined || state.length == 0 || (state != 1 && state != 2 && state != -1)) {
			alert('参数错误');
			return false;
		}
		if (confirm('确定要进行'+tag+'操作吗？')) {
			$.post("<?=Url::to(['hotel/ajax-upstate-facilities'])?>",{
				id:id,
				state:state
			},function(res){
				if (res.code == 200) {
					alert('操作成功');
					location.reload();
				} else {
					alert(res.msg);
					return false;
				}
			},"JSON");
		}
		
	}
</script>