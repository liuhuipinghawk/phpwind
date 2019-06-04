<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin\Subway */

$this->title = 'Create Subway';
$this->params['breadcrumbs'][] = ['label' => 'Subways', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subway-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'cate'=>$cate
    ]) ?>

</div>
