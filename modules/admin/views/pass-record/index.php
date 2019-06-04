<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = '世为闸机进出记录';
$this->params['breadcrumbs'][] = $this->title;
?>


<div>
    <h1><?=$this->title ?></h1>
    <br>
    <form class="form-inline" action="">
        <?php
        $house_id = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
        $type = empty(Yii::$app->request->get()['user_type']) ? '' : Yii::$app->request->get()['user_type'];
        $stime     = empty(Yii::$app->request->get()['stime']) ? '' : Yii::$app->request->get()['stime'];
        $etime     = empty(Yii::$app->request->get()['etime']) ? '' : Yii::$app->request->get()['etime'];
        ?>
        <div class="form-group">
            <select class="form-control" id="house_id" name="house_id">
                <option value="">选择楼盘</option>
                <?php if ($house) : ?>
                    <?php foreach($house as $k => $v): ?>
                        <option value="<?=$v['id']?>" <?php if($v['id'] == $house_id) echo 'selected'; ?>><?=$v['housename']?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" id="user_type" name="user_type">
                <option value="">选择进出类型</option>
                <option value="1" <?php if(1 == $type) echo 'selected'; ?>>业主进出</option>
                <option value="2" <?php if(2 == $type) echo 'selected'; ?>>访客进出</option>
            </select>
        </div>
        <input type="date" name="stime" id="stime" class="form-control" placeholder="开始时间" value="<?=$stime?>">
        <input type="date" name="etime" id="etime" class="form-control" placeholder="结束时间" value="<?=$etime?>">
        <button type="submit" class="btn btn-default">查询</button>
        <a href="javascript:void(0);" class="btn btn-default" onclick="location.reload();">刷新</a>
        &nbsp;&nbsp;<strong>共<?=$count?>条</strong>
    </form>
    <br>
    <br>
    <table class="table table-striped table-bordered" style="text-align: center;">
        <thead>
        <tr>
            <th style="text-align: center;">业主姓名</th>
            <th style="text-align: center;">联系方式</th>
            <th style="text-align: center;">进出时间</th>
            <th style="text-align: center;">进出类型</th>
            <th style="text-align: center;">项目名称</th>
            <th style="text-align: center;">设备名称</th>
            <th style="text-align: center;">访客姓名</th>
            <th style="text-align: center;">访客电话</th>
        </tr>
        </thead>
        <tbody>
        <?php if($data):?>
            <?php foreach($data as $k => $v): ?>
                <tr style="table-layout:fixed;">
                    <td><?=$v['TrueName'] ?></td>
                    <td><?=$v['Tell'] ?></td>
                    <td><?php if($v['pass_time']) echo date('Y-m-d H:i:s',round($v['pass_time']/1000)); else echo '--'; ?></td>
                    <td><?php
                        if($v['user_type'] == 1) echo '业主进出';
                        elseif($v['user_type'] == 2) echo '访客进出';
                        ?></td>
                    <td><?=$v['housename'] ?></td>
                    <td><?=$v['equipment_id'] ?></td>
                    <td><?=$v['name'] ?></td>
                    <td><?=$v['mobile'] ?></td>

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