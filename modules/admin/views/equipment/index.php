<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EquipmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '办公设备列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipment-index" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加办公设备信息', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'equipment_id',
            'equipment_name',
            'pid',
            [
                'label'=>'分类名称',
                'attribute'=>'category_name',
                'value'=>'category.category_name',
                'headerOptions' => ['width' => '170','style'=>'color:#337ab7;text-decoration:none'],
            ],
            'price',
            'house_id',
            [
                'label'=>'项目名称',
                'attribute'=>'housename',
                'value'=>'house.housename',
                'headerOptions' => ['width' => '170','style'=>'color:#337ab7;text-decoration:none'],
            ],
            [
                'attribute'=>'thumb',
                'format' => ['image',['width'=>'140','height'=>'60',]],
            ],
            // 'content:ntext',
            // 'create_time:datetime',
            // 'update_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
