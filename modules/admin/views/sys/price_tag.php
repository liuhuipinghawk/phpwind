<?php
use yii\helpers\Html;

$this->title = '电费价格标签管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<div>
	<h1><?=$this->title ?></h1>
    <form class="form-inline" action="/admin/sys/price-tag">
        <a href="/admin/sys/set-price-tag" class="btn btn-success">添加</a>&nbsp;&nbsp;
        <?php 
        $house_id = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
        ?>
        <div class="form-group">
            <select class="form-control" id="house_id" name="house_id">
            	<option value="">=选择楼盘=</option>
            	<?php foreach ($house as $k => $v): ?>
            		<option value="<?=$v['id']?>" <?php if($v['id'] == $house_id) echo 'selected'; ?>><?=$v['housename']?></option>
            	<?php endforeach ?>
            </select>
        </div>
        <button type="submit" class="btn btn-default">查询</button>
    </form>
    <hr>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">楼盘</th>
				<th style="text-align: center;">标签1</th>
				<th style="text-align: center;">标签2</th>
				<th style="text-align: center;">标签3</th>
				<th style="text-align: center;">标签4</th>
				<th style="text-align: center;">标签5</th>
				<th style="text-align: center;">标签6</th>
				<th style="text-align: center;">更新时间</th>
				<th style="text-align: center;">操作人</th>
				<th style="text-align: center;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if($list):?>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td><?=$v['id']?></td>
					<td><?=$v['house_name'].'-'.$v['seat_name']?></td>
					<td><?=$v['tag'] ? explode(',', $v['tag'])[0] : '--'?></td>
					<td><?=$v['tag'] ? explode(',', $v['tag'])[1] : '--'?></td>
					<td><?=$v['tag'] ? explode(',', $v['tag'])[2] : '--'?></td>
					<td><?=$v['tag'] ? explode(',', $v['tag'])[3] : '--'?></td>
					<td><?=$v['tag'] ? explode(',', $v['tag'])[4] : '--'?></td>
					<td><?=$v['tag'] ? explode(',', $v['tag'])[5] : '--'?></td>
					<td><?=date('Y-m-d H:i:s',$v['edit_time'])?></td>
					<td><?=$v['adminuser']?></td>
					<td>
						<a href="/admin/sys/set-price-tag?id=<?=$v['id']?>">编辑</a>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php endif;?>
		</tbody>
	</table>
</div>

<script type="text/javascript">

</script>