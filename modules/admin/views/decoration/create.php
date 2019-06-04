<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin\Decoration */

$this->title = 'Create Decoration';
$this->params['breadcrumbs'][] = ['label' => 'Decorations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="decoration-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
