<?php 
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '新增租赁记录';
if ($model) {
	$this->title = '修改租赁记录';
};

$this->params['breadcrumbs'][] = ['label' => '房屋租赁记录', 'url' => ['house-lease/house-lease-report']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div>
	<h3><?php echo $this->title; ?></h3>
	<form class="form-horizontal">
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">项目</label>
            <div class="col-sm-2">
                <select class="form-control" id="house_id" name="house_id">
                	<option value="">=选择楼盘=</option>
                	<?php if ($house): ?>
                		<?php foreach ($house as $k => $v): ?>
                			<option value="<?=$v['id']?>" <?php if ($v['id'] == $model['house_id']) echo 'selected'; ?>><?=$v['housename']?></option>
                		<?php endforeach ?>
                	<?php endif ?>
                </select>
            </div>
            <div class="col-sm-2">
                <select class="form-control" id="seat_id" name="seat_id">
                	<option value="">=选择楼座=</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">类型</label>
            <div class="col-sm-8">
                <select name="house_type" id="house_type" class="form-control">
                	<option value="1" <?php if($model['house_type'] == 1) echo 'selected'; ?>>写字楼</option>
                	<option value="2" <?php if($model['house_type'] == 2) echo 'selected'; ?>>商铺</option>
                	<option value="3" <?php if($model['house_type'] == 3) echo 'selected'; ?>>公寓</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">房间号</label>
            <div class="col-sm-8">
                <input type="text" name="room_num" id="room_num" class="form-control" value="<?=$model['room_num']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">面积</label>
            <div class="col-sm-8">
                <input type="text" name="space" id="space" class="form-control" value="<?=$model['space']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">佣金</label>
            <div class="col-sm-8">
                <input type="text" name="get_money" id="get_money" class="form-control" value="<?=$model['get_money']?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
                <input type="hidden" id="report_id" name="report_id" value="<?php echo $model['report_id']; ?>">
                <button type="button" class="btn btn-default btn_submit">提交</button>
            </div>
        </div>
    </form>
</div>

<?=Html::jsFile('/js/jquery-1.12.4.js')?>

<script type="text/javascript">
	$(function(){
		var hid = "<?=$model['house_id'] ?>";
		var sid = "<?=$model['seat_id'] ?>";
		bindSeat(hid,sid);

		$('.btn_submit').click(function(){
			var report_id = $('#report_id').val();
			var house_id = $('#house_id').val();
			var seat_id = $('#seat_id').val();
			var house_type = $('#house_type').val();
			var room_num = $.trim($('#room_num').val());
			var space = $.trim($('#space').val());
			var get_money = $.trim($('#get_money').val());
			if (house_id == undefined || parseInt(house_id) == 0) {
				alert('请选择楼盘');return false;
			}
			if (seat_id == undefined || parseInt(seat_id) == 0) {
				alert('请选择楼座');return false;
			}
			if (house_type == undefined || parseInt(house_type) == 0 || (house_type != 1 && house_type != 2 && house_type != 3)) {
				alert('房源类型不正确');return false;
			}
			if (room_num == undefined || room_num == '') {
				alert('请输入房间号');return false;
			}
			if (space == undefined || parseFloat(space) <= 0) {
				alert('请输入房屋面积');return false;
			}
			if (get_money == undefined || parseFloat(get_money) <= 0) {
				alert('请输入佣金');return false;
			}
			$.ajax({
				type:'post',
				dataType:'json',
				url:'/admin/house-lease/ajax-add-report',
				data:{
					report_id:report_id,
					house_id:house_id,
					seat_id:seat_id,
					house_type:house_type,
					room_num:room_num,
					space:space,
					get_money:get_money
				},
				success:function(res){
					if (res.code == 200) {
						alert(res.msg);
						location.href = '/admin/house-lease/house-lease-report';
					} else {
						alert(res.msg);return false;
					}
				}
			});
		});

		$('#house_id').change(function(){
			var id = $(this).val();
			bindSeat(id,0);
		});
	});

	function bindSeat(id,seat_id)
	{
		var option = "<option value=''>=请选择楼座=</option>";
		if (id == undefined || id == '') {
			$('#seat_id').html(option); return false;
		}
		$.ajax({
			type:'post',
			dataType:'json',
			url:'/admin/house-lease/ajax-get-seat',
			data:{
				parent_id:id
			},
			success:function(res){
				if (res.code == 200) {
					var len = res.data.length;
					if (len > 0) {
						for (var i = 0; i < len; i++) {
							var sid = res.data[i]['id'];
							if (seat_id == sid) {
								option += "<option value='"+res.data[i]['id']+"' selected>"+res.data[i]['housename']+"</option>";
							} else {
								option += "<option value='"+res.data[i]['id']+"'>"+res.data[i]['housename']+"</option>";
							}
						}
					}
				}
				$('#seat_id').html(option);
			}
		});
	}
</script>