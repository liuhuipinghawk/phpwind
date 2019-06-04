<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin\Learn */

$this->title = '添加内容';
$this->params['breadcrumbs'][] = ['label' => '学习园地', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learn-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'type'=>$type,
    ]) ?>

</div>
