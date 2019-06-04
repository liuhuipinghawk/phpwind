<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\WyOrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="wy-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'wyorderId') ?>

    <?= $form->field($model, 'houseId') ?>

    <?= $form->field($model, 'userId') ?>

    <?= $form->field($model, 'userName') ?>

    <?= $form->field($model, 'Address') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'thumb') ?>

    <?php // echo $form->field($model, 'orderTime') ?>

    <?php // echo $form->field($model, 'ContactPersion') ?>

    <?php // echo $form->field($model, 'ContactNumber') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
