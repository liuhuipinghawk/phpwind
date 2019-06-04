<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\PublishSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '房屋租赁列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publish-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加房屋租赁信息', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <hr>
    <table class="table table-striped table-bordered" style="text-align: center;">
        <thead>
        <tr>
            <th style="text-align: center;">ID</th>
            <th style="text-align: center;width: 50px;">价格</th>
            <th style="text-align: center;">面积</th>
            <th style="text-align: center;">面积单位</th>
            <th style="text-align: center;">房屋年份</th>
            <th style="text-align: center;">楼层</th>
            <th style="text-align: center;">地址</th>
            <th style="text-align: center;">联系人</th>
            <th style="text-align: center;">联系方式</th>
            <th style="text-align: center;">添加时间</th>
            <th style="text-align: center;">用户类型</th>
            <th style="text-align: center;width: 150px;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if($list):?>
            <?php foreach($list as $k => $v): ?>
                <tr>
                    <td><?=$v['publish_id'] ?></td>
                    <td><?=$v['price'] ?></td>
                    <td><?=$v['space'] ?></td>
                    <td><?=$v['unit'] ?></td>
                    <td><?=$v['age'] ?></td>
                    <td><?=$v['floor'] ?></td>
                    <td><?=$v['address'] ?></td>
                    <td><?=$v['person'] ?></td>
                    <td><?=$v['person_tel'] ?></td>
                    <td><?= date('Y-m-d H:i:s',$v['publish_time']); ?></td>
                    <td><?php if($v['status'] == 1) echo '上架'; else echo '下架'; ?></td>
                    <td>&nbsp;<a href="<?php echo \yii\helpers\Url::to(['house-img/create','publish_id'=>$v['publish_id']]); ?>">添加图片</a>&nbsp<a href="<?php echo \yii\helpers\Url::to(['publish/view','id'=>$v['publish_id']]); ?>">查看</a>&nbsp;&nbsp;<a href="<?php echo \yii\helpers\Url::to(['publish/update','id'=>$v['publish_id']]); ?>">更新</a>&nbsp;&nbsp;<a onclick="return ajaxdelete(<?php echo $v['publish_id'];?>);">删除</a>&nbsp;<a onclick="return ajaxstatus(<?php echo $v['publish_id'];?>);">状态更新</a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif;?>
        </tbody>
    </table>
    <div class="pagination-part">
        <nav>
            <?php
            echo \yii\widgets\LinkPager::widget([
                'pagination' => $pagination,
            ]);
            ?>
        </nav>
    </div>
</div>
<script>
    //软删除操作！
    function ajaxdelete(id) {
        if(confirm('确定删除吗？')){
            $.ajax({
                type:'GET',
                dataType:'JSON',
                url:'<?=\yii\helpers\Url::to(['publish/ajax-delete']) ?>',
                data:{cid:id},
                success:function (data) {
                    if (data.status == 200) {
                        alert(data.message);
                        window.location.reload();
                        return false;
                    } else {
                        alert(data.message);
                        window.location.reload();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    
    function ajaxstatus(id) {
        if(confirm('确定要下架吗？')){
            $.ajax({
                type:'GET',
                dataType:'JSON',
                url:'<?=\yii\helpers\Url::to(['publish/ajax-status']) ?>',
                data:{cid:id},
                success:function (data) {
                    if (data.status == 200) {
                        alert(data.message);
                        window.location.reload();
                        return false;
                    } else {
                        alert(data.message);
                        window.location.reload();
                        return false;
                    }
                }
            });
            return false;
        }
    }
</script>
