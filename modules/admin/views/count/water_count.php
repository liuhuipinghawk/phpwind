<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '水费统计';
$this->params['breadcrumbs'][] = $this->title;
?>

<link rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="/font/iconfont.css">
<link rel="stylesheet" href="/css/statistics.css">

<div class="select-cont">
    <h3 style="margin-bottom: 20px">信息筛选：</h3>
    <form action="/admin/count/water-count" >
        <?php
        $house_choose = empty(Yii::$app->request->get()['house_choose']) ? 'all' : Yii::$app->request->get()['house_choose'];
        $house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
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
            <select name="house_id" id="parentSelect">
                <?php if ($house): ?>
                    <?php foreach ($house as $k => $v): ?>
                        <option value="<?=$v['id']?>" <?php if ($v['id'] == $house_id) echo 'selected'; ?> class="listANext"><?=$v['housename'] ?></option>
                    <?php endforeach ?>
                <?php endif ?>
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

<div class="echart cont-base">
    <div class="lease-echarts water-echarts">
        <h4>项目数据汇总:</h4>
        <ul class="clearfix">
            <li><p class="text-muted ellipse">总水表(吨)</p><p class="num text-red"><?=$data['totals']?$data['totals']:'--' ?></p></li>
            <li><p class="text-muted ellipse">公区用水(吨)</p><p class="num"><?=$data['publics']?$data['publics']:'--' ?></p></li>
            <li><p class="text-muted ellipse">办公用水(吨)</p><p class="num"><?=$data['offices']?$data['offices']:'--' ?></p></li>
            <li><p class="text-muted ellipse">业主用水(吨)</p><p class="num"><?=$data['holds']?$data['holds']:'--' ?></p></li>
            <li><p class="text-muted ellipse">收费总金额(元)</p><p class="num"><?=$money['money']?$money['money']:'--' ?></p></li>
        </ul>
    </div>
</div>
<div class="data-total-project cont-base">
    <table class="table table-bordered text-center">
        <thead>
        <tr>
            <th class="text-center">名称</th>
            <?php foreach ($list as $k => $v): ?>
                <th class="text-center"><?=$v['housename'] ?></th>
            <?php endforeach?>
            <th class="text-center">合计</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>公区用水</td>
            <?php $a = 0;?>
            <?php foreach ($list as $k => $v): ?>
                <td class="text-center"><?=$v['public'] ?></td>
                <?php $a += $v['public']?>
            <?php endforeach?>
            <td class="text-center"><?=$a ?></td>
        </tr>
        <tr>
            <td>收费面积</td>
            <?php $b = 0;?>
            <?php foreach ($list as $k => $v): ?>
                <td class="text-center"><?=$v['area'] ?></td>
                <?php $b += $v['area']?>
            <?php endforeach?>
            <td class="text-center"><?=$b ?></td>
        </tr>
        <tr>
            <td>单位面积摊</td>
            <?php $c = 0;?>
            <?php foreach ($list as $k => $v): ?>
                <td class="text-center"><?=sprintf("%.2f",$v['val'])?></td>
                <?php $c += $v['val']?>
            <?php endforeach?>
            <td class="text-center"><?=sprintf("%.2f",$c) ?></td>
        </tr>
        </tbody>
    </table>

    <!--各个项目单位面积折线图-->
    <h4>各个项目单位面积折线图:</h4>
    <div class="line-chart clearfix" id="line-project"></div>

</div>

<div class="cont-base">
    <div class="bar-echarts" id="water-bar" style="height: 300px"></div>
</div>
<div class="data-table">
    <h4>水费收费统计:</h4>
    <!--总项目表-->
    <table class="table table-striped table-bordered text-center tab-total">
        <thead>
        <tr>
            <th class="text-center">项目</th>
            <th class="text-center">总用水量（吨）</th>
            <th class="text-center">公区用水量（吨）</th>
            <th class="text-center">公区用水占比</th>
            <th class="text-center">办公用水（吨）</th>
            <th class="text-center">办公用水占比</th>
            <th class="text-center">收费面积（㎡）</th>
            <th class="text-center">单位用水消耗（吨/平方米）<br/>公区用水量/收费面积</th>
            <th class="text-center">业主用水（吨）</th>
            <th class="text-center">业主用水占比</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($list as $k => $v): ?>
        <tr>
            <td><?=$v['housename'] ?></td>
            <td><?=$v['total'] ?></td>
            <td><?=$v['public'] ?></td>
            <td><?php echo sprintf("%.2f", ($v['public'] / ($v['total']?$v['total']:1)))*100; ?>%</td>
            <td><?=$v['office'] ?></td>
            <td><?php echo sprintf("%.2f", ($v['office'] / ($v['total']?$v['total']:1)))*100; ?>%</td>
            <td><?=$v['area'] ?></td>
            <td><?= sprintf("%.2f", $v['val'])?></td>
            <td><?=$v['hold'] ?></td>
            <td><?php echo sprintf("%.2f", ($v['hold'] / ($v['total']?$v['total']:1)))*100; ?>%</td>
        </tr>
        <?php endforeach?>
        </tbody>
    </table>
    <!--分项目表-->
    <table class="table table-striped table-bordered text-center tab-every active-show">
        <thead>
        <tr>
            <th class="text-center">序号</th>
            <th class="text-center">客户名称</th>
            <th class="text-center">客户地址</th>
            <th class="text-center">单价</th>
            <th class="text-center">用量</th>
            <th class="text-center">金额</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($n as $kk => $vv): ?>
        <tr>
            <td><?=$vv['order_sn']?></td>
            <td><?=$vv['owner']?></td>
            <td><?=$vv['housename'].'-'.$vv['seatname'].'-'.$vv['room_num']?></td>
            <td><?=round($vv['water_fee']/$vv['water_consumption'])?></td>
            <td><?=$vv['water_consumption']?></td>
            <td><?=$vv['water_fee']?></td>
        </tr>
        <?php endforeach?>
        </tbody>
        <div class="pagination-part">
            <nav>
                <?php
                echo LinkPager::widget([
                    'pagination' => $pagination,
                ]);
                ?>
            </nav>
        </div>
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
        // 折线图
        (function leaseLine() {
            var lineId = echarts.init(document.getElementById('line-project'));
            var lineTitle = '单位面积能耗：';
            var lineUnit = '';
            var lineColor =  ['#81abdd', '#c0504d', '#9bbb59', '#8064a2', '#4bacc6', '#f79646', '#2c4d75', '#5f7530', '#885cb9', '#78b1c0', '#f64b6f','#4B0082','#800000','#FF00FF'];
            var json = [];
                $.each( <?=json_encode($list)?>, function(i, n){
                    json.push({name: n.housename, type:'line', data: n.sn})
                });
//            console.log(json);
            var lineData =json;
            var xData = <?=json_encode($zoushi['x'])?>;
            Line(lineId, lineTitle, lineData, lineUnit, lineColor, xData);
        })();

        // 饼状图
        (function leaseBar() {
            var barId = echarts.init(document.getElementById('water-bar'));
            var barTitle = '能耗分析表：';
            var barName = '统计详情';
            var barColor =  ['#56bbdf', '#f8c663'];
            var tipData = ['业主用水','公区用水'];
            var barUnit = '吨';
            var barData = [
                {value:<?=$data['publics']?$data['publics']:0?>, name:'业主用水'},
                {value:<?=$data['holds']?$data['holds']:0?>, name:'公区用水'}
            ];
            Bar3(barId, barTitle, barName, barColor,tipData, barData, barUnit);
        })();
    });

</script>