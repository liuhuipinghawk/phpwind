<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\app\assets\AppAsset::register($this);
$this->title = '室内保洁预约管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <table class="table table-striped table-bordered">
        <tr>
            <th>室内保洁预约ID</th>
            <th>室内保洁项目名称</th>
            <th>预约时间</th>
            <td>结束时间</td>
            <td>联系方式</td>
            <td>联系人</td>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <?php foreach ($model as $val){ ?>
            <tr>
                <td><?php echo $val['baspeak_id']; ?></td>
                <td><?php echo $val['project_name'];  ?></td>
                <td><?php echo $val['baspeak_time'];  ?></td>
                <td><?php echo $val['end_time'];  ?></td>
                <td><?php echo $val['tell'];  ?></td>
                <td><?php echo $val['persion'];  ?></td>
                <td><?php if($val['status']==1){ ?>
                        <?php echo "<font color='#7fffd4'>未审核</font>"; ?>
                    <?php }else if($val['status']==2){?>
                        <?php echo "<font color='#ffd700'>审核中.....</font>"; ?>
                    <?php }else if($val['status']==3){ ?>
                        <?php echo "<font color='red'>信息审核完成！</font>"; ?>
                    <?php } ?>
                </td>
                <td>&nbsp<a onclick="return certification(<?php echo $val['baspeak_id']; ?>);">审核通行区域信息</a></td>
            </tr>
        <?php  } ?>
    </table>
    <?= LinkPager::widget(['pagination' => $pages]); ?>
</div>
<?=Html::jsFile('@web/js/jquery-1.12.4.js')?>
<!--<script type="text/javascript">
    function certification(id) {
        var url="http://192.168.10.113/index.php?r=admin/certification/ajax-confirm";
        //var url="index.php?r=admin/certification/confirm";
        var r = confirm("确认是否审核通行区域信息？");
        if(r==true){
            $.ajax({
                url:url,
                type:"get",
                dataType:"json",
                data:{id:id},
                success:function(data){
                    if(data.status == 200){
                        alert(data.message);
                        return false;
                    }else{
                        alert(data.message);
                        return false;
                    }
                },
                error:function (e) {
                    alert("错误！！");
                    window.clearInterval(timer);
                }
            });
        }else{
            alert("取消操作!");
        }
    }
</script>-->