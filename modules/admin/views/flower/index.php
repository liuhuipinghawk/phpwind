<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FlowerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '花卉租赁管理系统';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flower-index" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加花卉租赁信息', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'flower_id',
            'flower_name',
            'pid',
            'house_id',
            //'shopping_method',
            //'effect_plants',
            // 'Pot_type',
            // 'green_implication',
            // 'covering_area',
            // 'content:ntext',
            // 'position',
             //'create_time:datetime',
            //'update_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
