<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '房屋动态统计';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="/font/iconfont.css">
<link rel="stylesheet" href="/css/statistics.css">

<div class="select-cont">
    <h3 style="margin-bottom: 20px">信息筛选：</h3>
    
    <form action="/admin/count/house-count">
        <?php 
            $house_choose = empty(Yii::$app->request->get()['house_choose']) ? 'all' : Yii::$app->request->get()['house_choose'];
            $house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
            $time_tag = empty(Yii::$app->request->get()['time_tag']) ? 'first_half' : Yii::$app->request->get()['time_tag'];
            $sdate = empty(Yii::$app->request->get()['sdate']) ? date('Y-m-01') : Yii::$app->request->get()['sdate'];
            $edate = empty(Yii::$app->request->get()['edate']) ? date('Y-m-t') : Yii::$app->request->get()['edate'];
            $tab = empty(Yii::$app->request->get()['tab']) ? 1 : Yii::$app->request->get()['tab'];
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
        <input type="hidden" name="tab" id="tab" value="<?=$tab ? $tab : 1?>">
        <div class="select-list select-btn clearfix" style="padding-left: 0">
            <a href="javascript:void(0);" class="btn btn-default btn-warning btn-select" onclick="$('form').submit();">开始筛选</a>
            <a href="javascript:void(0);" class="btn btn-default btn-cancel">取消筛选</a>
        </div>
    </form>
