<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '客房管理';
$this->params['breadcrumbs'][] = ['label' => '酒店列表管理', 'url' => ['hotel']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::cssFile('/css/webuploader.css')?>  
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/js/webuploader/webuploader.js')?>
<?=Html::jsFile('/js/upload.js')?>

<style>
	#fileList .thumbnail > img, .thumbnail a > img{margin-left: 0;}
    #fileList .file-item{border: 0; width: 110px; display: block; float: left;}
    #fileList .file-item img{width:100px; height: 100px;}
    #fileList .file-item span.del-img,.file-item span.del-img1{
        display: block;
        width: 100%;
        height: 25px;
        background: rgba(0, 0, 0, .5);
        top: -25px;
        line-height: 25px;
        text-align: right;
        padding-right: 6px;
        color: #fff;
        cursor: pointer;
    }
    #filePicker{display: block; clear: both;}
    td.room_img img{max-height: 100px;}
</style>


<div style="width:80%; margin-left: 20px; display: block; float: left;">
	<h1><?=$this->title?></h1>
	<p>
		<a class="btn btn-success" href="<?=Url::to(['hotel/add-room','hotel_id'=>$hotel_id])?>">新增客房信息</a>
	</p>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">客房名称</th>
				<th style="text-align: center;">客房主图</th>
				<th style="text-align: center;">类型</th>
				<th style="text-align: center;">价格</th>
				<th style="text-align: center;">添加时间</th>
				<th style="text-align: center;">审核状态</th>
				<th style="text-align: center;">状态</th>
				<th style="text-align: center; width: 200px;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if($list): ?>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td><?=$v['room_id'] ?></td>
					<td><?=$v['room_name'] ?></td>
					<td class="room_img"><img src="<?=$v['room_img'] ?>"></td>
					<td><?=$v['type_name'] ?></td>
					<td><?=$v['price'] ?></td>
					<td><?php echo date('Y-m-d H:i:s',$v['add_time']); ?></td>
					<td>
						<?php 
							if ($v['audit_state'] == 0) {
								echo '待审核';
							} else if ($v['audit_state'] == 1) {
								echo '审核通过';
							} else if ($v['audit_state'] == 2) {
								echo '审核失败';
							}
						?>
					</td>
					<td>
						<?php 
							if ($v['state'] == 1) {
								echo '上架';
							} else if ($v['state'] == 2) {
								echo '下架';
							}
						?>
					</td>
					<td style="width: 200px;">
						<?php if($v['state'] == 2): ?>
						<a href="<?=Url::to(['hotel/add-room','hotel_id'=>$v['hotel_id'],'room_id'=>$v['room_id']])?>" title="编辑">编辑</a>&nbsp;&nbsp;
						<a href="javascript:void(0);" title="上架" onclick="upState(<?=$v['room_id']?>,'state',1)">上架</a>&nbsp;&nbsp;
						<a href="javascript:void(0);" title="删除" onclick="upState(<?=$v['room_id']?>,'del',-1)">删除</a>&nbsp;&nbsp;
						<?php endif; ?>

						<?php if($v['state'] == 1): ?>
						<a href="javascript:void(0);" title="下架" onclick="upState(<?=$v['room_id']?>,'state',2)">下架</a>&nbsp;&nbsp;
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="10">暂无相关数据</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<script>
	function upState(room_id,tag,state){
		if (room_id == undefined || room_id.length == 0 || room_id < 1) {
			alert('参数错误');return false;
		}
		if (tag != 'state' && tag != 'del') {
			alert('参数错误');return false;
		}
		if (state != 1 && state != 2 && state != -1) {
			alert('参数错误');return false;
		}
		var str = '确定要进行删除操作吗';
		if (tag == 'state' && state == 1) {
			str = '确定要进行上架操作吗';
		}		
		if (tag == 'state' && state == 2) {
			str = '确定要进行下架操作吗';
		}
		if (confirm(str)) {
			$.post("<?=Url::to(['hotel/ajax-upstate-room'])?>",{
				room_id:room_id,
				tag:tag,
				state:state
			},function(res){
				if (res.code == 200) {
					alert('操作成功');
					location.reload();
				} else {
					alert(res.msg);return false;
				}
			},"JSON");
		}
	}
</script>
