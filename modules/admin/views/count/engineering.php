<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '工程派单统计';
$this->params['breadcrumbs'][] = $this->title;
?>

<link rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="/font/iconfont.css">
<link rel="stylesheet" href="/css/statistics.css">

<div class="select-cont">
    <h3 style="margin-bottom: 20px">信息筛选：</h3>
    <form action="/admin/count/engineering">
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
    <div class="lease-echarts engineering-echarts">
        <h4>项目数据汇总:</h4>
        <ul class="clearfix">
            <li><p class="text-muted ellipse">任务总量</p><p class="num text-red"><?=$data['num'] ?></p></li>
            <li><p class="text-muted ellipse">完成数</p><p class="num text-red"><?=$data['do'] ?></p></li>
            <li><p class="text-muted ellipse">完成比率</p><p class="num">
                    <?php if ($data['num'] == 0): ?>
                        0
                    <?php else: ?>
                        <?=round($data['do']/$data['num']*100) ?>%
                    <?php endif ?>
                </p></li>
            <li><p class="text-muted ellipse">关闭数量</p><p class="num text-red"><?=$data['close'] ?></p></li>
            <li><p class="text-muted ellipse">关闭比率</p><p class="num">
                    <?php if ($data['do'] == 0): ?>
                        0
                    <?php else: ?>
                        <?=round($data['close']/$data['do']*100) ?>%
                    <?php endif ?>
                </p></li>
            <li><p class="text-muted ellipse">已评价</p><p class="num"><?=$data['com']['com'] ?></p></li>
            <li><p class="text-muted ellipse">总评分</p><p class="num text-red"><?=$data['com']['score']?$data['com']['score']:0 ?></p></li>
        </ul>
    </div>
</div>
<div class="cont-base dynamic-cont">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-tabs-total" id="myTabs">
        <li class="active"><a href="#tab1" data-toggle="tab">派工单完成汇总</a></li>
        <li class=""><a href="#tab2" data-toggle="tab">派工单关闭汇总</a></li>
        <li ><a href="#tab3" data-toggle="tab">派工单评价汇总</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content clearfix">
        <div class="tab-pane active" id="tab1">
            <div class="lease-echarts intersect-echarts">
                <h4 class="engineering-title">项目派工单完成数量对比</h4>
                <!--各项目派工单完成数量对比-->
                <div class="finishNum" id="en-finish-num">

                </div>
                <div style="background: #f5f5f5; width: 100%; height: 10px"></div>
                <h4 class="engineering-title">项目派工单完成比率对比</h4>
                <!--项目派工单完成比率对比-->
                <div class="finishPer" id="en-finish-per">

                </div>
            </div>
        </div>
        <div class="tab-pane " id="tab2">
            <div class="lease-echarts charge-echarts">
                <h4 class="engineering-title">项目派工单关闭数量对比</h4>
                <!--项目派工单关闭数量对比-->
                <div class="closeNum" id="en-close-num">

                </div>
                <div style="background: #f5f5f5; width: 100%; height: 10px"></div>
                <h4 class="engineering-title">项目派工单关闭率对比</h4>
                <!--项目派工单关闭率对比-->
                <div class="closePer" id="en-close-per">

                </div>

            </div>

        </div>
        <div class="tab-pane" id="tab3">
            <div class="lease-echarts apartment-echarts">
                <h4 class="engineering-title">项目派工单评价数量对比</h4>
                <!--项目派工单关闭数量对比-->
                <div class="evaluateNum" id="en-evaluate-num">

                </div>
                <div style="background: #f5f5f5; width: 100%; height: 10px"></div>
                <h4 class="engineering-title">项目派工单总体评分</h4>
                <!--项目派工单关闭率对比-->
                <div class="evaluatePer" id="en-evaluate-per">

                </div>

            </div>
        </div>
    </div>
</div>
<!--表格-->
<div class="cont-base">
    <h4 class=" pull-left">项目日常任务汇总</h4>
