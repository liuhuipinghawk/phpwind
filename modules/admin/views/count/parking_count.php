<?php

$this->title = '停车缴费统计';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="/font/iconfont.css">
<link rel="stylesheet" href="/css/statistics.css">


<div class="select-cont">
    <h3 style="margin-bottom: 20px">信息筛选：</h3>
    <form action="/admin/count/parking-count">
        <?php
        $house_choose = empty(Yii::$app->request->get()['house_choose']) ? 'all' : Yii::$app->request->get()['house_choose'];
        $house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
        $time_tag = empty(Yii::$app->request->get()['time_tag']) ? 'first_half' : Yii::$app->request->get()['time_tag'];
        $sdate = empty(Yii::$app->request->get()['sdate']) ? date('Y-m-01') : Yii::$app->request->get()['sdate'];
        $edate = empty(Yii::$app->request->get()['edate']) ? date('Y-m-t') : Yii::$app->request->get()['edate'];
        $currentPage = empty(Yii::$app->request->get()['currentPage']) ? '1' : Yii::$app->request->get()['currentPage'];
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
    <div class="lease-echarts parking-echarts">
        <h4>项目数据汇总:</h4>
        <ul class="clearfix">
            <li><p class="text-muted ellipse">车位总数(个)</p><p class="num"><?=$stall['num']?$stall['num']:0?></p></li>
            <li><p class="text-muted ellipse">已售车位数量(个)</p><p class="num"><?=$attr['sold']?$attr['sold']:0?></p></li>
            <li><p class="text-muted ellipse">租赁车位数量(个)</p><p class="num"><?=$attr['rent']?$attr['rent']:0?></p></li>
            <li><p class="text-muted ellipse">临停车位数量(个)</p><p class="num"><?=$linting['count']?></p></li>
            <li><p class="text-muted ellipse">临停收费金额(元)</p><p class="num text-red"><?=$linting['money']?></p></li>
            <li><p class="text-muted ellipse">其他车位数量(个)</p><p class="num text-orange"><?=$attr['other']?$attr['other']:0?></p></li>
        </ul>
        <!--停车饼状图-->
<!--        <div class="park-chart clearfix" id="parkBar"></div>-->
    </div>

</div>

