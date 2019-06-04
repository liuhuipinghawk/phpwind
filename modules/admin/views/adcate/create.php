<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin\Adcate */

$this->title = '添加广告分类';
$this->params['breadcrumbs'][] = ['label' => '广告分类', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adcate-create" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
    ]) ?>

</div>
