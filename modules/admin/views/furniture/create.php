<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Furniture */

$this->title = '添加办公家具';
$this->params['breadcrumbs'][] = ['label' => 'Furnitures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="furniture-create" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
    ]) ?>

</div>
