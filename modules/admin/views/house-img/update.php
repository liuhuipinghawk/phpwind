<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\HouseImg */

$this->title = 'Update House Img: ' . $model->img_id;
$this->params['breadcrumbs'][] = ['label' => 'House Imgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->img_id, 'url' => ['view', 'id' => $model->img_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="house-img-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
