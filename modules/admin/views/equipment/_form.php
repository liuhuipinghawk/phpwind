<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Equipment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="equipment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'equipment_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pid')->dropDownList($data) ?>

    <?= $form->field($model, 'house_id')->dropDownList(\yii\helpers\ArrayHelper::map($house,'id','housename')) ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'business_telephone')->textInput(['value' =>'400-6060-617']) ?>

    <?= $form->field($model, 'thumb')->fileInput() ?>

    <?= $form->field($model, 'equipment_desc')->textarea(["style"=>"width:940px;height:90px;"]) ?>

    <?= $form->field($model, 'content')->textarea(["style"=>"width:960px;height:400px;"]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock("js-block") ?>
$(function () {
var um = UM.getEditor("equipment-content", {
});
});
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks["js-block"], \yii\web\View::POS_END); ?>
