<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Adcate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="adcate-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'adCateName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parentId')->dropDownList($data) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
