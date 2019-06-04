<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '房屋租赁收费统计';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="/font/iconfont.css">
<link rel="stylesheet" href="/css/statistics.css">

<div class="select-cont">
    <h3 style="margin-bottom: 20px">信息筛选：</h3>
    
    <form action="/admin/count/house-lease-count">
        <?php 
            $house_choose = empty(Yii::$app->request->get()['house_choose']) ? 'all' : Yii::$app->request->get()['house_choose'];
            $house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
            $house_type = empty(Yii::$app->request->get()['house_type']) ? 0 : Yii::$app->request->get()['house_type'];
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
                <select id="house_type" name="house_type">
                    <option value="">=选择类型=</option>
                    <option value="1" <?php if($house_type == 1) echo 'selected';?>>写字楼</option>
                    <option value="2" <?php if($house_type == 2) echo 'selected';?>>商铺</option>
                    <option value="3" <?php if($house_type == 3) echo 'selected';?>>公寓</option>
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

<div class="echart">
    <div class="lease-echarts cont-base">
        <h4>项目数据汇总:</h4>
        <ul class="clearfix">
            <li><p class="text-muted ellipse">已收总佣金额(元)</p><p class="num text-red"><?=$report_count['get_money'] ? $report_count['get_money'] : '--'?></p></li>
            <li><p class="text-muted ellipse">总户数(户)</p><p class="num"><?=$lease_count['total_nums'] ? $lease_count['total_nums'] : '--'?></p></li>
            <li><p class="text-muted ellipse">可租户数(户)</p><p class="num"><?=$lease_count['rent_nums'] ? $lease_count['rent_nums'] : '--'?></p></li>
            <li><p class="text-muted ellipse">不可租户数（含未交房）</p><p class="num"><?=$lease_count['unrent_nums'] ? $lease_count['unrent_nums'] : '--'?></p></li>
            <li><p class="text-muted ellipse">总面积(㎡)</p><p class="num"><?=$lease_count['total_space'] ? $lease_count['total_space'] : '--'?></p></li>
            <li><p class="text-muted ellipse">可租面积(㎡)</p><p class="num"><?=$lease_count['rent_space'] ? $lease_count['rent_space'] : '--'?></p></li>
            <li><p class="text-muted ellipse">不可租面积(㎡)</p><p class="num"><?=$lease_count['unrent_space'] ? $lease_count['unrent_space'] : '--'?></p></li>
            <li><p class="text-muted ellipse">签约户数(户)</p><p class="num text-orange"><?=$report_count['nums'] ? $report_count['nums'] : '--'?></p></li>
            <li><p class="text-muted ellipse">签约面积(㎡)</p><p class="num text-green"><?=$report_count['space'] ? $report_count['space'] : '--'?></p></li>
        </ul>
        <!--租赁折线图-->
        <div class="line-chart clearfix" id="line-chart"></div>
    </div>

    <!--租赁饼状图-->
    <div class="row lease-bar">
        <div class="col-md-4 money-bar" id="moneyBar"></div>
        <div class="col-md-4 num-bar" id="numBar"></div>
        <div class="col-md-4 area-bar" id="areaBar"></div>
    </div>
</div>

<div class="data-table">
    <h4>房屋租赁收费统计:</h4>
    <table class="table table-striped table-bordered text-center">
        <thead>
        <tr>
            <th class="text-center">项目</th>
            <th class="text-center">已收佣金额</th>
            <th class="text-center">总户数</th>
            <th class="text-center">可租户数</th>
            <th class="text-center">不可租户数（含未交房）</th>
            <th class="text-center">可租面积</th>
            <th class="text-center">不可租面积</th>
            <th class="text-center">签约户数</th>
            <th class="text-center">签约面积</th>
        </tr>
        </thead>
        <tbody>
        <?php if ($list): ?>
            <?php foreach ($list as $k => $v): ?>
            <tr>
                <td><?=$v['housename']?></td>
                <td><?=$v['get_total_money']?></td>
                <td><?=$v['total_nums']?></td>
                <td><?=$v['rent_nums']?></td>
                <td><?=$v['unrent_nums']?></td>
                <td><?=$v['rent_space']?></td>
                <td><?=$v['unrent_space']?></td>
                <td><?=$v['total_count']?></td>
                <td><?=$v['total_space']?></td>
            </tr>
            <?php endforeach ?>
        <?php else: ?>
            <tr>
                <td colspan="9">暂无数据</td>
            </tr>
        <?php endif ?>
        </tbody>
    </table>
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
        // 租赁折线图
        (function leaseLine() {
            var lineId = echarts.init(document.getElementById('line-chart'));
            var lineTitle = '佣金统计：';
            var lineUnit = '元';
            var lineColor =  ['#7cbded'];
            var lineData = [
                {
                    name: '已收佣金',
                    type:'line',
                    data: <?=json_encode($zoushi['y'])?>
                }
            ];
            var xData = <?=json_encode($zoushi['x'])?>;
            Line(lineId, lineTitle, lineData, lineUnit, lineColor, xData);
        })();

        // 收取佣金饼状图统计
        (function leaseBar() {
            var barId = echarts.init(document.getElementById('moneyBar'));
            var barTitle = '佣金占比统计';
            var barName = '统计详情';
            var barColor =  ['#f3c55b', '#67bbe1', '#ef7489'];
            var tipData = ['写字楼','商铺','公寓'];
            var barUnit = '元';
            var barData = [
                {value:<?=$chart1['office']?$chart1['office']:0?>, name:'写字楼'},
                {value:<?=$chart1['shops']?$chart1['shops']:0?>, name:'商铺'},
                {value:<?=$chart1['apartment']?$chart1['apartment']:0?>, name:'公寓'}
            ];
            Bar2(barId, barTitle, barName, barColor,tipData, barData, barUnit);
        })();
        // 收取户数饼状图统计
        (function leaseBar() {
            var barId = echarts.init(document.getElementById('numBar'));
            var barTitle = '户数统计：';
            var barName = '统计详情';
            var barColor =  ['#f3c55b', '#67bbe1', '#ef7489'];
            var tipData = ['写字楼','商铺','公寓'];
            var barUnit = '户';
            var barData = [
                {value:<?=$chart2['office']?$chart1['office']:0?>, name:'写字楼'},
                {value:<?=$chart2['shops']?$chart1['shops']:0?>, name:'商铺'},
                {value:<?=$chart2['apartment']?$chart1['apartment']:0?>, name:'公寓'}
            ];
            Bar2(barId, barTitle, barName, barColor,tipData, barData, barUnit);
        })();
        // 收取面积饼状图统计
        (function leaseBar() {
            var barId = echarts.init(document.getElementById('areaBar'));
            var barTitle = '面积统计：';
            var barName = '统计详情';
            var barColor =  ['#f3c55b', '#67bbe1', '#ef7489'];
            var tipData = ['写字楼','商铺','公寓'];
            var barUnit = '平';
            var barData = [
                {value:<?=$chart3['office']?$chart1['office']:0?>, name:'写字楼'},
                {value:<?=$chart3['shops']?$chart1['shops']:0?>, name:'商铺'},
                {value:<?=$chart3['apartment']?$chart1['apartment']:0?>, name:'公寓'}
            ];
            Bar2(barId, barTitle, barName, barColor,tipData, barData, barUnit);
        })();

    });

</script>
