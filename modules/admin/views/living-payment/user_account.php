<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '生活缴费账户管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::jsFile('/js/jquery-1.12.4.js')?>

<div>
    <h1><?=$this->title ?></h1>
    <form class="form-inline" action="/admin/living-payment/user-account">
        <?php
            $house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
            $seat_id  = empty(Yii::$app->request->get()['seat_id']) ? 0 : Yii::$app->request->get()['seat_id'];
            $room_num = empty(Yii::$app->request->get()['room_num']) ? '' : Yii::$app->request->get()['room_num'];
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
        <button type="submit" class="btn btn-default">查询</button>
        <a href="javascript:void(0);" class="btn btn-default" onclick="location.reload();">刷新</a>
    </form>
    <br>
    <table class="table table-striped table-bordered" style="text-align: center;">
        <thead>
        <tr>
            <th style="text-align: center;">ID</th>
            <th style="text-align: center;">所属楼盘</th>
            <th style="text-align: center;">所属楼座</th>
            <th style="text-align: center;">房间号</th>
            <th style="text-align: center;">电表倍率</th>
            <th style="text-align: center;">电表号</th>
            <th style="text-align: center;">业主</th>
            <th style="text-align: center;">缴费人</th>
            <th style="text-align: center;">添加时间</th>
            <th style="text-align: center;">状态</th>
            <th style="text-align: center;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if($list):?>
            <?php foreach($list as $k => $v): ?>
                <tr>
                    <td><?=$v['account_id'] ?></td>
                    <td><?=$v['house_name'] ?></td>
                    <td><?=$v['seat_name'] ?></td>
                    <td><?=$v['room_num'] ?></td>
                    <td><?=$v['rate'] ?></td>
                    <td><?=$v['ammeter_id'] ? $v['ammeter_id'] : '--' ?></td>
                    <td><?=$v['owner'] ?></td>
                    <td><?=$v['true_name'] ?><br><?=$v['mobile'] ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$v['add_time']); ?></td>
                    <td><?php if ($v['is_open'] == 1) echo '缴费通道开启'; else echo '缴费通道关闭'; ?></td>
                    <td>
                        <?php if ($v['is_open'] == 1): ?>
                            <a href="javascript:void(0);" onclick="PaymentChannel(<?=$v['account_id']?>,2)">关闭缴费通道</a>
                        <?php else: ?>
                            <a href="javascript:void(0);" onclick="PaymentChannel(<?=$v['account_id']?>,1)">开启缴费通道</a>
                        <?php endif ?>
                    	<a href="javascript:void(0);" class="btn_del" data-id="<?=$v['account_id']?>">删除</a>
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
			var account_id = $(this).data('id');
			if (confirm('确定要进行删除操作吗？')) {
				if (account_id == undefined || account_id.length == 0) {
					alert('参数错误');
					return false;
				}
				$.ajax({
					type:'post',
					dataType:'json',
					url:"<?=Url::to(['living-payment/ajax-del-account']) ?>",
					data:{
						account_id:account_id
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
	});

    //缴费通道
    function PaymentChannel(account_id,tag){
        if (account_id == undefined || account_id.length == 0) {
            alert('参数错误');return false;
        }
        if (tag == undefined || tag.length == 0) {
            alert('参数错误');return false;
        }
        $.post('/index.php?r=admin/living-payment/ajax-up-payment-channel',{
            account_id:account_id,
            tag:tag
        },function(res){
            if (res.code == 200) {
                alert(res.msg);
                location.reload();
            } else {
                alert(res.msg);
                return false;
            }
        },'JSON');
    }

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