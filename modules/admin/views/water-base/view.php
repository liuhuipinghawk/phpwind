<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\WaterBase */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Water Bases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="water-base-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'house_id',
            'seat_id',
            'owner_name',
            'meter_number',
            'monovalent',
            'this_month',
            'end_month',
            'month_dosage',
            'month_amount',
            'water_type',
            'create_time:datetime',
            'status',
        ],
    ]) ?>

</div>
