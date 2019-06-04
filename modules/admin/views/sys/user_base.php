<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '用户基础信息';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::cssFile('/css/webuploader.css')?>  
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/js/webuploader/webuploader.js')?>
<?=Html::jsFile('/js/upload_excel.js')?>
<div>
	<h1><?=$this->title ?></h1>
    <form class="form-inline" action="">
        <?php 
        $company = empty(Yii::$app->request->get()['company']) ? '' : Yii::$app->request->get()['company'];
        $mobile = empty(Yii::$app->request->get()['mobile']) ? '' : Yii::$app->request->get()['mobile'];
        $true_name = empty(Yii::$app->request->get()['true_name']) ? '' : Yii::$app->request->get()['true_name'];
        $user_type    = empty(Yii::$app->request->get()['user_type']) ? 0 : Yii::$app->request->get()['user_type'];
        ?>
        <div class="form-group">
            <input type="text" class="form-control" id="company" name="company" placeholder="请输入公司名称" value="<?=$company?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="请输入联系方式" value="<?=$mobile?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="true_name" name="true_name" placeholder="请输入联系人" value="<?=$true_name?>">
        </div>
        <div class="form-group">
            <select class="form-control" name="user_type" id="user_type">
                <option value="0">状态</option>
                <option value="1" <?php if($user_type == 1) echo 'selected';?>>等待回访</option>
                <option value="2" <?php if($user_type == 2) echo 'selected';?>>成功回访</option>
            </select>
        </div>
        <button type="submit" class="btn btn-default">查询</button>
    </form>
	<div>
		<p>导入用户基础信息：</p>
		<div id="filePicker"></div>
		<div id="fileList"></div>
		<div class="class="form-group">
			<a href="javascript:void(0);" class="btn btn-default" id="btn_import">执行导入数据</a>
		</div>
		<div class="class="form-group">
			<p class="info"></p>
			<div id="error_data">
			</div>
            <p>
                <?= Html::a('手动添加用户基础信息', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
		</div>

	</div>
	<hr>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">姓名</th>
				<th style="text-align: center;">联系方式</th>
				<th style="text-align: center;">公司名称</th>
				<th style="text-align: center;">楼盘ID</th>
				<th style="text-align: center;">楼盘名称</th>
				<th style="text-align: center;">楼座ID</th>
				<th style="text-align: center;">楼座名称</th>
				<th style="text-align: center;">房间号</th>
				<th style="text-align: center;">详细地址</th>
				<th style="text-align: center;">用户类型</th>
                <th style="text-align: center;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if($list):?>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td><?=$v['id'] ?></td>
					<td><?=$v['true_name'] ?></td>
					<td><?=$v['mobile'] ?></td>
					<td><?=$v['company'] ?></td>
					<td><?=$v['house_id'] ?></td>
					<td><?=$v['house_name'] ?></td>
					<td><?=$v['seat_id'] ?></td>
					<td><?=$v['seat_name'] ?></td>
					<td><?=$v['room_num'] ?></td>
					<td><?=$v['address'] ?></td>
					<td><?php if($v['user_type'] == 1) echo '内部员工'; else echo '普通用户'; ?></td>
                    <td>&nbsp<a href="<?php echo \yii\helpers\Url::to(['sys/view','id'=>$v['id']]); ?>">查看</a>&nbsp;&nbsp;<a href="<?php echo \yii\helpers\Url::to(['sys/update','id'=>$v['id']]); ?>">更新</a>&nbsp;&nbsp;<a href="<?php echo \yii\helpers\Url::to(['sys/delete','id'=>$v['id']]) ?>">删除</a> </td>
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

<script type="text/javascript">
	$(function(){
		$('#btn_import').click(function(){
			var path = $('#fileList').data('url');
			if (path == undefined || path.length == 0) {
				alert('请先上传excel文件');return false;
			}
			$.post("<?=Url::to(['sys/ajax-import-excel'])?>",{
				path:path
			},function(res){
				if (res.code == 200) {
					$('.info').html('执行完毕，成功：'+res.success+'条；失败'+res.fail+'条。');
					var len = res.data.length;
					if (len > 0) {
						var str = '<table class="table table-striped table-bordered" style="text-align: center;">';
						str += '<thead><tr>';
						str += '<th>姓名</th>';
						str += '<th>手机号</th>';
						str += '<th>公司名称</th>';
						str += '<th>楼盘ID</th>';
						str += '<th>楼盘名称</th>';
						str += '<th>楼座ID</th>';
						str += '<th>楼座名称</th>';
						str += '<th>房间号</th>';
						str += '<th>详细地址</th>';
						str += '<th>错误信息</th>';
						str += '</tr></thead>';
						for (var i = 0; i < len; i++) {
							str += '<tbody><tr>';
							str += '<td>'+res.data[i]['true_name']+'</td>';
							str += '<td>'+res.data[i]['mobile']+'</td>';
							str += '<td>'+res.data[i]['company']+'</td>';
							str += '<td>'+res.data[i]['house_id']+'</td>';
							str += '<td>'+res.data[i]['house_name']+'</td>';
							str += '<td>'+res.data[i]['seat_id']+'</td>';
							str += '<td>'+res.data[i]['seat_name']+'</td>';
							str += '<td>'+res.data[i]['room_num']+'</td>';
							str += '<td>'+res.data[i]['address']+'</td>';
							str += '<td style="color:red;">'+res.data[i]['error']+'</td>';
							str += '</tr></tbody>';
						}
						str += '</table>';
						$('#error_data').html(str);
					}
				} else {
					$('.info').html(res.msg);
				}
			},'JSON');
		});
	});
</script>