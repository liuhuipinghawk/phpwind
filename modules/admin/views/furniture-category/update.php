<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FurnitureCategory */

$this->title = 'Update Furniture Category: ' . $model->category_id;
$this->params['breadcrumbs'][] = ['label' => 'Furniture Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->category_id, 'url' => ['view', 'id' => $model->category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="furniture-category-update" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
    ]) ?>

</div>
