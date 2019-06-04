<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin\CountWater */

$this->title = '项目数据添加';
$this->params['breadcrumbs'][] = ['label' => '项目水费管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="count-water-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
    ]) ?>

</div>
