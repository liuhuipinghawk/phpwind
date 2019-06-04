<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = '水费缴费订单';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?=$this->title ?></h1>
    <form class="form-inline" action="">
        <?php
        $water_consumption = empty(Yii::$app->request->get()['water_consumption']) ? '' : Yii::$app->request->get()['water_consumption'];
        $status     = empty(Yii::$app->request->get()['status']) ? 0 : Yii::$app->request->get()['status'];
        $pay_type     = empty(Yii::$app->request->get()['pay_type']) ? 0 : Yii::$app->request->get()['pay_type'];
        $house_id = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
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
            <input type="text" class="form-control" id="water_consumption" name="water_consumption" placeholder="用水量" value="<?=$water_consumption?>">
        </div>
        <div class="form-group">
            <select class="form-control" name="status" id="status">
                <option value="">状态</option>
                <option value="1" <?php if($status == 1) echo 'selected';?>>待支付</option>
                <option value="2" <?php if($status == 2) echo 'selected';?>>支付成功</option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" name="pay_type" id="pay_type">
                <option value="">状态</option>
                <option value="3" <?php if($pay_type == 3) echo 'selected';?>>未支付</option>
                <option value="1" <?php if($pay_type == 1) echo 'selected';?>>微信</option>
                <option value="2" <?php if($pay_type == 2) echo 'selected';?>>支付宝</option>
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
            <th style="text-align: center;">物业位置</th>
            <th style="text-align: center;">缴费人</th>
            <th style="text-align: center;">用水量</th>
            <th style="text-align: center;">水费费用</th>
            <th style="text-align: center;">个人/公司</th>
            <th style="text-align: center;">手机号/纳税人识别号</th>
            <th style="text-align: center;">支付时间</th>
            <th style="text-align: center;">发票类型</th>
            <th style="text-align: center;">支付方式</th>
            <th style="text-align: center;">状态</th>
            <th style="text-align: center;">添加时间</th>
            <th style="text-align: center;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if($list):?>
            <?php foreach($list as $k => $v): ?>
                <tr>
                    <td><?= Html::encode("{$v['order_sn']}") ?></td>
                    <td><?=$v['housename'].'-'.$v['seatname'].'-'.$v['room_num'] ?></td>
                    <td><?=$v['TrueName']?><br><?=$v['Tell']?></td>
                    <td style="text-align: left;"><?= Html::encode("{$v['water_consumption']}") ?></td>
                    <td><?= Html::encode("{$v['water_fee']}") ?></td>
                    <td><?= Html::encode("{$v['invoice_name']}") ?></td>
                    <td><?= Html::encode("{$v['invoice_num']}") ?></td>
                    <td><?php if($v['water_time']) echo date('Y-m-d H:i:s',$v['water_time']); else echo '--'; ?></td>
                    <td>
                        <?php
                        if($v['invoice_type'] == 0) echo '不开发票';
                        elseif($v['invoice_type'] == 1) echo '个人';
                        elseif($v['invoice_type'] == 2) echo '公司';
                        ?>
                    </td>
                    <td>
                        <?php
                        if($v['pay_type'] == 0) echo '未支付';
                        elseif($v['pay_type'] == 1) echo '微信';
                        elseif($v['pay_type'] == 2) echo '支付宝';
                        ?>
                    </td>
                    <td>
                        <?php
                        if($v['status'] == 1) echo '待支付';
                        elseif($v['status'] == 2) echo '支付成功';
                        elseif($v['status'] == 3) echo '支付失败';
                        ?>
                    </td>
                    <td><?php if($v['create_time']) echo date('Y-m-d H:i:s',$v['create_time']); else echo '--'; ?></td>
                    <td>
                    <?php if ($v['status'] == 1): ?>
                        <a href="javascript:void(0);" class="btn_del" onclick="del(<?=$v['order_id']?>)">删除</a>
                    <?php endif ?>
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
    function del(order_id){
        if (confirm('确定要删除吗？')) {
            var op_id = order_id;
            if (op_id == undefined || op_id.length == 0) {
                alert('参数错误');return false;
            }
            $.post('/admin/water-payment/del',{order_id:op_id},function(res){
                if (res.code == 200) {
                    alert(res.msg);
                    location.reload();
                } else {
                    alert(res.msg);
                    return false;
                }
            },'JSON');
        }
    }
</script>
