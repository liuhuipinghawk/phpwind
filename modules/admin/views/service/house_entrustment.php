<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '房屋委托列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
	<h1><?=$this->title ?></h1>
	<form class="form-inline" action="">
		<?php 
			$house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
			$house_type = empty(Yii::$app->request->get()['house_type']) ? 0 : Yii::$app->request->get()['house_type'];
			$person_name = empty(Yii::$app->request->get()['person_name']) ? '' : Yii::$app->request->get()['person_name'];
			$person_tel = empty(Yii::$app->request->get()['person_tel']) ? '' : Yii::$app->request->get()['person_tel'];
			$status = empty(Yii::$app->request->get()['status']) ? 0 : Yii::$app->request->get()['status'];
		?>
		<div class="form-group">
			<select class="form-control" name="house_id" id="house_id">
				<option value="">楼盘</option>
				<?php foreach ($house as $k => $v): ?>
				 	<option value="<?=$v['id']?>" <?php if($v['id'] == $house_id) echo 'selected';?>><?=$v['housename']?></option>
				<?php endforeach ?> 
			</select>
		</div>
		<div class="form-group">
			<select class="form-control" name="house_type" id="house_type">
				<option value="">房屋类型</option>
				<option value="1" <?php if($house_type == 1) echo 'selected';?>>写字楼</option>
				<option value="2" <?php if($house_type == 2) echo 'selected';?>>公寓</option>
				<option value="3" <?php if($house_type == 3) echo 'selected';?>>商铺</option>
			</select>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" id="person_name" name="person_name" placeholder="请输入联系人" value="<?=$person_name?>">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" id="person_tel" name="person_tel" placeholder="请输入联系方式" value="<?=$person_tel?>">
		</div>
		<div class="form-group">
			<select class="form-control" name="status" id="status">
				<option value="">状态</option>
				<option value="1" <?php if($status == 1) echo 'selected';?>>等待回访</option>
				<option value="2" <?php if($status == 2) echo 'selected';?>>成功回访</option>
				<option value="3" <?php if($status == 3) echo 'selected';?>>已取消</option>
			</select>
		</div>
		<button type="submit" class="btn btn-default">查询</button>
	</form>
	<br>	
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">楼盘</th>
				<th style="text-align: center;">房屋类型</th>
				<th style="text-align: center;">房屋面积</th>
				<th style="text-align: center;">地址</th>
				<th style="text-align: center;">联系人姓名</th>
				<th style="text-align: center;">联系方式</th>
				<th style="text-align: center;">预约时间</th>
				<th style="text-align: center;">预约人</th>
				<th style="text-align: center;">处理时间</th>
				<th style="text-align: center;">处理人</th>
				<th style="text-align: center;">状态</th>
				<th style="text-align: center; width: 150px;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if($list):?>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td><?=$v['id'] ?></td>
					<td><?=$v['house_name'] ?></td>
					<td>
						<?php 
							if($v['house_type'] == 1) echo '写字楼'; 
							elseif($v['house_type'] == 2) echo '公寓'; 
							elseif($v['house_type'] == 3) echo '商铺'; 
						?>
					</td>
					<td><?=$v['house_area'] ?></td>
					<td><?=$v['address'] ? $v['address'] : '--' ?></td>
					<td><?=$v['person_name'] ?></td>
					<td><?=$v['person_tel'] ?></td>
					<td><?php if($v['add_time']) echo date('Y-m-d H:i:s',$v['add_time']); else echo '--'; ?></td>
					<td><?=$v['true_name'] ?><br>(<?=$v['mobile']?>)</td>
					<td><?php if($v['deal_time']) echo date('Y-m-d H:i:s',$v['deal_time']); else echo '--'; ?></td>
					<td><?=$v['admin_name'] ? $v['admin_name'] : '--' ?></td>
					<td>
						<?php 
							if($v['status'] == 1) echo '等待回访';
							elseif($v['status'] == 2) echo '成功回访';
							elseif($v['status'] == 3) echo '取消预约';
					 	?>
					</td>
					<td style="width: 150px;">
						<?php if($v['status'] == 1): ?>
						<a href="javascript:void(0);" onclick="upState(<?=$v['id'] ?>,2)" title="成功回访">成功回访</a>&nbsp;&nbsp;
						<a href="javascript:void(0);" onclick="upState(<?=$v['id'] ?>,3)" title="取消预约">取消预约</a>&nbsp;&nbsp;
						<?php endif; ?>
						<a href="javascript:void(0);" onclick="doDelete(<?=$v['id'] ?>)" title="删除">删除</a>&nbsp;&nbsp;
					</td>
				</tr>
				<?php endforeach; ?>
			<?php endif;?>
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
	function upState(id,status){
		if (id == undefined || id.length == 0) {
			alert('参数错误');return false;
		}
		if (status == undefined || status.length == 0) {
			alert('参数错误');return false;
		}
		var str = '回访成功';
		if (status == 3) {
			str = '取消订单';
		}
		if (confirm('确定要进行'+str+'操作吗？')) {
			$.post("<?=Url::to(['service/ajax-upstate-house-entrustment']) ?>",{
				id:id,
				status:status
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

	function doDelete(id){
		if (id == undefined || id.length == 0) {
			alert('参数错误');return false;
		}
		if (confirm('确定要进行删除操作吗？')) {
			$.post("<?=Url::to(['service/ajax-delete-house-entrustment']) ?>",{
				id:id
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