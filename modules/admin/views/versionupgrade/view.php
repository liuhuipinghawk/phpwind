<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\VersionUpgrade */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Version Upgrades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="version-upgrade-view" style=" margin-left:210px;">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'app_id',
            'version_code',
            'type',
            'apk_url:url',
            'upgrade_point',
            'status',
            'create_time:datetime',
            'update_time:datetime',
        ],
    ]) ?>

</div>
