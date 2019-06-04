<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '物业费订单管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<div>
    <h1><?=$this->title ?></h1>
    <br>
    <form class="form-inline" action="/admin/property-pay/index">
        <?php
        $house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
        $seat_id  = empty(Yii::$app->request->get()['seat_id']) ? 0 : Yii::$app->request->get()['seat_id'];
        $room_num = empty(Yii::$app->request->get()['room_num']) ? '' : Yii::$app->request->get()['room_num'];
        $status = empty(Yii::$app->request->get()['status']) ? 0 : Yii::$app->request->get()['status'];
        $type = empty(Yii::$app->request->get()['type']) ? 0 : Yii::$app->request->get()['type'];
        $pay_type     = empty(Yii::$app->request->get()['pay_type']) ? 0 : Yii::$app->request->get()['pay_type'];
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
            <select class="form-control" id="seat_id" name="seat_id">
                <option value="">选择楼座</option>
            </select>
        </div>
        <div class="form-group">
            <input type="text" name="room_num" id="room_num" placeholder="输入房间号" class="form-control" value="<?=$room_num ?>">
        </div>
        <div class="form-group">
            <select class="form-control" id="type" name="type">
                <option value="">请选择发票状态</option>
                <option value="3" <?php if($type == 3) echo 'selected'; ?>>不开发票</option>
                <option value="1" <?php if($type == 1) echo 'selected'; ?>>普通发票</option>
                <option value="2" <?php if($type == 2) echo 'selected'; ?>>增值税专用发票</option>
            </select>
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
                <option value="">支付方式</option>
                <option value="1" <?php if($pay_type == 1) echo 'selected';?>>微信</option>
                <option value="2" <?php if($pay_type == 2) echo 'selected';?>>支付宝</option>
                <option value="3" <?php if($pay_type == 3) echo 'selected';?>>线下支付</option>
            </select>
        </div>
        <button type="submit" class="btn btn-default">查询</button>
        <a href="javascript:void(0);" class="btn btn-default" onclick="location.reload();">刷新</a>
        <a href="/admin/property-pay/add" class="btn btn-success">线下物业费录入</a>
    </form>
    <br>
