<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin\usercate */

$this->title = 'Create Usercate';
$this->params['breadcrumbs'][] = ['label' => 'Usercates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usercate-create" style="margin-left: 210px;">   

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
