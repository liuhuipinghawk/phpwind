<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Flower */

$this->title = 'Update Flower: ' . $model->flower_id;
$this->params['breadcrumbs'][] = ['label' => 'Flowers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->flower_id, 'url' => ['view', 'id' => $model->flower_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="flower-update" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
        'plants'=>$plants,
        'pot'=>$pot,
        'implication'=>$implication,
        'area'=>$area,
        'position'=>$position,
        'house'=>$house,
    ]) ?>

</div>
