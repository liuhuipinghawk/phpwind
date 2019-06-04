<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserPositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户职位信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-position-index" style="margin-left: 210px;">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加用户职位', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'position_id',
            'position_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
