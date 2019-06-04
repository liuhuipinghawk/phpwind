<?php 
	use yii\helpers\Html;

	$this->title = '新增/编辑';
	$this->params['breadcrumbs'][] = ['label' => '电费价格标签管理', 'url' => ['sys/price-tag']];
	$this->params['breadcrumbs'][] = $this->title;
 ?>

<?=Html::jsFile('/js/jquery-1.12.4.js')?>

<div class="container-fluid">
	<h3><?=$this->title ?></h3>
    <form class="form-horizontal">
    	<input type="hidden" name="id" id="id" value="<?=$model['id']?>">
        <div class="form-group">
        	<label class="col-sm-2 control-label">楼盘</label>
			<div class="col-sm-4">
	            <select class="form-control" id="house_id" name="house_id" style="width: 250px;">
	            	<option value="">选择楼盘</option>
	            	<?php if ($house): ?>
	            		<?php foreach ($house as $k => $v): ?>
	            			<option value="<?=$v['id']?>" <?php if($v['id'] == $model['house_id']) echo 'selected';?>><?=$v['housename']?></option>
	            		<?php endforeach ?>
	            	<?php endif ?>
	            </select>
        	</div>
        </div>
        <div class="form-group">
        	<label class="col-sm-2 control-label">楼座</label>
			<div class="col-sm-4">
	            <select class="form-control" id="seat_id" name="seat_id" style="width: 250px;">
	            	<option value="">选择楼座</option>
	            </select>
            </div>
        </div>
        <div class="form-group">
        	<label class="col-sm-2 control-label">价格标签1</label>
			<div class="col-sm-4">
		        <input type="number" class="form-control" style="width: 250px;" id="tag1" name="tag1" placeholder="请输入价格标签1" value="<?=$model['tag'] ? explode(',', $model['tag'])[0] : ''?>">
            </div>
        </div>
        <div class="form-group">
        	<label class="col-sm-2 control-label">价格标签2</label>
			<div class="col-sm-4">
	            <input type="number" class="form-control" style="width: 250px;" id="tag2" name="tag2" placeholder="请输入价格标签2" value="<?=$model['tag'] ? explode(',', $model['tag'])[1] : ''?>">
            </div>
        </div>
        <div class="form-group">
        	<label class="col-sm-2 control-label">价格标签3</label>
			<div class="col-sm-4">
	            <input type="number" class="form-control" style="width: 250px;" id="tag3" name="tag3" placeholder="请输入价格标签3" value="<?=$model['tag'] ? explode(',', $model['tag'])[2] : ''?>">
            </div>
        </div>
        <div class="form-group">
        	<label class="col-sm-2 control-label">价格标签4</label>
			<div class="col-sm-4">
	            <input type="number" class="form-control" style="width: 250px;" id="tag4" name="tag4" placeholder="请输入价格标签4" value="<?=$model['tag'] ? explode(',', $model['tag'])[3] : ''?>">
            </div>
        </div>
        <div class="form-group">
        	<label class="col-sm-2 control-label">价格标签5</label>
			<div class="col-sm-4">
	            <input type="number" class="form-control" style="width: 250px;" id="tag5" name="tag5" placeholder="请输入价格标签5" value="<?=$model['tag'] ? explode(',', $model['tag'])[4] : ''?>">
            </div>
        </div>
        <div class="form-group">
        	<label class="col-sm-2 control-label">价格标签6</label>
			<div class="col-sm-4">
	            <input type="number" class="form-control" style="width: 250px;" id="tag6" name="tag6" placeholder="请输入价格标签6" value="<?=$model['tag'] ? explode(',', $model['tag'])[5] : ''?>">
            </div>
        </div>
        <div class="form-group">
        	<label class="col-sm-2 control-label">&nbsp;</label>
			<div class="col-sm-4">
        		<button type="button" id="btn_submit" class="btn btn-default">提交</button>
            </div>
    	</div>
    </form>
</div>

<script type="text/javascript">
	$(function(){
		var house_id = <?=$model ? $model['house_id'] : 0?>;
		var seat_id = <?=$model ? $model['seat_id'] : 0?>;
		loadSeat(house_id,seat_id);
		
		// 楼盘切换
		$("#house_id").change(function(){
			var id = $(this).val();
			if (id > 0) {
				loadSeat(id,0)
			} else {
				$("#seat_id").html("<option value=\"\">选择楼盘</option>");
			}
		});
			
		// 提交
		$("#btn_submit").click(function(){
			var id = $("#id").val();
			var house_id = $("#house_id").val();
			var seat_id = $("#seat_id").val();
			var tag1 = $("#tag1").val();
			var tag2 = $("#tag2").val();
			var tag3 = $("#tag3").val();
			var tag4 = $("#tag4").val();
			var tag5 = $("#tag5").val();
			var tag6 = $("#tag6").val();
			if (house_id == undefined || house_id.length == 0) {
				alert("请选择楼盘");
				return false;
			}
			if (seat_id == undefined || seat_id.length == 0) {
				alert("请选择楼座");
				return false;
			}
			if (tag1 == undefined || tag1.length == 0 || tag1 < 50) {
				alert("请输入价格标签，不得小于50");
				return false;
			}
			if (tag2 == undefined || tag2.length == 0 || tag2 < 50) {
				alert("请输入价格标签");
				return false;
			}
			if (tag3 == undefined || tag3.length == 0 || tag3 < 50) {
				alert("请输入价格标签");
				return false;
			}
			if (tag4 == undefined || tag4.length == 0 || tag4 < 50) {
				alert("请输入价格标签");
				return false;
			}
			if (tag5 == undefined || tag5.length == 0 || tag5 < 50) {
				alert("请输入价格标签");
				return false;
			}
			if (tag6 == undefined || tag6.length == 0 || tag6 < 50) {
				alert("请输入价格标签");
				return false;
			}
			$.ajax({
				type:"post",
				dataType:"JSON",
				url:"/admin/sys/do-set-price-tag",
				data:{
					id:id,
					house_id:house_id,
					seat_id:seat_id,
					tag1:tag1,
					tag2:tag2,
					tag3:tag3,
					tag4:tag4,
					tag5:tag5,
					tag6:tag6
				},
				success:function(res){
					if (res.code == 200) {
						alert(res.msg);
						location.href = "/admin/sys/price-tag";
					} else {
						alert(res.msg);
						return false;
					}
				}
			});
		});
	});

	function loadSeat(pid,seat_id)
	{
		$.post("/admin/sys/ajax-get-seat",{id:pid},function(res){
			var _option = "<option value=\"\">选择楼盘</option>";
			if (res.code == 200) {
				var l = res.data.length;
				if (l > 0) {
					for (var i = 0; i < l; i++) {
						if (res.data[i]['id'] == seat_id) {
							_option += "<option value=\""+res.data[i]['id']+"\" selected>"+res.data[i]['housename']+"</option>";
						} else {
							_option += "<option value=\""+res.data[i]['id']+"\">"+res.data[i]['housename']+"</option>";
						}						
					}
				}						
				$("#seat_id").html(_option);
			} else {
				$("#seat_id").html(_option);
			}
		},"JSON");
	}
</script>

