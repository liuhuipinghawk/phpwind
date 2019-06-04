<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\CountWaterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '项目水费管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="count-water-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('项目添加', ['create'], ['class' => 'btn btn-success']) ?>
    </p><br>
    <p style="color: #aa0000"><strong>备注：每个项目只能添加一次</strong></p>
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'项目名称',
                'attribute'=>'housename',
                'value'=>'house.housename',
                'headerOptions' => ['width' => '170','style'=>'color:#337ab7;text-decoration:none'],
            ],
            [
                'attribute' => 'create_time',
                'label'=>'更新时间',
                'value'=>
                    function($model){
                        return  date('Y-m-d H:i:s',$model->create_time);   //主要通过此种方式实现
                    },
                'headerOptions' => ['width' => '170'],
            ],
            [
                'label'=>'添加人',
                'attribute'=>'adminemail',
                'value'=>'admin.adminemail',
                'headerOptions' => ['width' => '170','style'=>'color:#337ab7;text-decoration:none'],
            ],
            'area',

            ['class' => 'yii\grid\ActionColumn','header' => '操作',]
        ],
    ]); ?>
</div>
