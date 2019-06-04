<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Decoration */

$this->title = 'Update Decoration: ' . $model->deco_id;
$this->params['breadcrumbs'][] = ['label' => 'Decorations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->deco_id, 'url' => ['view', 'id' => $model->deco_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="decoration-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
