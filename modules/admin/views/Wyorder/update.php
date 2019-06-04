<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\WyOrder */

$this->title = 'Update Wy Order: ' . $model->wyorderId;
$this->params['breadcrumbs'][] = ['label' => 'Wy Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->wyorderId, 'url' => ['view', 'id' => $model->wyorderId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wy-order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
