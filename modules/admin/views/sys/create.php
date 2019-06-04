<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin\UserPosition */

$this->title = '添加用户基础信息';
$this->params['breadcrumbs'][] = ['label' => '用户基础信息', 'url' => ['sys/user-base']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-position-create" style="margin-left: 210px;">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'user_type'=>$user_type,
        'house'=>$house,
        'position'=>$position,
        'post'=>$post
    ]) ?>
</div>
