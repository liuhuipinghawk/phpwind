<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\UserPosition */

$this->title = '更新用户职位: ' . $model->position_id;
$this->params['breadcrumbs'][] = ['label' => 'User Positions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->position_id, 'url' => ['view', 'id' => $model->position_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-position-update" style="margin-left: 210px;">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
