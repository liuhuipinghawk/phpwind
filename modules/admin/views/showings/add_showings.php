<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = empty($id) ? '添加3D看房' : '编辑3D看房';
$this->params['breadcrumbs'][] = ['label' => '3D看房列表', 'url' => ['showings-list']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
	.thumbnail{border: 0;}
	.file-item img{float: left; width: 100px; height: 100px;}
	.del-img{float: left; margin-top: 50px; color: red;}
</style>

<div style="width:70%; margin-left: 10%; display: block; float: left;">
    <h3><?php echo $this->title; ?></h3>
	<form class="form-horizontal">
		<input type="hidden" name="dir" id="dir" value="3d">
		<input type="hidden" name="id" id="id" value="<?=$model['id']?>">
		<!-- 类型 -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;类型</label>
            <div class="col-sm-4">
                <select name="type" id="type" class="form-control">
                	<option value="0" <?php if($model['type'] == 0) echo 'selected';?>>楼盘</option>
                	<option value="1" <?php if($model['type'] == 1) echo 'selected';?>>大堂</option>
					<option value="2" <?php if($model['type'] == 2) echo 'selected';?>>电梯间</option>
					<option value="3" <?php if($model['type'] == 3) echo 'selected';?>>走廊</option>
					<option value="4" <?php if($model['type'] == 4) echo 'selected';?>>房源</option>
                </select>
            </div>
        </div>

        <!-- 楼盘 -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;所属楼盘</label>
            <div class="col-sm-4">
                <select name="house_id" id="house_id" class="form-control">
                	<option value="">选择楼盘</option>
                	<?php if($house): foreach($house as $k => $v): ?>
                		<option value="<?=$v['id']?>" <?php if($model['house_id'] == $v['id']) echo 'selected';?>><?=$v['housename']?></option>
                	<?php endforeach;endif; ?>
                </select>
            </div>
        </div>
		
		<!-- 楼盘-地址、标识 -->
		<div id="lp">
	        <div class="form-group">
	            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;详细地址</label>
	            <div class="col-sm-4">
	            	<input type="text" name="address" id="address" class="form-control" value="<?=$model['address']?>">
	            </div>
	        </div>
	        <div class="form-group">
	            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;标识</label>
	            <div class="col-sm-4">
	            	<input type="checkbox" name="chk_tag" value="写字楼" <?php if(strpos($model['tag'],'写字楼') !== false) echo 'checked';?>> 写字楼
	            	<input type="checkbox" name="chk_tag" value="商铺" <?php if(strpos($model['tag'],'商铺') !== false) echo 'checked';?>> 商铺
	            	<input type="checkbox" name="chk_tag" value="公寓" <?php if(strpos($model['tag'],'公寓') !== false) echo 'checked';?>> 公寓
	            </div>
	        </div>
        </div>

        <!-- 大堂、电梯间、走廊-楼座、描述 -->
        <div id="dt" <?php if(!in_array($model['type'],[1,2,3])) echo 'style="display: none;"';?>>
	        <!-- <div class="form-group">
	            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;所属楼座</label>
	            <div class="col-sm-4">
	                <select name="seat_id" id="seat_id" class="form-control">
	                	<option value="">选择楼座</option>
	                </select>
	            </div>
	        </div> -->
	        <div class="form-group">
	            <label for="" class="col-sm-2 control-label">&nbsp;描述</label>
	            <div class="col-sm-4">
	            	<input type="desc" name="desc" id="desc" class="form-control" placeholder="请输入描述" value="<?=$model['desc']?>">
	            </div>
	        </div>
        </div>

        <!-- 房源-房间号 -->
        <div class="form-group" id="roomnum" <?php if($model['type'] != 4) echo 'style="display: none;"';?>>
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;房间号</label>
            <div class="col-sm-4">
                <input type="text" name="room_num" id="room_num" class="form-control" placeholder="请输入房间号" value="<?=$model['room_num']?>">
            </div>
        </div>
		
		<!-- 封面图 -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;封面图</label>
            <div class="col-sm-4" style="width: 200px;">
                <div class="filePicker" onclick="add_id('a0')">请上传封面图</div>
            	<?php if (empty($model['img_thumb'])): ?>
            		<div id="fileList_a0"></div>
        		<?php else: ?>
        			<div id="fileList_a0">
	            		<div id="WU_FILE_0" class="file-item thumbnail" data-url="<?=$model['img_thumb']?>">
	            			<img src="<?=$model['img_thumb']?>">
	            			<span class="glyphicon glyphicon-trash del-img"></span>
	            		</div>	
            		</div>
            	<?php endif ?>
            </div>
        </div>

        <!-- 全景图 -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span id="qjt" style="color: red;">*</span>&nbsp;全景图</label>
            <div class="col-sm-4" style="width: 200px;">
                <div class="filePicker" onclick="add_id('a1')">请上传全景图</div>
            	<?php if (empty($model['img_path'])): ?>
            		<div id="fileList_a1"></div>
        		<?php else: ?>
        			<div id="fileList_a1">
	            		<div id="WU_FILE_0" class="file-item thumbnail" data-url="<?=$model['img_path']?>">
	            			<img src="<?=$model['img_path']?>">
	            			<span class="glyphicon glyphicon-trash del-img"></span>
	            		</div>	
            		</div>
            	<?php endif ?>
            </div>
        </div>

        <div style="display: none;">
        	<hr>
	        <div id="area_block"></div>
	        <a class="btn btn-success btn_add" style="margin-left: 17%">新增室内全景图</a>
        </div>

        <div class="form-group">
        	<label for="" class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-4">
        		<input type="button" class="btn btn-default btn_submit" name='submit' value="提交" >
        	</div>
        </div>
	</form>	
</div>

<div id="area_block_tpl" style="display: none;">
	<div class="form-group">
        <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;区域图片名称</label>
        <div class="col-sm-4">
            <input type="text" name="room_num" class="form-control" placeholder="请输入房间号">
        </div>
    </div>
    <div class="form-group">
        <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;封面图</label>
        <div class="col-sm-4" style="width:200px;">
            <div class="filePicker" onclick="add_id('c0')">请上传封面图</div>
        	<div id="fileList_c0"></div>
        </div>
        <div class="col-sm-4" style="width:200px;">
            <div class="filePicker" onclick="add_id('d0')">请上传全景图</div>
        	<div id="fileList_d0"></div>
        </div>
    </div>
</div>

<?=Html::cssFile('/css/webuploader.css')?>  
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/js/webuploader/webuploader.js')?>
<?=Html::jsFile('/js/upload_3d.js')?>

<script type="text/javascript">
	$(function(){
		var house_id = "<?=$model['house_id']?>";
		var seat_id = "<?=$model['seat_id']?>";
		bindSeatData(house_id,seat_id);
		if ($('#type').val() == 0) {
			$('#qjt').hide();
		}
		/**
		 * 楼盘切换
		 * @Author   tml
		 * @DateTime 2018-03-21
		 * @param    {[type]}   ){			var house_id      [description]
		 * @return   {[type]}             [description]
		 */
		$('#house_id').change(function(){
			var house_id = $(this).val();
			bindSeatData(house_id,0);
		});
		/**
		 * 提交
		 * @Author   tml
		 * @DateTime 2018-03-21
		 * @param    {[type]}   ){		} [description]
		 * @return   {[type]}           [description]
		 */
		$('.btn_submit').click(function(){
			var id        = $('#id').val();
			var type      = $('#type').val();
			var type_name = $('#type option:selected').html();
			var house_id  = $('#house_id').val();
			var address   = '';
			var tag       = '';
			var seat_id   = 0;
			var desc      = '';
			var room_num  = '';
			var img_thumb = '';
			var img_path  = '';
			if (type_name == undefined || type_name.length == 0) {
				alert('请选择类型');return false;
			}
			if (house_id == undefined || house_id.length == 0) {
				alert('请选择楼盘');return false;
			}
			if (type == 0) {
				address   = $('#address').val();
				img_thumb = $('#fileList_a0').find('.file-item').data('url');
				$('input[name=chk_tag]:checked').each(function(){
					if (tag != '') 
						tag += ',';
					tag += $(this).val();
				});
				if (address == undefined || address.length == 0) {
					alert('请填写楼盘地址');return false;
				}
				if (img_thumb == undefined || img_thumb.length == 0) {
					alert('请上传封面图');return false;
				}
				if (tag == '') {
					alert('请勾选标识');return false;
				}
			} else {
				// seat_id   = $('#seat_id').val();
				desc      = $('#desc').val();
				img_thumb = $('#fileList_a0').find('.file-item').data('url');
				img_path  = $('#fileList_a1').find('.file-item').data('url');
				// if (seat_id == undefined || seat_id.length == 0) {
				// 	alert('请选择楼座');return false;
				// }
				if (img_thumb == undefined || img_thumb.length == 0) {
					alert('请上传封面图');return false;
				}
				if (img_path == undefined || img_path.length == 0) {
					alert('请上传全景图');return false;
				}
				if (type == 4) {
					room_num = $('#room_num').val();
					if (room_num == '' || room_num.length == 0) {
						alert('请输入房间号');return false;
					}
				}
			}
			$.ajax({
				dataType:'json',
				type:'post',
				url:'/admin/showings/do-add-showings',
				data:{
					id:id,
					type:type,
					house_id:house_id,
					address:address,
					tag:tag,
					seat_id:seat_id,
					type_name:type_name,
					desc:desc,
					room_num:room_num,
					img_thumb:img_thumb,
					img_path:img_path
				},
				success:function(res){
					if (res.code == 200) {
						alert(res.msg);
						location.href = '/admin/showings/showings-list';
					} else {
						alert(res.msg);return false;
					}
				}
			});
		});
		/**
		 * 类型切换
		 * @Author   tml
		 * @DateTime 2018-03-23
		 * @param    {[type]}   house_id         [description]
		 * @param    {String}   seat_id)	{		var _option       [description]
		 * @return   {[type]}                    [description]
		 */
		$('#type').change(function(){
			var type = $(this).val();
			if (type == 0) {
				$('#lp').show();
				$('#dt').hide();
				$('#roomnum').hide();
				$('#qjt').hide();
			} else if (type == 4) {
				$('#roomnum').show();
				$('#qjt').show();
				$('#lp').hide();
				$('#dt').hide();
			} else {	
				$('#dt').show();
				$('#qjt').show();
				$('#lp').hide();		
				$('#roomnum').hide();
			}
		});
		/**
		 * 新增室内全景图
		 * @Author   tml
		 * @DateTime 2018-03-23
		 * @param    {[type]}   ){		} [description]
		 * @return   {[type]}           [description]
		 */
		$('.btn_add').click(function(){
			var _html = $('#area_block_tpl').html();
			var _html = '<div class="area_block">'+_html+'</div>';
			$('#area_block').append(_html);
		});
	});

	/**
	 * 绑定楼座信息
	 * @Author   tml
	 * @DateTime 2018-03-21
	 * @param    {[type]}   house_id [description]
	 * @return   {[type]}            [description]
	 */
	function bindSeatData(house_id,seat_id)
	{
		var _option = '<option value="">选择楼座</option>';
		if (house_id) {
			$.ajax({
				dataType:'json',
				type:'post',
				url:'/admin/showings/get-house-info',
				data:{
					parent_id:house_id
				},
				success:function(res){
					if (res.code == 200) {
						var l = res.data.length;
						if (l > 0) {
							for(var i = 0; i < l; i++){
								if (seat_id == res.data[i]['id']) {
									_option += '<option value="'+res.data[i]['id']+'" selected>'+res.data[i]['housename']+'</option>';
								} else {
									_option += '<option value="'+res.data[i]['id']+'">'+res.data[i]['housename']+'</option>';
								} 
							}
							$('#seat_id').html(_option);
						}
					}
				}
			});
		}
		$('#seat_id').html(_option);
	}
</script>