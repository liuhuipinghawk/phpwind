<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CleanService */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clean-service-form">

    <?php
    $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => '<div class="span12 field-box">{label}{input}</div>{error}',
        ],
        'options' => [
            'class' => 'new_user_form inline-input',
            'enctype' => 'multipart/form-data'
        ],
    ]); ?>

    <?= $form->field($model, 'clean_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pid')->dropDownList($data); ?>

    <?= $form->field($model, 'thumb')->fileInput() ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'content')->textarea(["style"=>"width:960px;height:400px;"]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock("js-block") ?>
$(function () {
var um = UM.getEditor("cleanservice-content", {
});
});
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks["js-block"], \yii\web\View::POS_END); ?>
