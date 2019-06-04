<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '物业费缴费统计';
$this->params['breadcrumbs'][] = $this->title;
?>

<link rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="/font/iconfont.css">
<link rel="stylesheet" href="/css/statistics.css">
<div class="select-cont">
    <h3 style="margin-bottom: 20px">信息筛选：</h3>
    <form action="/admin/count/property-fee-count">
        <?php 
            $house_choose = empty(Yii::$app->request->get()['house_choose']) ? 'all' : Yii::$app->request->get()['house_choose'];
            $house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
            $seat_id = empty(Yii::$app->request->get()['seat_id']) ? 0 : Yii::$app->request->get()['seat_id'];
            $time_tag = empty(Yii::$app->request->get()['time_tag']) ? 'first_half' : Yii::$app->request->get()['time_tag'];
            $sdate = empty(Yii::$app->request->get()['sdate']) ? date('Y-m-01') : Yii::$app->request->get()['sdate'];
            $edate = empty(Yii::$app->request->get()['edate']) ? date('Y-m-t') : Yii::$app->request->get()['edate'];
         ?>
        <div class="select-list clearfix project-menu">
            <label class="title pull-left">选择项目</label>
            <ul class="pagination ul-select pull-left">
                <li class="default <?php if($house_choose == 'all') echo 'active';?>"><a href="javascript:void(0);" onclick="$('#house_choose').val('all');">全部项目</a></li>
                <li class="other <?php if($house_choose == 'other') echo 'active';?>"><a href="javascript:void(0);" onclick="$('#house_choose').val('other');">其他项目</a></li>
            </ul>
            <input type="hidden" name="house_choose" id="house_choose" value="<?=$house_choose?>">
        </div>

        <div class="select-list clearfix project-list active-show">
            <label class="title pull-left">选择楼盘</label>
            <div class="pull-left select-project">
                <select id="house_id" name="house_id">
                    <option value="">=选择楼盘=</option>
                    <?php if ($house): ?>
                        <?php foreach ($house as $k => $v): ?>
                            <option value="<?=$v['id']?>" <?php if($house_id == $v['id']) echo 'selected';?>><?=$v['housename']?></option>
                        <?php endforeach ?>
                    <?php endif ?>
                </select>
                <select id="seat_id" name="seat_id">
                    <option value="">=选择座号=</option>
                </select>
            </div>
        </div>
        <div class="select-list clearfix">
            <label class="title pull-left">时间筛选</label>
            <ul class="pagination ul-select pull-left">
                <li class="<?php if($time_tag == 'day') echo 'active'; ?>"><a href="javascript:void(0);" onclick="$('#time_tag').val('day');">今天</a></li>
                <li class="<?php if($time_tag == 'week') echo 'active'; ?>"><a href="javascript:void(0);" onclick="$('#time_tag').val('week');">本周</a></li>
                <li class="<?php if($time_tag == 'month') echo 'active'; ?>"><a href="javascript:void(0);" onclick="$('#time_tag').val('month');">本月</a></li>
                <li class="default <?php if($time_tag == 'first_half') echo 'active'; ?>"><a href="javascript:void(0);" onclick="$('#time_tag').val('first_half');">前半年</a></li>
                <li class="<?php if($time_tag == 'second_half') echo 'active'; ?>"><a href="javascript:void(0);" onclick="$('#time_tag').val('second_half');">后半年</a></li>
                <li class="<?php if($time_tag == 'year') echo 'active'; ?>"><a href="javascript:void(0);" onclick="$('#time_tag').val('year');">全年</a></li>
                <li class="time-btn <?php if($time_tag == 'other') echo 'active'; ?>"><a href="javascript:void(0);" onclick="$('#time_tag').val('other');">自定义时间筛选</a></li>
            </ul>
            <input type="hidden" name="time_tag" id="time_tag" value="<?=$time_tag ?>">
            <div class="control-group time-select pull-left <?php if($time_tag != 'other') echo 'active-show';?>">
                <div class="form-inline pull-left">
                    <input size="16" type="text" value="<?=$sdate ?>" id="datetimeStart" name="sdate" readonly class="form_datetime form-control">
                </div>
                <div class="form-inline pull-left" style="line-height: 34px; padding: 0 5px">
                    至
                </div>
                <div class="form-inline pull-left">
                    <input size="16" type="text" value="<?=$edate ?>" id="datetimeEnd" name="edate" readonly class="form_datetime form-control">
                </div>
            </div>
        </div>
        <div class="select-list select-btn clearfix" style="padding-left: 0">
            <a href="javascript:void(0);" class="btn btn-default btn-warning btn-select" onclick="$('form').submit();">开始筛选</a>
            <a href="javascript:void(0);" class="btn btn-default btn-cancel">取消筛选</a>
        </div>
    </form>
</div>

