<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '维保基础数据新增';
$this->params['breadcrumbs'][] = ['label' => '维保基础数据列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<div>
    <h1><?=$this->title ?></h1>
</div>
<div class="article-form">
    <form>
        <div class="form-group">
            <label class="control-label">电梯类别</label>
                <select class="form-control" id="type" name="type" required="required">
                    <option value="">--请选择类别--</option>
                    <option value="1">直梯</option>
                    <option value="2">扶梯</option>
                </select>
        </div>
        <div class="form-group">
            <label class="control-label">维护周期</label>
                <select class="form-control" id="cast" name="cast" required="required">
                    <option value="">--请选择周期--</option>
                    <option value="1">半月</option>
                    <option value="2">季度</option>
                    <option value="3">半年</option>
                    <option value="4">全年</option>
                </select>
        </div>
        <div class="form-group">
            <label class="control-label">维护保养项目</label>
            <input type="text" class="form-control" id="content" placeholder="" name="content" required="required">
        </div>
        <div class="form-group field-user-logintime">
            <label class="control-label">维护保养要求</label>
            <input class="form-control" type="text" placeholder="" id="need" required="required" name="need">
        </div>
        <div class="form-group">
            <button class="btn btn-success btn_submit" type="button">提交</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function(){

        $('.btn_submit').click(function(){
            var type = $('#type').val();
            var cast  = $('#cast').val();
            var content = $('#content').val();
            var need    = $('#need').val();
            if (type == undefined || type.length == 0) {
                alert('请选择电梯类别');return false;
            }
            if (cast == undefined || cast.length == 0) {
                alert('请选择维护周期');return false;
            }
            var data = {};
            data.type = type;
            data.cast  = cast;
            data.content = content;
            data.need     = need;
            $.post('/index.php?r=admin/work-weibao/create',data,function(res){
                if (res.code == 200) {
                    alert(res.msg);
                    parent.location.reload();
                } else {
                    alert(res.msg);
                    return false;
                }
            },'JSON');
        });
    });
</script>