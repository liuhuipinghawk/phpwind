<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\AdcateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '广告分类';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adcate-index" style="margin-left:210px">

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
        <?= Html::a('添加广告分类', ['create'], ['class' => 'btn btn-success']) ?>
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
                <td><?php echo $val['adCateId']; ?></td>
                <td><?php echo $val['adCateName'];  ?></td>
                <td><?php echo date('Y-m-d H:i:s',$val['createTime']);  ?></td>
                <td><?php echo date('Y-m-d H:i:s',$val['updateTime']);  ?></td>
                <td>&nbsp<a href="<?php echo \yii\helpers\Url::to(['adcate/view','id'=>$val['adCateId']]); ?>">查看</a>&nbsp;&nbsp;<a href="<?php echo \yii\helpers\Url::to(['adcate/update','id'=>$val['adCateId']]); ?>">更新</a>&nbsp;&nbsp;<a href="<?php echo \yii\helpers\Url::to(['adcate/delete','id'=>$val['adCateId']]) ?>">删除</a> </td>
            </tr>
        <?php  } ?>
    </table>
</div>
