<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\PublishSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="publish-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'publish_id') ?>

    <?= $form->field($model, 'house_id') ?>

    <?= $form->field($model, 'region_id') ?>

    <?= $form->field($model, 'subway_id') ?>

    <?= $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'space') ?>

    <?php // echo $form->field($model, 'age') ?>

    <?php // echo $form->field($model, 'floor') ?>

    <?php // echo $form->field($model, 'deco_id') ?>

    <?php // echo $form->field($model, 'orien_id') ?>

    <?php // echo $form->field($model, 'house_desc') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'person') ?>

    <?php // echo $form->field($model, 'person_tel') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'is_del') ?>

    <?php // echo $form->field($model, 'publish_time') ?>

    <?php // echo $form->field($model, 'publish_user') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
