<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '停车缴费订单';
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <h1><?=$this->title ?></h1>
    <form class="form-inline" action="">
        <?php
        $parking_name = empty(Yii::$app->request->get()['parking_name']) ? '' : Yii::$app->request->get()['parking_name'];
        $car_no = empty(Yii::$app->request->get()['car_no']) ? '' : Yii::$app->request->get()['car_no'];
        $status     = empty(Yii::$app->request->get()['status']) ? 0 : Yii::$app->request->get()['status'];
        $pay_type     = empty(Yii::$app->request->get()['pay_type']) ? 0 : Yii::$app->request->get()['pay_type'];
        ?>
        <div class="form-group">
            <input type="text" class="form-control" id="person_kw" name="person_kw" placeholder="停车场名称" value="<?=$parking_name?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="repair_kw" name="repair_kw" placeholder="车牌号" value="<?=$car_no?>">
        </div>
        <div class="form-group">
            <select class="form-control" name="state" id="state">
                <option value="">状态</option>
                <option value="1" <?php if($status == 1) echo 'selected';?>>待支付</option>
                <option value="2" <?php if($status == 2) echo 'selected';?>>支付成功</option>
                <option value="3" <?php if($status == 3) echo 'selected';?>>支付失败</option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="pay_type" id="pay_type">
                <option value="">状态</option>
                <option value="1" <?php if($pay_type == 0) echo 'selected';?>>未支付</option>
                <option value="2" <?php if($pay_type == 1) echo 'selected';?>>微信</option>
                <option value="3" <?php if($pay_type == 2) echo 'selected';?>>支付宝</option>
            </select>
        </div>
        <button type="submit" class="btn btn-default">查询</button>
        <a href="javascript:void(0);" class="btn btn-default" onclick="location.reload();">刷新</a>
    </form>
    <br>
    <table class="table table-striped table-bordered" style="text-align: center;">
        <thead>
        <tr>
            <th style="text-align: center;">订单编号</th>
            <th style="text-align: center;">停车场名称</th>
            <th style="text-align: center;">车牌号</th>
            <th style="text-align: center;">停车位</th>
            <th style="text-align: center;">停车费用</th>
            <th style="text-align: center;">支付时间</th>
            <th style="text-align: center;">状态</th>
            <th style="text-align: center;">支付方式</th>
        </tr>
        </thead>
        <tbody>
        <?php if($list):?>
            <?php foreach($list as $k => $v): ?>
                <tr>
                    <td><?= Html::encode("{$v['order_sn']}") ?></td>
                    <td style="text-align: left;"><?= Html::encode("{$v['parking_name']}") ?></td>
                    <td><?= Html::encode("{$v['car_no']}") ?></td>
                    <td><?= Html::encode("{$v['park_card']}") ?></td>
                    <td><?= Html::encode("{$v['parking_fee']}") ?></td>
                    <td><?php if($v['pay_time']) echo date('Y-m-d H:i:s',$v['pay_time']); else echo '--'; ?></td>
                    <td>
                        <?php
                        if($v['status'] == 1) echo '待支付';
                        elseif($v['status'] == 2) echo '支付成功';
                        elseif($v['status'] == 3) echo '支付失败';
                        ?>
                    </td>
                    <td>
                        <?php
                        if($v['pay_type'] == 0) echo '未支付';
                        elseif($v['pay_type'] == 1) echo '微信';
                        elseif($v['pay_type'] == 2) echo '支付宝';
                        ?>
                    </td>
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

<script type="text/javascript">
    setInterval(refresh, 1000*60*5);

    function refresh(){
        location.reload();
    }
</script>