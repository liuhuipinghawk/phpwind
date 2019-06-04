<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\HouseImg */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="house-img-form">

    <?php $form = ActiveForm::begin([
            'fieldConfig' =>[
                'template' => '<div class="span12 field-box">{label}{input}</div>{error}',
            ],
            'options' => [
                'class'=>'new_user_form inline-input',
                'enctype'=> 'multipart/form-data'
            ],
    ]); ?>

    <?= $form->field($model, 'img_path')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
