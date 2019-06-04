<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Flower */

$this->title = 'Create Flower';
$this->params['breadcrumbs'][] = ['label' => 'Flowers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flower-create" style="margin-left:210px">

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
