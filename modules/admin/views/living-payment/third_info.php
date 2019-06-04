<?php

// use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '第三方基础信息管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::jsFile('/js/jquery-1.12.4.js')?>

<style type="text/css">
    .room_info{
        display: block; 
        float: left;
        border: 1px solid #333;
        background: #333;
        color: #fff;
        border-radius: 4px;
        padding: 10px 10px 0 10px;
        margin-right: 20px;
    }
    .tb_hide{display: none;}
</style>

<div>
    <h1>第三方基础信息管理</h1>
    <p><a href="javascript:void(0);" class="btn btn-default" onclick="updateAreaInfo()">更新区域信息</a></p>
    <p><a href="javascript:void(0);" class="btn btn-default" onclick="location.reload()">刷新</a></p>
    <!-- <p><a href="javascript:void(0);" class="btn btn-default">更新建筑信息</a></p>
    <p><a href="javascript:void(0);" class="btn btn-default">更新房间信息信息</a></p> -->
    <div id="error_info"></div>
    <hr>
    <h3>区域建筑列表</h3>
    <table class="table table-striped table-bordered" style="text-align: center;">
        <thead>
        <tr>
            <th style="text-align: center;">区域ID</th>
            <th style="text-align: center;">区域名称</th>
            <th style="text-align: center;">关联楼盘ID</th>
            <th style="text-align: center;">建筑ID</th>
            <th style="text-align: center;">建筑名称</th>
            <th style="text-align: center;">关联楼座ID</th>
            <th style="text-align: center;">总楼层</th>
            <th style="text-align: center;">开始楼层</th>
            <th style="text-align: center;">单位</th>
            <th style="text-align: center;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if($list):?>
            <?php foreach($list as $k => $v): ?>
                <tr>
                    <td><?=$v['area_id'] ?></td>
                    <td><?=$v['area_name'] ?></td>
                    <td><?=$v['house_id'] ?></td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td>--</td>
                    <td><a href="javascript:void(0);" onclick="updateArchInfo(<?=$v['id'] ?>)">更新楼座信息</a></td>
                </tr>
                <?php if ($v['arch']): ?>
                    <?php foreach ($v['arch'] as $kk => $vv): ?>
                        <tr>
                            <td><?=$vv['area_id'] ?></td>
                            <td><?=$v['area_name'] ?></td>
                            <td><?=$vv['house_id'] ?></td>
                            <td><?=$vv['arch_id'] ?></td>
                            <td><?=$vv['arch_name'] ?></td>
                            <td><?=$vv['seat_id'] ?></td>
                            <td><?=$vv['arch_storys'] ?></td>
                            <td><?=$vv['arch_begin'] ?></td>
                            <td><?=$vv['arch_unit'] ?></td>
                            <td>
                                <a href="javascript:void(0);" onclick="updateRoomInfo(<?=$vv['id'] ?>)">更新房间信息</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10" style="text-align: left;">
                                <?php if ($vv['floor']): ?>
                                    <a href="javascript:void(0);" class="show_hid">+ 展开房间信息</a>
                                    <table class="table table-bordered tb_hide">
                                        <?php foreach ($vv['floor'] as $a => $b): ?>
                                            <tr>
                                                <td rowspan="2" style="width: 80px;">楼层：<?=$b ?></td>
                                                <td style="width: 80px;">房间号</td>
                                                <?php if ($vv['room_list']): ?>
                                                    <?php foreach ($vv['room_list'] as $aa => $bb): ?>
                                                        <?php if ($bb['floor'] == $b): ?>
                                                            <td style="width: 80px;"><?=$bb['room_name'] ?></td>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 80px;">电表号</td>
