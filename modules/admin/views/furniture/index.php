<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FurnitureSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '办公家具管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="furniture-index" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加办公家具', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'furniture_id',
            'furniture_name',
            'price',
            'pid',
            'thumb',
            // 'content:ntext',
            // 'create_time:datetime',
            // 'update_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
