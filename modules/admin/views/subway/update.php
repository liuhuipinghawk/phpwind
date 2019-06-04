<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Subway */

$this->title = 'Update Subway: ' . $model->subway_id;
$this->params['breadcrumbs'][] = ['label' => 'Subways', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->subway_id, 'url' => ['view', 'id' => $model->subway_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="subway-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'cate'=>$cate
    ]) ?>

</div>
