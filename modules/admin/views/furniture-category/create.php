<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FurnitureCategory */

$this->title = '添加办公家具分类';
$this->params['breadcrumbs'][] = ['label' => 'Furniture Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="furniture-category-create" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
    ]) ?>

</div>
