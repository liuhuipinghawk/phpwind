<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '车位管理日报';
$this->params['breadcrumbs'][] = ['label' => '项目车位管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <h1><?=$this->title ?></h1>
<hr>
    <?php
    $stall_id = empty(Yii::$app->request->get()['id']) ? '' : Yii::$app->request->get()['id'];
    ?>
    <p>
        <a href="/admin/stall/add?stall_id=<?=$stall_id?>" class="btn btn-success">日报添加</a>
    </p>
    <p style="color: red;">备注：日报每个项目每日只能录入一次</p>
<br>
<table class="table table-striped table-bordered" style="text-align: center;">
    <thead>
    <tr>
        <th style="text-align: center;">ID</th>
        <th style="text-align: center;">楼盘</th>
        <th style="text-align: center;">售出车位</th>
        <th style="text-align: center;">出租车位</th>
        <th style="text-align: center;">其他车位</th>
        <th style="text-align: center;">添加时间</th>
        <th style="text-align: center;">添加人</th>
    </tr>
    </thead>
    <tbody>
    <?php if($data):?>
        <?php foreach($data as $k => $v): ?>
            <tr>
                <td><?=$v['id'] ?></td>
                <td><?=$v['housename'] ?></td>
                <td><?=$v['sold'] ?></td>
                <td><?=$v['rent'] ?></td>
                <td><?=$v['other'] ?></td>
                <td><?=date('Y-m-d',$v['create_time']) ?></td>
                <td><?=$v['adminemail'] ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif;?>
    </tbody>
</table>
<div class="pagination-part">
    <nav>
        <?php
        echo LinkPager::widget([
            'pagination' => $pagination,
        ]);
        ?>
    </nav>
</div>
</div>