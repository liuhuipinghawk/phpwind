<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Admin\VersionUpgrade */

$this->title = 'Create Version Upgrade';
$this->params['breadcrumbs'][] = ['label' => 'Version Upgrades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="version-upgrade-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data,
    ]) ?>

</div>
