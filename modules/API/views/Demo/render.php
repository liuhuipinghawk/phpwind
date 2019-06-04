<?php
use yii\bootstrap\ActiveForm;
?>
<html>
<?php
$form = ActiveForm::begin(['action'=>['api/order'],'method'=>'post']);
?>
内容:<textarea type="text" value="" name="content"></textarea><br/>
<input type="submit" value="提交" />
<?php ActiveForm::end(); ?>
</html>