<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '报检保修订单';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['list']];
?>

<div>
	<h1><?=$this->title ?></h1>	
	<form class="form-inline" action="/admin/order/list">
		<?php 
			$house_id  = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
			$seat_id  = empty(Yii::$app->request->get()['seat_id']) ? 0 : Yii::$app->request->get()['seat_id'];
			$person_kw = empty(Yii::$app->request->get()['person_kw']) ? '' : Yii::$app->request->get()['person_kw'];
			$content = empty(Yii::$app->request->get()['content']) ? '' : Yii::$app->request->get()['content'];
			$repair_kw = empty(Yii::$app->request->get()['repair_kw']) ? '' : Yii::$app->request->get()['repair_kw'];
			$state     = empty(Yii::$app->request->get()['state']) ? 0 : Yii::$app->request->get()['state'];
			$order_type1 = empty(Yii::$app->request->get()['order_type1']) ? 0 : Yii::$app->request->get()['order_type1'];
			$order_type2 = empty(Yii::$app->request->get()['order_type2']) ? 0 : Yii::$app->request->get()['order_type2'];
			$house_ids = Yii::$app->session['admin']['house_ids'];
			$group_id = Yii::$app->session['admin']['group_id'];
			$stime     = empty(Yii::$app->request->get()['stime']) ? '' : Yii::$app->request->get()['stime'];
			$etime     = empty(Yii::$app->request->get()['etime']) ? '' : Yii::$app->request->get()['etime'];
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
			<select class="form-control" id="seat_id" name="seat_id">
				<option value="">选择楼座</option>
			</select>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" id="content" name="content" placeholder="报修内容" value="<?=$content?>">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" id="person_kw" name="person_kw" placeholder="报修人姓名" value="<?=$person_kw?>">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" id="repair_kw" name="repair_kw" placeholder="维修师傅姓名" value="<?=$repair_kw?>">
		</div>
		<div class="form-group">
			<select class="form-control" name="order_type1" id="order_type1">
				<option value="0">维修区域</option>
				<?php foreach ($order_type as $k => $v) { ?>
					<option value="<?=$v['id']?>" <?php if($order_type1 == $v['id']) echo 'selected';?>><?=$v['type_name'] ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<select class="form-control" name="order_type2" id="order_type2">
				<option value="0">维修类型</option>
			</select>
		</div>
		<div class="form-group">
			<select class="form-control" name="state" id="state">
				<option value="">状态</option>
				<option value="1" <?php if($state == 1) echo 'selected';?>>等待处理</option>
				<option value="2" <?php if($state == 2) echo 'selected';?>>已派单</option>
				<option value="3" <?php if($state == 3) echo 'selected';?>>维修进行中</option>
				<option value="4" <?php if($state == 4) echo 'selected';?>>维修完成</option>
				<option value="6" <?php if($state == 6) echo 'selected';?>>审核通过</option>
				<option value="5" <?php if($state == 5) echo 'selected';?>>已评价</option>
			</select>
		</div>
		<input type="date" name="stime" id="stime" class="form-control" placeholder="开始时间" value="<?=$stime?>">
		<input type="date" name="etime" id="etime" class="form-control" placeholder="结束时间" value="<?=$etime?>">
		<button type="submit" class="btn btn-default">查询</button>
		<a href="javascript:void(0);" class="btn btn-default" onclick="location.reload();">刷新</a>
		<a href="javascript:void(0);" class="btn btn-default" id="btn_export">导出</a>
		<a href="javascript:void(0);" id="download_path"></a>
		&nbsp;&nbsp;<strong>共<?=$count?>条</strong>
		<!-- <hr>
		<div>
			<select class="form-control" id="sel_house" name="sel_house">
				<?php if ($group_id == 1): ?>
					<option value="">请选择项目</option>
				<?php endif ?>
				<?php foreach ($house as $k => $v): ?>
					<?php if (in_array($v['id'],$house_arr)): ?>
						<option value="<?=$v['id']?>" <?php if ($v['id']==$house_id) echo 'selected'; ?>><?=$v['housename']?></option>
					<?php endif ?>
				<?php endforeach ?>
			</select>
			<input type="date" id="txt_stime" name="txt_stime" class="form-control" placeholder="开始时间" value="<?php echo date('Y-m-d',time()-7*24*3600);?>">
			<input type="date" id="txt_etime" name="txt_etime" class="form-control" placeholder="结束时间" value="<?php echo date('Y-m-d',time());?>">
			<a href="javascript:void(0);" class="btn btn-default" id="btn_export">导出</a>
			<a href="javascript:void(0);" id="download_path"></a>
		</div> -->
	</form>
	<br>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>   
				<th style="text-align: center;">订单编号</th>
				<th style="text-align: center;">项目</th>
				<th style="text-align: center;">区域类型</th>
				<th style="text-align: center;">报修内容</th>
				<th style="text-align: center;">报修人</th>
				<th style="text-align: center;">报修时间</th>
				<th style="text-align: center;">派单时间</th>
				<th style="text-align: center;">指派维修师傅</th>
				<th style="text-align: center;">状态</th>
				<th style="text-align: center;">审核时间</th>
				<th style="text-align: center; width: 150px;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if($list):?>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td><?= Html::encode("{$v['order_no']}") ?></td>
					<td><?=$v['house_name'] .'-'.$v['seat_name'].'-'.$v['room_num'] ?></td>
					<td><?=$v['area_name'] .'-'.$v['type_name'] ?></td>
					<td style="text-align: left;"><?= Html::encode("{$v['content']}") ?></td>
					<td><?= Html::encode("{$v['persion']}（{$v['persion_tel']}）") ?></td>
					<td><?= Html::encode("{$v['order_time']}") ?></td>
					<td><?php if($v['deal_time']) echo date('Y-m-d H:i:s',$v['deal_time']); else echo '--'; ?></td>
					<td><?php if($v['repair_name']) echo $v['repair_name'].'（'.$v['repair_tel'].'）'; else echo '--'; ?></td>
					<td>
						<?php 
							if($v['state'] == 1) echo '等待处理';
							elseif($v['state'] == 2) echo '已派单';
							elseif($v['state'] == 3) echo '维修进行中';
							elseif($v['state'] == 4) echo '维修完成';
							elseif($v['state'] == 5) echo '已评价';
							elseif($v['state'] == 6) echo '审核通过';
					 	?>
					</td>
					<td><?=$v['audit_time'] ? date('Y-m-d H:i',$v['audit_time']) : '--'?></td>
					<td style="width: 150px;">
						<?php $url = Yii::$app->request->url; ?>
						<?php if($v['state'] == 1): ?>
						<a href="<?=Url::to(['order/al-order','id'=>$v['order_id']])?>&tag=dispatch&url=<?=urlencode($url)?>" title="派单">派单</a>&nbsp;&nbsp;
						<a href="javascript:void(0);" onclick="doDel(<?=$v['order_id']?>)" title="删除">删除</a>&nbsp;&nbsp;
						<?php endif; ?>

						<?php if($v['state'] == 2 || ($v['state'] == 3 && $v['audit_time'])): ?>
						<a href="<?=Url::to(['order/al-order','id'=>$v['order_id']])?>&tag=dispatch&url=<?=urlencode($url)?>" title="重新派单">重新派单</a>&nbsp;&nbsp;
						<?php endif; ?>
						<?php if($v['state'] == 4): ?>
						<a href="<?=Url::to(['order/al-order','id'=>$v['order_id']])?>&tag=audit&url=<?=urlencode($url)?>" title="审核">审核</a>&nbsp;&nbsp;
						<?php endif; ?>
						<?php if($v['state'] > 2): ?>
						<a href="<?=Url::to(['order/al-order','id'=>$v['order_id']])?>&url=<?=urlencode($url)?>" title="查看">查看</a>&nbsp;&nbsp;
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
			    'nextPageLabel' => '下一页',
			    'prevPageLabel' => '上一页',
			    'firstPageLabel' => '首页',
			    'lastPageLabel' => '尾页',
			]);
		?>


		</nav>
		<span style="position: absolute;right: 70px;bottom: 25px;">
			跳转
			<input type="text" style="width: 68px;" name="tz" id="tz" value="" placeholder="输入页码">
			<button onclick="jumpPage($('#tz').val());">确定</button>
		</span>
	</div>
