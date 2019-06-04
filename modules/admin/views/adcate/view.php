<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Adcate */

$this->title = $model->adCateId;
$this->params['breadcrumbs'][] = ['label' => '广告分类', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adcate-view" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->adCateId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->adCateId], [
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
            'adCateId',
            'adCateName',
            'parentId',
            'createTime',
            'updateTime',
        ],
    ]) ?>

</div>
