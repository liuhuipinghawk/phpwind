<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CleanService */

$this->title = $model->clean_id;
$this->params['breadcrumbs'][] = ['label' => 'Clean Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clean-service-view" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->clean_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->clean_id], [
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
            'clean_id',
            'clean_name',
            'pid',
            'price',
            'create_time:datetime',
            'update_time:datetime',
        ],
    ]) ?>

</div>
