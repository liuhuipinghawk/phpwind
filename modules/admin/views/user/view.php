<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Admin\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view" style="margin-left: 210px;">  

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
            'Tell',
            'PassWord',
            'CreateTime',
            'UpdateTime',
            'LoginTime',
            'HeaderImg',
            'NickName',
            'Email:email',
            'TrueName',
            'HouseId',
            'Seat',
            'Address',
            'IdCard',
            'IdCardOver',
            'WorkCard',
            'Company',
            'Status',
            'Cases',
            'Department',
            'Position',
            'Maintenancetype',
        ],
    ]) ?>

</div>