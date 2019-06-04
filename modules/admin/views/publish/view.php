<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Publish */

$this->title = $model->publish_id;
$this->params['breadcrumbs'][] = ['label' => 'Publishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publish-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->publish_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->publish_id], [
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
            'publish_id',
            'house_id',
            'region_id',
            'subway_id',
            'price',
            'space',
            'age',
            'floor',
            'deco_id',
            'orien_id',
            'house_desc:raw',
            'address',
            'person',
            'person_tel',
            'status',
            'is_del',
            'publish_time:datetime',
            'publish_user',
        ],
    ]) ?>

</div>
