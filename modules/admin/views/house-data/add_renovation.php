<?php 
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '新增数据';
if ($model) {
	$this->title = '修改数据';
};

$this->params['breadcrumbs'][] = ['label' => '装修办理列表', 'url' => ['house-data/renovation']];
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
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">已办理装修户数</label>
            <div class="col-sm-6">
                <input type="text" name="renovation_nums" id="renovation_nums" class="form-control" value="<?=$model['renovation_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">已验收户数</label>
            <div class="col-sm-6">
                <input type="text" name="check_nums" id="check_nums" class="form-control" value="<?=$model['check_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">已退保证金户数</label>
            <div class="col-sm-6">
                <input type="text" name="return_nums" id="return_nums" class="form-control" value="<?=$model['return_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">正在装修户数</label>
            <div class="col-sm-6">
                <input type="text" name="nowing_nums" id="nowing_nums" class="form-control" value="<?=$model['nowing_nums']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">当前申请装修户数</label>
            <div class="col-sm-6">
                <input type="text" name="current_nums" id="current_nums" class="form-control" value="<?=$model['current_nums']?>">
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
			var renovation_nums = $('#renovation_nums').val();
			var check_nums = $('#check_nums').val();
			var return_nums = $('#return_nums').val();
            var nowing_nums = $('#nowing_nums').val();
			var current_nums = $('#current_nums').val();
			if (house_id == undefined || parseInt(house_id) == 0) {
				alert('请选择正确的项目');return false;
			}
			if (seat_id == undefined || parseInt(seat_id) == 0) {
				alert('请选择正确的楼盘');return false;
			}
			if (renovation_nums == undefined || parseInt(renovation_nums) < 0) {
				alert('已办理装修户数不能为空');return false;
			}
			if (check_nums == undefined || parseInt(check_nums) < 0) {
				alert('已验收户数不能为空');return false;
			}
			if (return_nums == undefined || parseInt(return_nums) < 0) {
				alert('已退保证金户数不能为空');return false;
			}
			if (nowing_nums == undefined || parseInt(nowing_nums) < 0) {
				alert('正在装修户数不能为空');return false;
			}
			if (current_nums == undefined || parseInt(current_nums) < 0) {
				alert('当前申请装修户数不能为空');return false;
			}
			$.ajax({
				type:'post',
				dataType:'json',
				url:'/admin/house-data/ajax-add-renovation',
				data:{
					id:id,
					house_id:house_id,
					seat_id:seat_id,
					house_type:house_type,
                    renovation_nums:renovation_nums,
                    check_nums:check_nums,
                    return_nums:return_nums,
                    nowing_nums:nowing_nums,
					current_nums:current_nums
				},
				success:function(res){
					if (res.code == 200) {
						alert(res.msg);
						location.href = '/admin/house-data/renovation';
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