<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CleanService */

$this->title = '添加室内保洁服务';
$this->params['breadcrumbs'][] = ['label' => 'Clean Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="添加室内保洁服务" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
    ]) ?>

</div>
