<?php
use yii\bootstrap\ActiveForm;
?>
<html>
<?php
$form = ActiveForm::begin(['action'=>['default/busines-property'],'method'=>'post']);
?>
业主房号:<input type="text" value="408" name="proprietorHouse"/><br/>
业主电话号码:<input type="text" value="17073577408" name="proprietorPhone"/><br/>
访客姓名:<input type="text" value="王大锤" name="visitorName" /><br/>
到访人数:<input type="text" value="2" name="vistorsQuantity" /><br/>
到访时间:<input type="text" value="2017-10-24 15:00:00" name="visitTime" /><br/>
出入次数:<input type="text" value="4" name="inoutQuantity" /><br/>
截止日期:<input type="text" value="2017-10-24 16:00:00" name="endTime" /><br/>
<input type="submit" value="提交" />    
<?php ActiveForm::end(); ?>
</html>
