<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WaterBase */

$this->title = '修改水费基础信息: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '水费基础信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="water-base-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'house'=>$house,
        'seat'=>$seat
    ]) ?>

</div>
