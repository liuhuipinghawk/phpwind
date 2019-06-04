<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin\House */

$this->title = '添加维修类型';
$this->params['breadcrumbs'][] = ['label' => '维修类型列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="house-create" style="margin-left: 210px;">   

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
    ]) ?>

</div>
