<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\OrientationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orientations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orientation-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Orientation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'orien_id',
            'orien_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
