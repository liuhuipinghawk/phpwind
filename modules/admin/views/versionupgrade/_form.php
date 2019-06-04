<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\VersionUpgrade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="version-upgrade-form">

    <?php  $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => '<div class="span12 field-box">{label}{input}</div>{error}',
        ]
    ]); ?>

    <?= $form->field($model, 'app_id')->dropDownList(\yii\helpers\ArrayHelper::map($data,'id','name')) ?>

    <?= $form->field($model, 'status')->dropDownList(\yii\helpers\ArrayHelper::map(array(array('id'=>1,'status'=>'上架'),array('id'=>0,'status'=>'下架')),'id','status')) ?>

    <?= $form->field($model, 'type')->dropDownList(\yii\helpers\ArrayHelper::map(array(array('id'=>1,'type'=>'升级'),array('id'=>0,'type'=>'不升级'),array('id'=>2,'type'=>'强制升级')),'id','type')) ?>

    <?= $form->field($model, 'version_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apk_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'upgrade_point')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
