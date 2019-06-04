<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin\Stall */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => 'Stalls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stall-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <p style="color: red;">备注：每个项目的数据只能添加一次，如需修改请去修改页面</p>
    <br>
    <?= $this->render('_form', [
        'model' => $model,
        'data'=>$data,
    ]) ?>

</div>
