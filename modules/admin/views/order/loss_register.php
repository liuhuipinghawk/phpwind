<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '遗失登记列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<div style="width:80%; margin-left: 20px; display: block; float: left;">
	<h1><?=$this->title ?></h1>
    <form class="form-inline" action="">
        <?php
        $TrueName = empty(Yii::$app->request->get()['TrueName']) ? '' : Yii::$app->request->get()['TrueName'];
        $Tell = empty(Yii::$app->request->get()['Tell']) ? '' : Yii::$app->request->get()['Tell'];
		$house_id = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
        ?>
        <div class="form-group">
            <input type="text" class="form-control" id="TrueName" name="TrueName" placeholder="登记人" value="<?=$TrueName?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="Tell" name="Tell" placeholder="联系方式" value="<?=$Tell?>">
        </div>
		<select class="form-control" id="house_id" name="house_id">
			<?php if($house):?>
				<option value ="">请选择项目</option>
			<?php foreach($house as $k => $v): ?>
				<option value ="<?=$v['id'] ?>" <?php if($v['id'] == $house_id) echo 'selected';?>><?=$v['housename'] ?></option>
			<?php endforeach; ?>
			<?php endif;?>
		</select>
        <button type="submit" class="btn btn-default">查询</button>
        <a href="javascript:void(0);" class="btn btn-default" onclick="location.reload();">刷新</a>
    </form>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>
				<th style="text-align: center;">登记ID</th>
				<th style="text-align: center;">内容描述</th>
				<th style="text-align: center;">登记时间</th>
				<th style="text-align: center;">登记人</th>
				<th style="text-align: center;">登记人联系方式</th>
				<th style="text-align: center;">遗失人</th>
				<th style="text-align: center;">遗失人联系方式</th>
				<th style="text-align: center;">遗失项目</th>
			</tr>
		</thead>
		<tbody>
			<?php if($list):?>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td><?=$v['reg_id'] ?></td>
					<td style="text-align: left;"><?= Html::encode("{$v['content']}") ?></td>
					<td><?php echo date('Y-m-d H:i:s',$v['reg_time']); ?></td>
					<td><?=$v['TrueName'] ?></td>
					<td><?=$v['Tell'] ?></td>
					<td><?=$v['name'] ?></td>
					<td><?=$v['mobile'] ?></td>
					<td><?=$v['housename'] ?></td>
				</tr>
				<?php endforeach; ?>
			<?php endif;?>
		</tbody>
	</table>
	<div class="pagination-part">
	    <nav>
		<?php
			echo LinkPager::widget([
			    'pagination' => $pagination,
			]);
		?>
		</nav>
	</div>
</div>