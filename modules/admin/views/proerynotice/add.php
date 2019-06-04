<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '发布公告';
$this->params['breadcrumbs'][] = ['label' => '公告列表', 'url' => ['index']];
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
            <label class="control-label">楼盘</label>
                <select class="form-control" id="house_id" name="house_id" required="required">
                    <option value="">--请选择楼盘--</option>
                    <?php foreach ($house as $key=>$val){ ?>
                        <option value="<?php echo $val['id'];  ?>"><?php echo $val['housename'];  ?></option>
                    <?php } ?>
                </select>
        </div>
        <div class="form-group field-user-logintime">
            <label class="control-label">标题</label>
            <input class="form-control" type="text" placeholder="" id="title" required="required" name="title">
        </div>
        <div class="form-group field-user-logintime">
            <label class="control-label">内容</label>
            <input class="form-control" type="text" placeholder="" id="content" required="required" name="content">
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
            var title    = $('#title').val();
            var content     = $('#content').val();
            var data = {};
            data.house_id = house_id;
            data.title  = title;
            data.content = content;
            $.post('/index.php?r=admin/proerynotice/add',data,function(res){
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