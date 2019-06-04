<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CleanService */

$this->title = 'Update Clean Service: ' . $model->clean_id;
$this->params['breadcrumbs'][] = ['label' => 'Clean Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->clean_id, 'url' => ['view', 'id' => $model->clean_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="clean-service-update" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
    ]) ?>

</div>
