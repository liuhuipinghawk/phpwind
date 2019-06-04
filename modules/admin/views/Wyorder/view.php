<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\WyOrder */

$this->title = $model->wyorderId;
$this->params['breadcrumbs'][] = ['label' => 'Wy Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wy-order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->wyorderId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->wyorderId], [
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
            'wyorderId',
            'houseId',
            'userId',
            'userName',
            'Address',
            'content',
            'thumb',
            'orderTime',
            'ContactPersion',
            'ContactNumber',
            'status',
        ],
    ]) ?>

</div>
