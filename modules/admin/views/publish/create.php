<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin\Publish */

$this->title = '添加房屋租赁信息';
$this->params['breadcrumbs'][] = ['label' => '房屋租赁列表', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="publish-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'house'=>$house,
        'region_id'=>$region_id,
        'subway_id'=>$subway_id,
        'decoration'=>$decoration,
        'orientation'=>$orientation,
        'house_type'=>$house_type
    ]) ?>

</div>
