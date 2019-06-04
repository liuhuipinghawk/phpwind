<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '项目电费管理月报';
$this->params['breadcrumbs'][] = ['label' => '项目电费管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <h1><?=$this->title ?></h1>
    <hr>
    <?php
    $electr_id = empty(Yii::$app->request->get()['id']) ? '' : Yii::$app->request->get()['id'];
    ?>
    <p>
        <a href="/admin/count-electr/add?electr_id=<?=$electr_id?>" class="btn btn-success">月报添加</a>
    </p>
    <p style="color: #aa0000;"><strong>备注：电费统计必须按月份顺序添加,每个月份每年只能选择一次,如果当月没有数据,就上传0</strong></p>
    <br>
    <table class="table table-striped table-bordered" style="text-align: center;">
        <thead>
        <tr>
            <th style="text-align: center;">ID</th>
            <th style="text-align: center;">楼盘</th>
            <th style="text-align: center;">月份</th>
            <th style="text-align: center;">总用电量</th>
            <th style="text-align: center;">公区用电量</th>
            <th style="text-align: center;">办公用电量</th>
            <th style="text-align: center;">业主用电量</th>
            <th style="text-align: center;">多种经营用电量</th>
            <th style="text-align: center;">物业自用电量</th>
            <th style="text-align: center;">商业用电</th>
            <th style="text-align: center;">商户预存电</th>
            <th style="text-align: center;">业主预存电</th>
            <th style="text-align: center;">添加时间</th>
            <th style="text-align: center;">抄表时间</th>
            <th style="text-align: center;">添加人</th>
            <th style="text-align: center;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if($data):?>
            <?php foreach($data as $k => $v): ?>
                <tr>
                    <td><?=$v['id'] ?></td>
                    <td><?=$v['housename'] ?></td>
                    <td><?=date('Y-m',$v['time']) ?></td>
                    <td><?=$v['total'] ?></td>
                    <td><?=$v['public'] ?></td>
                    <td><?=$v['office'] ?></td>
                    <td><?=$v['hold'] ?></td>
                    <td><?=$v['sell'] ?></td>
                    <td><?=$v['self'] ?></td>
                    <td><?=$v['shop'] ?></td>
                    <td><?=$v['shop_pre'] ?></td>
                    <td><?=$v['hold_pre'] ?></td>
                    <td><?=date('Y-m-d',$v['create_time']) ?></td>
                    <td><?=date('Y-m-d',$v['meter_time']) ?></td>
                    <td><?=$v['adminemail'] ?></td>
                    <td><a href="<?php echo Url::to(['count-electr/del','id'=>$v['id'],'electr_id'=>$v['electr_id']]) ?>">删除</a></td>
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