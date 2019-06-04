<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FlowerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="flower-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'flower_id') ?>

    <?= $form->field($model, 'flower_name') ?>

    <?= $form->field($model, 'pid') ?>

    <?= $form->field($model, 'shopping_method') ?>

    <?= $form->field($model, 'effect_plants') ?>

    <?php // echo $form->field($model, 'Pot_type') ?>

    <?php // echo $form->field($model, 'green_implication') ?>

    <?php // echo $form->field($model, 'covering_area') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
