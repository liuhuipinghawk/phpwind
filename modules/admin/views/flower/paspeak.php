<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\app\assets\AppAsset::register($this);
$this->title = '预约管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>
    <form class="form-inline" action="">
        <?php
        $project_name = empty(Yii::$app->request->get()['project_name']) ? '' : Yii::$app->request->get()['project_name'];
        $tell = empty(Yii::$app->request->get()['tell']) ? '' : Yii::$app->request->get()['tell'];
        $persion = empty(Yii::$app->request->get()['persion']) ? '' : Yii::$app->request->get()['persion'];
        $price = empty(Yii::$app->request->get()['price']) ? '' : Yii::$app->request->get()['price'];
        $state      = empty(Yii::$app->request->get()['state']) ? 0 : Yii::$app->request->get()['state'];
        ?>
        <div class="form-group">
            <input type="text" class="form-control" id="project_name" name="project_name" placeholder="请输入项目名称" value="<?=$project_name?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="tell" name="tell" placeholder="请输入联系方式" value="<?=$tell?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="persion" name="persion" placeholder="请输入联系人" value="<?=$persion?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="price" name="price" placeholder="项目价格" value="<?=$price?>">
        </div>
        <div class="form-group">
            <select class="form-control" name="state" id="state">
                <option value="">状态</option>
                <option value="1" <?php if($state == 1) echo 'selected';?>>等待回访</option>
                <option value="2" <?php if($state == 2) echo 'selected';?>>成功回访</option>
            </select>
        </div>
        <button type="submit" class="btn btn-default">查询</button>
    </form>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <table class="table table-striped table-bordered">
        <tr>
            <th>预约ID</th>
            <th>项目名称</th>
            <th>项目价格</th>
            <th>预约时间</th>
            <th>结束时间</th>
            <th>联系方式</th>
            <th>联系人</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <?php foreach ($model as $val){ ?>
            <tr>
                <td><?php echo $val['baspeak_id']; ?></td>
                <td><?php echo $val['project_name'];  ?></td>
                <td><?php echo $val['price'];  ?></td>
                <td><?php echo date('Y-m-d H:i:s',$val['baspeak_time']);  ?></td>
                <td><?php echo date('Y-m-d H:i:s',$val['end_time']);  ?></td>
                <td><?php echo $val['tell'];  ?></td>
                <td><?php echo $val['persion'];  ?></td>
                <td><?php if($val['state']==1){
                    echo "未审核";
                    }else{
                    echo "<font color='red;'>电话已回访！</font>";
                    }  ?></td>
                <td>&nbsp<a onclick="return paspeak(<?php echo $val['baspeak_id']; ?>);">审核预约信息</a></td>
            </tr>
        <?php  } ?>
    </table>
    <?= LinkPager::widget(['pagination' => $pages]); ?>
</div>
<?=Html::jsFile('@web/js/jquery-1.12.4.js')?>
<script type="text/javascript">
    function paspeak(id) {
        var url="/index.php?r=admin/flower/ajax-confirm";
        //var url="index.php?r=admin/certification/confirm";
        var r = confirm("确认是否电话回访信息？");
        if(r==true){
            $.ajax({
                url:url,
                type:"get",
                dataType:"json",
                data:{id:id},
                success:function(data){
                    if(data.status == 200){
                        alert(data.message);
                        window.location.reload();
                        return false;
                    }else{
                        alert(data.message);
                        window.location.reload();
                        return false;
                    }
                },
            });
            return false;
        }else{
            alert("取消操作!");
        }
    }
</script>