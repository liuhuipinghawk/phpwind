<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\StallSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目车位管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stall-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('项目添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'house_id',
            [
                'label'=>'项目名称',
                'attribute'=>'housename',
                'value'=>'house.housename',
                'headerOptions' => ['width' => '170','style'=>'color:#337ab7;text-decoration:none'],
            ],
            'stall_num',
            'user_id',
            [
                'label'=>'添加人',
                'attribute'=>'adminemail',
                'value'=>'admin.adminemail',
                'headerOptions' => ['width' => '170','style'=>'color:#337ab7;text-decoration:none'],
            ],
            'time:date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
