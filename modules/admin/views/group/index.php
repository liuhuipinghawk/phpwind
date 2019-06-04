<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\admin\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '角色列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('添加角色', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'description',
            [
              'class'=>'yii\grid\ActionColumn',
                'header'=>'操作',
                'template'=>'{view} {update} {get-role} {update-role} {delete-role}',
                'buttons'=>[
                    'get-role'=> function($url,$model,$key){
                     return Html::a('分配权限',$url,['title'=>'分配权限']);
                    },
                    // 'update-role'=> function($url,$model,$key){
                    //     return Html::a('修改权限',$url,['title'=>'修改权限']);
                    // },
                    // 'delete-role'=> function($url,$model,$key){
                    //     return Html::a('删除权限',$url,['title'=>'删除权限']);
                    // }
                ],
            ],
            //['class' => 'yii\grid\ActionColumn','header'=>'操作','template' => '{view}{update}{delete}{add1}'],
        ],
    ]);
    
    ?>
</div>
