<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Flower */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="flower-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'flower_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'another_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'business_telephone')->textInput(['value' =>'400-6060-617']) ?>

    <?= $form->field($model, 'pid')->dropDownList($data) ?>

    <?= $form->field($model, 'house_id')->dropDownList(\yii\helpers\ArrayHelper::map($house,'id','housename')) ?>

    <?= $form->field($model, 'effect_plants')->checkBoxList(\yii\helpers\ArrayHelper::map($plants,'plants_id','plants_name')) ?>

    <?= $form->field($model, 'Pot_type')->checkBoxList(\yii\helpers\ArrayHelper::map($pot,'pot_id','pot_name')) ?>

    <?= $form->field($model, 'green_implication')->checkBoxList(\yii\helpers\ArrayHelper::map($implication,'implication_id','implication_name')) ?>

    <?= $form->field($model, 'covering_area')->checkBoxList(\yii\helpers\ArrayHelper::map($area,'area_id','area_name')) ?>

    <?= $form->field($model, 'position')->checkBoxList(\yii\helpers\ArrayHelper::map($position,'opsition_id','opsition_name')) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'thumb')->fileInput() ?>

    <?= $form->field($model, 'flower_desc')->textarea(["style"=>"width:925px;height:100px;"]) ?>

    <?= $form->field($model, 'content')->textarea(["style"=>"width:960px;height:400px;"]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock("js-block") ?>
$(function () {
var um = UM.getEditor("flower-content", {
});
});
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks["js-block"], \yii\web\View::POS_END); ?>
