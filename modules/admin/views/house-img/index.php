<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\HouseImgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'House Imgs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="house-img-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create House Img', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'img_id',
            'publish_id',
            'img_path',
            'tag',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
