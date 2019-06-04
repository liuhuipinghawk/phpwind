<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '车位租赁预约订单';
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="width:80%; margin-left: 20px; display: block; float: left;">
	<h1><?=$this->title ?></h1>
    <form class="form-inline" action="">
        <?php
        $person_name = empty(Yii::$app->request->get()['person_name']) ? '' : Yii::$app->request->get()['person_name'];
        $person_tel = empty(Yii::$app->request->get()['person_tel']) ? '' : Yii::$app->request->get()['person_tel'];
        $state      = empty(Yii::$app->request->get()['state']) ? 0 : Yii::$app->request->get()['state'];
        ?>
        <div class="form-group">
            <input type="text" class="form-control" id="person_name" name="person_name" placeholder="请输入联系人" value="<?=$person_name?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="person_tel" name="person_tel" placeholder="请输入联系方式" value="<?=$person_tel?>">
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
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">楼盘信息</th>
				<th style="text-align: center;">联系人信息</th>
				<th style="text-align: center;">租赁时间</th>
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
					<td><?php echo $v['house_name'].'-<br/>'.$v['seat_name'].'-<br/>'.$v['floor']; ?></td>
					<td><?php echo $v['person_name'].'<br/>tel：'.$v['person_tel']; ?></td>
					<td><?=$v['order_type'] ?></td>
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
			$.post("<?=Url::to(['service/ajax-upstate-carport']) ?>",{
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


