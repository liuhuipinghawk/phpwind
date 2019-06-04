<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '中奖纪录';
$this->params['breadcrumbs'][] = ['label' => '大转盘抽奖', 'url' => ['lottery/list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
	<h1><?=$this->title ?></h1>	
	<form class="form-inline" action="/admin/lottery/record-list">
        <input type="hidden" name="id" id="id" value="<?=$id ?>">
        <div class="form-group">
            <select class="form-control" id="house_id" name="house_id">
            	<option value="">项目</option>
            	<?php foreach ($house as $k => $v): ?>
            		<option value="<?=$v['id'] ?>" <?php if($house_id == $v['id']) echo 'selected';?>><?=$v['housename']?></option>
            	<?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" id="award" name="award">
            	<option value="">奖项</option>
            	<?php foreach ($award as $k => $v): ?>
            		<option value="<?=$k?>" <?php if($keyword == $k) echo 'selected';?>><?=$v?></option>
            	<?php endforeach ?>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" id="user_type" name="user_type">
            	<option value="">用户类型</option>
            	<option value="1" <?php if($user_type == 1) echo 'selected';?>>内部员工</option>
            	<option value="2" <?php if($user_type == 2) echo 'selected';?>>普通用户</option>
            </select>
        </div>
        <button type="submit" class="btn btn-default">查询</button>
    </form>
    <hr>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>   
				<th style="text-align: center;">编号</th>
				<th style="text-align: center;">项目</th>
				<th style="text-align: center;">手机号</th>
				<th style="text-align: center;">姓名</th>
				<th style="text-align: center;">用户类型</th>
				<th style="text-align: center;">所属公司</th>
				<th style="text-align: center;">奖品</th>
				<th style="text-align: center;">获奖时间</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $k => $v): ?>
			<tr>
				<td><?=$v['id'] ?></td>
				<td><?=$v['housename'] ?></td>
				<td><?=$v['Tell'] ?></td>
				<td><?=$v['TrueName'] ?></td>
				<td><?=$v['CateId'] == 1  ? '内部员工' : '普通用户' ?></td>
				<td><?=$v['Company'] ?></td>
				<td><?=$v['award_name'] ?></td>
				<td><?=date('Y-m-d H:i:s',$v['add_time']) ?></td>
			</tr>				
			<?php endforeach ?>
		</tbody>
	</table>
	<div class="pagination-part">
	    <nav>
		<?php
			echo LinkPager::widget([
			    'pagination' => $pagination,
			    'nextPageLabel' => '下一页',
			    'prevPageLabel' => '上一页',
			    'firstPageLabel' => '首页',
			    'lastPageLabel' => '尾页',
			]);
		?>
		</nav>
	</div>
</div>