<div class="data-echarts cont-base">
    <h4>项目数据汇总:</h4>
    <div class="row">
        <div class="col-md-6 left-cont">
            <div class="top">
                <ul>
                    <li><div class="pull-left">
                            <i class="iconfont icon-renminbi2"></i>
                        </div>
                        <div class="pull-left text-num text-center">
                            <p class="title">本期应收金额</p>
                            <p class="num"><span class="tip">￥</span><?=$total_money ? round($total_money,2) : '--' ?></p>
                        </div>
                    </li>
                    <li><div class="pull-left">
                            <i class="iconfont icon-renminbi2"></i>
                        </div>
                        <div class="pull-left text-num text-center">
                            <p class="title">本期实收金额</p>
                            <p class="num"><span class="tip">￥</span><?=$real_money ? round($real_money,2) : '--' ?></p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="money" id="BarMoney"></div>
        </div>
        <div class="col-md-6 right-cont">
            <div class="top">
                <ul>
                    <li><div class="pull-left">
                            <i class="iconfont icon-duorenyonghu"></i>
                        </div>
                        <div class="pull-left">
                            <p class="title text-num text-center">应收户数</p>
                            <p class="num"><?=$total_households ?>/<span class="tip">户</span></p>
                        </div>
                    </li>
                    <li><div class="pull-left">
                            <i class="iconfont icon-duorenyonghu"></i>
                        </div>
                        <div class="pull-left">
                            <p class="title text-num text-center">实收户数</p>
                            <p class="num"><?=$real_households ?>/<span class="tip">户</span></p>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="households" id="BarHouse"></div>
        </div>
    </div>
</div>

<div class="data-table" id="data-table">
    <h4>物业收费详情:</h4>
    <table class="table table-striped table-bordered text-center">
        <thead>
        <tr>
            <th class="text-center">项目</th>
            <th class="text-center">业主姓名</th>
            <th class="text-center">门牌号/位置</th>
            <th class="text-center">房屋面积</th>
            <th class="text-center">物业费单价</th>
            <th class="text-center">应缴费月数</th>
            <th class="text-center">应收物业费</th>
            <th class="text-center">实际收取当期物业费</th>
            <!-- <th class="text-center">实际收取往期物业费</th> -->
        </tr>
        </thead>
        <tbody>
            <?php if ($list): ?>
                <?php foreach ($list as $k => $v): ?>
                <tr>
                    <td><?=$v['house_name'] ?></td>
                    <td><?=$v['owner'] ?></td>
                    <td><?=$v['house_name'].'-'.$v['seat_name'].'-'.$v['room'] ?></td>
                    <td><?=$v['area'] ? round($v['area']) : 0 ?></td>
                    <td><?=$v['property_fee'] ? round($v['property_fee'],2) : 0 ?></td>
                    <td><?=$num ?></td>
                    <td><?=$v['total_money'] ? round($v['total_money'],2) : 0 ?></td>
                    <td><?=$v['real_money'] ? round($v['real_money'],2) : 0 ?></td>
                    <!-- <td>查看详情</td> -->
                </tr>
                <?php endforeach ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">暂无数据</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>
    
    <?php 
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
     ?>

</div>

<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-datetimepicker.js"></script>
<script src="/js/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="/js/echarts.min.js"></script>
<script src="/js/statistics.js"></script>
<script src="/js/com-charts.js"></script>
<script type="text/javascript">
    $(function () {
        loadData();
        // 物业金额比
        (function moneyBar() {
            var myChartBarMoney = echarts.init(document.getElementById('BarMoney'));
            var moneyData = [
                {value:<?=($total_money-$real_money) ?>, name:'未收取总金额'},
                {value:<?=$real_money ?>, name:'实际收取总金额'}
            ];
            var moneyTitle = '金额比';
            var moneyColor =  ['#56bbdf', '#f8c663'];
            Bar(myChartBarMoney, moneyData, moneyTitle, moneyColor);
        })();

        // 物业户数比
        (function moneyBar() {
            var myChartBarMoney = echarts.init(document.getElementById('BarHouse'));
            var moneyData = [
                {value:<?=($total_households-$real_households) ?>, name:'未收取户数'},
                {value:<?=$real_households ?>, name:'实际收取户数'}
            ];
            var moneyTitle = '户数比';
            var moneyColor =  ['#24d7ba', '#f8758a'];
            Bar(myChartBarMoney, moneyData, moneyTitle, moneyColor);
        })();

        $(document).on('change','#house_id',function(){
            var id = $(this).val();
            bindSeat(id);
        });
    })

    function bindSeat(id,seat_id)
    {
        var option = "<option value=''>=请选择楼座=</option>";
        if (id == undefined || id == '') {
            $('#seat_id').html(option); return false;
        }
        $.ajax({
            type:'post',
            dataType:'json',
            url:'/admin/count/ajax-get-house',
            data:{
                parent_id:id
            },
            success:function(res){
                if (res.code == 200) {
                    var len = res.data.length;
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            var sid = res.data[i]['id'];
                            if (seat_id == sid) {
                                option += "<option value='"+res.data[i]['id']+"' selected>"+res.data[i]['housename']+"</option>";
                            } else {
                                option += "<option value='"+res.data[i]['id']+"'>"+res.data[i]['housename']+"</option>";
                            }
                        }
                    }
                }
                $('#seat_id').html(option);
            }
        });
    }

    function loadData(){
        var house_id = <?=$house_id ?>;
        var seat_id = <?=$seat_id ?>;
        bindSeat(house_id,seat_id);
    }
</script>