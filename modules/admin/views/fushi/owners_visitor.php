<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '业主访客进出记录';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
	<h1><?=$this->title ?></h1>	
	<form class="form-inline" action="/admin/fushi/get-owners-visitor" onsubmit="return checkData();">
		<?php 
			$house_id  = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];	
			$house_ids = Yii::$app->session['admin']['house_ids'];
			$house_arr = empty($house_ids) ? [] : explode(',', $house_ids);
			$page      = empty(Yii::$app->request->get()['page']) ? 1 : Yii::$app->request->get()['page'];
			$owner_phone = empty(Yii::$app->request->get()['owner_phone']) ? '' : Yii::$app->request->get()['owner_phone'];
			$stime     = empty(Yii::$app->request->get()['stime']) ? date('Y-m-d',strtotime(date('Y-m-01'))) : Yii::$app->request->get()['stime'];
			$etime     = empty(Yii::$app->request->get()['etime']) ? date('Y-m-d',time()) : Yii::$app->request->get()['etime'];
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
			<input type="text" class="form-control" name="owner_phone" id="owner_phone" value="<?=$owner_phone ?>" placeholder="请输入业主手机号">
		</div>
		<div class="form-group">
			<input type="date" class="form-control" name="stime" id="stime" value="<?=$stime ?>">
		</div>
		<div class="form-group">
			<input type="date" class="form-control" name="etime" id="etime" value="<?=$etime ?>">
		</div>
		<button type="submit" class="btn btn-default">查询</button>
	</form>
	<br>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>   
				<th style="text-align: center;">记录编号</th>
				<th style="text-align: center;">访客openid</th>
				<th style="text-align: center;">访客姓名</th>
				<th style="text-align: center;">访客手机号</th>
				<th style="text-align: center;">授权码</th>
				<th style="text-align: center;">出入库类型</th>
				<th style="text-align: center;">业主姓名</th>
				<th style="text-align: center;">业主手机</th>
				<th style="text-align: center;">出入库时间</th>
				<th style="text-align: center;">数据库插入时间</th>
			</tr>
		</thead>
		<tbody>
			<?php if($data):?>
				<?php foreach($data as $k => $v): ?>
				<tr>
					<td><?=$v['numbercode'] ? $v['numbercode'] : '--' ?></td>
					<td><?=$v['visitoropenid'] ? $v['visitoropenid'] : '--' ?></td>
					<td><?=$v['visitorname'] ? $v['visitorname'] : '--' ?></td>
					<td><?=$v['visitorphone'] ? $v['visitorphone'] : '--' ?></td>
					<td><?=$v['qrcode'] ? $v['qrcode'] : '--'  ?></td>
					<td><?=$v['outIncomingtype'] ? $v['outIncomingtype'] : '--'  ?></td>
					<td><?=$v['ownername'] ? $v['ownername'] : '--' ?></td>
					<td><?=$v['ownerphone'] ? $v['ownerphone'] : '--' ?></td>
					<td><?=$v['operatetime'] ? $v['operatetime'] : '--' ?></td>
					<td><?=$v['createtime'] ? $v['createtime'] : '--' ?></td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr><td colspan="10">暂无数据</td></tr>
			<?php endif;?>
		</tbody>
	</table>
	<?php if ($total_page > 1): ?>
	<div>
		<a href="javascript:void(0);" onclick="jumpPage(1,<?=$total_page ?>);">首页</a>
		<a href="javascript:void(0);" onclick="jumpPage(<?=$page-1 ?>,<?=$total_page ?>);">上一页</a>
		<a href="javascript:void(0);" onclick="jumpPage(<?=$page+1 ?>,<?=$total_page ?>);">下一页</a>
		<a href="javascript:void(0);" onclick="jumpPage(<?=$total_page ?>,<?=$total_page ?>);">末页</a>
		跳转
		<input type="text" style="width: 68px;" name="tz" id="tz" value="" placeholder="输入页码">
		<button onclick="jumpPage($('#tz').val(),<?=$total_page ?>);">确定</button>
		共 <span><?=$total_page ?></span> 页，当前第 <span><?=$page ?></span> 页
	</div>		
	<?php endif ?>
</div>

<script type="text/javascript">	
	function checkData(){
		var house_id = $('#house_id').val();
		var owner_phone = $('#owner_phone').val();
		var stime = $('#stime').val();
		var etime = $('#etime').val();
		if (house_id == undefined || house_id == 0) {
			alert('请选择项目');return false;
		}
		if (owner_phone == undefined || owner_phone == '') {
			alert('请输入业主手机号');return false;
		}
		if (stime == undefined || stime == '') {
			alert('请选择开始时间');return false;
		}
		if (etime == undefined || etime == '') {
			alert('请选择结束时间');return false;
		}
		if (stime > etime) {
			alert('开始时间不可以在结束时间之后');return false;
		}
		if (stime.substr(0,7) != etime.substr(0,7)) {
			alert('不可跨月查询');return false;
		}
		return true;
	}

	function jumpPage(page,total_page){
		page = page < 1 ? 1 : page;
		page = page > total_page ? total_page : page;
		if (checkData()) {
			location.href = '/admin/fushi/get-owners-visitor?house_id='+$('#house_id').val()+'&owner_phone='+$('#owner_phone').val()+'&stime='+$('#stime').val()+'&etime='+$('#etime').val()+'&page='+page;
		}
	}
</script>




