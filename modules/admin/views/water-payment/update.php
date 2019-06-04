<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\WaterPayment */

$this->title = 'Update Water Payment: ' . $model->order_id;
$this->params['breadcrumbs'][] = ['label' => 'Water Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->order_id, 'url' => ['view', 'id' => $model->order_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="water-payment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
