<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\WaterBaseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="water-base-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'house_id') ?>

    <?= $form->field($model, 'house_name') ?>

    <?= $form->field($model, 'seat_id') ?>

    <?= $form->field($model, 'seat_name') ?>

    <?php // echo $form->field($model, 'owner_name') ?>

    <?php // echo $form->field($model, 'installation_site') ?>

    <?php // echo $form->field($model, 'meter_number') ?>

    <?php // echo $form->field($model, 'installation_time') ?>

    <?php // echo $form->field($model, 'monovalent') ?>

    <?php // echo $form->field($model, 'rate') ?>

    <?php // echo $form->field($model, 'this_month') ?>

    <?php // echo $form->field($model, 'end_month') ?>

    <?php // echo $form->field($model, 'month_dosage') ?>

    <?php // echo $form->field($model, 'month_amount') ?>

    <?php // echo $form->field($model, 'water_type') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
