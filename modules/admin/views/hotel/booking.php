<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '酒店预定列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="width:80%; margin-left: 20px; display: block; float: left;">
	<h1><?=$this->title ?></h1>
	
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>
				<th style="text-align: center;">预定ID</th>
				<th style="text-align: center;">酒店名称</th>
				<th style="text-align: center;">客房名称</th>
				<th style="text-align: center;">入住日期</th>
				<th style="text-align: center;">入住人信息</th>
				<th style="text-align: center;">房间数</th>
				<th style="text-align: center;">客房单价</th>
				<th style="text-align: center;">预定总价</th>
				<th style="text-align: center;">酒店电话</th>
				<th style="text-align: center;">预定时间</th>
				<th style="text-align: center;">处理时间</th>
				<th style="text-align: center;">处理人</th>
				<th style="text-align: center;">状态</th>
				<th style="text-align: center;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if($list): ?>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td><?=$v['book_id'] ?></td>
					<td><?=$v['hotel_name'] ?></td>
					<td><?=$v['room_name'] ?></td>
					<td>
						<p><?=$v['in_date'] ?>&nbsp;~&nbsp;<?=$v['out_date'] ?></p>
						<p>(共&nbsp;<?=$v['days'] ?>&nbsp;晚)</p>
					</td>
					<td>
						<p><?=$v['person_name'] ?></p>
						<p><?=$v['person_tel'] ?></p>
					</td>
					<td><?=$v['room_nums']?></td>
					<td><?=$v['price'] ?></td>
					<td><?=$v['total_price'] ?></td>
					<td><?=$v['hotel_tel'] ?></td>
					<td><?php echo date('Y-m-d H:i:s',$v['book_time']); ?></td>
					<td><?php if(empty($v['deal_time'])) echo '--'; else echo date('Y-m-d H:i:s',$v['deal_time']); ?></td>
					<td><?php if(empty($v['adminuser'])) echo '--'; else echo $v['adminuser']; ?></td>
					<td>
						<?php 
							if ($v['state'] == 1) {
								echo '等待预定';
							} else if ($v['state'] == 2) {
								echo '已预订';
							} else if ($v['state'] == 3) {
								echo '已取消';
							} else if ($v['state'] == 4) {
								echo '已评价';
							}
						?>
					</td>
					<td>
						<?php if($v['state'] == 1): ?>
							<a href="javascript:void(0);" onclick="upState(<?=$v['book_id']?>,2)" title="预定成功">预定成功</a>&nbsp;&nbsp;
							<a href="javascript:void(0);" onclick="upState(<?=$v['book_id']?>,3)" title="取消订单">取消订单</a>&nbsp;&nbsp;
						<?php else: ?>
							--
						<?php endif; ?>
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
	function upState(book_id,state){
		if (book_id == undefined || book_id.length == 0) {
			alert('参数错误');return false;
		}
		if (state == undefined || state.length == 0) {
			alert('参数错误');return false;
		}
		if (state != 2 && state != 3) {
			alert('参数错误');return false;
		}
		var str = '预定成功';
		if (state == 3) {
			str = '取消订单';
		}
		if (confirm('确定要进行'+str+'操作吗？')) {
			$.post("<?=Url::to(['hotel/ajax-upstate-booking'])?>",{
				book_id:book_id,
				state:state
			},function(res){
				if (res.code == 200) {
					alert('操作成功');
					location.reload();
				} else {
					alert(res.msg);return false;
				}
			},'JSON');
		}		
	}
</script>