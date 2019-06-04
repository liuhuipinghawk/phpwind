<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\WyOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wy Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wy-order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Wy Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'wyorderId',
            'houseId',
            'userId',
            'userName',
            'Address',
            // 'content',
            // 'thumb',
            // 'orderTime',
            // 'ContactPersion',
            // 'ContactNumber',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
