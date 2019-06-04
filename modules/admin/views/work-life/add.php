<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '项目电梯数据新增';
$this->params['breadcrumbs'][] = ['label' => '项目电梯数据列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<div>
    <h1><?=$this->title ?></h1>
</div>
<div class="article-form">
    <form>
        <div class="form-group">
            <label class="control-label">楼盘名称</label>
                <select class="form-control" id="house_id" name="house_id" required="required">
                    <option value="">--请选择楼盘--</option>
                    <?php if ($house) : ?>
                        <?php foreach($house as $k => $v): ?>
                            <option value="<?=$v['id']?>"><?=$v['housename']?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
        </div>
        <div class="form-group">
            <label class="control-label">电梯类型</label>
            <select class="form-control" id="type" name="type" required="required">
                <option value="">--请选择类型--</option>
                <option value="1">电梯</option>
                <option value="2">扶梯</option>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">电梯名称</label>
            <input type="text" class="form-control" id="name" placeholder="" name="name" required="required">
        </div>
        <div class="form-group">
            <button class="btn btn-success btn_submit" type="button">提交</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function(){

        $('.btn_submit').click(function(){
            var house_id = $('#house_id').val();
            var name  = $('#name').val();
            var type = $('#type').val();
            if (house_id == undefined || house_id.length == 0) {
                alert('请选择楼盘');return false;
            }
            var data = {};
            data.house_id = house_id;
            data.name  = name;
            data.type = type;
            $.post('/index.php?r=admin/work-life/create',data,function(res){
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