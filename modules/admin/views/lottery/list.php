<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '大转盘抽奖';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['list']];
?>
<div>
	<a href="/admin/lottery/add" class="btn btn-success">新增抽奖</a>
	<h1><?=$this->title ?></h1>	
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>   
				<th style="text-align: center;">编号</th>
				<th style="text-align: center;">标题</th>
				<th style="text-align: center;">添加时间</th>
				<th style="text-align: center;">活动时间</th>
				<th style="text-align: center;">启/禁用状态</th>
				<th style="text-align: center;">活动状态</th>
				<th style="text-align: center; width: 200px;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list as $k => $v): ?>
			<tr>
				<td><?=$v['id']?></td>
				<td><?=$v['title']?></td>
				<td><?=date('Y-m-d H:i',$v['add_time'])?></td>
				<td><?=date('Y-m-d H:i',$v['stime']).' 至 '.date('Y-m-d H:i',$v['etime'])?></td>
				<td>
					<?php if ($v['status'] == 1): ?>
						<button class="btn btn-success" onclick="upStatus(<?=$v['id']?>,0)">启用</button>
					<?php else: ?>
						<button class="btn btn-danger" onclick="upStatus(<?=$v['id']?>,1)">禁用</button>
					<?php endif ?>
				</td>
				<td><?=$v['stime'] > time() ? '未开始' : ($v['etime'] < time() ? '已结束' : '进行中') ?></td>
				<td>
					<?php if ($v['status'] == 0) { ?>
						<?php if ($v['stime'] > time()) { ?>
							<a href="/admin/lottery/add?tag=edit&id=<?=$v['id']?>">修改</a>
						<?php } else { ?>
							<a href="/admin/lottery/add?tag=view&id=<?=$v['id']?>">查看</a>
							<a href="/admin/lottery/award-record?id=<?=$v['id']?>">活动统计</a>
						<?php } ?>
						<a href="javascript:void(0);?>" class="btn_del" data-id="<?=$v['id']?>">删除</a>
					<?php } else { ?>
						<a href="/admin/lottery/add?tag=view&id=<?=$v['id']?>">查看</a>
						<a href="/admin/lottery/award-record?id=<?=$v['id']?>">活动统计</a>
						<a href="/admin/lottery/record-list?id=<?=$v['id']?>">获奖记录</a>
					<?php } ?>
				</td>
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

<?=Html::jsFile('@web/js/jquery-1.12.4.js')?>

<script type="text/javascript">
	$(function(){
		// 删除
		$(".btn_del").click(function(){
			if (confirm("确定要进行删除操作吗?")) {
				var id = $(this).data("id");
				if (id == undefined || id.length == 0) {
					alert("参数错误");
					return false;
				} 
				$.post("/admin/lottery/do-del",{id:id},function(res){
					if (res.code == 200) {
						alert(res.msg);
						location.reload();
					} else {
						alert(res.msg);
						return false;
					}
				},"JSON");
			}
		});
	});

	// 启用、禁用
	function upStatus(id,status)
	{
		if (confirm("确定要进行该操作吗?")) {
			if (id == undefined || id.length == 0 || status == undefined || status.length == 0) {
				alert("参数错误");
				return false;
			}
			$.post("/admin/lottery/do-upstatus",{
				id:id,
				status:status
			},function(res){
				if (res.code == 200) {
					alert(res.msg);
					location.reload();
				} else {
					alert(res.msg);
					return false;
				}
			},"JSON");
		}
	}
</script>