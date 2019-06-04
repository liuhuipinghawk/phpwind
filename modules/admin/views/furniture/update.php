<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Furniture */

$this->title = 'Update Furniture: ' . $model->furniture_id;
$this->params['breadcrumbs'][] = ['label' => 'Furnitures', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->furniture_id, 'url' => ['view', 'id' => $model->furniture_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="furniture-update" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
    ]) ?>

</div>
