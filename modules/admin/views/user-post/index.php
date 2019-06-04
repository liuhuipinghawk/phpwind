<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserPostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户岗位信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-post-index" style="margin-left: 210px;">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加用户岗位', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'post_id',
            'post_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
