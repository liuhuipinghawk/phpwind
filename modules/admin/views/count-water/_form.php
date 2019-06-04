<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\CountWater */
/* @var $form yii\widgets\ActiveForm */
?>
<p style="color: #aa0000"><strong>备注：每个项目只能添加一次</strong></p>
<div class="count-water-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'house_id')->dropDownList(\yii\helpers\ArrayHelper::map($data,'id','housename')) ?>

    <?= $form->field($model, 'area')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
