<?php
use yii\bootstrap\ActiveForm;
?>
<html>
<?php
$form = ActiveForm::begin(['action'=>['init/index'],'method'=>'post']);
?>
设备号:<input type="text" value="" name="did"/><br/>
版本号:<input type="text" value="" name="version_id"/><br/>
小版本号:<input type="text" value="" name="version_mini"/><br/>
APP类型<input type="text" value="" name="app_id"/><br/>
encrypt_did<input type="text" value="c39f07bf54425745d642498395ce144c" name="encrypt_did" /> <br/>
<input type="submit" value="提交" />
<?php ActiveForm::end(); ?>
</html>