<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Flower */

$this->title = $model->flower_id;
$this->params['breadcrumbs'][] = ['label' => 'Flowers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flower-view" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->flower_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->flower_id], [
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
            'flower_id',
            'flower_name',
            'pid',
            'shopping_method',
            'effect_plants',
            'Pot_type',
            'green_implication',
            'covering_area',
            'content:ntext',
            'position',
            'create_time:datetime',
            'update_time:datetime',
        ],
    ]) ?>

</div>
