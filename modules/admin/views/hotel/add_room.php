<?php 
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '新增客房信息';
if ($model) {
	$this->title = '修改客房信息';
};
$this->params['breadcrumbs'][] = ['label' => '酒店列表管理', 'url' => ['hotel']];
$this->params['breadcrumbs'][] = ['label' => '客房管理', 'url' => ['rooms','hotel_id'=>$hotel_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::cssFile('/css/webuploader.css')?>  
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/js/webuploader/webuploader.js')?>
<?=Html::jsFile('/js/upload.js')?>

<style>
	#fileList .thumbnail > img, .thumbnail a > img{margin-left: 0;}
    #fileList .file-item{border: 0; width: 110px; display: block; float: left;}
    #fileList .file-item img{width:100px; height: 100px;}
    #fileList .file-item span.del-img,.file-item span.del-img1{
        display: block;
        width: 100%;
        height: 25px;
        background: rgba(0, 0, 0, .5);
        top: -25px;
        line-height: 25px;
        text-align: right;
        padding-right: 6px;
        color: #fff;
        cursor: pointer;
    }
    #filePicker{display: block; clear: both;}
</style>

<div style="width:40%; margin-left: 20%; display: block; float: left;">
    <h3><?php echo $this->title; ?></h3>
    <form class="form-horizontal">
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;客房名称</label>
            <div class="col-sm-8">
                <input type="input" class="form-control" name="room_name" id="room_name" value="<?=$model['room_name']?>" placeholder="请输入客房名称" max-length="50">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;客房类型</label>
            <div class="col-sm-8">
                <select name="room_type" id="room_type" class="form-control">
                	<?php foreach($room_type as $k => $v): ?>
	                	<option value="<?=$v['type_id']?>" <?php if($model['room_type'] == $v['type_id']) echo 'selected';?>><?=$v['type_name']?></option>
	                <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;价格</label>
            <div class="col-sm-8">
                <input type="input" class="form-control" name="price" id="price" value="<?=$model['price']?>" placeholder="请输入最低价格">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;客房图片</label>
            <div class="col-sm-10">	
                <div id="fileList">
                	<?php if($room_imgs): foreach($room_imgs as $k => $v): ?>
                	<div class="file-item thumbnail" data-url="<?php echo $v['path']; ?>">
                        <img src="<?php echo $v['path']; ?>">
                        <span class="glyphicon glyphicon-trash del-img1"></span>
                    </div>
            		<?php endforeach; endif; ?>
                </div>
                <div id="filePicker"></div>
				<input type="hidden" id="hotel" value="icon">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;床型</label>
            <div class="col-sm-8">
                <input type="input" class="form-control" name="bed_type" id="bed_type" value="<?=$model['bed_type']?>" placeholder="eg：单人床1.35x2.0米 2张" max-length="50">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;早餐</label>
            <div class="col-sm-8">
                <input type="input" class="form-control" name="breakfast" id="breakfast" value="<?=$model['breakfast']?>" placeholder="eg：双早" max-length="30">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;上网</label>
            <div class="col-sm-8">
                <input type="input" class="form-control" name="wifi" id="wifi" value="<?=$model['wifi']?>" placeholder="eg：wifi和宽带" max-length="30">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;窗户</label>
            <div class="col-sm-8">
                <input type="input" class="form-control" name="room_window" id="room_window" value="<?=$model['room_window']?>" placeholder="eg：部分房间有窗户" max-length="30">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;可住</label>
            <div class="col-sm-8">
                <input type="input" class="form-control" name="to_live" id="to_live" value="<?=$model['to_live']?>" placeholder="eg：2人" max-length="30">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;卫浴</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="bathroom" id="bathroom" value="<?=$model['bathroom'] ?>" placeholder="eg：独立" max-length="30">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;面积</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="room_space" id="room_space" value="<?=$model['room_space'] ?>" placeholder="eg：20㎡" max-length="30">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;楼层</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="floor" id="floor" value="<?=$model['floor'] ?>" placeholder="eg：18-25层" max-length="30">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
                <input type="hidden" id="hotel_id" value="<?php if($model) echo $model['hotel_id']; else echo $hotel_id; ?>">
                <input type="hidden" id="room_id" value="<?=$model['room_id']?>">
                <button type="button" class="btn btn-default btn_submit">提交</button>
            </div>
        </div>
    </form>
</div>

<script>	
	$(function(){
		$('.btn_submit').click(function(){
			var hotel_id  = $('#hotel_id').val();
			var room_id   = $('#room_id').val();
			var room_name = $('#room_name').val();
			var room_type = $('#room_type').val();
			var price     = $('#price').val();
			var bed_type  = $('#bed_type').val();
			var breakfast = $('#breakfast').val();
			var wifi      = $('#wifi').val();
			var room_window = $('#room_window').val();
			var to_live   = $('#to_live').val();
			var bathroom  = $('#bathroom').val();
			var room_space = $('#room_space').val();
			var floor     = $('#floor').val();
			var room_imgs = '';
			$('#fileList').find('.file-item').each(function(){
				room_imgs += $(this).data('url') + ',';
			});

			if (room_name == undefined || room_name.length == 0) {
				alert('请输入客房名称');return false;
			}
			if (room_type == undefined || room_type.length == 0) {
				alert('请选择客房类型');return false;
			}
			if (price == undefined || price.length == 0) {
				alert('请输入价格');return false;
			}
			if (bed_type == undefined || bed_type.length == 0) {
				alert('请输入床型信息');return false;
			}
			if (breakfast == undefined || breakfast.length == 0) {
				alert('请输入早餐信息');return false;
			}
			if (wifi == undefined || wifi.length == 0) {
				alert('请输入上网信息');return false;
			}
			if (room_window == undefined || room_window.length == 0) {
				alert('请输入客房窗户信息');return false;
			}
			if (to_live == undefined || to_live.length == 0) {
				alert('请输入可住人数');return false;
			}
			if (bathroom == undefined || bathroom.length == 0) {
				alert('请输入卫浴信息');return false;
			}
			if (room_space == undefined || room_space.length == 0) {
				alert('请输入客房面积');return false;
			}
			if (floor == undefined || floor.length == 0) {
				alert('请输入楼层信息');return false;
			}
			if (room_imgs.length == 0) {
				alert('请上传客房图片');return false;
			}

			var data = {};
			data.hotel_id  = hotel_id;
			data.room_id   = room_id;
			data.room_name = room_name;
			data.room_type = room_type;
			data.price     = price;
			data.bed_type  = bed_type;
			data.breakfast = breakfast;
			data.wifi      = wifi;
			data.room_window = room_window;
			data.to_live   = to_live;
			data.bathroom  = bathroom;
			data.room_space = room_space;
			data.floor     = floor;
			data.room_imgs = room_imgs;

			$.post("<?=Url::to(['hotel/ajax-add-room'])?>",data,function(res){
				if (res.code == 200) {
					alert('提交成功');
					location.href = "<?=Url::to(['hotel/rooms'])?>" + '&hotel_id='+hotel_id;
				} else {
					alert(res.msg);return false;
				}
			},"JSON");
		});
	});
</script>