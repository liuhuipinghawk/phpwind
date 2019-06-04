<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin\UserPost */

$this->title = '添加用户岗位';
$this->params['breadcrumbs'][] = ['label' => 'User Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-post-create" style="margin-left: 210px;">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
