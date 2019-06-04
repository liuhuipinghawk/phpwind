<?php 
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '新增数据';
if ($model) {
	$this->title = '修改数据';
};

$this->params['breadcrumbs'][] = ['label' => '房屋动态列表', 'url' => ['house-data/house-data-list']];
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
                	<option value="">=请选择楼座=</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">类型</label>
            <div class="col-sm-2">
                <select class="form-control" id="house_type" name="house_type">
                    <option value="1" <?php if($model['house_type'] == 1) echo 'selected';?>>写字楼</option>
                    <option value="2" <?php if($model['house_type'] == 2) echo 'selected';?>>商铺</option>
                    <option value="3" <?php if($model['house_type'] == 3) echo 'selected';?>>公寓</option>
                    <option value="4" <?php if($model['house_type'] == 4) echo 'selected';?>>停车位</option>
					<option value="5" <?php if($model['house_type'] == 5) echo 'selected';?>>储藏间</option>
					<option value="6" <?php if($model['house_type'] == 6) echo 'selected';?>>其他</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">总数</label>
            <div class="col-sm-6">
                <input type="text" name="total_nums" id="total_nums" class="form-control" value="<?=$model['total_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">未售数</label>
            <div class="col-sm-6">
                <input type="text" name="unsale_nums" id="unsale_nums" class="form-control" value="<?=$model['unsale_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">已售数</label>
            <div class="col-sm-6">
                <input type="text" name="sale_nums" id="sale_nums" class="form-control" value="<?=$model['sale_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">不符合交付</label>
            <div class="col-sm-6">
                <input type="text" name="unmatch_nums" id="unmatch_nums" class="form-control" value="<?=$model['unmatch_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">符合交付</label>
            <div class="col-sm-6">
                <input type="text" name="match_nums" id="match_nums" class="form-control" value="<?=$model['match_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">符合未交付</label>
            <div class="col-sm-6">
                <input type="text" name="unalready_nums" id="unalready_nums" class="form-control" value="<?=$model['unalready_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">符合已交付</label>
            <div class="col-sm-6">
                <input type="text" name="already_nums" id="already_nums" class="form-control" value="<?=$model['already_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">应收金额</label>
            <div class="col-sm-6">
                <input type="text" name="total_money" id="total_money" class="form-control" value="<?=$model['total_money']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">实收金额</label>
            <div class="col-sm-6">
                <input type="text" name="real_money" id="real_money" class="form-control" value="<?=$model['real_money']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">出租居住</label>
            <div class="col-sm-6">
                <input type="text" name="rent_live" id="rent_live" class="form-control" value="<?=$model['rent_live']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">出租办公</label>
            <div class="col-sm-6">
                <input type="text" name="rent_office" id="rent_office" class="form-control" value="<?=$model['rent_office']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">酒店</label>
            <div class="col-sm-6">
                <input type="text" name="hotel" id="hotel" class="form-control" value="<?=$model['hotel']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">员工宿舍</label>
            <div class="col-sm-6">
                <input type="text" name="dormitory" id="dormitory" class="form-control" value="<?=$model['dormitory']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">自用办公</label>
            <div class="col-sm-6">
                <input type="text" name="self_office" id="self_office" class="form-control" value="<?=$model['self_office']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">自用居住</label>
            <div class="col-sm-6">
                <input type="text" name="self_live" id="self_live" class="form-control" value="<?=$model['self_live']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">空置</label>
            <div class="col-sm-6">
                <input type="text" name="vacant" id="vacant" class="form-control" value="<?=$model['vacant']?>">
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
			var unsale_nums = $('#unsale_nums').val();
			var sale_nums = $('#sale_nums').val();
			var unmatch_nums = $('#unmatch_nums').val();
			var match_nums = $('#match_nums').val();
			var unalready_nums = $('#unalready_nums').val();
			var already_nums = $('#already_nums').val();
			var total_money = $('#total_money').val();
			var real_money = $('#real_money').val();
			var rent_live = $('#rent_live').val();
            var rent_office = $('#rent_office').val();
            var hotel = $('#hotel').val();
            var dormitory = $('#dormitory').val();
            var self_office = $('#self_office').val();
            var self_live = $('#self_live').val();
            var vacant = $('#vacant').val();
			if (house_id == undefined || parseInt(house_id) == 0) {
				alert('请选择正确的项目');return false;
			}
			if (seat_id == undefined || parseInt(seat_id) == 0) {
				alert('请选择正确的楼盘');return false;
			}
			if (total_nums == undefined || parseInt(total_nums) < 0) {
				alert('总数不能为空');return false;
			}
			if (unsale_nums == undefined || parseInt(unsale_nums) < 0) {
				alert('未售数不能为空');return false;
			}
			if (sale_nums == undefined || parseInt(sale_nums) < 0) {
				alert('已售数不能为空');return false;
			}
			if (unmatch_nums == undefined || parseInt(unmatch_nums) < 0) {
				alert('不符合交付数不能为空');return false;
			}
			if (match_nums == undefined || parseInt(match_nums) < 0) {
				alert('符合交付数不能为空');return false;
			}
			if (unalready_nums == undefined || parseInt(unalready_nums) < 0) {
				alert('符合未交付数不能为空');return false;
			}
			if (already_nums == undefined || parseInt(already_nums) < 0) {
				alert('符合已交付数不能为空');return false;
			}
			if (total_money == undefined || parseFloat(total_money) < 0) {
				alert('应收金额不能为空');return false;
			}
			if (real_money == undefined || parseFloat(real_money) < 0) {
				alert('应收金额不能为空');return false;
			}
			$.ajax({
				type:'post',
				dataType:'json',
				url:'/admin/house-data/ajax-add-house-data',
				data:{
					id:id,
					house_id:house_id,
					seat_id:seat_id,
					house_type:house_type,
					total_nums:total_nums,
					unsale_nums:unsale_nums,
					sale_nums:sale_nums,
					unmatch_nums:unmatch_nums,
					match_nums:match_nums,
					unalready_nums:unalready_nums,
					already_nums:already_nums,
					total_money:total_money,
					real_money:real_money,
					rent_live:rent_live,
            		rent_office:rent_office,
            		hotel:hotel,
            		dormitory:dormitory,
            		self_office:self_office,
            		self_live:self_live,
            		vacant:vacant
				},
				success:function(res){
					if (res.code == 200) {
						alert(res.msg);
						location.href = '/admin/house-data/house-data-list';
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