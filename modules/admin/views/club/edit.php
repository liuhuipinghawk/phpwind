<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = empty($id) ? '企业入驻' : '编辑企业简介';
$this->params['breadcrumbs'][] = ['label' => '企业入驻', 'url' => ['index']];
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
        <input type="hidden" name="id" id="id" value="<?=$data['id']?>">
        <!-- house_desc -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;企业描述</label>
            <div class="col-sm-4">
                <script id="house_desc" type="text/plain" style="width:800px;height:280px;"><?=htmlspecialchars_decode($data['content'])?></script>
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
        var content = ue.getContent();
        if (content == undefined || content.length == 0) {
            alert('请输入房源描述');return false;
        }
        var data = {};
        data.id = id;
        data.content = content;
        $.ajax({
            type:'post',
            dataType:'json',
            url:'/admin/club/update',
            data:{
                data
            },
            success:function(res){
                if (res.code == 200) {
                    alert(res.msg);
                    location.href = '/admin/club/index';
                } else {
                    alert(res.msg);return false;
                }
            }
        });
    });
</script>
