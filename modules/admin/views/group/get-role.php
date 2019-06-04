<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '权限分配';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .table-striped > tbody > tr:nth-of-type(odd) {background: none;}
</style>
<div class="category-index" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
    if(Yii::$app->getSession()->hasFlash('error')){
        echo Alert::widget([
            'options' => [
                'class' => 'alert-success', //这里是提示框的class
            ],
            'body' => Yii::$app->getSession()->getFlash('error'), //消息体
        ]);
    }
    ?>
    <button class="select">确定</button>
    <button class="all">全选</button>
    <table class="table table-striped table-bordered">
        <tr>
            <th><input type="checkbox" name="1" /></th>
            <th>分类ID</th>
            <th>分类名称</th>
        </tr>
        <?php foreach ($gr_list as $v){ ?>
            <?php if ($v['pid'] == 0): ?>
            <tr style="background: #e8e8e8;">
            <?php else: ?>
            <tr>
            <?php endif ?>            
                <td><input type="checkbox" name="chkId" value="<?=$v['id']; ?>" <?php if(in_array($v['id'],$group_role)) echo 'checked'; ?>></td>
                <td><?=$v['id']; ?></td>
                <td><?=$v['name'];  ?></td>
            </tr>
        <?php  } ?>
    </table>
</div>
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript">
    $(function () {
        var strSel = '';
        $(".select").click(function () {
            $("[name='chkId']:checked").each(function (index,element) {
                strSel +=$(this).val() + ",";
            });
            if(strSel.length >0){
                //如果获取到
                strSel = strSel.substring(0,strSel.length - 1);
            }else{
                alert("内容不能为空！");
                return false;
            }
            var group_id = "<?php echo $_GET['id']; ?>";
            var url = "/index.php?r=admin/group/ajax-group";
            $.ajax({
                'url':url,
                'type':'post',
                'dataType':'json',
                'data':{role_id:strSel,group_id:group_id},
                success:function (data) {
                    if(data.status==200){
                        alert(data.message);
                        window.location.reload();
                        return false;
                    }else{
                        alert(data.message);
                        window.location.reload();
                        return false;
                    }
                }
            });
            return false;
        });
        //全选
        $(".all").click(function(){
            $("input[name='chkId']").each(function(){
                if (this.checked) {
                    this.checked = false;
                }
                else {
                    this.checked = true;
                }
            });
        })
    });
</script>
