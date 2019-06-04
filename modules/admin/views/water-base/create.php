<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\WaterBase */

$this->title = '添加水费基础信息';
$this->params['breadcrumbs'][] = ['label' => '水费基础信息', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="water-base-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'house'=> $house,
    ]) ?>

</div>
