<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Article */
/* @var $form yii\widgets\ActiveForm */
?>
<?php 
    AppAsset::addCss($this,"/ueditor/themes/default/css/ueditor.css");
    AppAsset::addScript($this,"/ueditor/ueditor.config.js");
    AppAsset::addScript($this,"/ueditor/ueditor.all.min.js");
    AppAsset::addScript($this,"/ueditor/lang/zh-cn/zh-cn.js");
 ?>
<style type="text/css">
    #article-content{height:auto !important;}
</style>
<div class="article-form">
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

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cateId')->dropDownList($data) ?>  

    <?= $form->field($model, 'houseId')->dropDownList(\yii\helpers\ArrayHelper::map($house,'id','housename')) ?>

    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thumb')->fileInput() ?>

    <?= $form->field($model,'introduction')->textarea(['style'=>'width:960px;height:100px;']);?>

    <?= $form->field($model, 'content')->textarea(['style'=>'width: 960px;padding: 0px;border: none;height: auto !important;']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '提交' : '提交', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $this->beginBlock("js-block") ?>
$(function () {
var ue = UE.getEditor('article-content');
});
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks["js-block"], \yii\web\View::POS_END); ?>
