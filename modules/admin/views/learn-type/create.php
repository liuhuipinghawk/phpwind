<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin\LearnType */

$this->title = 'Create Learn Type';
$this->params['breadcrumbs'][] = ['label' => 'Learn Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="learn-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
