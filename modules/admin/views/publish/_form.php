<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Publish */
/* @var $form yii\widgets\ActiveForm */
AppAsset::register($this);
AppAsset::addCss($this,"/css/umeditor/themes/default/css/umeditor.css");
AppAsset::addScript($this,"/css/umeditor/third-party/template.min.js");
AppAsset::addScript($this,"/css/umeditor/umeditor.config.js");
AppAsset::addScript($this,"/css/umeditor/umeditor.min.js");
AppAsset::addScript($this,"/css/umeditor/lang/zh-cn/zh-cn.js");
?>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.bootcss.com/moment.js/2.18.1/moment-with-locales.min.js"></script>
<link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<div class="publish-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model,'house_type')->dropDownList(\yii\helpers\ArrayHelper::map($house_type,'id','house_type')); ?>
    <?= $form->field($model, 'house_id')->dropDownList(\yii\helpers\ArrayHelper::map($house,'id','housename')) ?>

    <?= $form->field($model, 'region_id')->dropDownList($region_id); ?>

    <?= $form->field($model, 'subway_id')->dropDownList($subway_id) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'space')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model,'unit')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model,'age')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'floor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'deco_id')->dropDownList(\yii\helpers\ArrayHelper::map($decoration,'deco_id','deco_name')) ?>

    <?= $form->field($model, 'orien_id')->dropDownList(\yii\helpers\ArrayHelper::map($orientation,'orien_id','orien_name')) ?>

    <?= $form->field($model, 'house_desc')->textarea(["style"=>"width:1170px;height:200px;"]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'person')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'person_tel')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
        $('#date1').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: moment.locale('zh-cn')
        });
</script>
<?php $this->beginBlock("js-block") ?>
$(function () {
var um = UM.getEditor("publish-house_desc", {
});
});
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks["js-block"], \yii\web\View::POS_END); ?>
