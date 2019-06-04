<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\WaterPaymentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="water-payment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'account_id') ?>

    <?= $form->field($model, 'order_sn') ?>

    <?= $form->field($model, 'water_consumption') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'water_fee') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'water_type') ?>

    <?php // echo $form->field($model, 'water_time') ?>

    <?php // echo $form->field($model, 'trade_no') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
