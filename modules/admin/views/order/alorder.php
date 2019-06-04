<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '派单';
$this->params['breadcrumbs'][] = ['label' => '报检保修订单', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;

?>
<style>
	.height90{
		height: 90%;
	}
	img{
		max-width: 100%;
		max-height: 100%;
	}
	body, html, ul{
		margin:0;
		padding:0;
	}
	.tooltip_li{
		list-style:none;
		float:left;
		margin: 5px;
		width: 80px;
		height: 80px;
		line-height: 80px;
		position: relative;
	}
	.tooltip_li img{
		vertical-align: middle;
		cursor: url(/images/big.png), url(http://assets.alicdn.com/img/common/zoom_in.cur), auto;
		left: 0;
		top: 0;
		opacity: 1;
	}
	#tooltip{
		position: fixed;
		top: 0;
		left: 0;
		background: rgba(0, 0, 0, 0.6);
		width: 100%;
		height: 100%;
		text-align: center;
	}
	.tooltip_big{
		margin: auto;
		position: absolute;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
        z-index: 99999;
	}
	.tooltip_big{
		cursor: url(/images/small.png), url(http://assets.alicdn.com/img/common/zoom_out.cur), auto;
	}
</style>

<div>
	<input type="hidden" id="url" name="url" value="<?=Yii::$app->request->get('url')?>">
	<h3>订单详情</h3>
	<table class="table table-striped table-bordered" style="text-align: center;">
		<tr>
			<td style="text-align: right;">订单编号</td>
			<td style="text-align: left;"><?php echo $order['order_no']; ?></td>
		</tr>
		<tr>
			<td style="text-align: right;">维修区域类型</td>
			<td style="text-align: left;"><?=$order['area_name'].'-'.$order['type_name'] ?></td>
		</tr>
		<tr>
			<td style="text-align: right;">报修内容</td>
			<td style="text-align: left;"><?php echo $order['content']; ?></td>
		</tr>
		<tr>
			<td style="text-align: right;">楼盘信息</td>
			<td style="text-align: left;"><?php echo $order['house_name'].'-'.$order['seat_name'].'-'.$order['room_num']; ?></td>
		</tr>
		<tr>
			<td style="text-align: right;">详细地址</td>
			<td style="text-align: left;"><?php echo $order['address']; ?></td>
		</tr>
		<tr>
			<td style="text-align: right;">故障图片</td>
			<td style="text-align: left;" class="tooltip_li">
				<?php 
					$thumbs = json_decode($order['thumbs']);
					if ($thumbs) {
						foreach ($thumbs as $t) {
							echo '<img class="tooltip" src="'.$t.'" height="100" width="100px" alt=""/>&nbsp;&nbsp;';
						}
					}
				?>
			</td>
		</tr>
		<tr>
			<td style="text-align: right;">报修人</td>
			<td style="text-align: left;"><?php echo $order['persion'].'（'.$order['persion_tel'].'）'; ?></td>
		</tr>
		<tr>
			<td style="text-align: right;">报修时间</td>
			<td style="text-align: left;"><?php echo $order['order_time']; ?></td>
		</tr>
		<?php if($order['state'] == 1): ?>			
			<tr>
				<td style="text-align: right;">状态</td>
				<td style="text-align: left;">等待处理</td>
			</tr>
		<?php elseif($order['state'] == 2): ?>
			<tr>
				<td style="text-align: right;">派单时间</td>
				<td style="text-align: left;"><?php echo date('Y-m-d H:i:s',$order['deal_time']); ?></td>
			</tr>		
			<tr>
				<td style="text-align: right;">维修师傅</td>
				<td style="text-align: left;"><?php echo $order['repair_name'].'（'.$order['repair_tel'].'）'; ?></td>
			</tr>		
			<tr>
				<td style="text-align: right;">状态</td>
				<td style="text-align: left;">已派单</td>
			</tr>
		<?php elseif($order['state'] == 3): ?>
			<tr>
				<td style="text-align: right;">派单时间</td>
				<td style="text-align: left;"><?php echo date('Y-m-d H:i:s',$order['deal_time']); ?></td>
			</tr>		
			<tr>
				<td style="text-align: right;">维修师傅</td>
				<td style="text-align: left;"><?php echo $order['repair_name'].'（'.$order['repair_tel'].'）'; ?></td>
			</tr>
			<tr>
				<td style="text-align: right;">接单时间</td>
				<td style="text-align: left;"><?php echo date('Y-m-d H:i:s',$order['start_time']); ?></td>
			</tr>
			<tr>
				<td style="text-align: right;">状态</td>
				<td style="text-align: left;">维修进行中</td>
			</tr>
		<?php elseif($order['state'] == 4): ?>
			<tr>
				<td style="text-align: right;">派单时间</td>
				<td style="text-align: left;"><?php echo date('Y-m-d H:i:s',$order['deal_time']); ?></td>
			</tr>		
			<tr>
				<td style="text-align: right;">维修师傅</td>
				<td style="text-align: left;"><?php echo $order['repair_name'].'（'.$order['repair_tel'].'）'; ?></td>
			</tr>
			<tr>
				<td style="text-align: right;">接单时间</td>
				<td style="text-align: left;"><?php echo date('Y-m-d H:i:s',$order['start_time']); ?></td>
			</tr>
			<tr>
				<td style="text-align: right;">完成时间</td>
				<td style="text-align: left;"><?php echo date('Y-m-d H:i:s',$order['complate_time']); ?></td>
			</tr>
			<tr>
				<td style="text-align: right;">状态</td>
				<td style="text-align: left;">维修完成</td>
			</tr>
		<?php elseif($order['state'] == 5): ?>
			<tr>
				<td style="text-align: right;">派单时间</td>
				<td style="text-align: left;"><?php echo date('Y-m-d H:i:s',$order['deal_time']); ?></td>
			</tr>		
			<tr>
				<td style="text-align: right;">维修师傅</td>
				<td style="text-align: left;"><?php echo $order['repair_name'].'（'.$order['repair_tel'].'）'; ?></td>
			</tr>
			<tr>
				<td style="text-align: right;">接单时间</td>
				<td style="text-align: left;"><?php echo date('Y-m-d H:i:s',$order['start_time']); ?></td>
			</tr>
			<tr>
				<td style="text-align: right;">完成时间</td>
				<td style="text-align: left;"><?php echo date('Y-m-d H:i:s',$order['complate_time']); ?></td>
			</tr>
			<tr>
				<td style="text-align: right;">关闭时间</td>
				<td style="text-align: left;"><?=$audit ? date('Y-m-d H:i:s',$audit[0]['audit_time']) : '--' ?></td>
			</tr>
			<tr>
				<td style="text-align: right;">评价时间</td>
				<td style="text-align: left;"><?php echo date('Y-m-d H:i:s',$order['comment_time']); ?></td>
			</tr>
			<tr>
				<td style="text-align: right;">评价内容</td>
				<td style="text-align: left;"><?php echo $order['score'].'分<br>'.$order['comment']; ?></td>
			</tr>
			<tr>
				<td style="text-align: right;">状态</td>
				<td style="text-align: left;">已评价</td>
			</tr>
		<?php elseif($order['state'] == 6): ?>
			<tr>
				<td style="text-align: right;">派单时间</td>
				<td style="text-align: left;"><?php echo date('Y-m-d H:i:s',$order['deal_time']); ?></td>
			</tr>		
			<tr>
				<td style="text-align: right;">维修师傅</td>
				<td style="text-align: left;"><?php echo $order['repair_name'].'（'.$order['repair_tel'].'）'; ?></td>
			</tr>
			<tr>
				<td style="text-align: right;">接单时间</td>
				<td style="text-align: left;"><?php echo date('Y-m-d H:i:s',$order['start_time']); ?></td>
			</tr>
			<tr>
				<td style="text-align: right;">完成时间</td>
				<td style="text-align: left;"><?php echo date('Y-m-d H:i:s',$order['complate_time']); ?></td>
			</tr>
			<tr>
				<td style="text-align: right;">关闭时间</td>
				<td style="text-align: left;"><?php echo date('Y-m-d H:i:s',$order['comment_time']); ?></td>
			</tr>
			<tr>
				<td style="text-align: right;">状态</td>
				<td style="text-align: left;">已关闭</td>
			</tr>
		<?php endif; ?>
	</table>

	<!-- 审核 -->
	<?php if ($order['state'] >= 3 || ($order['state'] == 2 && $audit)): ?>
	<h3>订单审核</h3>
	<table class="table table-striped table-bordered" style="text-align: center;">
	<?php if ($audit): ?>
		<tr>
			<td style="text-align: right;">完成明细</td>
			<td style="text-align: left;" class="td_img">
				<?php foreach ($audit as $k => $v): ?>
					<?php if ($k != 0): ?>
						<hr>
						<p>维修人：<?=$v['TrueName'] ? $v['TrueName'] : '--' ?><?=$v['Tell'] ? '('.$v['Tell'].')': '' ?></p>
						<p>完成时间：<?=$v['complate_time'] ? date('Y-m-d H:i',$v['add_time']) : '--' ?></p>
						<p >完成图片：
							<?php if ($v['complate_img']): ?>
								<?php $img_arr = explode(',',$v['complate_img']); ?>
                            <div style="display: inline-block">
                                <?php foreach ($img_arr as $kk => $vv): ?>
                                    <div class="tooltip_li">
                                        <img class="tooltip" src="<?=$vv?>" height="100" width="100px" alt="">
                                    </div>
                                <?php endforeach ?>
                            </div>
							<?php endif ?>
						</p><br/>
						<p>备注：<?=$v['complate_remark'] ? $v['complate_remark'] : '--'?></p>
						<p>审核状态：<?=$v['audit_status'] == 2 ? '审核通过' : ($v['audit_status'] == 3 ? '审核失败' : '待审核')?></p>
						<p>审核备注：<?=$v['audit_remark'] ? $v['audit_remark'] : '--'?></p>
						<p>审核时间：<?=$v['audit_time'] ? date('Y-m-d H:i',$v['audit_time']) : '--'?></p>
						<p>审核人：<?=$v['adminuser'] ? $v['adminuser'] : '--'?></p>
					<?php else: ?>
						<p>维修人：<?=$v['TrueName'] ? $v['TrueName'] : '--' ?><?=$v['Tell'] ? '('.$v['Tell'].')': '' ?></p>
						<p>完成时间：<?=$v['complate_time'] ? date('Y-m-d H:i',$v['add_time']) : '--' ?></p>
						<p>完成图片：
							<?php if ($v['complate_img']): ?>
								<?php $img_arr = explode(',',$v['complate_img']); ?>
                                <div style="display: inline-block">
                                    <?php foreach ($img_arr as $kk => $vv): ?>
                                        <div class="tooltip_li">
                                            <img class="tooltip" src="<?=$vv?>" height="100" width="100px" alt="">
                                        </div>
                                    <?php endforeach ?>
                                </div>
							<?php endif ?>
						</p><br/>
						<p>备注：<?=$v['complate_remark'] ? $v['complate_remark'] : '--'?></p>
						<p>审核状态：<?=$v['audit_status'] == 2 ? '审核通过' : ($v['audit_status'] == 3 ? '审核失败' : '待审核')?></p>
						<p>审核备注：<?=$v['audit_remark'] ? $v['audit_remark'] : '--'?></p>
						<p>审核时间：<?=$v['audit_time'] ? date('Y-m-d H:i',$v['audit_time']) : '--'?></p>
						<p>审核人：<?=$v['adminuser'] ? $v['adminuser'] : '--'?></p>
					<?php endif ?>
				<?php endforeach ?>
			</td>
		</tr>
		<?php if(!empty(Yii::$app->request->get()['tag']) && Yii::$app->request->get()['tag'] == 'audit'): ?>
			<tr>
				<td style="text-align: right;">审核操作</td>
				<td style="text-align: left;">
					<p>
						<input type="radio" name="rdo_check" value="2" checked> 审核通过，关闭订单
						<input type="radio" name="rdo_check" value="3"> 审核不通过，返工重新修理
					</p>
					<p>
						<textarea name="audit_remark" id="audit_remark" class="form-control" placeholder="请输入审核备注"></textarea>
					</p>
					<p>
						<input type="checkbox" name="audit_send_msg" id="audit_send_msg" checked="true">是否发送短信
						<span style="color:red;">注：默认勾选给维修师傅发送短信通知</span>
					</p>
					<p>
						<a href="javascript:void(0);" class="btn btn-default" onclick="order_audit(<?=$audit[0]['item_id']?>)">审核</a>
					</p>
				</td>
			</tr>
		<?php endif ?>
	<?php else: ?>
		<tr>
			<td colspan="2" style="color: red;">温馨提示：旧版爱办App维修订单暂无审核功能，请相关派单、审核人员和维修师傅升级至最新版爱办App！</td>
		</tr>
	<?php endif ?>
	</table>
	<?php endif ?>

	<?php if(in_array($order['state'],[1,2]) || ($order['state'] == 3 && $order['audit_time'])): ?>
	<h3>派单-维修师傅列表</h3>
	<form class="form-inline">
		<div class="form-group">
			<select class="form-control" id="house_id" name="house_id">
				<option value="">请选择项目</option>				
				<?php foreach ($house as $k => $v): ?>
					<option value="<?=$v['id']?>"><?=$v['housename']?></option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="form-group">
			<input type="text" class="form-control" id="repair_name" name="repair_name" placeholder="维修师傅姓名" onkeydown="if(event.keyCode==13)return false;">
		</div>
		<button type="button" class="btn btn-default" id="btn_search">查询</button>
	</form>
	<p>
		<input type="checkbox" name="send_msg" id="send_msg" checked="true">是否发送短信
		<span style="color:red;">注：默认勾选给维修师傅发送短信通知</span>
	</p>
	<p><span style="color:red;">由于维修师傅人数过多，影响网页打开速度，请主动根据项目或者维修师傅姓名关键字检索维修师傅</span></p>
	<div id="repairs" style="width:100%;min-height: 200px;"></div>
	<?php endif; ?>
</div>
<!-- <img src="/img/timg.gif"> -->
<div id="tooltip" style="display: none"><img src="" class="tooltip_big"></div>
<?=Html::jsFile('@web/js/jquery-1.12.4.js')?>
<?=Html::jsFile('@web/js/jquery.min.js')?>
<script>
	var redirect_url = $("#url").val();
	$(function(){
		//维修师傅检索
		$("#btn_search").click(function(){
			$("#right_main").addClass("height90");
			$("#repairs").html("<img src=\"/img/timg.gif\"><p>数据检索中，请耐心等待...</p>");
			$("#right_main").removeClass("height90");
			var house_id = $("#house_id").val();
			var repair_name = $("#repair_name").val();
			$.ajax({
				type:"post",
				dataType:"json",
				url:"<?=Url::to(['order/ajax-get-repairs'])?>",
				data:{
					house_id:house_id,
					repair_name:repair_name
				},
				success:function(res){
					var _html  = "<table class=\"table table-striped table-bordered\" style=\"text-align: center;\">";
					_html     += 	"<thead>";
					_html     += 		"<tr>";
					_html     += 			"<th style=\"text-align: center;\">真实姓名</th>";
					_html     += 			"<th style=\"text-align: center;\">联系方式</th>";
					_html     += 			"<th style=\"text-align: center;\">订单量</th>";
					_html     += 			"<th style=\"text-align: center; width: 150px;\">操作</th>";
					_html     += 		"</tr>";
					_html     += 	"</thead>";
					_html     += 	"<tbody>";
					if (res.code == 200) {
						var data = res.data;
						var _l = data.length;
						if (_l > 0) {
							for (var i = 0; i < _l; i++) {
								_html     += "<tr>";
								_html     += 	"<td>"+res.data[i]['TrueName']+"</td>";					
								_html     += 	"<td>"+res.data[i]['Tell']+"</td>";					
								_html     += 	"<td>进行中："+res.data[i]['status3']+"单<br>未接单："+res.data[i]['status2']+"单</td>";					
								_html     += 	"<td style=\"width: 150px;\"><a href=\"javascript:void(0);\" class=\"confirm\" data-uid=\""+res.data[i]['id']+"\" title=\"派单\">确定派单</a></td>";					
								_html     += "</tr>";
							}
						} else {
							_html     += "<tr><td colspan=\"4\">暂无维修师傅</td></tr>";
						}
						_html     += 	"</tbody>";
						_html     += "</table>";
						$("#repairs").html(_html);
						// $("#right_main").css("height","auto");
					}
				}
			});
		});

		// 派单操作
		$("#repairs").on("click",".confirm",function(){
			if (confirm("确定要进行派单任务吗？")) {
				var send_msg = $('#send_msg').prop('checked');
				var order_id = <?=$order['order_id'] ?>;
				var repair_id = $(this).data("uid");
				if (order_id == undefined || order_id.length == 0) {
					alert("参数错误");
					return false;
				}
				if (repair_id == undefined || repair_id.length == 0) {
					alert("参数错误");
					return false;
				}
				$.post("<?=Url::to(['order/do-appoint'])?>",{
					'order_id':order_id,
					'repair_id':repair_id,
					'send_msg':send_msg
				},function(res){
					if (res.code == 200) {
						alert(res.msg);
						location.href = redirect_url;
					} else {
						alert(res.msg);
						return false;
					}
				},"JSON");
			}
		});
	});

	function order_audit(item_id)
	{
		if (item_id == undefined || item_id == 0) {
			alert('参数错误');return false;
		}
		var audit_status = $('input[name=rdo_check]:checked').val();
		var tip = '';
		if (audit_status == 2) {
			tip = '审核通过,关闭订单';
		} else if (audit_status == 3) {
			tip = '审核不通过，返工重新修理'
		} else {
			alert('审核状态错误');return false;
		}
		if (confirm('确定要'+tip+'吗？')) {
			var audit_remark = $('#audit_remark').val();
			var audit_send_msg = $('#audit_send_msg').prop('checked');
			if (audit_status == 3 && (audit_remark == undefined || audit_remark.length == 0)) {
				alert('请在审核备注栏输入不通过具体原因');return false;
			}
			$.post("<?=Url::to(['order/do-audit'])?>",{
				'item_id':item_id,
				'audit_status':audit_status,
				'audit_remark':audit_remark,
				'audit_send_msg':audit_send_msg
			},function(res){
				if (res.code == 200) {
					alert(res.msg);
					location.href = redirect_url;
				} else {
					alert(res.msg);
					return false;
				}
			},"JSON");
		}
	}
	$(function(){
		$(".tooltip").click(function (e) {
			var tooltip_big_route = this.src;
			$(".tooltip_big").attr("src", tooltip_big_route);
			$("#tooltip").show();
			$(".tooltip_li img").css("opacity", 0);
		});

	});
	$(document).ready(function () {
		$(".tooltip_big, #tooltip").click(function (e) {
			$("#tooltip").hide();
			$(".tooltip_li img").css("opacity", 1);
		});
	})
</script>