<!--                                                --><?php //if ($vv['room_list']): ?>
<!--                                                    --><?php //foreach ($vv['room_list'] as $aa => $bb): ?>
<!--                                                        --><?php //if ($bb['floor'] == $b): ?>
<!--                                                            <td style="width: 80px;">--><?//=$bb['ammeter_id'] ?><!--</td>-->
<!--                                                        --><?php //endif ?>
<!--                                                    --><?php //endforeach ?>
<!--                                                --><?php //endif ?>
                                                <td></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </table>
                                    <?php else: ?>
                                        暂无房间信息
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
            <?php endforeach; ?>
        <?php endif;?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(function(){
        $('.show_hid').click(function(){
            if ($(this).next('table').hasClass('tb_hide')) {
                $(this).next('table').removeClass('tb_hide');
                $(this).html('- 收起房间信息');
            } else {
                $(this).next('table').addClass('tb_hide');
                $(this).html('+ 展开房间信息');
            }
        });
    });

    //更新区域信息
	function updateAreaInfo(){
        $("#zzc").click();
        $("#myModalLabel").html("更新区域信息操作提示");
        $("#myModalBody").html("<p>程序正在执行，请耐心等待...</p><img src=\"/img/timg.gif\">");        
        $.ajax({
            type:'post',
            dataType:'json',
            url:"<?=Url::to(['living-payment/get-area-info'])?>",
            data:{},
            success:function(res){
                if (res.code == 200) {
                    // alert(res.msg);
                    $("#myModalBody").html("<p>"+res.msg+"</p>");
                    var l = res.data.length;
                    if (l > 0) {
                        var str = '';
                        for (var i = 0; i < l; i++) {
                            str += '<p>'+res.data[i]['area_name']+','+res.data[i]['error']+'</p>';
                        }
                        // $('#error_info').html(str);
                        $("#myModalBody").append(str);
                    } 
                } else {
                    // alert(res.msg);return false;
                    $("#myModalBody").html("<p>"+res.msg+"</p>");
                }
                $("#zzc_close").html("<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\" onclick=\"location.reload();\">关闭刷新</button>");
            }
        });
    }

    //更新楼座信息
    function updateArchInfo(id){
        $("#zzc").click();
        $("#myModalLabel").html("更新楼座信息操作提示");
        $("#myModalBody").html("<p>程序正在执行，请耐心等待...</p><img src=\"/img/timg.gif\">");
        $.ajax({
            type:'post',
            dataType:'json',
            url:"<?=Url::to(['living-payment/get-arch-info'])?>",
            data:{
                id:id
            },
            success:function(res){
                if (res.code == 200) {
                    // alert(res.msg);
                    $("#myModalBody").html("<p>"+res.msg+"</p>");
                    var l = res.data.length;
                    if (l > 0) {
                        var str = '';
                        for (var i = 0; i < l; i++) {
                            str += '<p>'+res.data[i]['arch_name']+','+res.data[i]['error']+'</p>';
                        }
                        // $('#error_info').html(str);
                        $("#myModalBody").append(str);
                    }
                } else {
                    // alert(res.msg);return false;
                    $("#myModalBody").html("<p>"+res.msg+"</p>");
                }
                $("#zzc_close").html("<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\" onclick=\"location.reload();\">关闭刷新</button>");
            }
        });
    }

    //更新房间信息
    function updateRoomInfo(id){
        $("#zzc").click();
        $("#myModalLabel").html("更新房间信息操作提示");
        $("#myModalBody").html("<p>程序正在执行，请耐心等待...</p><img src=\"/img/timg.gif\">");
        $.ajax({
            type:'post',
            dataType:'json',
            url:"<?=Url::to(['living-payment/get-room-info'])?>",
            data:{
                id:id
            },
            success:function(res){
                if (res.code == 200) {
                    var str = '<p>执行结果：</p>';
                    var len = res.data.length;
                    if (len) {
                        for (var i = 0; i < len; i++) {
                            str += '<p>'+res.data[i]+'</p>';
                        }
                    }
                    // $('#error_info').html(str);
                    $("#myModalBody").html(str);
                } else {
                    $("#myModalBody").html("<p>"+res.msg+"</p>");
                }
                $("#zzc_close").html("<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\" onclick=\"location.reload();\">关闭刷新</button>");
            }
        });
    }
</script>