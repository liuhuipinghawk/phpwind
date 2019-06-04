<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Adcate */

$this->title = '更新广告分类: ' . $model->adCateId;
$this->params['breadcrumbs'][] = ['label' => '广告分类', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->adCateId, 'url' => ['view', 'id' => $model->adCateId]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="adcate-update" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
    ]) ?>

</div>
