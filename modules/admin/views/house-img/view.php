<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\HouseImg */

$this->title = $model->img_id;
$this->params['breadcrumbs'][] = ['label' => 'House Imgs', 'url' => ['publish/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="house-img-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->img_id,'publish_id'=>$_GET['publish_id']], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->img_id,'publish_id'=>$_GET['publish_id']], [
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
            'img_id',
            'publish_id',
            [
                'attribute'=>'img_path',
                'format' => ['image',['width'=>'176px','height'=>'51px',]],
            ],
            'tag',
        ],
    ]) ?>

</div>
