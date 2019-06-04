<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Furniture */

$this->title = $model->furniture_id;
$this->params['breadcrumbs'][] = ['label' => 'Furnitures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="furniture-view" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->furniture_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->furniture_id], [
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
            'furniture_id',
            'furniture_name',
            'price',
            'pid',
            'thumb',
            'content:ntext',
            'create_time:datetime',
            'update_time:datetime',
        ],
    ]) ?>

</div>
