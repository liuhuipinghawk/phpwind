<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '3D看房列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
	<h1><?=$this->title ?></h1>	
	<form class="form-inline" action="/admin/showings/showings-list">
		<?php 
			$house_id  = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
			$type  = empty(Yii::$app->request->get()['type']) ? '' : Yii::$app->request->get()['type'];
			$room_num  = empty(Yii::$app->request->get()['room_num']) ? '' : Yii::$app->request->get()['room_num'];			
			$house_ids = Yii::$app->session['admin']['house_ids'];
			// $group_id = Yii::$app->session['admin']['group_id'];
			$house_arr = empty($house_ids) ? [] : explode(',', $house_ids);
		?>
		<div class="form-group">
			<select class="form-control" id="house_id" name="house_id">
				<option value="">请选择项目</option>
				<?php foreach ($house as $k => $v): ?>
					<?php if (in_array($v['id'],$house_arr)): ?>
						<option value="<?=$v['id']?>" <?php if ($v['id']==$house_id) echo 'selected'; ?>><?=$v['housename']?></option>
					<?php endif ?>
				<?php endforeach ?>
			</select>
		</div>
		<div class="form-group">
			<select class="form-control" id="type" name="type">
				<option value="">请选择类型</option>
				<option value="1" <?php if($type == 1) echo 'selected';?>>大堂</option>
				<option value="2" <?php if($type == 2) echo 'selected';?>>电梯间</option>
				<option value="3" <?php if($type == 3) echo 'selected';?>>走廊</option>
				<option value="4" <?php if($type == 4) echo 'selected';?>>房源</option>
			</select>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" id="room_num" name="room_num" placeholder="请输入房间号" value="<?=$room_num?>">
		</div>
		<button type="submit" class="btn btn-default">查询</button>
	</form>
	<br>
	<p>
		<a href="/admin/showings/add-showings" class="btn btn-success">添加3D看房</a>
	</p>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>   
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">项目</th>
				<th style="text-align: center;">类型</th>
				<th style="text-align: center;">缩略图</th>
				<th style="text-align: center;">房间号</th>
				<th style="text-align: center;">描述</th>
				<th style="text-align: center;">添加时间</th>
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
					<td><?=$v['type_name'] ?></td>
					<td><img src="<?=$v['img_thumb'] ?>" style="height: 100px;"></td>
					<td><?=$v['room_num'] ?></td>
					<td><?=$v['desc'] ?></td>
					<td><?php echo date('Y-m-d H:i',$v['add_time']); ?></td>
					<td><?=$v['status'] == 1 ? '上架' : '下架'; ?></td>
					<td>
						<?php if ($v['status'] == 1): ?>
							<a href="javascript:void(0);" onclick="doUpstatus(<?=$v['id']?>,2)">下架</a>
						<?php else: ?>
							<a href="/admin/showings/add-showings?id=<?=$v['id']?>">编辑</a>
							<a href="javascript:void(0);" onclick="doUpstatus(<?=$v['id']?>,1)">上架</a>
							<a href="javascript:void(0);" onclick="doDel(<?=$v['id']?>)">删除</a>
						<?php endif ?>
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

<?=Html::jsFile('@web/js/jquery-1.12.4.js')?>

<script type="text/javascript">
	/**
	 * 删除操作
	 * @Author   tml
	 * @DateTime 2018-03-23
	 * @param    {[type]}   id [description]
	 * @return   {[type]}      [description]
	 */
	function doDel(id) {
		if (id == 0 || id == '' || id == undefined) {
			alert('参数错误');return false;
		}
		if (confirm('确定要删除吗？')) {
			$.ajax({
				dataType:'json',
				type:'post',
				url:'/admin/showings/do-del-showings',
				data:{
					id:id,
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
	/**
	 * 上下架操作
	 * @Author   tml
	 * @DateTime 2018-03-23
	 * @param    {[type]}   id [description]
	 * @return   {[type]}      [description]
	 */
	function doUpstatus(id,status) {
		if (id == 0 || id == '' || id == undefined) {
			alert('参数错误');return false;
		}
		if (status != 1 && status != 2) {
			alert('参数错误');return false;
		}
		var tag = status == 1 ? '上架' : '下架';
		if (confirm('确定要进行'+ tag +'吗？')) {
			$.ajax({
				dataType:'json',
				type:'post',
				url:'/admin/showings/do-upstatus-showings',
				data:{
					id:id,
					status:status
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




