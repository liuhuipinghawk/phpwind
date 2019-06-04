<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index" style="margin-left: 210px;">   

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'Tell',     
			'NickName', 
			'TrueName',
            'CreateTime',  
            'UpdateTime', 
            // 'LoginTime',
            // 'HeaderImg',
            // 'Email:email',
            // 'HouseId',
            // 'Seat',
            // 'Address',
            // 'IdCard',
            // 'IdCardOver',
            // 'WorkCard',
            // 'Company',
            // 'Status',
            // 'Cases',
            // 'Department',
            // 'Position',
            // 'Maintenancetype',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
