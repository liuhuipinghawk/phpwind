<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\House */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="house-form">


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

    <?= $form->field($model, 'housename')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parentId')->dropDownList($data); ?>

    <?= $form->field($model, 'cityid')->dropDownList(\yii\helpers\ArrayHelper::map($city,'id','city')); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
