<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EquipmentCategory */

$this->title = 'Create Equipment Category';
$this->params['breadcrumbs'][] = ['label' => 'Equipment Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipment-category-create" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data,
    ]) ?>

</div>
