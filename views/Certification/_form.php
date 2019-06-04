<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Tell')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PassWord')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CreateTime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UpdateTime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LoginTime')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HeaderImg')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NickName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TrueName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'HouseId')->textInput() ?>

    <?= $form->field($model, 'Seat')->textInput() ?>

    <?= $form->field($model, 'Address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IdCard')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'IdCardOver')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'WorkCard')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