</div>
<div class="cont-base dynamic-cont">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-tabs-total" id="myTabs">
        <li class="<?php if($tab == 1) echo ' active';?>" onclick="setValue(1)"><a href="#tab1" data-toggle="tab">交房汇总</a></li>
        <li class="<?php if($tab == 2) echo ' active';?>" onclick="setValue(2)"><a href="#tab2" data-toggle="tab">房屋动态汇总</a></li>
        <li class="<?php if($tab == 3) echo ' active';?>" onclick="setValue(3)"><a href="#tab3" data-toggle="tab">交付收费率汇总</a></li>
        <li class="<?php if($tab == 4) echo ' active';?>" onclick="setValue(4)"><a href="#tab4" data-toggle="tab">装修办理</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane <?php if($tab == 1) echo ' active';?>" id="tab1">
            <div class="lease-echarts intersect-echarts">
                <!--<h4>房屋动态收费率汇总:</h4>-->
                <ul class="clearfix">
                    <li><p class="text-muted ellipse">总户数(户）</p><p class="num"><?=$data1['total_nums'] ? $data1['total_nums'] : '--' ?></p></li>
                    <li><p class="text-muted ellipse">未售户数(户)</p><p class="num"><?=$data1['unsale_nums'] ? $data1['unsale_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">已售户数(户）</p><p class="num"><?=$data1['sale_nums'] ? $data1['sale_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">符合交房(户）</p><p class="num"><?=$data1['match_nums'] ? $data1['match_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">符合未交房(户）</p><p class="num"><?=$data1['unalready_nums'] ? $data1['unalready_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">已交房(户）</p><p class="num"><?=$data1['already_nums'] ? $data1['already_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">交房率</p><p class="num text-red"><?=$data1['jfl']?></p></li>
                    <li><p class="text-muted ellipse">应收金额(元)</p><p class="num"><?=$data1['total_money'] ? $data1['total_money'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">实收金额(元)</p><p class="num text-orange"><?=$data1['real_money'] ? $data1['real_money'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">收费率</p><p class="num text-red"><?=$data1['sfl']?></p></li>
                </ul>
                <div class="row dynamic-row clearfix">
                    <!--交房率-->
                    <div class="col-md-6 roomRate" id="roomRate"></div>
                    <!--收费率-->
                    <div class="col-md-6 rateCharge" id="rateCharge"></div>
                </div>
            </div>
            <div style="background: #f5f5f5; width: 100%; height: 10px"></div>
            <div class="data-table">
                <h4>房屋动态统计</h4>
                <table class="table table-striped table-bordered text-center">
                    <thead>
                    <tr>
                        <th class="text-center">项目</th>
                        <th class="text-center">总户数(户）</th>
                        <th class="text-center">未售户数(户)</th>
                        <th class="text-center">已售户数（户）</th>
                        <th class="text-center">符合交房（户）</th>
                        <th class="text-center">符合未交房（户）</th>
                        <th class="text-center">已交房（户）</th>
                        <th class="text-center">交房率</th>
                        <th class="text-center">应收金额（元）</th>
                        <th class="text-center">实收金额（元）</th>
                        <th class="text-center">收费率</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($list1): ?>
                        <?php foreach ($list1 as $k => $v): ?>
                        <tr>
                            <td><?=$v['housename'] ? $v['housename'] : '--'?></td>
                            <td><?=$v['total_nums'] ? $v['total_nums'] : '--'?></td>
                            <td><?=$v['unsale_nums'] ? $v['unsale_nums'] : '--'?></td>
                            <td><?=$v['sale_nums'] ? $v['sale_nums'] : '--'?></td>
                            <td><?=$v['match_nums'] ? $v['match_nums'] : '--'?></td>
                            <td><?=$v['unalready_nums'] ? $v['unalready_nums'] : '--'?></td>
                            <td><?=$v['already_nums'] ? $v['already_nums'] : '--'?></td>
                            <td><?=$v['already_nums'] ? ($v['match_nums'] > 0 ? round(bcdiv($v['already_nums'],$v['match_nums'],5)*100,2).'%' : '--') : '--'?></td>
                            <td><?=$v['total_money']?></td>
                            <td><?=$v['real_money']?></td>
                            <td><?=$v['real_money'] ? ($v['total_money'] > 0 ? round(bcdiv($v['real_money'],$v['total_money'],5)*100,2).'%' : '--') : '--'?></td>
                        </tr>    
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr><td colspan="11">暂无数据</td></tr>
                    <?php endif ?>
                    
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane <?php if($tab == 2) echo ' active';?>" id="tab2">
            <div class="dynamic-cont">
                <ul class="nav nav-tabs nav-tabs-dy">
                    <li class="active"><a href="#tab11" data-toggle="tab" class="tab11">公寓户数统计</a></li>
                    <li ><a href="#tab12" data-toggle="tab" class="tab12">商业户数统计</a></li>
                    <li ><a href="#tab13" data-toggle="tab" class="tab13">办公户数统计</a></li>
                    <li ><a href="#tab15" data-toggle="tab" class="tab15">地下车位数量统计</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab11">
                        <div class="lease-echarts dynamic-echarts">
                            <h4>公寓户数统计分析</h4>
                            <ul class="clearfix">
                            <?php if (!empty($data2[3])): ?>
                                <li><p class="text-muted ellipse">总户数(户）</p><p class="num text-orange"><?=$data2[3]['total_nums'] ? $data2[3]['total_nums'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">未售(户)</p><p class="num"><?=$data2[3]['unsale_nums'] ? $data2[3]['unsale_nums'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">不符合交付(户）</p><p class="num"><?=$data2[3]['unmatch_nums'] ? $data2[3]['unmatch_nums'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">已交付(户）</p><p class="num"><?=$data2[3]['already_nums'] ? $data2[3]['already_nums'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">符合未交付(户）</p><p class="num"><?=$data2[3]['unalready_nums'] ? $data2[3]['unalready_nums'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">交付率</p><p class="num text-red"><?=$data2[3]['jfl'] ? $data2[3]['jfl'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">出租居住(户)</p><p class="num"><?=$data2[3]['rent_live'] ? $data2[3]['rent_live'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">出租办公(户)</p><p class="num"><?=$data2[3]['rent_office'] ? $data2[3]['rent_office'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">酒店(户)</p><p class="num"><?=$data2[3]['hotel'] ? $data2[3]['hotel'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">员工宿舍(户)</p><p class="num"><?=$data2[3]['dormitory'] ? $data2[3]['dormitory'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">自用办公(户)</p><p class="num"><?=$data2[3]['self_office'] ? $data2[3]['self_office'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">自用居住(户)</p><p class="num"><?=$data2[3]['self_live'] ? $data2[3]['self_live'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">空置(户)</p><p class="num"><?=$data2[3]['vacant'] ? $data2[3]['vacant'] : '--'?></p></li>
                            <?php else: ?>
                                <li><p class="text-muted ellipse">总户数(户）</p><p class="num text-orange">--</p></li>
                                <li><p class="text-muted ellipse">未售(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">不符合交付(户）</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">已交付(户）</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">符合未交付(户）</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">交付率</p><p class="num text-red">--</p></li>
                                <li><p class="text-muted ellipse">出租居住(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">出租办公(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">酒店(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">员工宿舍(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">自用办公(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">自用居住(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">空置(户)</p><p class="num">--</p></li>
                            <?php endif ?>
                            </ul>
                            <div class="row clearfix dynamic-row">
                                <!--交付饼状图-->
                                <div class="col-md-6 apartBar1" id="apartBar1"></div>
                                <!--据用饼状图-->
                                <div class="col-md-6 apartBar2" id="apartBar2"></div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane" id="tab12">
                        <div class="lease-echarts dynamic-echarts">
                            <h4>商业户数统计分析</h4>
                            <ul class="clearfix">
                            <?php if (!empty($data2[2])): ?>
                                <li><p class="text-muted ellipse">总户数(户）</p><p class="num text-orange"><?=$data2[2]['total_nums'] ? $data2[2]['total_nums'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">未售(户)</p><p class="num"><?=$data2[2]['unsale_nums'] ? $data2[2]['unsale_nums'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">不符合交付(户）</p><p class="num"><?=$data2[2]['unmatch_nums'] ? $data2[2]['unmatch_nums'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">已交付(户）</p><p class="num"><?=$data2[2]['already_nums'] ? $data2[2]['already_nums'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">符合未交付(户）</p><p class="num"><?=$data2[2]['unalready_nums'] ? $data2[2]['unalready_nums'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">交付率</p><p class="num text-red"><?=$data2[2]['jfl'] ? $data2[2]['jfl'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">出租居住(户)</p><p class="num"><?=$data2[2]['rent_live'] ? $data2[2]['rent_live'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">出租办公(户)</p><p class="num"><?=$data2[2]['rent_office'] ? $data2[2]['rent_office'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">酒店(户)</p><p class="num"><?=$data2[2]['hotel'] ? $data2[2]['hotel'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">员工宿舍(户)</p><p class="num"><?=$data2[2]['dormitory'] ? $data2[2]['dormitory'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">自用办公(户)</p><p class="num"><?=$data2[2]['self_office'] ? $data2[2]['self_office'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">自用居住(户)</p><p class="num"><?=$data2[2]['self_live'] ? $data2[2]['self_live'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">空置(户)</p><p class="num"><?=$data2[2]['vacant'] ? $data2[2]['vacant'] : '--'?></p></li>
                            <?php else: ?>
                                <li><p class="text-muted ellipse">总户数(户）</p><p class="num text-orange">--</p></li>
                                <li><p class="text-muted ellipse">未售(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">不符合交付(户）</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">已交付(户）</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">符合未交付(户）</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">交付率</p><p class="num text-red">--</p></li>
                                <li><p class="text-muted ellipse">出租居住(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">出租办公(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">酒店(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">员工宿舍(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">自用办公(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">自用居住(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">空置(户)</p><p class="num">--</p></li>
                            <?php endif ?>
                            </ul>
                            <div class="row clearfix dynamic-row">
                                <!--交付饼状图-->
                                <div class="col-md-6 businessBar1" id="businessBar1"></div>
                                <!--据用饼状图-->
                                <div class="col-md-6 businessBar2" id="businessBar2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab13">
                        <div class="lease-echarts dynamic-echarts">
                            <h4>办公户数统计分析</h4>
                            <ul class="clearfix">
                            <?php if (!empty($data2[1])): ?>
                                <li><p class="text-muted ellipse">总户数(户）</p><p class="num text-orange"><?=$data2[1]['total_nums'] ? $data2[1]['total_nums'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">未售(户)</p><p class="num"><?=$data2[1]['unsale_nums'] ? $data2[1]['unsale_nums'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">不符合交付(户）</p><p class="num"><?=$data2[1]['unmatch_nums'] ? $data2[1]['unmatch_nums'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">已交付(户）</p><p class="num"><?=$data2[1]['already_nums'] ? $data2[1]['already_nums'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">符合未交付(户）</p><p class="num"><?=$data2[1]['unalready_nums'] ? $data2[1]['unalready_nums'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">交付率</p><p class="num text-red"><?=$data2[1]['jfl'] ? $data2[1]['jfl'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">出租居住(户)</p><p class="num"><?=$data2[1]['rent_live'] ? $data2[1]['rent_live'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">出租办公(户)</p><p class="num"><?=$data2[1]['rent_office'] ? $data2[1]['rent_office'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">酒店(户)</p><p class="num"><?=$data2[1]['hotel'] ? $data2[1]['hotel'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">员工宿舍(户)</p><p class="num"><?=$data2[1]['dormitory'] ? $data2[1]['dormitory'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">自用办公(户)</p><p class="num"><?=$data2[1]['self_office'] ? $data2[1]['self_office'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">自用居住(户)</p><p class="num"><?=$data2[1]['self_live'] ? $data2[1]['self_live'] : '--'?></p></li>
                                <li><p class="text-muted ellipse">空置(户)</p><p class="num"><?=$data2[1]['vacant'] ? $data2[1]['vacant'] : '--'?></p></li>
                            <?php else: ?>
                                <li><p class="text-muted ellipse">总户数(户）</p><p class="num text-orange">--</p></li>
                                <li><p class="text-muted ellipse">未售(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">不符合交付(户）</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">已交付(户）</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">符合未交付(户）</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">交付率</p><p class="num text-red">--</p></li>
                                <li><p class="text-muted ellipse">出租居住(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">出租办公(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">酒店(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">员工宿舍(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">自用办公(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">自用居住(户)</p><p class="num">--</p></li>
                                <li><p class="text-muted ellipse">空置(户)</p><p class="num">--</p></li>
                            <?php endif ?>
                            </ul>
                            <div class="row clearfix dynamic-row">
                                <!--交付饼状图-->
                                <div class="col-md-6 officeBar1" id="officeBar1"></div>
                                <!--据用饼状图-->
                                <div class="col-md-6 officeBar2" id="officeBar2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane " id="tab15">
                        <h4>地下车位统计分析</h4>
                        <!--总项目-->
                        <table class="table table-striped table-bordered text-center tab-total">
                            <thead>
                            <tr>
                                <th class="text-center" rowspan="2">项目名称</th>
                                <th class="text-center" rowspan="2">金额/数量</th>
                                <th class="text-center" colspan="3">已售车位</th>
                                <th class="text-center" rowspan="2">未售车位</th>
                                <th class="text-center" rowspan="2">出租车位</th>
                                <th class="text-center" rowspan="2">合计</th>
                            </tr>
                            <tr>
                                <th class="text-center">标准车位</th>
                                <th class="text-center">加长加宽车位</th>
                                <th class="text-center">子母车位</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td rowspan="2" style="vertical-align: middle">国际广场</td>
                                <td>均价金额</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>数量</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td rowspan="2" style="vertical-align: middle">航海广场</td>
                                <td>均价金额</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>数量</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                        <!--分项目-->
                        <table class="table table-striped table-bordered text-center tab-every active-show">
                            <thead>
                            <tr>
                                <th class="text-center" rowspan="2">金额/数量</th>
                                <th class="text-center" colspan="3">已售车位</th>
                                <th class="text-center" rowspan="2">未售车位</th>
                                <th class="text-center" rowspan="2">出租车位</th>
                                <th class="text-center" rowspan="2">合计</th>
                            </tr>
                            <tr>
                                <th class="text-center">标准车位</th>
                                <th class="text-center">加长加宽车位</th>
                                <th class="text-center">子母车位</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>均价金额</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>---</td>
                            </tr>
                            <tr>
                                <td>数量</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="house-data-table-bg" style="background: #f5f5f5; width: 100%; height: 10px"></div>
            <div class="data-table house-data-table">
                <h4>房屋动态统计</h4>
                <table class="table table-striped table-bordered text-center dynamic-apart-table">
                    <thead>
                    <tr>
                        <th class="text-center" rowspan="2">区域名称</th>
                        <th class="text-center" rowspan="2">合计(户)</th>
                        <th class="text-center" rowspan="2">未售(户)</th>
                        <th class="text-center" rowspan="2">不符合交付(户)</th>
                        <th class="text-center" colspan="2">符合交付</th>
                        <th class="text-center" rowspan="2">交付率</th>
                        <th class="text-center" rowspan="2">出租居住(户)</th>
                        <th class="text-center" rowspan="2">出租办公(户)</th>
                        <th class="text-center" rowspan="2">酒店(户)</th>
                        <th class="text-center" rowspan="2">员工宿舍(户)</th>
                        <th class="text-center" rowspan="2">自用办公(户)</th>
                        <th class="text-center" rowspan="2">自用居住(户)</th>
                        <th class="text-center" rowspan="2">空置(户)</th>
                    </tr>
                    <tr>
                        <th class="text-center">已交付(户)</th>
                        <th class="text-center">符合未交付(户)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($data2): ?>
                        <?php foreach ($data2 as $k => $v): ?>
                        <tr>
                            <td><?=$k == 1 ? '办公总户数' : ($k == 2 ? '商业总户数' : '公寓总户数')?></td>
                            <td><?=$v ? $v['total_nums'] : '--' ?></td>
                            <td><?=$v ? $v['unsale_nums'] : '--' ?></td>
                            <td><?=$v ? $v['unmatch_nums'] : '--' ?></td>
                            <td><?=$v ? $v['already_nums'] : '--' ?></td>
                            <td><?=$v ? $v['unalready_nums'] : '--' ?></td>
                            <td><?=!empty($v['jfl']) ? $v['jfl'] : '--' ?></td>
                            <td><?=$v ? $v['rent_live'] : '--' ?></td>
                            <td><?=$v ? $v['rent_office'] : '--' ?></td>
                            <td><?=$v ? $v['hotel'] : '--' ?></td>
                            <td><?=$v ? $v['dormitory'] : '--' ?></td>
                            <td><?=$v ? $v['self_office'] : '--' ?></td>
                            <td><?=$v ? $v['self_live'] : '--' ?></td>
                            <td><?=$v ? $v['vacant'] : '--' ?></td>
                        </tr>    
                        <?php endforeach ?>
                    <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane <?php if($tab == 3) echo ' active';?>" id="tab3">
            <div class="lease-echarts charge-echarts">
                <h4>房屋动态收费率汇总</h4>
                <ul class="clearfix">
                    <li><p class="text-muted ellipse">应收金额(元）</p><p class="num"><?=$data3_house['total_money'] ? $data3_house['total_money'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">已收金额(元)</p><p class="num text-orange"><?=$data3_house['get_money'] ? $data3_house['get_money'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">当前收取金额(元）</p><p class="num"><?=$data3_house['current_money'] ? $data3_house['current_money'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">未收金额(元）</p><p class="num"><?=$data3_house['unget_money'] ? $data3_house['unget_money'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">金额收费率</p><p class="num text-red"><?=$data3_house['get_money'] ? round(($data3_house['get_money']/$data3_house['total_money'])*100,2).'%' : '--'?></p></li>
                    <li><p class="text-muted ellipse">应收户数(户）</p><p class="num"><?=$data3_house['total_nums'] ? $data3_house['total_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">已收户数(户)</p><p class="num"><?=$data3_house['get_nums'] ? $data3_house['get_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">当前收取户数(户)</p><p class="num"><?=$data3_house['current_nums'] ? $data3_house['current_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">未收户数(户)</p><p class="num"><?=$data3_house['unget_nums'] ? $data3_house['unget_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">户数收费率</p><p class="num text-red"><?=$data3_house['get_nums'] ? round(($data3_house['get_nums']/$data3_house['total_nums'])*100,2).'%' : '--'?></p></li>
                </ul>
                <div class="chargeAll" id="chargeAll"></div>
            </div>

            <div style="background: #f5f5f5; width: 100%; height: 10px"></div>
            <div class="lease-echarts charge-echarts" style="margin-top: 35px">
                <h4>车位收费率汇总</h4>
                <ul class="clearfix">
                    <li><p class="text-muted ellipse">应收金额(元）</p><p class="num"><?=$data3_parking['total_money'] ? $data3_parking['total_money'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">已收金额(元)</p><p class="num text-orange"><?=$data3_parking['get_money'] ? $data3_parking['get_money'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">当前收取金额(元）</p><p class="num"><?=$data3_parking['current_money'] ? $data3_parking['current_money'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">未收金额(元）</p><p class="num"><?=$data3_parking['unget_money'] ? $data3_parking['unget_money'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">金额收费率</p><p class="num text-red"><?=$data3_parking['get_money'] ? round(($data3_parking['get_money']/$data3_parking['total_money'])*100,2).'%' : '--'?></p></li>
                    <li><p class="text-muted ellipse">应收户数(户）</p><p class="num"><?=$data3_parking['total_nums'] ? $data3_parking['total_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">已收户数(户)</p><p class="num"><?=$data3_parking['get_nums'] ? $data3_parking['get_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">当前收取户数(户)</p><p class="num"><?=$data3_parking['current_nums'] ? $data3_parking['current_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">未收户数(户)</p><p class="num"><?=$data3_parking['unget_nums'] ? $data3_parking['unget_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">户数收费率</p><p class="num text-red"><?=$data3_parking['get_nums'] ? round(($data3_parking['get_nums']/$data3_parking['total_nums'])*100,2).'%' : '--'?></p></li>
                </ul>
                <div class="chargeAll" id="carChargeAll"></div>
            </div>
            <div style="background: #f5f5f5; width: 100%; height: 10px"></div>
            <div class="data-table">
                <h4>房屋动态统计</h4>
                <table class="table table-striped table-bordered text-center">
                    <thead>
                    <tr>
                        <th class="text-center">区域名称</th>
                        <th class="text-center">应收金额(元)</th>
                        <th class="text-center">已收金额(元)</th>
                        <th class="text-center">当前收取金额(元)</th>
                        <th class="text-center">未收金额(元)</th>
                        <th class="text-center">金额收费率</th>
                        <th class="text-center">应收户数(户)</th>
                        <th class="text-center">已收户数(户)</th>
                        <th class="text-center">当前收取户数(户)</th>
                        <th class="text-center">未收户数(户)</th>
                        <th class="text-center">实际收费率</th>
                        <th class="text-center">备注</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($list3_house): ?>
                        <?php foreach ($list3_house as $k => $v): ?>
                        <tr>
                            <td><?=$v['housename'] ? $v['housename'] : '--'?></td>
                            <td><?=$v['total_money'] ? $v['total_money'] : '--'?></td>
                            <td><?=$v['get_money'] ? $v['get_money'] : '--'?></td>
                            <td><?=$v['current_money'] ? $v['current_money'] : '--'?></td>
                            <td><?=$v['unget_money'] ? $v['unget_money'] : '--'?></td>
                            <td><?=$v['get_money'] ? round(($v['get_money']/$v['total_money'])*100,2).'%' : '--'?></td>
                            <td><?=$v['total_nums'] ? $v['total_nums'] : '--'?></td>
                            <td><?=$v['get_nums'] ? $v['get_nums'] : '--'?></td>
                            <td><?=$v['current_nums'] ? $v['current_nums'] : '--'?></td>
                            <td><?=$v['unget_nums'] ? $v['unget_nums'] : '--'?></td>
                            <td><?=$v['get_nums'] ? round(($v['get_nums']/$v['total_nums'])*100,2).'%' : '--'?></td>
                            <td></td>
                        </tr>    
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="12">暂无数据</td>
                        </tr>
                    <?php endif ?>
                    <?php if ($list3_total): ?>
                        <tr>
                            <td>总计</td>
                            <td><?=$list3_total['total_money'] ? $list3_total['total_money'] : '--'?></td>
                            <td><?=$list3_total['get_money'] ? $list3_total['get_money'] : '--'?></td>
                            <td><?=$list3_total['current_money'] ? $list3_total['current_money'] : '--'?></td>
                            <td><?=$list3_total['unget_money'] ? $list3_total['unget_money'] : '--'?></td>
                            <td><?=$list3_total['get_money'] ? round(($list3_total['get_money']/$list3_total['total_money'])*100,2).'%' : '--'?></td>
                            <td><?=$list3_total['total_nums'] ? $list3_total['total_nums'] : '--'?></td>
                            <td><?=$list3_total['get_nums'] ? $list3_total['get_nums'] : '--'?></td>
                            <td><?=$list3_total['current_nums'] ? $list3_total['current_nums'] : '--'?></td>
                            <td><?=$list3_total['unget_nums'] ? $list3_total['unget_nums'] : '--'?></td>
                            <td><?=$list3_total['get_nums'] ? round(($list3_total['get_nums']/$list3_total['total_nums'])*100,2).'%' : '--'?></td>
                            <td></td>
                        </tr>
                    <?php endif ?>
                    <?php if ($list3_parking): ?>
                        <tr>
                            <td>车位</td>
                            <td><?=$list3_parking['total_money'] ? $list3_parking['total_money'] : '--'?></td>
                            <td><?=$list3_parking['get_money'] ? $list3_parking['get_money'] : '--'?></td>
                            <td><?=$list3_parking['current_money'] ? $list3_parking['current_money'] : '--'?></td>
                            <td><?=$list3_parking['unget_money'] ? $list3_parking['unget_money'] : '--'?></td>
                            <td><?=$list3_parking['get_money'] ? round(($list3_parking['get_money']/$list3_parking['total_money'])*100,2).'%' : '--'?></td>
                            <td><?=$list3_parking['total_nums'] ? $list3_parking['total_nums'] : '--'?></td>
                            <td><?=$list3_parking['get_nums'] ? $list3_parking['get_nums'] : '--'?></td>
                            <td><?=$list3_parking['current_nums'] ? $list3_parking['current_nums'] : '--'?></td>
                            <td><?=$list3_parking['unget_nums'] ? $list3_parking['unget_nums'] : '--'?></td>
                            <td><?=$list3_parking['get_nums'] ? round(($list3_parking['get_nums']/$list3_parking['total_nums'])*100,2).'%' : '--'?></td>
                            <td></td>
                        </tr>
                    <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane <?php if($tab == 4) echo ' active';?>" id="tab4">
            <div class="lease-echarts apartment-echarts">
                <!--<h4>项目数据汇总:</h4>-->
                <ul class="clearfix">
                    <li><p class="text-muted ellipse">已办理装修户数(户）</p><p class="num"><?=$data4['renovation_nums'] ? $data4['renovation_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">已验收户数(户)</p><p class="num"><?=$data4['check_nums'] ? $data4['check_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">已退保证金户数(户）</p><p class="num"><?=$data4['return_nums'] ? $data4['return_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">正在装修户数(户）</p><p class="num"><?=$data4['nowing_nums'] ? $data4['nowing_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">今日申请装修户数(户）</p><p class="num"><?=$data4['current_nums'] ? $data4['current_nums'] : '--'?></p></li>
                    <li><p class="text-muted ellipse">装修率</p><p class="num text-red"><?=$data4['zxl'] ? $data4['zxl'] : '--'?></p></li>
                </ul>
                <div class="clearfix">
                    <div class="Renovation" id="Renovation"></div>
                </div>

            </div>
            <div style="background: #f5f5f5; width: 100%; height: 10px"></div>
            <div class="data-table">
                <h4>房屋动态统计</h4>
                <table class="table table-striped table-bordered text-center">
                    <thead>
                    <tr>
                        <th class="text-center">区域名称</th>
                        <th class="text-center">已办理装修户数(户）</th>
                        <th class="text-center">已验收户数(户)</th>
                        <th class="text-center">已退保证金户数（户）</th>
                        <th class="text-center">正在装修户数（户）</th>
                        <th class="text-center">当前申请装修户数（户）</th>
                        <th class="text-center">装修率</th>
                        <th class="text-center">备注</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    <?php if ($list4): ?>
                        <?php foreach ($list4 as $k => $v): ?>
                        <tr>
                            <td><?=$v['housename'] ? $v['housename'] : '--'?></td>
                            <td><?=$v['renovation_nums'] ? $v['renovation_nums'] : 0?></td>
                            <td><?=$v['check_nums'] ? $v['check_nums'] : 0?></td>
                            <td><?=$v['return_nums'] ? $v['return_nums'] : 0?></td>
                            <td><?=$v['nowing_nums'] ? $v['nowing_nums'] : 0?></td>
                            <td><?=$v['current_nums'] ? $v['current_nums'] : 0?></td>
                            <td><?=$v['zxl'] ? $v['zxl'] : 0?></td>
                            <td>--</td>
                        </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">暂无数据</td>
                        </tr>
                    <?php endif ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="/js/jquery-2.1.4.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-datetimepicker.js"></script>
<script src="/js/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="/js/echarts.min.js"></script>
<script src="/js/statistics.js"></script>
<script src="/js/com-charts.js"></script>
<script>
    $(function () {
        // 交房汇总--交房率
        (function rateBar() {
            var myChartBarRate = echarts.init(document.getElementById('roomRate'));
            var rateData = [
                {value:<?=$data1['unalready_nums'] ? $data1['unalready_nums'] : 0?>, name:'符合未交房'},
                {value:<?=$data1['already_nums'] ? $data1['already_nums'] : 0?>, name:'已交房'}
            ];
            var rateTitle = '交房率';
            var rateColor =  ['#56bbdf', '#f8c663'];
            Bar(myChartBarRate, rateData, rateTitle, rateColor);
        })();
        // 交房汇总-- 收费率
        (function chargeBar() {
            var myChartBarCharge = echarts.init(document.getElementById('rateCharge'));
            var chargeData = [
                {value:<?=$data1['total_money'] ? bcsub($data1['total_money'],$data1['real_money'],2) : 0?>, name:'实际未收取金额'},
                {value:<?=$data1['real_money'] ? $data1['real_money'] : 0?>, name:'实际收取金额'}
            ];
            var chargeTitle = '收费率';
            var chargeColor =  ['#24d7ba', '#f8758a'];
            Bar(myChartBarCharge, chargeData, chargeTitle, chargeColor);
        })();
        // 房屋动态汇总--公寓交房率
        (function leaseBar() {
            var barId = echarts.init(document.getElementById('apartBar1'));
            var barTitle = '交付率';
            var barName = '统计详情';
            var barColor =  ['#f8758a', '#f8c663', '#56bbdf','#65e0ad'];
            var tipData = ['已交付','未售','不符合交付','符合未交付'];
            var barUnit = '户';
            var barData = [
                {value:<?=$data2[3] ? $data2[3]['already_nums'] : 0?>, name:'已交付'},
                {value:<?=$data2[3] ? $data2[3]['unsale_nums'] : 0?>, name:'未售'},
                {value:<?=$data2[3] ? $data2[3]['unmatch_nums'] : 0?>, name:'不符合交付'},
                {value:<?=$data2[3] ? $data2[3]['unalready_nums'] : 0?>, name:'符合未交付'}
            ];
            Bar3(barId, barTitle, barName, barColor,tipData, barData, barUnit);
        })();
        // 房屋动态汇总--公寓使用率
        (function leaseBar() {
            var barId = echarts.init(document.getElementById('apartBar2'));
            var barTitle = '使用率';
            var barName = '统计详情';
            var barColor =  ['#ff6361', '#3cd557', '#37a9de','#e9d636', '#fd8952', '#8976fa','#5d6982'];
            var tipData = ['出租居住','出租办公','酒店','员工宿舍','自用办公','自用居住','空置'];
            var barUnit = '户';
            var barData = [
                {value:<?=$data2[3] ? $data2[3]['rent_live'] : 0?>, name:'出租居住'},
                {value:<?=$data2[3] ? $data2[3]['rent_office'] : 0?>, name:'出租办公'},
                {value:<?=$data2[3] ? $data2[3]['hotel'] : 0?>, name:'酒店'},
                {value:<?=$data2[3] ? $data2[3]['dormitory'] : 0?>, name:'员工宿舍'},
                {value:<?=$data2[3] ? $data2[3]['self_office'] : 0?>, name:'自用办公'},
                {value:<?=$data2[3] ? $data2[3]['self_live'] : 0?>, name:'自用居住'},
                {value:<?=$data2[3] ? $data2[3]['vacant'] : 0?>, name:'空置'}
            ];
            Bar3(barId, barTitle, barName, barColor,tipData, barData, barUnit);
        })();
        // 房屋动态汇总--商业交房率
        (function leaseBar() {
            var barId = echarts.init(document.getElementById('businessBar1'));
            var barTitle = '交付率';
            var barName = '统计详情';
            var barColor =  ['#f8758a', '#f8c663', '#56bbdf','#65e0ad'];
            var tipData = ['已交付','未售','不符合交付','符合未交付'];
            var barUnit = '户';
            var barData = [
                {value:<?=$data2[2] ? $data2[2]['already_nums'] : 0?>, name:'已交付'},
                {value:<?=$data2[2] ? $data2[2]['unsale_nums'] : 0?>, name:'未售'},
                {value:<?=$data2[2] ? $data2[2]['unmatch_nums'] : 0?>, name:'不符合交付'},
                {value:<?=$data2[2] ? $data2[2]['unalready_nums'] : 0?>, name:'符合未交付'}
            ];
            Bar3(barId, barTitle, barName, barColor,tipData, barData, barUnit);
        })();
        // 房屋动态汇总--商业使用率
        (function leaseBar() {
            var barId = echarts.init(document.getElementById('businessBar2'));
            var barTitle = '使用率';
            var barName = '统计详情';
            var barColor =  ['#ff6361', '#3cd557', '#37a9de','#e9d636', '#fd8952', '#8976fa','#5d6982'];
            var tipData = ['出租居住','出租办公','酒店','员工宿舍','自用办公','自用居住','空置'];
            var barUnit = '户';
            var barData = [
                {value:<?=$data2[2] ? $data2[2]['rent_live'] : 0?>, name:'出租居住'},
                {value:<?=$data2[2] ? $data2[2]['rent_office'] : 0?>, name:'出租办公'},
                {value:<?=$data2[2] ? $data2[2]['hotel'] : 0?>, name:'酒店'},
                {value:<?=$data2[2] ? $data2[2]['dormitory'] : 0?>, name:'员工宿舍'},
                {value:<?=$data2[2] ? $data2[2]['self_office'] : 0?>, name:'自用办公'},
                {value:<?=$data2[2] ? $data2[2]['self_live'] : 0?>, name:'自用居住'},
                {value:<?=$data2[2] ? $data2[2]['vacant'] : 0?>, name:'空置'}
            ];
            Bar3(barId, barTitle, barName, barColor,tipData, barData, barUnit);
        })();
        // 房屋动态汇总--办公交房率
        (function leaseBar() {
            var barId = echarts.init(document.getElementById('officeBar1'));
            var barTitle = '交付率';
            var barName = '统计详情';
            var barColor =  ['#f8758a', '#f8c663', '#56bbdf','#65e0ad'];
            var tipData = ['已交付','未售','不符合交付','符合未交付'];
            var barUnit = '户';
            var barData = [
                {value:<?=$data2[1] ? $data2[1]['already_nums'] : 0?>, name:'已交付'},
                {value:<?=$data2[1] ? $data2[1]['unsale_nums'] : 0?>, name:'未售'},
                {value:<?=$data2[1] ? $data2[1]['unmatch_nums'] : 0?>, name:'不符合交付'},
                {value:<?=$data2[1] ? $data2[1]['unalready_nums'] : 0?>, name:'符合未交付'}
            ];
            Bar3(barId, barTitle, barName, barColor,tipData, barData, barUnit);
        })();
        // 房屋动态汇总--办公使用率
        (function leaseBar() {
            var barId = echarts.init(document.getElementById('officeBar2'));
            var barTitle = '使用率';
            var barName = '统计详情';
            var barColor =  ['#ff6361', '#3cd557', '#37a9de','#e9d636', '#fd8952', '#8976fa','#5d6982'];
            var tipData = ['出租居住','出租办公','酒店','员工宿舍','自用办公','自用居住','空置'];
            var barUnit = '户';
            var barData = [
                {value:<?=$data2[1] ? $data2[1]['rent_live'] : 0?>, name:'出租居住'},
                {value:<?=$data2[1] ? $data2[1]['rent_office'] : 0?>, name:'出租办公'},
                {value:<?=$data2[1] ? $data2[1]['hotel'] : 0?>, name:'酒店'},
                {value:<?=$data2[1] ? $data2[1]['dormitory'] : 0?>, name:'员工宿舍'},
                {value:<?=$data2[1] ? $data2[1]['self_office'] : 0?>, name:'自用办公'},
                {value:<?=$data2[1] ? $data2[1]['self_live'] : 0?>, name:'自用居住'},
                {value:<?=$data2[1] ? $data2[1]['vacant'] : 0?>, name:'空置'}
            ];
            Bar3(barId, barTitle, barName, barColor,tipData, barData, barUnit);
        })();
        // 交付收费率汇总---- 房屋动态收费率汇总
        (function chargeLine() {
            var lineId = echarts.init(document.getElementById('chargeAll'));
            var lineTitle = '金额';
            var lineUnit = '万';
            var lineColor =  ['#7cbded'];
            var lineData = [
                {
                    name: '已收金额',
                    type:'line',
                    data: <?=json_encode($data3_chart['house'])?>
                }
            ];
            var xData = <?=json_encode($data3_chart['x'])?>;
            Line(lineId, lineTitle, lineData, lineUnit, lineColor, xData);
        })();
        // 交付收费率汇总---车位收费率汇总
        (function carChargeLine() {
            var lineId = echarts.init(document.getElementById('carChargeAll'));
            var lineTitle = '金额';
            var lineUnit = '万';
            var lineColor =  ['#7cbded'];
            var lineData = [
                {
                    name: '已收金额',
                    type:'line',
                    data: <?=json_encode($data3_chart['parking'])?>
                }
            ];
            var xData = <?=json_encode($data3_chart['x'])?>;
            Line(lineId, lineTitle, lineData, lineUnit, lineColor, xData);
        })();
        // 装修统计
        (function RenovationBar() {
            var barId = echarts.init(document.getElementById('Renovation'));
            var barTitle = '';
            var barName = '统计详情';
            var barColor =  ['#f8c663', '#56bbdf'];
            var tipData = ['已装修户数','未装修户数'];
            var barUnit = '户';
            var barData = [
                {value:<?=$data4['check_nums'] ? $data4['check_nums'] : 0?>, name:'已装修户数'},
                {value:<?=$data4['wzx'] ? $data4['wzx'] : 0?>, name:'未装修户数'}
            ];
            Bar3(barId, barTitle, barName, barColor,tipData, barData, barUnit);
        })();

    });

    function setValue(val)
    {
        $('#tab').val(val);
    }
</script>
