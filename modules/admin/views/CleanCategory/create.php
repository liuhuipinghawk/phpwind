<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CleanCategory */

$this->title = 'Create Clean Category';
$this->params['breadcrumbs'][] = ['label' => 'Clean Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clean-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
