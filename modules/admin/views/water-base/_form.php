<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\WaterBase */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="water-base-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group field-userbase-house_id">
        <label class="control-label" for="userbase-house_id">
            楼盘Id
        </label>
        <select id="userbase-house_id" class="form-control" name="WaterBase[house_id]" required>
            <option value="">--请选择楼盘--</option>
            <?php foreach ($house as $key=>$val){ ?>
                <option value="<?php echo $val['id'];  ?>" <?php if($val['id'] == $model['house_id']) echo 'selected'; ?> ><?php echo $val['housename'];  ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group field-userbase-seat_id">
        <label class="control-label" for="userbase-seat_id">
            座号Id
        </label>
        <select id="userbase-seat_id" class="form-control" name="WaterBase[seat_id]" required>
            <option value="">--请选择座号--</option>
            <?php foreach ($house as $key=>$val){ ?>
                <option value="<?php echo $val['id'];  ?>" <?php if($val['id'] == $model['seat_id']) echo 'selected'; ?> ><?php echo $val['housename'];  ?></option>
            <?php } ?>
        </select>
    </div>

    <?= $form->field($model, 'room_num')->textInput() ?>

    <?= $form->field($model, 'owner_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meter_number')->textInput() ?>

    <?= $form->field($model, 'monovalent')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'this_month')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'end_month')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'month_dosage')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'month_amount')->textInput(['maxlength' => true]) ?>

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