</div>
<?=Html::jsFile('@web/js/jquery-1.12.4.js')?>

<script type="text/javascript">
	$(function() {
		getSeat(<?=$house_id ?>, <?=$seat_id ?>);

		$('#house_id').change(function () {
			var house_id = $(this).val();
			getSeat(house_id, 0);
		});
	});
	function getSeat(house_id,seat_id){
		$.ajax({
			type:'post',
			dataType:'json',
			url:"<?=Url::to(['living-payment/ajax-get-seat']) ?>",
			data:{
				house_id:house_id
			},
			success:function(res){
				if (res.code == 200) {
					var len = res.data.length;
					var _option = '<option value="">选择楼座</option>';
					for(var i = 0; i < len; i++){
						_option += '<option';
						if (res.data[i]['id'] == seat_id) {
							_option += ' selected';
						}
						_option += ' value="'+res.data[i]['id']+'">'+res.data[i]['housename']+'</option>';
					}
					$('#seat_id').html(_option);
				}
			}
		});
	}
	$(document).ready(function(){
		var pid = $("#order_type1").val();
		loadRepairArea(pid);
		// 导出excel
		$('#btn_export').click(function(){
			// var house = $('#sel_house').val();
			// var stime = $('#txt_stime').val();
			// var etime = $('#txt_etime').val();
			// if (stime == undefined || stime == '' || etime == undefined || etime == '') {
			// 	alert('请选择导出数据的开始结束时间');return false;
			// }
			var house_id = $("#house_id").val();
			var seat_id = $("#seat_id").val();
			var content = $("#content").val();
			var person_kw = $("#person_kw").val();
			var repair_kw = $("#repair_kw").val();
			var order_type1 = $("#order_type1").val();
			var order_type2 = $("#order_type2").val();
			var state = $("#state").val();
			var stime = $("#stime").val();
			var etime = $("#etime").val();
			$.ajax({
				type:'post',
				dataType:'json',
				url:'/index.php?r=admin/order/ajax-order-export',
				data:{
					house_id:house_id,
					seat_id:seat_id,
					content:content,
					person_kw:person_kw,
					repair_kw:repair_kw,
					order_type1:order_type1,
					order_type2:order_type2,
					state:state,
					stime:stime,
					etime:etime
				},
				success:function(res){
					if (res.code == 200) {
						$('#download_path').attr('href','/index.php?r=admin/order/download&path='+res.path);
						$('#download_path').html('点击下载');
					} else {
						$('#download_path').attr('href','');
						$('#download_path').html('');
						alert(res.msg);
						return false;
					}
				}
			});
		});

		$("#order_type1").change(function(){
			var id = $(this).val();
			loadRepairArea(id);
		});
	});

	setInterval(refresh, 1000*60*5);
	function refresh()
	{
		location.reload();
	}

	function doDel(order_id)
	{
		if (confirm("确定要删除订单吗？删除之后订单将不可恢复！！！")) {
			$.ajax({
				type:'post',
				dataType:'json',
				url:'/index.php?r=admin/order/ajax-order-del',
				data:{
					order_id:order_id
				},
				success:function(res){
					if (res.code == 200) {
						alert(res.msg);
						location.reload();
					} else {
						alert(res.msg);
						return false;
					}
				}
			});
		}
	}

	function loadRepairArea(id)
	{
		var order_type2 = "<?=$order_type2?>";
		$.post("/index.php?r=admin/order/ajax-get-order-type",{pid:id},function(res){
			if (res.code == 200) {
				var len = res.data.length;
				var option = "<option value=\"0\">维修类型</option>";
				if (len > 0) {
					for (var i = 0; i < len; i++) {
						if (order_type2 == res.data[i]['id']) {
							option += "<option value=\""+res.data[i]['id']+"\" selected>"+res.data[i]['type_name']+"</option>";
						} else {
							option += "<option value=\""+res.data[i]['id']+"\">"+res.data[i]['type_name']+"</option>";
						}
					}
				}
				$("#order_type2").html(option);
			} else {
				alert(res.msg); 
				return false;
			}
		},"json");
	}
	function jumpPage(page){
		page = page < 1 ? 1 : page;
		var stime = $('#stime').val();
		if($('#stime').val() == undefined){
			stime = '';
		}
		var etime = $('#etime').val();
		if($('#etime').val() == undefined){
			etime = '';
		}
		location.href = '/admin/order/list?house_id='+$('#house_id').val()+'&seat_id='+$('#seat_id').val()+'&person_kw='+$('#person_kw').val()+
				'&repair_kw='+$('#repair_kw').val()+'&order_type1='+$('#order_type1').val()+'&order_type2='+$('#order_type2').val()+
				'&state='+$('#state').val()+'&sel_house='+$('#sel_house').val()+'&txt_stime='+$('#txt_stime').val()+'&content='+$('#content').val()+
				'&txt_etime='+$('#txt_etime').val()+'&stime='+stime+'&etime='+etime+'&page='+page;

	}
</script>




