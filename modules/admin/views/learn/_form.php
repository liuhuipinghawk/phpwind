<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Learn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="learn-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?= $form->field($model, 'upload')->fileInput() ?>

    <?= $form->field($model, 'type')->dropDownList(\yii\helpers\ArrayHelper::map($type,'id','name')) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '更改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