<!--    <p class=" pull-right" style="margin-top: 10px">任务时间：--><?//=$sdate?><!--至--><?//=$edate?><!--</p>-->
    <table class="table engineering-table table-bordered text-center clearfix">
        <thead>
        <tr>
            <th class="text-center" rowspan="2">项目</th>
            <th class="text-center" rowspan="2">任务总量</th>
            <th class="text-center" colspan="2">完成情况</th>
            <th class="text-center" colspan="2">关闭情况</th>
            <th class="text-center" colspan="2">点评情况</th>
        </tr>
        <tr>
            <th class="text-center">完成数量</th>
            <th class="text-center">完成率</th>
            <th class="text-center">关闭数量</th>
            <th class="text-center">关闭率</th>
            <th class="text-center">已评价</th>
            <th class="text-center">总体评分</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($res as $k => $v): ?>
        <tr>
            <td><?=$v['housename']?></td>
            <td><?=$v['num']?></td>
            <td><?=$v['do']?></td>
            <?php if ($v['num'] == 0): ?>
                <td>0</td>
            <?php else: ?>
                <td><?=round($v['do']/$v['num']*100,2)?>%</td>
            <?php endif ?>
            <td><?=$v['close']?></td>
            <?php if ($v['do'] == 0): ?>
                <td>0</td>
            <?php else: ?>
                <td><?=round($v['close']/$v['do']*100,2)?>%</td>
            <?php endif ?>
            <td><?=$v['com']['com']?></td>
            <td><?=$v['com']['score']?$v['com']['score']:0?></td>
        </tr>
        <?php endforeach ?>
        <tr>
            <td>合并</td>
            <td><?=$data['num'] ?></td>
            <td><?=$data['do'] ?></td>
            <?php if ($data['num'] == 0): ?>
                <td>0</td>
            <?php else: ?>
                <td><?=round($data['do']/$data['num']*100) ?>%</td>
            <?php endif ?>
            <td><?=$data['close'] ?></td>
            <?php if ($data['do'] == 0): ?>
                <td>0</td>
            <?php else: ?>
                <td><?=round($data['close']/$data['do']*100) ?>%</td>
            <?php endif ?>
            <td><?=$data['com']['com'] ?></td>
            <td><?=$data['com']['score']?$data['com']['score']:0 ?></td>
        </tr>
        <tr>
            <td>市区维修组</td>
            <td><?=$w['num'] ?></td>
            <td><?=$w['do'] ?></td>
            <?php if ($w['num'] == 0): ?>
                <td>0</td>
            <?php else: ?>
                <td><?=round($w['do']/$w['num']*100) ?>%</td>
            <?php endif ?>
            <td><?=$w['close'] ?></td>
            <?php if ($w['do'] == 0): ?>
                <td>0</td>
            <?php else: ?>
                <td><?=round($w['close']/$w['do']*100) ?>%</td>
            <?php endif ?>
            <td><?=$w['com']['com'] ?></td>
            <td><?=$w['com']['score']?$w['com']['score']:0 ?></td>
        </tr>
        </tbody>
    </table>
</div>
<p style="margin-top: 15px">说明：市区维修组工单含在市区各项目工单总数内，为方便统计单独列出。</p>

