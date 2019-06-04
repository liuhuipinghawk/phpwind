<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\Admin */

$this->title = '更新管理员: ' . $model->adminid;
$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->adminid, 'url' => ['view', 'id' => $model->adminid]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="admin-update" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'house' => $house,
        'group' => $group
    ]) ?>

</div>
