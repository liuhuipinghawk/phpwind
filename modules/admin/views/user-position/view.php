<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\UserPosition */

$this->title = $model->position_id;
$this->params['breadcrumbs'][] = ['label' => '用户职位信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-position-view" style="margin-left: 210px;">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->position_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->position_id], [
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
            'position_id',
            'position_name',
        ],
    ]) ?>

</div>
