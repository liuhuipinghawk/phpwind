<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\VersionUpgradeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Version Upgrades';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="version-upgrade-index" style=" margin-left:210px;">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Version Upgrade', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'app_id',
            'version_code',
            'type',
            'apk_url:url',
            // 'upgrade_point',
            // 'status',
            // 'create_time:datetime',
            // 'update_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
