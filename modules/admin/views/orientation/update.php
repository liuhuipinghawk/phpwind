<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Orientation */

$this->title = 'Update Orientation: ' . $model->orien_id;
$this->params['breadcrumbs'][] = ['label' => 'Orientations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->orien_id, 'url' => ['view', 'id' => $model->orien_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="orientation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
