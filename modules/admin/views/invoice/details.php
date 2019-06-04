<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<?=Html::cssFile('/layout/css/bootstrap.min.css')?>
<?=Html::cssFile('/css/site.css')?>
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<br>
<div class="container-fluid">
	<li>
		<span style="text-align: center;">抬头:</span>
		<input class="form-control" type="text" placeholder="" value='<?=$res['title']?$res['title']:'---';?>' readonly="readonly">
	</li>
	<br>
	<li>
		<span style="text-align: center;">手机号码:</span>
		<input class="form-control" type="text" placeholder="" value="<?=$res['mobile']?$res['mobile']:'---';?>" readonly="readonly">
	</li>
	<br>
	<li>
		<span style="text-align: center;">纳税人识别号:</span>
		<input class="form-control" type="text" placeholder="" value="<?=$res['number']?$res['number']:'---';?>" readonly="readonly">
	</li>
	<br>
	<li>
		<span style="text-align: center;">电话:</span>
		<input class="form-control" type="text" placeholder="" value="<?=$res['tell']?$res['tell']:'---';?>" readonly="readonly">
	</li>
	<br>
	<li>
		<span style="text-align: center;">地址:</span>
		<input class="form-control" type="text" placeholder="" value="<?=$res['address']?$res['address']:'---';?>" readonly="readonly">
	</li>
	<br>
	<li>
		<span style="text-align: center;">开户银行:</span>
		<input class="form-control" type="text" placeholder="" value="<?=$res['bank']?$res['bank']:'---';?>" readonly="readonly">
	</li>
	<br>
	<li>
		<span style="text-align: center;">开户账号:</span>
		<input class="form-control" type="text" placeholder="" value="<?=$res['account_nub']?$res['account_nub']:'---';?>" readonly="readonly">
	</li>
</div>
<script>
	$(document).ready(function(){
			$("#w0").hide();
	});
</script>