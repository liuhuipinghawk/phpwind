<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '生活服务预约订单';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
	<h1><?=$this->title ?></h1>
	<form class="form-inline" action="">
		<?php 
			$person_name = empty(Yii::$app->request->get()['person_name']) ? '' : Yii::$app->request->get()['person_name'];
			$person_tel = empty(Yii::$app->request->get()['person_tel']) ? '' : Yii::$app->request->get()['person_tel'];
			$order_type = empty(Yii::$app->request->get()['order_type']) ? 0 : Yii::$app->request->get()['order_type'];
			$state      = empty(Yii::$app->request->get()['state']) ? 0 : Yii::$app->request->get()['state'];
		?>
		<div class="form-group">
			<input type="text" class="form-control" id="person_name" name="person_name" placeholder="请输入联系人" value="<?=$person_name?>">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" id="person_tel" name="person_tel" placeholder="请输入联系方式" value="<?=$person_tel?>">
		</div>
		<div class="form-group">
			<select class="form-control" name="order_type" id="order_type">
				<option value="">请选择服务类型</option>
				<option value="1" <?php if($order_type == 1) echo 'selected';?>>洗衣服务</option>
				<option value="2" <?php if($order_type == 2) echo 'selected';?>>公司注册</option>
				<option value="3" <?php if($order_type == 3) echo 'selected';?>>直饮水</option>
				<option value="4" <?php if($order_type == 4) echo 'selected';?>>石材养护</option>
				<option value="5" <?php if($order_type == 5) echo 'selected';?>>室内清洁</option>
				<option value="6" <?php if($order_type == 6) echo 'selected';?>>甲醛治理</option>
				<option value="7" <?php if($order_type == 7) echo 'selected';?>>洗车服务</option> 
				<option value="8" <?php if($order_type == 8) echo 'selected';?>>办公设备</option> 
				<option value="9" <?php if($order_type == 9) echo 'selected';?>>办公家具</option> 
				<option value="10" <?php if($order_type == 10) echo 'selected';?>>花卉租赁</option>
                <option value="11" <?php if($order_type == 11) echo 'selected';?>>房屋租赁</option>
				<option value="12" <?php if($order_type == 12) echo 'selected';?>>酒店</option>
				<option value="13" <?php if($order_type == 13) echo 'selected';?>>美食</option>
				<option value="14" <?php if($order_type == 14) echo 'selected';?>>办公家具</option>
				<option value="15" <?php if($order_type == 15) echo 'selected';?>>礼品定制</option>
				<option value="16" <?php if($order_type == 16) echo 'selected';?>>装饰设计</option>
				<option value="17" <?php if($order_type == 17) echo 'selected';?>>代理记账</option>
				<option value="18" <?php if($order_type == 18) echo 'selected';?>>宣传服务</option>
			</select>
		</div>
		<div class="form-group">
			<select class="form-control" name="state" id="state">
				<option value="">状态</option>
				<option value="1" <?php if($state == 1) echo 'selected';?>>等待回访</option>
				<option value="2" <?php if($state == 2) echo 'selected';?>>成功回访</option>
				<option value="3" <?php if($state == 3) echo 'selected';?>>取消预约</option>
			</select>
		</div>
		<button type="submit" class="btn btn-default">查询</button>
	</form>
	<br>	
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">联系人姓名</th>
				<th style="text-align: center;">联系方式</th>
				<th style="text-align: center;">预约类型</th>
				<th style="text-align: center;">预约时间</th>
				<th style="text-align: center;">状态</th>
				<th style="text-align: center; width: 150px;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if($list):?>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td><?=$v['order_id'] ?></td>
					<td><?=$v['person_name'] ?></td>
					<td><?=$v['person_tel'] ?></td>
					<td>
						<?php 
							if($v['order_type'] == 1) echo '洗衣服务'; 
							elseif($v['order_type'] == 2) echo '公司注册'; 
							elseif($v['order_type'] == 3) echo '直饮水'; 
							elseif($v['order_type'] == 4) echo '石材养护'; 
							elseif($v['order_type'] == 5) echo '室内清洁'; 
							elseif($v['order_type'] == 6) echo '甲醛治理'; 
							elseif($v['order_type'] == 7) echo '洗车服务'; 
							elseif($v['order_type'] == 8) echo '办公设备'; 
							elseif($v['order_type'] == 9) echo '办公家具'; 
							elseif($v['order_type'] == 10) echo '花卉租赁';
                            elseif($v['order_type'] == 11) echo '房屋租赁';
							elseif($v['order_type'] == 12) echo '酒店';
							elseif($v['order_type'] == 13) echo '美食';
							elseif($v['order_type'] == 14) echo '办公家具';
							elseif($v['order_type'] == 15) echo '礼品定制';
							elseif($v['order_type'] == 16) echo '装饰设计';
							elseif($v['order_type'] == 17) echo '代理记账';
							elseif($v['order_type'] == 18) echo '宣传服务';
                        ?>
					</td>
					<td><?php if($v['add_time']) echo date('Y-m-d H:i:s',$v['add_time']); else echo '--'; ?></td>
					<td>
						<?php 
							if($v['state'] == 1) echo '等待回访';
							elseif($v['state'] == 2) echo '成功回访';
							elseif($v['state'] == 3) echo '取消预约';
					 	?>
					</td>
					<td style="width: 150px;">
						<?php if($v['state'] == 1): ?>
						<a href="javascript:void(0);" onclick="upState(<?=$v['order_id'] ?>,2)" title="成功回访">成功回访</a>&nbsp;&nbsp;
						<a href="javascript:void(0);" onclick="upState(<?=$v['order_id'] ?>,3)" title="取消预约">取消预约</a>&nbsp;&nbsp;
						<?php endif; ?>
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
	function upState(order_id,state){
		if (order_id == undefined || order_id.length == 0) {
			alert('参数错误');return false;
		}
		if (state == undefined || state.length == 0) {
			alert('参数错误');return false;
		}
		var str = '回访成功';
		if (state == 3) {
			str = '取消订单';
		}
		if (confirm('确定要进行'+str+'操作吗？')) {
			$.post("<?=Url::to(['service/ajax-upstate-service-order']) ?>",{
				order_id:order_id,
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