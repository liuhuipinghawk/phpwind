<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\VersionUpgradeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="version-upgrade-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'app_id') ?>

    <?= $form->field($model, 'version_code') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'apk_url') ?>

    <?php // echo $form->field($model, 'upgrade_point') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
