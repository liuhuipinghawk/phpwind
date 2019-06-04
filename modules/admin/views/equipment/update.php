<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Equipment */

$this->title = '修改办公设备信息: ' . $model->equipment_id;
$this->params['breadcrumbs'][] = ['label' => 'Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->equipment_id, 'url' => ['view', 'id' => $model->equipment_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="修改办公设备信息" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
        'house'=>$house,
    ]) ?>

</div>
