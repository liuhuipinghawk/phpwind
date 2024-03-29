<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\UserPosition */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-position-form">

    <?php  $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => '<div class="span12 field-box">{label}{input}</div>{error}',
        ]
    ]); ?>

    <?= $form->field($model, 'position_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
