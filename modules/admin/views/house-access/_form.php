<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\HouseAccess */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="house-access-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'house_id')->dropDownList(\yii\helpers\ArrayHelper::map($data,'id','housename')) ?>

    <?= $form->field($model, 'access')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'home')->textInput(['maxlength' => true]) ?>
    <div style="color: red;">备注：输入框请填数字，以逗号隔开，首页图标权限必须添加8个，不能多也不能少<p><br>
        增资服务权限：1：绿植租赁；2：办公设备；3：洗衣服务；4：公司注册；5：直饮水；6：室内保洁；7：洗车服务;8：3D看房;9：酒店；10：美食；11：办公家具；12：礼品定制；13：装饰设计；14：代理记账；15：宣传服务
    </div><br>
    <div style="color: red;">
        <strong><p>首页图标对应名称</p></strong>
        <tr>
            <td>1：自助开门；2：访客预约；3：停车缴费；4：生活缴费；5：物业公告；6：报检保修；7：房屋租赁；8：兴业有道；9：遗失登记；10：房屋委托；11：车位租赁</td>
        </tr>
    </div><br>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
