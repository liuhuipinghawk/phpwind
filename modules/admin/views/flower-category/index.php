<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FlowerCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Flower Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flower-category-index" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
    if(Yii::$app->getSession()->hasFlash('error')){
        echo Alert::widget([
            'options' => [
                'class' => 'alert-success', //这里是提示框的class
            ],
            'body' => Yii::$app->getSession()->getFlash('error'), //消息体
        ]);
    }
    ?>
    <p>
        <?= Html::a('Create Flower Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table class="table table-striped table-bordered">
        <tr>
            <th>分类ID</th>
            <th>分类名称</th>
            <th>添加时间</th>
            <th>修改时间</th>
            <th>操作</th>
        </tr>
        <?php foreach ($catelist as $val){ ?>
            <tr>
                <td><?php echo $val['category_id']; ?></td>
                <td><?php echo $val['category_name'];  ?></td>
                <td><?php echo date('Y-m-d H:i:s',$val['create_time']);  ?></td>
                <td><?php echo date('Y-m-d H:i:s',$val['update_time']);  ?></td>
                <td>&nbsp<a href="<?php echo \yii\helpers\Url::to(['equipment-category/view','id'=>$val['category_id']]); ?>">查看</a>&nbsp;&nbsp;<a href="<?php echo \yii\helpers\Url::to(['equipment-category/update','id'=>$val['category_id']]); ?>">更新</a>&nbsp;&nbsp;<a href="<?php echo \yii\helpers\Url::to(['equipment-category/delete','id'=>$val['category_id']]) ?>">删除</a> </td>
            </tr>
        <?php  } ?>
    </table>
</div>
