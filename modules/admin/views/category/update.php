<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Category */

$this->title = 'Update Category: ' . $model->categoryId;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->categoryId, 'url' => ['view', 'id' => $model->categoryId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data' =>$data,
    ]) ?>

</div>
