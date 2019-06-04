<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\HouseAccess */

$this->title = 'Update House Access: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'House Accesses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="house-access-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
    ]) ?>

</div>
