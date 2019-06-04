<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\StallSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stall-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'house_id') ?>

    <?= $form->field($model, 'stall_num') ?>

    <?= $form->field($model, 'stall_sold') ?>

    <?= $form->field($model, 'stall_rent') ?>

    <?php // echo $form->field($model, 'stall_other') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
