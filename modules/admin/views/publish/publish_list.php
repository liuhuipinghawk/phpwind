<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '房屋租赁';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
	<h1><?=$this->title ?></h1>	
	<form class="form-inline" action="/admin/publish/index">
		<?php 
			$house_id  = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
			$house_type  = empty(Yii::$app->request->get()['house_type']) ? '' : Yii::$app->request->get()['house_type'];	
			$house_ids = Yii::$app->session['admin']['house_ids'];
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
			<select class="form-control" id="house_type" name="house_type">
				<option value="">请选择类型</option>
				<option value="1" <?php if($house_type == 1) echo 'selected';?>>写字楼</option>
				<option value="2" <?php if($house_type == 2) echo 'selected';?>>公寓</option>
				<option value="3" <?php if($house_type == 3) echo 'selected';?>>商铺</option>
			</select>
		</div>
		<button type="submit" class="btn btn-default">查询</button>
	</form>
	<br>
	<p>
		<a href="/admin/publish/publish" class="btn btn-success">发布房源</a>
	</p>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>   
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">项目</th>
				<th style="text-align: center;">房源类型</th>
				<th style="text-align: center;">区域</th>
				<th style="text-align: center;">地铁</th>
				<th style="text-align: center;">面积</th>
				<th style="text-align: center;">价格</th>
				<th style="text-align: center;">添加时间</th>
				<th style="text-align: center;">状态</th>
				<th style="text-align: center; width: 150px;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if($list):?>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td><?=$v['publish_id'] ?></td>
					<td><?=$v['house_name'] ?></td>
					<td><?=$v['house_type'] == 1 ? '写字楼' : ($v['house_type'] == 2 ? '公寓' : '商铺') ?></td>
					<td><?=$v['region_pname'] ?>-<?=$v['region_name'] ?></td>
					<td><?=$v['subway_pname'] ?>-<?=$v['subway_name'] ?></td>
					<td><?=$v['space'] ?>㎡</td>
					<td><?=$v['price'] ?><?=$v['unit'] ?></td>
					<td><?php echo date('Y-m-d H:i',$v['publish_time']); ?></td>
					<td><?=$v['status'] == 1 ? '上架' : '下架'; ?></td>
					<td>
						<?php if ($v['status'] == 1): ?>
							<a href="javascript:void(0);" onclick="doUpstatus(<?=$v['publish_id']?>,2)">下架</a>
						<?php else: ?>
							<a href="/admin/publish/publish?id=<?=$v['publish_id']?>">编辑</a>
							<a href="javascript:void(0);" onclick="doUpstatus(<?=$v['publish_id']?>,1)">上架</a>
							<a href="javascript:void(0);" onclick="doDel(<?=$v['publish_id']?>)">删除</a>
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
				url:'/admin/publish/do-del-publish',
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
				url:'/admin/publish/do-upstatus-publish',
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




