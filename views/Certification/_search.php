<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'Tell') ?>

    <?= $form->field($model, 'PassWord') ?>

    <?= $form->field($model, 'CreateTime') ?>

    <?= $form->field($model, 'UpdateTime') ?>

    <?php // echo $form->field($model, 'LoginTime') ?>

    <?php // echo $form->field($model, 'HeaderImg') ?>

    <?php // echo $form->field($model, 'NickName') ?>

    <?php // echo $form->field($model, 'Email') ?>

    <?php // echo $form->field($model, 'TrueName') ?>

    <?php // echo $form->field($model, 'HouseId') ?>

    <?php // echo $form->field($model, 'Seat') ?>

    <?php // echo $form->field($model, 'Address') ?>

    <?php // echo $form->field($model, 'IdCard') ?>

    <?php // echo $form->field($model, 'IdCardOver') ?>

    <?php // echo $form->field($model, 'WorkCard') ?>

    <?php // echo $form->field($model, 'Company') ?>

    <?php // echo $form->field($model, 'Status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
