<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->articleId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->articleId], [
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
            'title',
            'adminName',
            [
                'attribute'=>'headImg',
                'format' => ['image',['width'=>'176px','height'=>'51px',]],
            ],
            [
                'attribute'=>'thumb',
                'format' => ['image',['width'=>'50%','height'=>'50%',]],
            ],    
            'content:raw',
            'createTime',
            'updateTime',
        ],
    ]) ?>

</div>
