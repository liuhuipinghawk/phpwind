<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\WaterPayment */

$this->title = 'Create Water Payment';
$this->params['breadcrumbs'][] = ['label' => 'Water Payments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="water-payment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
