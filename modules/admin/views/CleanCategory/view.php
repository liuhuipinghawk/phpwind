<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CleanCategory */

$this->title = $model->category_id;
$this->params['breadcrumbs'][] = ['label' => 'Clean Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clean-category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->category_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->category_id], [
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
            'category_id',
            'category_name',
            'parent_id',
            'create_time:datetime',
            'update_time:datetime',
        ],
    ]) ?>

</div>
