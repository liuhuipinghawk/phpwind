<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\UsercateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usercates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usercate-index" style="margin-left: 210px;">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Usercate', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'parentid',
            'cratetime',
            'updatetime',  

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
