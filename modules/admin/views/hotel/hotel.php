<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '酒店列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
	.hotel_img img{max-height: 100px;}
</style>

<div style="width:80%; margin-left: 20px; display: block; float: left;">
	<h1><?=$this->title?></h1>
	<p>
		<a class="btn btn-success" href="<?=Url::to(['hotel/add-hotel'])?>">新增酒店信息</a>
	</p>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">酒店名称</th>
				<th style="text-align: center;">酒店主图</th>
				<th style="text-align: center;">所属楼盘</th>
				<th style="text-align: center;">酒店品牌</th>
				<th style="text-align: center;">酒店星级</th>
				<th style="text-align: center;">添加时间</th>
				<th style="text-align: center;">审核状态</th>
				<th style="text-align: center;">状态</th>
				<th style="text-align: center; width: 200px;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if($list): ?>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td><?=$v['hotel_id'] ?></td>
					<td><?=$v['hotel_name'] ?></td>
					<td class="hotel_img"><img src="<?=$v['hotel_img'] ?>"></td>
					<td><?=$v['house_name'] ?></td>
					<td><?=$v['brand_name'] ?></td>
					<td>
						<?php
							if ($v['hotel_star'] == 1) {
								echo '经济型';
							} elseif ($v['hotel_star'] == 2) {
								echo '舒适/三星';
							} elseif ($v['hotel_star'] == 3) {
								echo '高档/四星';
							} elseif ($v['hotel_star'] == 4) {
								echo '豪华/五星';
							}
						?>					 	
					 </td>
					<td><?php echo date('Y-m-d H:i:s',$v['add_time']); ?></td>
					<td>
						<?php 
							if ($v['audit_state'] == 0) {
								echo '待审核';
							} else if ($v['audit_state'] == 1) {
								echo '审核通过';
							} else if ($v['audit_state'] == 2) {
								echo '审核失败';
							}
						?>
					</td>
					<td>
						<?php 
							if ($v['state'] == 1) {
								echo '上架';
							} else if ($v['state'] == 2) {
								echo '下架';
							}
						?>
					</td>
					<td style="width: 200px;">
						<?php if($v['state'] == 2): ?>
						<a href="<?=Url::to(['hotel/add-hotel','id'=>$v['hotel_id']])?>" title="编辑">编辑</a>&nbsp;&nbsp;
						<a href="javascript:void(0);" title="上架" onclick="upState(<?=$v['hotel_id']?>,'state',1)">上架</a>&nbsp;&nbsp;
						<a href="javascript:void(0);" title="删除" onclick="upState(<?=$v['hotel_id']?>,'del',-1)">删除</a>&nbsp;&nbsp;
						<br>
						<a href="<?=Url::to(['hotel/rooms','hotel_id'=>$v['hotel_id']])?>" title="客房管理">客房管理</a>&nbsp;&nbsp;
						<?php endif; ?>

						<?php if($v['state'] == 1): ?>
						<a href="javascript:void(0);" title="下架" onclick="upState(<?=$v['hotel_id']?>,'state',2)">下架</a>&nbsp;&nbsp;
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="10">暂无相关数据</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>

	<div class="pagination-part">
	    <nav>
		<?php
			echo LinkPager::widget([
			    'pagination' => $pagination,
			]);
		?>
		</nav>
	</div>
</div>

<script>
	function upState(hotel_id,tag,state){
		if (hotel_id == undefined || hotel_id.length == 0 || hotel_id < 1) {
			alert('参数错误');return false;
		}
		if (tag != 'state' && tag != 'del') {
			alert('参数错误');return false;
		}
		if (state != 1 && state != 2 && state != -1) {
			alert('参数错误');return false;
		}
		var str = '确定要进行删除操作吗';
		if (tag == 'state' && state == 1) {
			str = '确定要进行上架操作吗';
		}		
		if (tag == 'state' && state == 2) {
			str = '确定要进行下架操作吗';
		}
		if (confirm(str)) {
			$.post("<?=Url::to(['hotel/ajax-upstate-hotel'])?>",{
				hotel_id:hotel_id,
				tag:tag,
				state:state
			},function(res){
				if (res.code == 200) {
					alert('操作成功');
					location.reload();
				} else {
					alert(res.msg);return false;
				}
			},"JSON");
		}
	}
</script>