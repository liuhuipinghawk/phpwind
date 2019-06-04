<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Admin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="admin-form">

    <?php
    $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => '<div class="span12 field-box">{label}{input}</div>{error}',
        ],
        'options' => [
            'class' => 'new_user_form inline-input',
            'enctype' => 'multipart/form-data'
        ],
    ]); ?>
    <?php echo $form->field($model,'adminuser')->textInput(['class'=>'span12','placeholder'=>'管理员名称']) ?>
    <?php echo $form->field($model,'password')->passwordInput(['class'=>'span12','placeholder'=>'管理员密码']) ?>
    <?php echo $form->field($model,'adminemail')->textInput(['class'=>'span12','placeholder'=>'邮箱']) ?>
    <?php echo $form->field($model, 'headerImg')->fileInput() ?>

    <?= $form->field($model, 'house_ids')->checkboxList($house)->label('绑定项目') ?>

    <?php echo $form->field($model,'group_id')->dropDownList($group,['prompt' => '=请选择角色=','class'=>'span12'])->label('绑定角色') ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    // $(function(){
    //     var 
    // });
</script>
