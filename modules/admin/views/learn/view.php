<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Learn */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '学习园地', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learn-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
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
            'title',
            'create_time:datetime',
            'content:ntext',
            [
                'attribute'=>'image',
                'format' => ['image',['width'=>'176px','height'=>'51px',]],
            ],
            'upload',
            'type',
            'comment_num',
            'read_num',
            'like_num',
            'download_num',
            'adminuser',
        ],
    ]) ?>

</div>
