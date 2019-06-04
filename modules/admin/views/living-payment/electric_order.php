<?php

// use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '电费预充值订单管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::jsFile('/js/jquery-1.12.4.js')?>

<div>
    <h1><?=$this->title ?></h1>
    <form class="form-inline" action="/admin/living-payment/electric-order">
        <?php
            $house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
            $seat_id  = empty(Yii::$app->request->get()['seat_id']) ? 0 : Yii::$app->request->get()['seat_id'];
            $room_num = empty(Yii::$app->request->get()['room_num']) ? '' : Yii::$app->request->get()['room_num'];
            $order_sn = empty(Yii::$app->request->get()['order_sn']) ? '' : Yii::$app->request->get()['order_sn'];
            $order_status = empty(Yii::$app->request->get()['order_status']) ? 0 : Yii::$app->request->get()['order_status'];
            $stime = empty(Yii::$app->request->get()['stime']) ? '' : Yii::$app->request->get()['stime'];
            $etime = empty(Yii::$app->request->get()['etime']) ? '' : Yii::$app->request->get()['etime'];
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
            <input type="text" name="order_sn" id="order_sn" placeholder="输入订单号" class="form-control" value="<?=$order_sn ?>">
        </div>
        <div class="form-group">
            <select class="form-control" id="order_status" name="order_status">
                <option value="">订单状态</option>
                <option value="1" <?php if($order_status == 1) echo 'selected'; ?>>待支付</option>
                <option value="2" <?php if($order_status == 2) echo 'selected'; ?>>已支付</option>
                <option value="3" <?php if($order_status == 3) echo 'selected'; ?>>充电完成</option>
            </select>
        </div>
        <div class="form-group">
            <input type="date" name="stime" id="stime" class="form-control" value="<?=$stime?>">
            <input type="date" name="etime" id="etime" class="form-control" value="<?=$etime?>">
        </div>
        <button type="submit" class="btn btn-default">查询</button>
        <a href="javascript:void(0);" class="btn btn-default" onclick="location.reload();">刷新</a>
        <a href="javascript:void(0);" class="btn btn-default" id="btn_export">导出</a>
        <a href="javascript:void(0);" id="download_path"></a>
    </form>
    <br>
    <table class="table table-striped table-bordered" style="text-align: center;">
        <thead>
        <tr>
            <th style="text-align: center;">ID</th>
            <th style="text-align: center;">订单编号</th>
            <th style="text-align: center;">入户信息</th>
            <th style="text-align: center;">充值金额</th>
            <th style="text-align: center;">备注</th>
            <th style="text-align: center;">创建时间</th>
            <th style="text-align: center;">支付类型</th>
            <th style="text-align: center;">支付状态</th>
            <th style="text-align: center;">支付时间</th>
            <th style="text-align: center;">缴费人</th>
            <th style="text-align: center;">送电时间</th>
            <th style="text-align: center;">操作人</th>
            <th style="text-align: center;">订单状态</th>
            <th style="text-align: center;">发票类型</th>
            <th style="text-align: center;">姓名/公司名</th>
            <th style="text-align: center;">手机号/纳税人识别号</th>
            <th style="text-align: center;">操作</th>
        </tr> 
        </thead>
        <tbody>
        <?php if($list):?>
            <?php foreach($list as $k => $v): ?>
                <tr>
                    <td><?=$v['order_id'] ?></td>
                    <td><?=$v['order_sn'] ?></td>
                    <td><?php echo $v['house_name'].'-'.$v['seat_name'].'-'.$v['room_num'] ?></td>
                    <td><?=$v['money'] ?></td>
                    <td><?=$v['remark'] ?></td>
                    <td><?=$v['add_time'] ? date('Y-m-d H:i:s',$v['add_time']) : '--' ?></td>
                    <td><?=$v['pay_type'] == 1 ? '微信' : ($v['pay_type'] == 2 ? '支付宝' : '--') ?></td>
                    <td><?=$v['pay_status'] == 1 ? '待支付' : ($v['pay_status'] == 2 ? '支付成功' : ($v['pay_status'] == 3 ? '支付失败' : '--'))?></td>
                    <td><?=$v['pay_time'] ? date('Y-m-d H:i:s',$v['pay_time']) : '--' ?></td>
                    <td><?=$v['true_name'] ?><br><?=$v['mobile']?></td>
                    <td><?php echo $v['send_time'] ? date('Y-m-d H:i:s',$v['send_time']) : '--'; ?></td>
                    <td><?=$v['admin_user'] ?></td>
                    <td>
                        <?php if($v['order_status'] == 1) echo '待支付'; else if($v['order_status'] == 2) echo '已支付，等待送电'; else if($v['order_status'] == 3) echo '充电完成'; ?>
                    </td>
                    <td><?php if($v['invoice_type'] == 0) echo '不开发票'; else if($v['invoice_type'] == 1) echo '个人'; else if($v['invoice_type'] == 2) echo '公司'; ?></td>
                    <td><?=$v['invoice_name'] ?></td>
                    <td><?=$v['invoice_num'] ?></td>
                    <td>
                    	<?php if ($v['order_status'] == 2): ?>
                            <a href="javascript:void(0);" class="btn_sure" data-id="<?=$v['order_id']?>">确认送电</a>
                        <?php endif ?>
                        <?php if ($v['order_status'] == 1): ?>
                            <a href="javascript:void(0);" class="btn_del" data-id="<?=$v['order_id']?>">删除</a>
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

        //删除
		$('.btn_del').click(function(){
			var order_id = $(this).data('id');
			if (confirm('确定要进行删除操作吗？')) {
				if (order_id == undefined || order_id.length == 0) {
					alert('参数错误');
					return false;
				}
				$.ajax({
					type:'post',
					dataType:'json',
					url:"<?=Url::to(['living-payment/ajax-del-electric-order']) ?>",
					data:{
						order_id:order_id
					},
					success:function(res){
						if (res.code == 200) {
							alert(res.msg);
							location.reload();
						} else {
							alert(res.msg);
							return false;
						}
					}
				});	
			}
		});

        //确认送电
        $('.btn_sure').click(function(){
            var order_id = $(this).data('id');
            if (confirm('确定要进行确认送电操作吗？')) {
                if (order_id == undefined || order_id.length == 0) {
                    alert('参数错误');
                    return false;
                }
                $.ajax({
                    type:'post',
                    dataType:'json',
                    url:"<?=Url::to(['living-payment/ajax-send-electric']) ?>",
                    data:{
                        order_id:order_id
                    },
                    success:function(res){
                        if (res.code == 200) {
                            alert(res.msg);
                            location.reload();
                        } else {
                            alert(res.msg);
                            return false;
                        }
                    }
                }); 
            }
        });

        // 导出excel
        $('#btn_export').click(function(){
            var house_id = $('#house_id').val();
            var seat_id = $('#seat_id').val();
            var room_num = $('#room_num').val();
            var order_sn = $('#order_sn').val();
            var order_status = $('#order_status').val();
            var stime = $('#stime').val();
            var etime = $('#etime').val();
            if (stime == undefined || stime == '' || etime == undefined || etime == '') {
                alert('请选择导出数据的开始结束时间');return false;
            }
            $.ajax({
                type:'post',
                dataType:'json',
                url:'/index.php?r=admin/living-payment/ajax-order-export',
                data:{
                    house_id:house_id,
                    seat_id:seat_id,
                    room_num:room_num,
                    order_sn:order_sn,
                    order_status:order_status,
                    stime:stime,
                    etime:etime
                },
                success:function(res){
                    if (res.code == 200) {
                        $('#download_path').attr('href','/index.php?r=admin/order/download&path='+res.path);
                        $('#download_path').html('点击下载');
                    } else {
                        $('#download_path').attr('href','');
                        $('#download_path').html('');
                        alert(res.msg);
                        return false;
                    }
                }
            });
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
</script>