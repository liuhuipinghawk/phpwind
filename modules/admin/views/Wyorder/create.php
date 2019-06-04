<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin\WyOrder */

$this->title = 'Create Wy Order';
$this->params['breadcrumbs'][] = ['label' => 'Wy Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wy-order-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
