<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '物业费订单线下录入';
$this->params['breadcrumbs'][] = ['label' => '物业费列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<div>
    <h1><?=$this->title ?></h1>
</div>
<p style="color: #aa0000"><strong>备注：房间信息必须在缴费账户基础信息列表先录入，物业费输入金额和缴费账户基础信息必须一致，线上缴纳过的物业费不能录入</strong></p>
<div class="article-form">
    <form>
        <div class="form-group">
            <label class="control-label">楼盘</label>
                <select class="form-control" id="house_id" name="house_id" required="required">
                    <option value="">--请选择楼盘--</option>
                    <?php foreach ($house as $key=>$val){ ?>
                        <option value="<?php echo $val['id'];  ?>"><?php echo $val['housename'];  ?></option>
                    <?php } ?>
                </select>
        </div>
        <div class="form-group">
            <label class="control-label">楼座</label>
                <select class="form-control" id="seat_id" name="seat_id" required="required">
                    <option value="">--请选择座号--</option>
                    <?php foreach ($house as $key=>$val){ ?>
                        <option value="<?php echo $val['id'];  ?>"  ><?php echo $val['housename'];  ?></option>
                    <?php } ?>
                </select>
        </div>
        <div class="form-group">
            <label class="control-label">房间号</label>
            <input type="text" class="form-control" id="room_num" placeholder="" name="room_num" required="required">
        </div>
        <div class="form-group field-user-logintime">
            <label class="control-label">缴纳费用</label>
            <input class="form-control" type="text" placeholder="" id="money" required="required" name="money">
        </div>
        <div class="form-group">
            <label class="control-label">缴费周期</label>
            <select class="form-control" id="year" name="year" required="required">
                <option value="">选择周期</option>
                <?php foreach ($year as $v): ?>
                    <option value="<?=$v?>"><?=$v?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">周期状态</label>
            <select class="form-control" id="year_status" name="year_status" required="required">
                <option value="">选择周期状态</option>
                <option value="1">上半年</option>
                <option value="2">下半年</option>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-success btn_submit" type="button">提交</button>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function(){

        $('.btn_submit').click(function(){
            var house_id = $('#house_id').val();
            var seat_id  = $('#seat_id').val();
            var room_num = $('#room_num').val();
            var money    = $('#money').val();
            var year     = $('#year').val();
            var year_status = $('#year_status').val();
            if (year == undefined || year.length == 0) {
                alert('请选择缴费周期');return false;
            }
            if (year_status == undefined || year_status.length == 0) {
                alert('请选择缴费状态');return false;
            }
            var data = {};
            data.house_id = house_id;
            data.seat_id  = seat_id;
            data.room_num = room_num;
            data.money     = money;
            data.year     = year;
            data.year_status     = year_status;
            $.post('/index.php?r=admin/property-pay/add',data,function(res){
                if (res.code == 200) {
                    alert(res.msg);
                    parent.location.reload();
                } else {
                    alert(res.msg);
                    return false;
                }
            },'JSON');
        });
    });

    $('#house_id').change(function () {
        var house_ids = $(this).children('option:selected').val();
        var mysqlurl ="/index.php?r=admin/sys/site";
        $.ajax({
            type: 'GET',
            url: mysqlurl,
            dataType: 'json',
            data: {house_id: house_ids},
            success: function (data) {
                //console.log(data.code[0]['housename']);
                var html='';
                for(var i=0;i<data.code.length;i++){
                    // console.log(data.code[i]['housename']);
                    html += '<option value='+data.code[i]['id']+'>'+data.code[i]['housename']+'</option>';
                }
                var oContent=$("#seat_id");
                oContent.html(html);
            }
        });
    });
</script>