<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-datetimepicker.js"></script>
<script src="/js/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="/js/echarts.min.js"></script>
<script src="/js/statistics.js"></script>
<script src="/js/com-charts.js"></script>
<script type="text/javascript">
    $(function () {
        // 柱状图---项目派工单完成数量对比：
        (function engineeringBar() {
            var barId = echarts.init(document.getElementById('en-finish-num'));
            var barTitle = '任务数量(单)';
            var barUnit = '单';
            var barColor =  ['#f8c663', '#56bbdf'];
            var tipData = ['任务总量','完成数'];
//            var xData = ['向阳广场一期','和谐大厦一期','学府广场一期','建正东方中心一期','正商国际广场一期','航海广场一期','蓝海广场一期','合并','市区维修组'];
            var xData = <?=json_encode($list['housename'])?>;
            var barData = [
                {
                    name:'任务总量',
                    type:'bar',
                    barCategoryGap: '50%',
                    itemStyle: {
                        normal: {
                            label: {
                                show: true,
                                position: 'top',
                                textStyle: {
                                    color: '#000000'
                                }
                            }
                        }
                    },
                    data:<?=json_encode($list['num'])?>,
                },
                {
                    name:'完成数',
                    type:'bar',
                    barCategoryGap: '50%',
                    itemStyle: {
                        normal: {
                            label: {
                                show: true,
                                position: 'top',
                                textStyle: {
                                    color: '#000000'
                                }
                            }
                        }
                    },
                    data:<?=json_encode($list['do'])?>,
                }
            ];
            Bar4(barId, barTitle, barUnit, barColor, tipData, xData, barData);
        })();

        // 柱状图---项目派工单完成比率对比：
        (function engineeringBar() {
            var barId = echarts.init(document.getElementById('en-finish-per'));
            var barTitle = '完成比率';
            var barUnit = '%';
            var barColor =  ['#5686df'];
            var tipData = ['完成率'];
            var xData = <?=json_encode($list['housename'])?>;
            var barData = [
                {
                    name:'完成率',
                    type:'bar',
                    barCategoryGap: '60%',
                    itemStyle: {
                        normal: {
                            label: {
                                show: true,
                                position: 'top',
                                formatter: '{c}%',
                                textStyle: {
                                    color: '#000000'
                                }
                            }
                        }
                    },
                    data:<?=json_encode($list['do_pro'])?>
                }
            ];
            Bar4(barId, barTitle, barUnit, barColor, tipData, xData, barData);
        })();

        // 柱状图---项目派工单关闭数量对比：
        (function engineeringBar() {
            var barId = echarts.init(document.getElementById('en-close-num'));
            var barTitle = '关闭数量(单)';
            var barUnit = '单';
            var barColor =  ['#56bbdf', '#f87863'];
            var tipData = ['完成数量','关闭数量'];
            var xData = <?=json_encode($list['housename'])?>;
            var barData = [
                {
                    name:'完成数量',
                    type:'bar',
                    barCategoryGap: '50%',
                    itemStyle: {
                        normal: {
                            label: {
                                show: true,
                                position: 'top',
                                textStyle: {
                                    color: '#000000'
                                }
                            }
                        }
                    },
                    data:<?=json_encode($list['do'])?>
                },
                {
                    name:'关闭数量',
                    type:'bar',
                    barCategoryGap: '50%',
                    itemStyle: {
                        normal: {
                            label: {
                                show: true,
                                position: 'top',
                                textStyle: {
                                    color: '#000000'
                                }
                            }
                        }
                    },
                    data:<?=json_encode($list['close'])?>
                }
            ];
            Bar4(barId, barTitle, barUnit, barColor, tipData, xData, barData);
        })();

        // 柱状图---项目派工单关闭率对比：
        (function engineeringBar() {
            var barId = echarts.init(document.getElementById('en-close-per'));
            var barTitle = '关闭率';
            var barUnit = '%';
            var barColor =  ['#63c9f8'];
            var tipData = ['关闭率'];
            var xData = <?=json_encode($list['housename'])?>;
            var barData = [
                {
                    name:'关闭率',
                    type:'bar',
                    barCategoryGap: '60%',
                    itemStyle: {
                        normal: {
                            label: {
                                show: true,
                                position: 'top',
                                formatter: '{c}%',
                                textStyle: {
                                    color: '#000000'
                                }
                            }
                        }
                    },
                    data:<?=json_encode($list['close_pro'])?>
                }
            ];
            Bar4(barId, barTitle, barUnit, barColor, tipData, xData, barData);
        })();

        // 柱状图---项目派工单评价数量对比：
        (function engineeringBar() {
            var barId = echarts.init(document.getElementById('en-evaluate-num'));
            var barTitle = '评价数量(单)';
            var barUnit = '单';
            var barColor =  ['#f87863', '#f670a9'];
            var tipData = ['关闭数量','评价数量'];
            var xData = <?=json_encode($list['housename'])?>;
            var barData = [
                {
                    name:'关闭数量',
                    type:'bar',
                    barCategoryGap: '50%',
                    itemStyle: {
                        normal: {
                            label: {
                                show: true,
                                position: 'top',
                                textStyle: {
                                    color: '#000000'
                                }
                            }
                        }
                    },
                    data:<?=json_encode($list['close'])?>
                },
                {
                    name:'评价数量',
                    type:'bar',
                    barCategoryGap: '50%',
                    itemStyle: {
                        normal: {
                            label: {
                                show: true,
                                position: 'top',
                                textStyle: {
                                    color: '#000000'
                                }
                            }
                        }
                    },
                    data:<?=json_encode($list['com'])?>
                }
            ];
            Bar4(barId, barTitle, barUnit, barColor, tipData, xData, barData);
        })();

        // 柱状图---项目派工单评价率对比：
        (function engineeringBar() {
            var barId = echarts.init(document.getElementById('en-evaluate-per'));
            var barTitle = '总体评分';
            var barUnit = '';
            var barColor =  ['#56dfb7'];
            var tipData = ['评分'];
            var xData = <?=json_encode($list['housename'])?>;
            var barData = [
                {
                    name:'评分',
                    type:'bar',
                    barCategoryGap: '60%',
                    itemStyle: {
                        normal: {
                            label: {
                                show: true,
                                position: 'top',
                                textStyle: {
                                    color: '#000000'
                                }
                            }
                        }
                    },
                    data:<?=json_encode($list['score'])?>
                }
            ];
            Bar4(barId, barTitle, barUnit, barColor, tipData, xData, barData);
        })();


    });

</script>