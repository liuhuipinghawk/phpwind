<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '新闻';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加新闻', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'articleId',
            'title',
            //'adminName',
            //[
               // 'attribute'=>'headImg',
                //'format' => ['image',['width'=>'30','height'=>'30',]],
            //],
            [
                'attribute'=>'thumb',
                'format' => ['image',['width'=>'140','height'=>'60',]],
            ],
            'createTime',
            'updateTime',
             //'content:ntext',
            // 'status',
            // 'stars',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
