<?php 
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '新增数据';
if ($model) {
	$this->title = '修改数据';
};

$this->params['breadcrumbs'][] = ['label' => '房屋交付收费列表', 'url' => ['house-data/house-charge-list']];
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
            <label for="" class="col-sm-2 control-label">应收金额</label>
            <div class="col-sm-6">
                <input type="text" name="total_money" id="total_money" class="form-control" value="<?=$model['total_money']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">已收金额</label>
            <div class="col-sm-6">
                <input type="text" name="get_money" id="get_money" class="form-control" value="<?=$model['get_money']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">当前收取金额</label>
            <div class="col-sm-6">
                <input type="text" name="current_money" id="current_money" class="form-control" value="<?=$model['current_money']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">未收金额</label>
            <div class="col-sm-6">
                <input type="text" name="unget_money" id="unget_money" class="form-control" value="<?=$model['unget_money']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">应收户数</label>
            <div class="col-sm-6">
                <input type="text" name="total_nums" id="total_nums" class="form-control" value="<?=$model['total_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">已收户数</label>
            <div class="col-sm-6">
                <input type="text" name="get_nums" id="get_nums" class="form-control" value="<?=$model['get_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">当前收取户数</label>
            <div class="col-sm-6">
                <input type="text" name="current_nums" id="current_nums" class="form-control" value="<?=$model['current_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">未收户数</label>
            <div class="col-sm-6">
                <input type="text" name="unget_nums" id="unget_nums" class="form-control" value="<?=$model['unget_nums']?>">
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
			var total_money = $('#total_money').val();
			var get_money = $('#get_money').val();
			var current_money = $('#current_money').val();
			var unget_money = $('#unget_money').val();
			var total_nums = $('#total_nums').val();
			var get_nums = $('#get_nums').val();
			var current_nums = $('#current_nums').val();
			var unget_nums = $('#unget_nums').val();
			
			if (house_id == undefined || parseInt(house_id) == 0) {
				alert('请选择正确的项目');return false;
			}
			if (seat_id == undefined || parseInt(seat_id) == 0) {
				alert('请选择正确的楼盘');return false;
			}
			if (total_money == undefined || parseFloat(total_money) < 0) {
				alert('总数不能为空');return false;
			}
			if (get_money == undefined || parseFloat(get_money) < 0) {
				alert('未售数不能为空');return false;
			}
			if (current_money == undefined || parseFloat(current_money) < 0) {
				alert('已售数不能为空');return false;
			}
			if (unget_money == undefined || parseFloat(unget_money) < 0) {
				alert('不符合交付数不能为空');return false;
			}
			if (total_nums == undefined || parseInt(total_nums) < 0) {
				alert('符合交付数不能为空');return false;
			}
			if (get_nums == undefined || parseInt(get_nums) < 0) {
				alert('符合未交付数不能为空');return false;
			}
			if (current_nums == undefined || parseInt(current_nums) < 0) {
				alert('符合已交付数不能为空');return false;
			}
			if (unget_nums == undefined || parseFloat(unget_nums) < 0) {
				alert('应收金额不能为空');return false;
			}
			$.ajax({
				type:'post',
				dataType:'json',
				url:'/admin/house-data/ajax-add-house-charge',
				data:{
					id:id,
					house_id:house_id,
					seat_id:seat_id,
					house_type:house_type,
					total_money:total_money,
					get_money:get_money,
					current_money:current_money,
					unget_money:unget_money,
					total_nums:total_nums,
					get_nums:get_nums,
					current_nums:current_nums,
					unget_nums:unget_nums
				},
				success:function(res){
					if (res.code == 200) {
						alert(res.msg);
						location.href = '/admin/house-data/house-charge-list';
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