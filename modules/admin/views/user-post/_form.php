<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\UserPost */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="user-post-form">
   <?php  $form = ActiveForm::begin([
    'fieldConfig' => [
    'template' => '<div class="span12 field-box">{label}{input}</div>{error}',
    ]
    ]); ?>
    <?= $form->field($model, 'post_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
