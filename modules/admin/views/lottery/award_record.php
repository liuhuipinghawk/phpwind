<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '活动统计';
$this->params['breadcrumbs'][] = ['label' => '大转盘抽奖', 'url' => ['lottery/list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
	<h4>活动统计</h4>
	<p style="margin-left: 20px;">活动标题：<?=$lottery['title']?></p>
	<p style="margin-left: 20px;">添加时间：<?=date('Y-m-d H:i',$lottery['add_time'])?></p>
	<p style="margin-left: 20px;">活动时间：<?=date('Y-m-d H:i',$lottery['stime']).' 至 '.date('Y-m-d H:i',$lottery['etime'])?></p>
	<p style="margin-left: 20px;">活动状态：<?=$lottery['status'] ? ($lottery['stime'] > time() ? '未开始' : ($lottery['etime'] < time() ? '已结束' : '进行中')) : '禁用'?></p>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>   
				<th style="text-align: center;">项目</th>
				<th style="text-align: center;">参与人数</th>
				<th style="text-align: center;">抽奖次数</th>
				<th style="text-align: center;">获奖人数</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($count as $k => $v): ?>
			<tr>
				<td><?=$v['housename']?></td>
				<td><?=$v['total_user']?></td>
				<td><?=$v['total_nums']?></td>
				<td><?=$v['total_award']?></td>
			</tr>				
			<?php endforeach ?>
		</tbody>
	</table>
	<hr>
	<h4>奖项统计</h4>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>   
				<th style="text-align: center;">奖项</th>
				<th style="text-align: center;">初始数量</th>
				<th style="text-align: center;">剩余数量</th>
				<th style="text-align: center;">中奖数量</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $k => $v): ?>
			<tr>
				<td><?=$v['award_name']?></td>
				<td><?=$v['init_count']?></td>
				<td><?=$v['remain_count']?></td>
				<td><?=$v['award_count']?></td>
			</tr>				
			<?php endforeach ?>
			<tr>
				<td><b style="color:red;">程序内置谢谢参与</b></td>
				<td>--</td>
				<td>--</td>
				<td><?=$thanks?></td>
			</tr>
		</tbody>
	</table>
</div>