<br>
<table class="table table-striped table-bordered" style="text-align: center;">
    <thead>
    <tr>
        <th style="text-align: center;">ID</th>
        <th style="text-align: center;">订单号</th>
        <th style="text-align: center;">缴费人</th>
        <th style="text-align: center;">物业位置</th>
        <th style="text-align: center;">业主姓名</th>
        <th style="text-align: center;">房屋面积</th>
        <th style="text-align: center;">物业费单价</th>
        <th style="text-align: center;">缴费年份</th>
        <th style="text-align: center;">收缴物业费</th>
        <th style="text-align: center;">订单创建时间</th>
        <th style="text-align: center;">支付时间</th>
        <th style="text-align: center;">订单状态</th>
        <th style="text-align: center;">发票类型</th>
        <th style="text-align: center;">支付路径</th>
        <th style="text-align: center;">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if($data):?>
        <?php foreach($data as $k => $v): ?>
            <tr>
                <td><?=$v['id'] ?></td>
                <td><?=$v['order_sn'] ?></td>
                <td><?=$v['TrueName'] ?><br><?=$v['Tell'] ?></td>
                <td><?=$v['housename'].'-'.$v['seatname'].'-'.$v['room'] ?></td>
                <td><?=$v['owner'] ?></td>
                <td><?=$v['area'] ?></td>
                <td><?=$v['property_fee'] ?></td>
                <td><?=$v['year']?$v['year']:'/'?>-<?php if($v['year_status'] == 1){ echo '上半年';}elseif($v['year_status'] == 2){ echo '下半年';}else{echo '/';} ?></td>
                <td><?=$v['money']?></td>
                <td><?=date('Y-m-d',$v['create_time'])?></td>
                <td><?php if ($v['pay_time'] == 0){echo '--';} else{echo date('Y-m-d',$v['pay_time']);} ?></td>
                <td><?php if($v['status'] == 1) echo '待支付'; else if($v['status'] == 2) echo '已支付';if($v['invoice_type']==1) echo '--已开发票'; ?></td>
                <td><?php if ($v['type']==1){
                        if ($v['sta']==1){
                            echo '个人普通发票';
                        }elseif($v['sta']==2){
                            echo '公司普通发票';
                        }else{
                            echo '--';
                        }
                    }elseif($v['type']==2){
                        echo '增值税专用发票';
                    }else{
                        echo '不开发票';
                    } ?></td>
                <td><?php if ($v['order_type']==1){
                            echo '线上支付';
                        if($v['pay_type']==1){
                            echo '--微信支付';
                        }
                        if($v['pay_type']==2){
                            echo '--支付宝支付';
                        }
                    }elseif($v['order_type']==2){
                        echo '线下支付';
                    }?></td>
                <td>
                    <?php if ($v['status'] == 1): ?>
                        <a href="javascript:void(0);" class="btn_del" data-id="<?=$v['id']?>">删除</a>
                    <?php endif ?>
                    <?php if ($v['status'] == 2 && $v['invoice_type'] == 0 && $v['type']!=''): ?>
                        <a href="javascript:void(0);" class="btn_invoice" data-id="<?=$v['id']?>">开发票</a>
                    <?php endif ?>
                    &nbsp;
                    <?php if ($v['type'] == 1 || $v['type']==2): ?>
                    <a href="javascript:void(0);" class="btn_update" data-id="<?=$v['invoice_id']?>">查看发票</a>
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
    $(function(){
        getSeat(<?=$house_id ?>,<?=$seat_id ?>);

        $('#house_id').change(function(){
            var house_id = $(this).val();
            getSeat(house_id,0);
        });
        $('.btn_del').click(function(){
            if (confirm('确定要删除吗？')) {
                var op_id = $(this).data('id');
                if (op_id == undefined || op_id.length == 0) {
                    alert('参数错误');return false;
                }
                $.post('/index.php?r=admin/property-pay/del',{id:op_id},function(res){
                    if (res.code == 200) {
                        alert(res.msg);
                        location.reload();
                    } else {
                        alert(res.msg);
                        return false;
                    }
                },'JSON');
            }
        });
        $('.btn_invoice').click(function(){
            if (confirm('确定已开发票了吗？')) {
                var op_id = $(this).data('id');
                if (op_id == undefined || op_id.length == 0) {
                    alert('参数错误');return false;
                }
                $.post('/index.php?r=admin/property-pay/invoice',{id:op_id},function(res){
                    if (res.code == 200) {
                        alert(res.msg);
                        location.reload();
                    } else {
                        alert(res.msg);
                        return false;
                    }
                },'JSON');
            }
        });
    });
    function getSeat(house_id,seat_id){
        $.ajax({
            type:'post',
            dataType:'json',
            url:"<?=Url::to(['living-payment/ajax-get-seat']) ?>",
            data:{
                house_id:house_id
            },
            success:function(res){
                if (res.code == 200) {
                    var len = res.data.length;
                    var _option = '<option value="">选择楼座</option>';
                    for(var i = 0; i < len; i++){
                        _option += '<option';
                        if (res.data[i]['id'] == seat_id) {
                            _option += ' selected';
                        }
                        _option += ' value="'+res.data[i]['id']+'">'+res.data[i]['housename']+'</option>';
                    }
                    $('#seat_id').html(_option);
                }
            }
        });
    }
    layui.use('layer', function(){
        var layer = layui.layer;
        //添加/修改
        $('#btn_add,.btn_update').click(function(){
            layer.open({
                type:2,
                content:'/index.php?r=admin/invoice/details&invoice_id='+$(this).data('id'),
                area:['600px','600px']
            });
        });
    });
</script>