<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */

\app\assets\AppAsset::register($this);
$this->title = '系统管理员权限管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-form" style="margin-left:210px">
    <?php $form = ActiveForm::begin(); ?>
    <label>权限集</label>
    <?= $form->field($model, 'item_name')->checkboxList(\yii\helpers\ArrayHelper::map($data,'name','name')) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>