<div class="data-table">
    <h4>停车场收费统计:</h4>
    <!--总项目表-->
    <table class="table table-striped table-bordered text-center tab-total">
        <thead>
        <tr>
            <th class="text-center">项目</th>
            <th class="text-center">车位总数</th>
            <th class="text-center">已售车位数量</th>
            <th class="text-center">租赁数量</th>
            <th class="text-center">其他数量</th>
            <th class="text-center">临停车位数量</th>
            <th class="text-center">临停收费金额</th>
        </tr>
        </thead>
        <tbody>
        <?php if($list):?>
        <?php foreach ($list as $k => $v): ?>
        <tr>
            <td><?=$v['housename'] ?></td>
            <td><?=$v['stall_num'] ?></td>
            <td><?=$v['sold'] ?></td>
            <td><?=$v['rent'] ?></td>
            <td><?=$v['other'] ?></td>
            <td><?=$v['count'] ?></td>
            <td><?=$v['money'] ?></td>
        </tr>
        <?php endforeach?>
        <?php endif ?>
        </tbody>
    </table>
    <!--分项目表-->
    <table class="table table-striped table-bordered text-center tab-every active-show">
        <thead>
        <tr>
            <th class="text-center">交易流水号</th>
            <th class="text-center">凭证号</th>
            <th class="text-center">入场时间</th>
            <th class="text-center">计费开始时间</th>
            <th class="text-center">计费截止时间</th>
            <th class="text-center">扣款金额</th>
            <th class="text-center">支付方式</th>
        </tr>
        </thead>
        <tbody>
        <?php if($linting['list']):?>
        <?php foreach ($linting['list'] as $k => $v): ?>
            <tr>
                <td><?=$v->TranId?$v->TranId:0 ?></td>
                <td><?=$v->TokenId?$v->TokenId:0 ?></td>
                <td><?=$v->InTime?$v->InTime:0 ?></td>
                <td><?=$v->TollBeginTime?$v->TollBeginTime:0 ?></td>
                <td><?=$v->TollEndTime?$v->TollEndTime:0 ?></td>
                <td><?=$v->CashAmount?$v->CashAmount:0 ?></td>
                <!--           1 银联闪付, 2 微信, 3 现金, 4 ETC, 5 支付宝, 6 银联钱包, 7 翼支付, 8 百度钱包, 9 POS机，10优惠券，11 会员积分, 12 其他-->
                <td><?php if($v->TollType == 1){
                        echo '银联闪付';
                    }elseif($v->TollType == 2){
                        echo '微信';
                    }elseif($v->TollType == 3){
                        echo '现金';
                    }elseif($v->TollType == 5){
                        echo '支付宝';
                    }else{
                        echo '其他';
                    } ?>
                </td>
            </tr>
        <?php endforeach?>
        <?php endif ?>
        </tbody>
    </table>

    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li>
                <a href="/admin/count/parking-count?house_choose=<?=$house_choose?>&house_id=<?=$house_id?>&time_tag=<?=$time_tag?>&sdate=<?=$sdate?>&edate=<?=$edate?>&currentPage=1" aria-label="Previous">
                    <span aria-hidden="true">首页</span>
                </a>
            </li>
            <li>
                <a href="/admin/count/parking-count?house_choose=<?=$house_choose?>&house_id=<?=$house_id?>&time_tag=<?=$time_tag?>&sdate=<?=$sdate?>&edate=<?=$edate?>&currentPage=<?=empty($currentPage-1)?1:$currentPage-1?>" aria-label="Previous">
                    <span aria-hidden="true">上一页</span>
                </a>
            </li>
            <li>
                <a href="/admin/count/parking-count?house_choose=<?=$house_choose?>&house_id=<?=$house_id?>&time_tag=<?=$time_tag?>&sdate=<?=$sdate?>&edate=<?=$edate?>&currentPage=<?=$currentPage+1?>" aria-label="Next">
                    <span aria-hidden="true">下一页</span>
                </a>
            </li>
            <li><a href="#" aria-label="Next">
                    <span aria-hidden="true">当前第 <span><?=$currentPage ?></span> 页</span>
                </a>
            </li>
        </ul>
    </nav>


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
        // 停车缴费饼状图
        //(function leaseBar() {
        //    var barId = echarts.init(document.getElementById('parkBar'));
        //    var barTitle = '类型统计：';
        //    var barName = '统计详情';
        //    var barColor =  ['#65dd65', '#f8758a', '#56bbdf', '#f8c663'];
        //    var tipData = ['已售车位','其他车位','临时车', '月租车'];
        //    var barUnit = '个';
        //    var barData = [
        //        {value:<?//=$attr['sold']?$attr['sold']:0?>//, name:'已售车位'},
        //        {value:<?//=$attr['other']?$attr['other']:0?>//, name:'其他车位'},
        //        {value:50, name:'临时车'},
        //        {value:<?//=$attr['rent']?$attr['rent']:0?>//, name:'月租车'}
        //    ];
        //    Bar3(barId, barTitle, barName, barColor,tipData, barData, barUnit);
        //})();

        //停车缴费折线图
        (function leaseLine() {
            var lineId = echarts.init(document.getElementById('parkBar'));
            var lineTitle = '收费金额统计：';
            var lineUnit = '元';
            var lineColor =  ['#74c9e8'];
            var lineData = [
                {
                    name: '临停收费金额',
                    type:'line',
                    data: [100, 50, 100, 150, 200, 300, 400]
                }
            ];
            var xData = <?=json_encode($zoushi['x'])?>;
            Line(lineId, lineTitle, lineData, lineUnit, lineColor, xData);
        })();
    });

</script>
