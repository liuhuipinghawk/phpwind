<?php 
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '新增楼盘房源';
if ($model) {
	$this->title = '修改楼盘房源';
};

$this->params['breadcrumbs'][] = ['label' => '项目房源管理', 'url' => ['house-lease/house-lease-list']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div>
	<h3><?php echo $this->title; ?></h3>
	<form class="form-horizontal">
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">项目</label>
            <div class="col-sm-2">
                <select class="form-control" id="house_id" name="house_id">
                	<option value="">=请选择楼盘=</option>
                	<?php if ($house): ?>
                		<?php foreach ($house as $k => $v): ?>
                			<option value="<?=$v['id']?>" <?php if ($v['id'] == $model['house_id']) echo 'selected'; ?>><?=$v['housename']?></option>
                		<?php endforeach ?>
                	<?php endif ?>
                </select>
            </div>
            <div class="col-sm-2">
                <select class="form-control" id="seat_id" name="seat_id">
                	<option>=请选择楼座=</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">类型</label>
            <div class="col-sm-6">
                <select name="house_type" id="house_type" class="form-control">
                	<option value="1" <?php if($model['house_type'] == 1) echo 'selected'; ?>>写字楼</option>
                	<option value="2" <?php if($model['house_type'] == 2) echo 'selected'; ?>>商铺</option>
                	<option value="3" <?php if($model['house_type'] == 3) echo 'selected'; ?>>公寓</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">总户数</label>
            <div class="col-sm-6">
                <input type="text" name="total_nums" id="total_nums" class="form-control" value="<?=$model['total_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">可租户数</label>
            <div class="col-sm-6">
                <input type="text" name="rent_nums" id="rent_nums" class="form-control" value="<?=$model['rent_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">不可租户数</label>
            <div class="col-sm-6">
                <input type="text" name="unrent_nums" id="unrent_nums" class="form-control" value="<?=$model['unrent_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">总面积</label>
            <div class="col-sm-6">
                <input type="text" name="total_space" id="total_space" class="form-control" value="<?=$model['total_space']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">可租面积</label>
            <div class="col-sm-6">
                <input type="text" name="rent_space" id="rent_space" class="form-control" value="<?=$model['rent_space']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">不可租面积</label>
            <div class="col-sm-6">
                <input type="text" name="unrent_space" id="unrent_space" class="form-control" value="<?=$model['unrent_space']?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <input type="hidden" id="id" name="id" value="<?php echo $model['id']; ?>">
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

		$('#house_id').change(function(){
			var id = $(this).val();
			bindSeat(id,0);
		});

		$('.btn_submit').click(function(){
			var id = $('#id').val();
			var house_id = $('#house_id').val();
			var seat_id = $('#seat_id').val();
			var house_type = $('#house_type').val();
			var total_nums = $('#total_nums').val();
			var rent_nums = $('#rent_nums').val();
			var unrent_nums = $('#unrent_nums').val();
			var total_space = $('#total_space').val();
			var rent_space = $('#rent_space').val();
			var unrent_space = $('#unrent_space').val();
			if (house_id == undefined || parseInt(house_id) == 0) {
				alert('请选择正确的项目');return false;
			}
			if (seat_id == undefined || parseInt(seat_id) == 0) {
				alert('请选择正确的楼座');return false;
			}
			if (house_type == undefined || parseInt(house_type) == 0 || (house_type != 1 && house_type != 2 && house_type != 3)) {
				alert('房源类型不正确');return false;
			}
			if (total_nums == undefined || parseInt(total_nums) <= 0) {
				alert('总户数不能为空');return false;
			}
			if (rent_nums == undefined || parseInt(rent_nums) <= 0) {
				alert('可租户数不能为空');return false;
			}
			if (unrent_nums == undefined || parseInt(unrent_nums) <= 0) {
				alert('不可租户数不能为空');return false;
			}
			if (total_space == undefined || parseInt(total_space) <= 0) {
				alert('总面积不能为空');return false;
			}
			if (rent_space == undefined || parseInt(rent_space) <= 0) {
				alert('可租面积不能为空');return false;
			}
			if (unrent_space == undefined || parseInt(unrent_space) <= 0) {
				alert('不可租面积不能为空');return false;
			}
			if (parseInt(total_nums) != parseInt(parseInt(unrent_nums)+parseInt(rent_nums))) {
				alert('总户数与可租户数和不可租户数不匹配');return false;
			}
			if (parseFloat(total_space) != parseFloat(parseFloat(unrent_space)+parseFloat(rent_space))) {
				alert('总面积与可租面积和不可租面积不匹配');return false;
			}
			$.ajax({
				type:'post',
				dataType:'json',
				url:'/admin/house-lease/ajax-add-house-lease',
				data:{
					id:id,
					house_id:house_id,
					seat_id:seat_id,
					house_type:house_type,
					total_nums:total_nums,
					rent_nums:rent_nums,
					unrent_nums:unrent_nums,
					total_space:total_space,
					rent_space:rent_space,
					unrent_space:unrent_space
				},
				success:function(res){
					if (res.code == 200) {
						alert(res.msg);
						location.href = '/admin/house-lease/house-lease-list';
					} else {
						alert(res.msg);return false;
					}
				}
			});
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