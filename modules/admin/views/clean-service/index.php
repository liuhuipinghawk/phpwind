<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CleanServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '添加室内保洁服务';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clean-service-index" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加室内保洁服务', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'clean_id',
            'clean_name',
            [
                'attribute'=>'thumb',
                'format' => ['image',['width'=>'140','height'=>'60',]],
            ],
            //'pid',
            'price',
            'create_time:datetime',
            // 'update_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
