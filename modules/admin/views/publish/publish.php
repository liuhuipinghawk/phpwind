<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = empty($id) ? '添加房屋租赁' : '编辑房屋租赁';
$this->params['breadcrumbs'][] = ['label' => '房屋租赁', 'url' => ['publish-list']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
	.thumbnail{border: 0; display: block; float: left;}
	.file-item img{float: left; width: 100px; height: 100px;}
	.del-img{float: left; margin-top: 50px; color: red;}
</style>

<div style="width:70%; margin-left: 10%; display: block; float: left;">
    <h3><?php echo $this->title; ?></h3>
	<form class="form-horizontal">
		<input type="hidden" name="dir" id="dir" value="3d">
		<input type="hidden" name="id" id="id" value="<?=$model['publish_id']?>">
		<!-- house_id -->
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
        <!-- house_type -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;房源类型</label>
            <div class="col-sm-4">
                <select name="house_type" id="house_type" class="form-control">
                	<option value="">房源类型</option>
                	<option value="1" <?php if($model['house_type'] == 1) echo 'selected';?>>写字楼</option>
					<option value="2" <?php if($model['house_type'] == 2) echo 'selected';?>>公寓</option>
					<option value="3" <?php if($model['house_type'] == 3) echo 'selected';?>>商铺</option>
                </select>
            </div>
        </div>
        <!-- region -->
		<div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;区域</label>
            <div class="col-sm-4">
                <select name="region_id" id="region_id" class="form-control">
                	<option value="">选择区域</option>
                	<?php if($region): foreach($region as $k => $v): ?>
                		<option value="<?=$v['region_id']?>" <?php if($v['parent_id'] == 0) echo 'disabled';?> <?php if($model['region_id'] == $v['region_id']) echo 'selected';?>><?=$v['region_name']?></option>
                	<?php endforeach;endif; ?>
                </select>
            </div>
        </div>
        <!-- subway -->
		<div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;地铁</label>
            <div class="col-sm-4">
                <select name="subway_id" id="subway_id" class="form-control">
                	<option value="">选择地铁</option>
                	<?php if($subway): foreach($subway as $k => $v): ?>
                		<option value="<?=$v['subway_id']?>" <?php if($v['parent_id'] == 0) echo 'disabled';?> <?php if($model['subway_id'] == $v['subway_id']) echo 'selected';?>><?=$v['subway_name']?></option>
                	<?php endforeach;endif; ?>
                </select>
            </div>
        </div>
        <!-- space -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;面积</label>
            <div class="col-sm-4">
				<input type="text" name="space" id="space" class="form-control" value="<?=$model['space']?>" placeholder="请输入面积">
            </div>
        </div>
        <!-- price/unit -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;价格/单位</label>
            <div class="col-sm-4">
				<input type="text" name="price" id="price" class="form-control" value="<?=$model['price']?>" placeholder="价格" style="width: 100px; float: left;"> <span style="width: 20px; height:34px; line-height: 34px; text-align: center; display: block; float: left;">/</span>
				<input type="text" name="unit" id="unit" class="form-control" value="<?=$model['unit']?>" placeholder="单位" style="width: 100px; float: left;">
            </div>
        </div>
        <!-- house_imgs -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;轮播图</label>
            <div class="col-sm-6">
                <div class="filePicker" onclick="add_id('house_img')">请上传房屋轮播图</div>
                <?php if (empty($house_imgs)): ?>
                    <div id="fileList_house_img"></div>
                <?php else: ?>
                    <div id="fileList_house_img">
                        <?php foreach ($house_imgs as $k => $v): ?>
                        <div id="WU_FILE_$k" class="file-item thumbnail" data-url="<?=$v['img_path']?>">
                            <img src="<?=$v['img_path']?>">
                            <span class="glyphicon glyphicon-trash del-img"></span>
                        </div>    
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
        <!-- img_3d -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;全景图</label>
            <div class="col-sm-4">
                <div class="filePicker" onclick="add_id('qj')">请上传房屋全景图</div>
                <?php if (empty($model['img_3d'])): ?>
                    <div id="fileList_qj"></div>
                <?php else: ?>
                    <div id="fileList_qj">
                        <div id="WU_FILE_0" class="file-item thumbnail" data-url="<?=$model['img_3d']?>">
                            <img src="<?=$model['img_3d']?>">
                            <span class="glyphicon glyphicon-trash del-img"></span>
                        </div>  
                    </div>
                <?php endif ?>
            </div>
        </div>
        <!-- age -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;房源年份</label>
            <div class="col-sm-4">
				<input type="text" name="age" id="age" class="form-control" value="<?=$model['age']?>" placeholder="请输入房龄">
            </div>
        </div>
        <!-- floor -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;楼层</label>
            <div class="col-sm-4">
				<input type="text" name="floor" id="floor" class="form-control" value="<?=$model['floor']?>" placeholder="请输入楼层">
            </div>
        </div>
		<!-- deco_id -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;装修</label>
            <div class="col-sm-4">
                <select name="deco_id" id="deco_id" class="form-control">
                	<option value="">选择装修</option>
                	<?php if($deco): foreach($deco as $k => $v): ?>
                		<option value="<?=$v['deco_id']?>" <?php if($model['deco_id'] == $v['deco_id']) echo 'selected';?>><?=$v['deco_name']?></option>
                	<?php endforeach;endif; ?>
                </select>
            </div>
        </div>
		<!-- orien_id -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;朝向</label>
            <div class="col-sm-4">
                <select name="orien_id" id="orien_id" class="form-control">
                	<option value="">选择朝向</option>
                	<?php if($orien): foreach($orien as $k => $v): ?>
                		<option value="<?=$v['orien_id']?>" <?php if($model['orien_id'] == $v['orien_id']) echo 'selected';?>><?=$v['orien_name']?></option>
                	<?php endforeach;endif; ?>
                </select>
            </div>
        </div>
        <!-- house_desc -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;房源描述</label>
            <div class="col-sm-4">
            	<script id="house_desc" type="text/plain" style="width:800px;height:280px;"><?=htmlspecialchars_decode($model['house_desc'])?></script>
            </div>
        </div>
        <!-- address -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;详细地址</label>
            <div class="col-sm-4">
				<input type="text" name="address" id="address" class="form-control" value="<?=$model['address']?>" placeholder="请输入详细地址">
            </div>
        </div>
        <!-- person -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;联系人</label>
            <div class="col-sm-4">
				<input type="text" name="person" id="person" class="form-control" value="<?=$model['person']?>" placeholder="请输入联系人">
            </div>
        </div>
        <!-- person_tel -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;联系方式</label>
            <div class="col-sm-4">
				<input type="text" name="person_tel" id="person_tel" class="form-control" value="<?=$model['person_tel']?>" placeholder="请输入联系方式">
            </div>
        </div>

        <div class="form-group">
        	<label for="" class="col-sm-2 control-label">&nbsp;</label>
            <div class="col-sm-4">
        		<input type="button" class="btn btn-default btn_submit" name='submit' value="提交" >
        	</div>
        </div>
	</form>	
</div>

<?=Html::cssFile('/css/webuploader.css')?>   
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/js/webuploader/webuploader.js')?>
<?=Html::jsFile('/js/upload_3d.js')?>

<link rel="stylesheet" type="text/css" href="/ueditor/themes/default/css/ueditor.min.css">
<script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>

<script type="text/javascript">
	var ue = UE.getEditor('house_desc');
    $('.btn_submit').click(function(){
        var id         = $('#id').val();
        var house_id   = $('#house_id').val();
        var house_type = $('#house_type').val();
        var region_id  = $('#region_id').val();
        var subway_id  = $('#subway_id').val();
        var space      = $('#space').val();
        var price      = $('#price').val();
        var unit       = $('#unit').val();
        var age        = $('#age').val();
        var floor      = $('#floor').val();
        var deco_id    = $('#deco_id').val();
        var orien_id   = $('#orien_id').val();
        var house_desc = ue.getContent();
        var address    = $('#address').val();
        var person     = $('#person').val();
        var person_tel = $('#person_tel').val();
        var house_imgs = [];
        $('#fileList_house_img').find('.file-item').each(function(){
            house_imgs.push($(this).data('url'));
        });
        var img_3d = $('#fileList_qj').find('.file-item').data('url') == undefined ? '' : $('#fileList_qj').find('.file-item').data('url');

        if (house_id == undefined || house_id.length == 0) {
            alert('请选择楼盘');return false;
        }
        if (house_type == undefined || (house_type !=1 && house_type != 2 && house_type != 3)) {
            alert('请选择房源类型');return false;
        }
        if (region_id == undefined || region_id.length == 0) {
            alert('请选择区域');return false;
        }
        if (subway_id == undefined || subway_id.length == 0) {
            alert('请选择地铁');return false;
        }
        if (space == undefined || space.length == 0) {
            alert('请输入面积');return false;
        }
        if (price == undefined || price.length == 0) {
            alert('请输入价格');return false;
        }
        if (unit == undefined || unit.length == 0) {
            alert('请输入单位');return false;
        }
        if (age == undefined || age.length == 0) {
            alert('请输入房源年份');return false;
        }
        if (floor == undefined || floor.length == 0) {
            alert('请输入楼层');return false;
        }
        if (deco_id == undefined || deco_id.length == 0) {
            alert('请选择装修');return false;
        }
        if (orien_id == undefined || orien_id.length == 0) {
            alert('请选择朝向');return false;
        }
        if (house_desc == undefined || house_desc.length == 0) {
            alert('请输入房源描述');return false;
        }
        if (address == undefined || address.length == 0) {
            alert('请输入详细地址');return false;
        }
        if (person == undefined || person.length == 0) {
            alert('请输入联系人');return false;
        }
        if (person_tel == undefined || person_tel.length == 0) {
            alert('请输入联系方式');return false;
        }
        var data = {};
        data.publish_id = id;
        data.house_id = house_id;
        data.house_type = house_type;
        data.region_id = region_id;
        data.subway_id = subway_id;
        data.space = space;
        data.price = price;
        data.unit = unit;
        data.img_3d = img_3d;
        data.age = age;
        data.floor = floor;
        data.deco_id = deco_id;
        data.orien_id = orien_id;
        data.house_desc = house_desc;
        data.address = address;
        data.person = person;
        data.person_tel = person_tel;
        $.ajax({
            type:'post',
            dataType:'json',
            url:'/admin/publish/do-publish',
            data:{
                data,
                house_imgs:house_imgs
            },
            success:function(res){
                if (res.code == 200) {
                    alert(res.msg);
                    location.href = '/admin/publish/index';
                } else {
                    alert(res.msg);return false;
                }
            }
        });
    });
</script>
