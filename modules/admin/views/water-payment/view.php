<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\WaterPayment */

$this->title = $model->order_id;
$this->params['breadcrumbs'][] = ['label' => 'Water Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="water-payment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->order_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->order_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_id',
            'user_id',
            'account_id',
            'order_sn',
            'water_consumption',
            'create_time:datetime',
            'water_fee',
            'status',
            'water_type',
            'water_time:datetime',
            'trade_no',
        ],
    ]) ?>

</div>
