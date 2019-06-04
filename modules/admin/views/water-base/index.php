<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\WaterBaseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '水费基础信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Html::cssFile('/css/webuploader.css')?>
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/js/webuploader/webuploader.js')?>
<?=Html::jsFile('/js/upload_excel.js')?>
<style>
    .mask-body{
        display: none;
    }
    .mask{
        position: fixed;
        left: 0;
        top: 0;
        display: block;
        width: 100%;
        height: 100%;
        text-align: center;
        background: rgba(0,0,0,0.3);
        z-index: 1;
    }
    .tip{
        position: absolute;
        left: 34%;
        top: 20%;
        width: 600px;
        height: 120px;
        background: #ffffff;
        border-radius: 10px;
        padding: 20px 0;
        text-align: left;
    }
    .title{
        padding-left: 15px;
        font-size: 16px;
        border-bottom: 1px solid #e6e6e6;
        padding-bottom: 10px;
    }
    .load{
        padding-left: 15px;
        margin-top: 15px;
        font-size: 15px;
    }
</style>
<div class="mask-body">
    <div class="tip">
        <div class="title">提示</div>
        <div class="load">上传中，请稍等……</div>
    </div>
</div>
<div class="water-base-index mask-sib">
    <h1><?= Html::encode($this->title) ?></h1>
    <form class="form-inline" action="">
        <?php
        $owner_name = empty(Yii::$app->request->get()['owner_name']) ? '' : Yii::$app->request->get()['owner_name'];
        $house_id = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
        $room_num = empty(Yii::$app->request->get()['room_num']) ? '' : Yii::$app->request->get()['room_num'];
        $water_type     = empty(Yii::$app->request->get()['water_type']) ? 0 : Yii::$app->request->get()['water_type'];
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
            <input type="text" class="form-control" id="owner_name" name="owner_name" placeholder="业主名称" value="<?=$owner_name?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="room_num" name="room_num" placeholder="房间号" value="<?=$room_num?>">
        </div>
        <div class="form-group">
            <select class="form-control" name="water_type" id="water_type">
                <option value="">状态</option>
                <option value="3" <?php if($water_type == '3') echo 'selected';?>>未支付</option>
                <option value="1" <?php if($water_type == '1') echo 'selected';?>>支付</option>
                <option value="2" <?php if($water_type == '2') echo 'selected';?>>线下支付</option>
            </select>
        </div>
        <button type="submit" class="btn btn-default">查询</button>
        <a href="javascript:void(0);" class="btn btn-default" onclick="location.reload();">刷新</a>
    </form>
    <br/>
    <div>
        <p><a href="/admin/water-base/download-file" class="btn btn-success">下载模板</a></p>
        <p>导入水费基础信息：</p>
        <div id="filePicker"></div>
        <div id="fileList"></div>
        <div class="class="form-group">
        <a href="javascript:void(0);" class="btn btn-default" id="btn_import">执行导入数据</a>
        &nbsp;<button class="btn btn-danger" id="select">删除</button>&nbsp;&nbsp<!--<button class="btn btn-default" id="payment">线下缴费</button>-->
        <button class="all btn btn-default">全选</button>
        <?= Html::a('添加水费基础信息', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="class="form-group">
    <p class="info"></p>
    <div id="error_data">
    </div>
</div>
</div>
<table class="table table-striped table-bordered" style="text-align: center;">
    <thead>
    <tr>
        <th style="text-align: center;"></th>
        <th style="text-align: center;">ID</th>
        <th style="text-align: center;">楼盘名称</th>
        <th style="text-align: center;">座号</th>
        <th style="text-align: center;">房间号</th>
        <th style="text-align: center;">业主名称</th>
        <th style="text-align: center;">水表号</th>
        <th style="text-align: center;">单价</th>
        <th style="text-align: center;">月初度数</th>
        <th style="text-align: center;">月末度数</th>
        <th style="text-align: center;">本月用量</th>
        <th style="text-align: center;">本月金额</th>
        <th style="text-align: center;">支付状态</th>
        <th style="text-align: center;">创建时间</th>
        <th style="text-align: center;">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if($list):?>
        <?php foreach($list as $k => $v): ?>
            <tr>
                <td><input type="checkbox" name="chkId" value="<?php echo $v['id']; ?>"  /></td>
                <td><?=$v['id'] ?></td>
                <td><?=$v['house_name'] ?></td>
                <td><?=$v['seat_name'] ?></td>
                <td><?=$v['room_num'] ?></td>
                <td><?=$v['owner_name'] ?></td>
                <td><?=$v['meter_number'] ?></td>
                <td><?=$v['monovalent'] ?></td>
                <td><?=$v['this_month'] ?></td>
                <td><?=$v['end_month'] ?></td>
                <td><?=$v['month_dosage'] ?></td>
                <td><?=$v['month_amount'] ?></td>
                <td>
                    <?php
                    if($v['water_type'] == 0) echo '未支付';
                    elseif($v['water_type'] == 1) echo '支付';
                    elseif($v['water_type'] == 2) echo '线下支付';
                    ?>
                </td>
                <td><?= date('Y-m-d H:i:s',$v['create_time']); ?></td>
                <td>&nbsp<a href="<?php echo \yii\helpers\Url::to(['water-base/view','id'=>$v['id']]); ?>">查看</a>&nbsp;&nbsp;<a href="<?php echo \yii\helpers\Url::to(['water-base/update','id'=>$v['id']]); ?>">更新</a>&nbsp;&nbsp;<!--<a href="<?php echo \yii\helpers\Url::to(['water-base/delete','id'=>$v['id']]) ?>">删除</a>--> </td>
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

<script type="text/javascript">
    $(function(){
        var strSel = '';
        $("#payment").click(function () {
            $("[name='chkId']:checked").each(function () {
                strSel += $(this).val() + ",";
            })
            if(strSel.length >0){
                strSel = strSel.substring(0,strSel.length - 1);
            }else{
                alert("内容不能为空！");
                return false;
            }
            var dataurl = "/index.php?r=admin/water-base/ajax-pay";
            $.ajax({
                'url':dataurl,
                'type':'GET',
                'dataType':'json',
                'data':{Id:strSel},
                success:function (data) {
                    if(data.status==-200){ 
                        alert(data.message);
                        window.location.reload();
                        return false;
                    }else{
                        alert(data.message);
                        window.location.reload();
                        return false;
                    }
                }
            });
            return false;
        });
        $("#select").click(function () {
            $("[name='chkId']:checked").each(function (index,element) {
                strSel += $(this).val() + ",";
            })
            if(strSel.length >0){
                strSel = strSel.substring(0,strSel.length - 1);
            }else{
                alert("内容不能为空！");
                return false;
            }
            var url = "/index.php?r=admin/water-base/ajax-delete";
            $.ajax({
                'url':url,
                'type':'GET',
                'dataType':'json',
                'data':{Id:strSel},
                success:function (data) {
                    if(data.status==-200){
                        alert(data.message);
                        window.location.reload();
                        return false;
                    }else{
                        alert(data.message);
                        window.location.reload();
                        return false;
                    }
                }
            });
            return false;
        });
        $('#btn_import').click(function(){
            var path = $('#fileList').data('url');
            if (path == undefined || path.length == 0) {
                alert('请先上传excel文件');return false;
            }
            $(this).parents('.mask-sib').siblings('.mask-body').addClass('mask');
            $.post("<?= Url::to(['water-base/ajax-import-excel'])?>",{
                path:path
            },function(res){
                if (res.code == 200) {
                    $('.info').html('执行完毕，成功：'+res.success+'条；失败'+res.fail+'条。');
                    var len = res.data.length;
                    if (len > 0) {
                        var str = '<table class="table table-striped table-bordered" style="text-align: center;">';
                        str += '<thead><tr>';
                        str += '<th>楼盘名称</th>';
                        str += '<th>座号</th>';
                        str += '<th>房间号</th>';
                        str += '<th>业主名称</th>';
                        str += '<th>电表号</th>';
                        str += '<th>单价</th>';
                        str += '<th>月初度数</th>';
                        str += '<th>月末度数</th>';
                        str += '<th>本月用量</th>';
                        str += '<th>本月金额</th>';
                        str += '<th>执行结果</th>';
                        str += '</tr></thead>';
                        for (var i = 0; i < len; i++) {
                            str += '<tbody><tr>';
                            str += '<td>'+res.data[i]['house_id']+'</td>';
                            str += '<td>'+res.data[i]['seat_id']+'</td>';
                            str += '<td>'+res.data[i]['room_num']+'</td>';
                            str += '<td>'+res.data[i]['owner_name']+'</td>';
                            str += '<td>'+res.data[i]['meter_number']+'</td>';
                            str += '<td>'+res.data[i]['monovalent']+'</td>';
                            str += '<td>'+res.data[i]['this_month']+'</td>';
                            str += '<td>'+res.data[i]['end_month']+'</td>';
                            str += '<td>'+res.data[i]['month_dosage']+'</td>';
                            str += '<td>'+res.data[i]['month_amount']+'</td>';
                            str += '<td style="color:red;">'+res.data[i]['error']+'</td>';
                            str += '</tr></tbody>';
                        }
                        str += '</table>';
                        $('#error_data').html(str);
                        $('.mask-body').removeClass('mask');
                    }
                    setTimeout(function(){
                        location.reload();
                    },5000);
                } else {
                    $('.info').html(res.msg);
                }
            },'JSON');
        });
        //全选
        $(".all").click(function(){
            $("input[name='chkId']").each(function(){
                if (this.checked) {
                    this.checked = false;
                }
                else {
                    this.checked = true;
                }
            });
        })
    });
</script>
