<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Learn */

$this->title = '修改: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '学习园地', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="learn-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'type'=>$type,
    ]) ?>

</div>
