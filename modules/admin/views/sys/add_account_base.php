<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '缴费账户基础信息';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::cssFile('/layout/css/bootstrap.min.css')?>
<?=Html::cssFile('/css/site.css')?>
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<br>
<div class="container-fluid">
	<form class="form-horizontal">
		<input type="hidden" name="op_id" id="op_id" value="<?=$op_id?>">
		<div class="form-group">
			<label class="col-sm-2 control-label">楼盘</label>
			<div class="col-sm-10">
				<select class="form-control" id="house_id" name="house_id">
					<option value="">选择楼盘</option>
					<?php foreach ($house as $k => $v): ?>
						<option value="<?=$v['id']?>" <?php if ($v['id'] == $model['house_id']) echo 'selected'; ?>><?=$v['housename']?></option>
					<?php endforeach ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">楼座</label>
			<div class="col-sm-10">
				<select class="form-control" id="seat_id" name="seat_id">
					<option value="">选择楼座</option>
					<?php foreach ($seat as $k => $v): ?>
						<option value="<?=$v['id']?>" <?php if ($v['id'] == $model['seat_id']) echo 'selected'; ?>><?=$v['housename']?></option>
					<?php endforeach ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">房间号</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="room_num" name="room_num" value="<?=$model['room_num']?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">业主</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="owner" name="owner" value="<?=$model['owner']?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">电表倍率</label>
			<div class="col-sm-10">
				<input type="number" class="form-control" id="rate" name="rate" value="<?=$model['rate']?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">物业费</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="property_fee" name="property_fee" value="<?=$model['property_fee']?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">物业面积</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="area" name="area" value="<?=$model['area']?>">
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="button" class="btn btn-success btn-default btn_submit">提交</button>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	$(function(){
		$('.btn_submit').click(function(){
			var op_id    = $('#op_id').val();
			var house_id = $('#house_id').val();
			var seat_id  = $('#seat_id').val();
			var room_num = $('#room_num').val();
			var owner    = $('#owner').val();
			var rate     = $('#rate').val();
			var property_fee = $('#property_fee').val();
			var area     = $('#area').val();
			if (house_id == undefined || house_id.length == 0) {
				alert('请选择楼盘');return false;
			}
			if (seat_id == undefined || seat_id.length == 0) {
				alert('请选择楼座');return false;
			}
			if (room_num == undefined || room_num.length == 0) {
				alert('请输入房间号');return false;
			}
			if (owner == undefined || owner.length == 0) {
				alert('请输入房主信息');return false;
			}
			if (rate == undefined || rate.length == 0) {
				alert('请输入电表倍率');return false;
			}
			if (rate < 1) {
				alert('电表倍率不可以小于1');return false;
			}
			if (property_fee == undefined || property_fee.length == 0) {
				alert('请输入物业费');return false;
			}
			if (area == undefined || area.length == 0) {
				alert('请输入物业面积');return false;
			}
			var data = {};
			data.op_id    = op_id;
			data.house_id = house_id;
			data.seat_id  = seat_id;
			data.room_num = room_num;
			data.owner    = owner;
			data.rate     = rate;
			data.property_fee     = property_fee;
			data.area     = area;
			$.post('/index.php?r=admin/sys/ajax-do-add-account-base',data,function(res){
				if (res.code == 200) {
					alert(res.msg);
					parent.location.reload();
				} else {
					alert(res.msg);
					return false;
				}
			},'JSON');
		});

		//楼盘
		$('#house_id').change(function(){
			var house_id = $(this).val();
			getSeat(house_id,0);
		});
	});

	//获取楼座信息
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
</script>