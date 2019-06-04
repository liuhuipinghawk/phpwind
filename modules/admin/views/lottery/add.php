<?php 
use yii\helpers\Html;
use yii\helpers\Url;

$tag = Yii::$app->request->get('tag');
$this->title = '新增';
if ($model) {
	$this->title = '修改';
    if ($tag == 'view') {
        $this->title = '查看';
    }
};

$this->params['breadcrumbs'][] = ['label' => '大转盘抽奖', 'url' => ['lottery/list']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div>
	<h1><?=$this->title ?></h1>	
	<form class="form-horizontal">
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">活动标题</label>
            <div class="col-sm-4">
                <input type="text" name="title" id="title" class="form-control" placeholder="请输入活动标题，不可超过100字符" value="<?=$model['title']?>">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">活动时间</label>
            <div class="col-sm-2">
                <input type="datetime" name="stime" id="stime" class="form-control" placeholder="例如：2018-08-10 18:00" value="<?=$model['stime'] ? date('Y-m-d H:i',$model['stime']) : ''?>">
            </div>
            <span style="display: block; float: left; margin-left: -5px; height: 34px; line-height: 34px;">至</span>
            <div class="col-sm-2">
                <input type="datetime" name="etime" id="etime" class="form-control" placeholder="例如：2018-08-10 20:00" value="<?=$model['etime'] ? date('Y-m-d H:i',$model['etime']) : ''?>">
            </div>
        </div>
        <!-- <div class="form-group">
            <label for="" class="col-sm-2 control-label">中奖率</label>
            <div class="col-sm-4">
                <input type="text" name="probability" id="probability" class="form-control" placeholder="概率为100% 填1，50% 填0.5，以此类推">
            </div>
        </div> -->
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><h4>奖项数量设置</h4></label>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">特等奖</label>
            <div class="col-sm-4">
                <input type="number" name="te" id="te" class="form-control" value="<?=unserialize($model['award'])['te']?>" placeholder="请输入奖品数量">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">一等奖</label>
            <div class="col-sm-4">
                <input type="number" name="yi" id="yi" class="form-control" value="<?=unserialize($model['award'])['yi']?>" placeholder="请输入奖品数量">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">二等奖</label>
            <div class="col-sm-4">
                <input type="number" name="er" id="er" class="form-control" value="<?=unserialize($model['award'])['er']?>" placeholder="请输入奖品数量">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">三等奖</label>
            <div class="col-sm-4">
                <input type="number" name="san" id="san" class="form-control" value="<?=unserialize($model['award'])['san']?>" placeholder="请输入奖品数量">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">幸运奖1</label>
            <div class="col-sm-4">
                <input type="number" name="can1" id="can1" class="form-control" value="<?=unserialize($model['award'])['can1']?>" placeholder="请输入奖品数量">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">幸运奖2</label>
            <div class="col-sm-4">
                <input type="number" name="can2" id="can2" class="form-control" value="<?=unserialize($model['award'])['can2']?>" placeholder="请输入奖品数量">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">空奖</label>
            <div class="col-sm-4">
                <input type="number" name="kong" id="kong" class="form-control" value="<?=unserialize($model['award'])['kong']?>" placeholder="请输入奖品数量">
            </div>
        </div>
        <?php if ($tag != 'view'): ?>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <input type="hidden" id="id" name="id" value="<?=$model['id']?>">
                    <button type="button" class="btn btn-success btn_submit"><?php echo $model['id'] ? '提交' : '创建活动'; ?></button>
                </div>
            </div>
        <?php endif ?>        
    </form>
</div>

<?=Html::jsFile('@web/js/jquery-1.12.4.js')?>

<script type="text/javascript">
    $(function(){
        $(".btn_submit").click(function(){
            var id = $("#id").val();
            var title = $("#title").val();
            var stime = $("#stime").val();
            var etime = $("#etime").val();
            var te = $("#te").val();
            var yi = $("#yi").val();
            var er = $("#er").val();
            var san = $("#san").val();
            var can1 = $("#can1").val();
            var can2 = $("#can2").val();
            var kong = $("#kong").val();
            if (title == undefined || title.length == 0) {
                alert("请输入活动标题");
                return false;
            }
            if (title.length > 100) {
                alert("活动标题不可超过100字符");
                return false;
            }
            if (stime == undefined || stime.length == 0) {
                alert("请输入活动开始时间");
                return false;
            }
            if (etime == undefined || etime.length == 0) {
                alert("请输入活动结束时间");
                return false;
            }
            if (te == undefined || te.length == 0 || te < 0) {
                alert("请输入特等奖奖品数量");
                return false;
            }
            if (yi == undefined || yi.length == 0 || yi < 0) {
                alert("请输入一等奖奖品数量");
                return false;
            }
            if (er == undefined || er.length == 0 || er < 0) {
                alert("请输入二等奖奖品数量");
                return false;
            }
            if (san == undefined || san.length == 0 || san < 0) {
                alert("请输入三等奖奖品数量");
                return false;
            }
            if (can1 == undefined || can1.length == 0 || can1 < 0) {
                alert("请输入幸运奖1奖品数量");
                return false;
            }
            if (can2 == undefined || can2.length == 0 || can2 < 0) {
                alert("请输入幸运奖2奖品数量");
                return false;
            }
            if (kong == undefined || kong.length == 0 || kong < 0) {
                alert("请输入空奖奖品数量");
                return false;
            }
            $.post("/admin/lottery/do-add",{
                id:id,
                title:title,
                stime:stime,
                etime:etime,
                te:te,
                yi:yi,
                er:er,
                san:san,
                can1:can1,
                can2:can2,
                kong:kong
            },function(res){
                if (res.code == 200) {
                    alert(res.msg);
                    location.href = "/admin/lottery/list";
                } else {
                    alert(res.msg);
                    return false;
                }
            },"JSON");
        });
    });
</script>