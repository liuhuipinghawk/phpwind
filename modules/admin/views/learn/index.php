<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\LearnSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '学习园地';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learn-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加内容', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'status',
            'title',
            'content:ntext',
            [
                'attribute'=>'image',
                'format' => ['image',['width'=>'140','height'=>'60',]],
            ],
            ['class' => 'yii\grid\ActionColumn','header'=>'操作','template' => '{add} {view} {update} {delete}',
                'buttons' => [
                    'add' => function ($model,$key) {
                        return  Html::a('<span onclick="status('.$key->id.')" class="btn btn-success">置顶</span>','#', ['title' => '置顶'] ) ;
                    },
                ],
                'headerOptions' => ['width' => '180']
            ],
        ],
    ]);?>
</div>
<script>
    function status(id){
        if (id == undefined || id.length == 0) {
            alert('类型名称不能为空');return false;
        }
        $.ajax({
            type:'post',
            dataType:'json',
            url:'/admin/learn/status',
            data:{
                id:id
            },
            success:function(res){
                if (res.code == 200) {
                    alert(res.msg);
                    location.href = '/admin/learn/index';
                } else {
                    alert(res.msg);return false;
                }
            }
        });
    }
</script>
