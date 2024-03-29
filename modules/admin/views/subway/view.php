<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Subway */

$this->title = $model->subway_id;
$this->params['breadcrumbs'][] = ['label' => 'Subways', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subway-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->subway_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->subway_id], [
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
            'subway_id',
            'subway_name',
            'parent_id',
        ],
    ]) ?>

</div>
