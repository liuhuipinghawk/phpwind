<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Equipment */

$this->title = '添加办公设备信息';
$this->params['breadcrumbs'][] = ['label' => 'Equipments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipment-create" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data,
        'house'=>$house,
    ]) ?>

</div>
