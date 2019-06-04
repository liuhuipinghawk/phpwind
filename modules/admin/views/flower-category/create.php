<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FlowerCategory */

$this->title = 'Create Flower Category';
$this->params['breadcrumbs'][] = ['label' => 'Flower Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flower-category-create" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
    ]) ?>

</div>
