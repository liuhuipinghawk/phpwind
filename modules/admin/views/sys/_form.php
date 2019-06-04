<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\UserPosition */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-position-form">

   <?php $form = ActiveForm::begin([
    'fieldConfig' => [
    'template' => '<div class="span12 field-box">{label}{input}</div>{error}',
    ],
    'options' => [
    'class' => 'new_user_form inline-input',
    'enctype' => 'multipart/form-data'
    ],
    ]); ?>
    <?= $form->field($model, 'user_type')->dropDownList(\yii\helpers\ArrayHelper::map($user_type,'id','type_name')); ?>
    <?= $form->field($model, 'true_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>
    <div class="form-group field-userbase-posts">
        <label class="control-label" for="userbase-posts">
            岗位
        </label>
        <select id="userbase-posts" class="form-control" name="UserBase[posts]">
            <option value="">--请选择岗位--</option>
            <?php foreach ($post as $key=>$val){ ?>
                <option value="<?php echo $val['post_id'];  ?>"  ><?php echo $val['post_name'];  ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group field-userbase-position">
        <label class="control-label" for="userbase-position">
            职位
        </label>
        <select id="userbase-position" class="form-control" name="UserBase[position]">
            <option value="">--请选择职位--</option>
            <?php foreach ($position as $key=>$val){ ?>
                <option value="<?php echo $val['position_id']; ?>" ><?php echo $val['position_name'];  ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group field-userbase-house_id">
        <label class="control-label" for="userbase-house_id">
            楼盘Id
        </label>
        <select id="userbase-house_id" class="form-control" name="UserBase[house_id]">
            <option value="">--请选择楼盘--</option>
            <?php foreach ($house as $key=>$val){ ?>
                <option value="<?php echo $val['id'];  ?>" <?php if($model->house_id == $val['id']){ ?> selected="selected" <?php }; ?> ><?php echo $val['housename'];  ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group field-userbase-seat_id">
        <label class="control-label" for="userbase-seat_id">
            座号Id
        </label>
        <select id="userbase-seat_id" class="form-control" name="UserBase[seat_id]">
            <option value="">--请选择座号--</option>
        </select>
    </div>
    <?= $form->field($model, 'room_num')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>       

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<script src="/js/jquery-2.1.4.js"></script>     
<script>
    $('#userbase-house_id').change(function () {
       var house_ids = $(this).children('option:selected').val();
       var mysqlurl ="/index.php?r=admin/sys/site";
       $.ajax({
           type: 'GET',
           url: mysqlurl,
           dataType: 'json',
           data: {house_id: house_ids},
           success: function (data) {
               //console.log(data.code[0]['housename']);
               var html='';
               for(var i=0;i<data.code.length;i++){
                  // console.log(data.code[i]['housename']);
                   html += '<option value='+data.code[i]['id']+'>'+data.code[i]['housename']+'</option>';
               }
               var oContent=$("#userbase-seat_id");
               oContent.html(html);
           }
       });
    });
</script>
