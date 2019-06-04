<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '缴费账户基础信息';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::cssFile('/css/webuploader.css')?>
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/js/webuploader/webuploader.js')?>
<?=Html::jsFile('/js/upload_excel.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<style>
    .mask-body{
        display: none;
    }
    .mask{
        position: fixed;
        left: 0;
        top: 0;
        display: block;
        width: 100%;
        height: 100%;
        text-align: center;
        background: rgba(0,0,0,0.3);
        z-index: 1;
    }
    .tip{
        position: absolute;
        left: 34%;
        top: 20%;
        width: 600px;
        height: 120px;
        background: #ffffff;
        border-radius: 10px;
        padding: 20px 0;
        text-align: left;
    }
    .title{
        padding-left: 15px;
        font-size: 16px;
        border-bottom: 1px solid #e6e6e6;
        padding-bottom: 10px;
    }
    .load{
        padding-left: 15px;
        margin-top: 15px;
        font-size: 15px;
    }
</style>
<div class="mask-body">
    <div class="tip">
        <div class="title">提示</div>
        <div class="load">上传中，请稍等……</div>
    </div>
</div>
<div class="mask-sib">
	<h1><?=$this->title ?></h1>
    <form class="form-inline" action="/admin/sys/account-base">
        <?php
	        $house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
	        $seat_id  = empty(Yii::$app->request->get()['seat_id']) ? 0 : Yii::$app->request->get()['seat_id'];
	        $room_num = empty(Yii::$app->request->get()['room_num']) ? '' : Yii::$app->request->get()['room_num'];
        ?>
        <div class="form-group">
            <select class="form-control" id="house_id" name="house_id">
            	<option value="">选择楼盘</option>
            	<?php if (!empty($house)): ?>
            		<?php foreach ($house as $k => $v): ?>
            			<option value="<?=$v['id'] ?>" <?php if($v['id'] == $house_id) echo 'selected'; ?>><?=$v['housename'] ?></option>
            		<?php endforeach ?>
            	<?php endif ?>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" id="seat_id" name="seat_id">
            	<option value="">选择楼座</option>
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="room_num" name="room_num" placeholder="请输入房间号" value="<?=$room_num?>">
        </div>
        <button type="submit" class="btn btn-default">查询</button>
    </form>
	<div style="margin-top: 20px;">
		<p><a href="/admin/sys/download-file" class="btn btn-success">下载模板</a></p>
		<p>导入缴费账户基础信息：</p>
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
                <a href="javascript:void(0);" id="btn_add" class="btn btn-success" data-id="0">添加账户</a>
            </p>
		</div>
	</div>
	<hr>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<thead>
			<tr>
				<th style="text-align: center;">ID</th>
				<th style="text-align: center;">楼盘</th>
				<th style="text-align: center;">楼座</th>
				<th style="text-align: center;">房间号</th>
				<th style="text-align: center;">房主</th>
				<th style="text-align: center;">电表倍率</th>
				<th style="text-align: center;">物业费单价</th>
				<th style="text-align: center;">物业面积</th>
				<th style="text-align: center;">创建时间</th>
				<th style="text-align: center;">修改时间</th>
				<th style="text-align: center;">修改人</th>
                <th style="text-align: center;">操作</th>
			</tr>
		</thead>
		<tbody>
			<?php if($list):?>
				<?php foreach($list as $k => $v): ?>
				<tr>
					<td><?=$v['id'] ?></td>
					<td><?=$v['house_name'] ?></td>
					<td><?=$v['seat_name'] ?></td>
					<td><?=$v['room_num'] ?></td>
					<td><?=$v['owner'] ?></td>
					<td><?=$v['rate'] ?></td>
					<td><?=$v['property_fee'] ?></td>
					<td><?=$v['area'] ?></td>
					<td><?=$v['create_time'] ? date('Y-m-d',$v['create_time']) : '--' ?></td>
					<td><?=$v['update_time'] ? date('Y-m-d',$v['update_time']) : '--'?></td>
					<td><?=$v['adminemail'] ?></td>
					<td>
						<a href="javascript:void(0);" class="btn_update" data-id="<?=$v['id']?>">修改</a>&nbsp;&nbsp;
						<a href="javascript:void(0);" class="btn_del" data-id="<?=$v['id']?>">删除</a>
					</td>
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
        getSeat(<?=$house_id ?>,<?=$seat_id ?>);

        //楼盘
		$('#house_id').change(function(){
			var house_id = $(this).val();
			getSeat(house_id,0);
		});

		//导入
		$('#btn_import').click(function(){
			var path = $('#fileList').data('url');
			if (path == undefined || path.length == 0) {
				alert('请先上传excel文件');return false;
			}
            $(this).parents('.mask-sib').siblings('.mask-body').addClass('mask');
			$.post("<?=Url::to(['sys/ajax-import-account-base'])?>",{
				path:path
			},function(res){
				if (res.code == 200) {
					$('.info').html('执行完毕，成功：'+res.success+'条；失败'+res.fail+'条。');
					var len = res.data.length;
					if (len > 0) {
						var str = '<table class="table table-striped table-bordered" style="text-align: center;">';
						str += '<thead><tr>';
						str += '<th>楼盘名称</th>';
						str += '<th>楼盘ID</th>';
						str += '<th>楼座名称</th>';
						str += '<th>楼座ID</th>';
						str += '<th>房间号</th>';
						str += '<th>房主</th>';
						str += '<th>倍率</th>';
						str += '<th>物业费</th>';
						str += '<th>物业面积</th>';
						str += '<th>错误提示</th>';
						str += '</tr></thead>';
						for (var i = 0; i < len; i++) {
							str += '<tbody><tr>';
							str += '<td>'+res.data[i]['house_name']+'</td>';
							str += '<td>'+res.data[i]['house_id']+'</td>';
							str += '<td>'+res.data[i]['seat_name']+'</td>';
							str += '<td>'+res.data[i]['seat_id']+'</td>';
							str += '<td>'+res.data[i]['room_num']+'</td>';
							str += '<td>'+res.data[i]['owner']+'</td>';
							str += '<td>'+res.data[i]['rate']+'</td>';
							str += '<td>'+res.data[i]['property_fee']+'</td>';
							str += '<td>'+res.data[i]['area']+'</td>';
							str += '<td style="color:red;">'+res.data[i]['error']+'</td>';
							str += '</tr></tbody>';
						}
						str += '</table>';
						$('#error_data').html(str);
						$('.mask-body').removeClass('mask');
					}
                    setTimeout(function(){
                        location.reload();
                    },5000);
				} else {
					$('.info').html(res.msg);
				}
			},'JSON');
		});

		//删除
		$('.btn_del').click(function(){
			if (confirm('确定要删除吗？')) {
				var op_id = $(this).data('id');
				if (op_id == undefined || op_id.length == 0) {
					alert('参数错误');return false;
				}
				$.post('/index.php?r=admin/sys/ajax-del-account-base',{op_id:op_id},function(res){
					if (res.code == 200) {
						alert(res.msg);
						location.reload();
					} else {
						alert(res.msg);
						return false;
					}
				},'JSON');
			}
		});
	});

	//获取楼座信息
    function getSeat(house_id,seat_id){
        $.ajax({
            type:'post',
            dataType:'json',
            url:"<?=Url::to(['living-payment/ajax-get-seat']) ?>",
            data:{
                house_id:house_id
            },
            success:function(res){
                if (res.code == 200) {
                    var len = res.data.length;
                    var _option = '<option value="">选择楼座</option>';
                    for(var i = 0; i < len; i++){
                        _option += '<option';
                        if (res.data[i]['id'] == seat_id) {
                            _option += ' selected';
                        }
                        _option += ' value="'+res.data[i]['id']+'">'+res.data[i]['housename']+'</option>';
                    }
                    $('#seat_id').html(_option);
                }
            }
        });
    }

    //layer新增、修改弹出层
    layui.use('layer', function(){
		var layer = layui.layer;
		//添加/修改
		$('#btn_add,.btn_update').click(function(){
			layer.open({
				type:2,
				content:'/index.php?r=admin/sys/add-account-base&op_id='+$(this).data('id'),
				area:['500px','650px']
			});
		});
	});
</script>