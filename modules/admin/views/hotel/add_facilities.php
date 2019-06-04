<?php 
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '新增基础设施';
if ($model) {
	$this->title = '修改基础设施';
};
$this->params['breadcrumbs'][] = ['label' => '基础设施管理', 'url' => ['facilities']];
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

<div style="width:70%; margin-left: 10%; display: block; float: left;">
    <h3><?php echo $this->title; ?></h3>
    <form class="form-horizontal">
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">设施名称</label>
            <div class="col-sm-8">
                <input type="input" class="form-control" name="faci_name" id="faci_name" value="<?php echo $model['faci_name']; ?>" placeholder="请输入设施名称">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">所属类型</label>
            <div class="col-sm-8">
                <select name="faci_type" id="faci_type" class="form-control">
                	<option value="1" <?php if($model['faci_type'] == 1) echo 'selected'; ?>>酒店</option>
                	<option value="2" <?php if($model['faci_type'] == 2) echo 'selected'; ?>>美食</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">上传图标</label>
            <div class="col-sm-8">	
                <div id="fileList">
                <?php if(!empty($model)){ ?>
                    <div class="file-item thumbnail" data-url="<?php echo $model['faci_icon']; ?>">
                        <img src="<?php echo $model['faci_icon']; ?>">
                        <span class="glyphicon glyphicon-trash del-img1"></span>
                    </div>
                <?php } ?>
                </div>

                <div id="filePicker" onclick="return checkImg();"></div>

				<input type="hidden" id="dir" value="icon">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
                <input type="hidden" id="faci_id" value="<?php echo $model['faci_id']; ?>">
                <button type="button" class="btn btn-default btn_submit">提交</button>
            </div>
        </div>
    </form>
</div>

<script>
	$(function(){
		$('.btn_submit').click(function(){
            var faci_id   = $('#faci_id').val();
			var faci_name = $('#faci_name').val();
			var faci_type = $('#faci_type').val();
			var url = $('#fileList').find('.file-item').data('url');
			if (faci_name == undefined || faci_name.length == 0) {
				alert('请输入设施名称');
				return false;
			}
			if (faci_type == undefined || faci_type.length == 0) {
				alert('请输入设施名称');
				return false;
			}
            if (url == undefined || url.length == 0) {
                alert('请上传设施图标');
                return false;
            }
            $.post("<?=Url::to(['hotel/ajax-add-facilities'])?>",{
                faci_id:faci_id,
                faci_name:faci_name,
                faci_type:faci_type,
                url:url
            },function(res){
                if (res.code == 200) {
                    alert('操作成功');
                    location.href = "<?=Url::to(['hotel/facilities'])?>";
                } else {
                    alert(res.msg);
                    return false;
                }
            },"JSON");
		});
	});

    function checkImg(){
        if ($('#fileList').find('.file-item').length) {
            alert('请先删除已上传的图片');
            return false;
        }
    }
</script>
