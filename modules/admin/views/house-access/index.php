<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\HouseAccessSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'House Accesses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="house-access-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加楼盘增值服务权限', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div style="color: red;">
        <strong><p>楼盘序号对应楼盘名称</p></strong>
    <?php
        $m = new \app\models\Admin\House();
        $data = $m->find()->where(['parentId'=>0])->asArray()->all();
        foreach ($data as $val){
    ?>
        <tr>
            <td><?php echo $val['id']; ?></td>
            <td><?php echo $val['housename']; ?>；</td>
        </tr>
    <?php  } ?>
    </div>
    <br>
    <div style="color: red;">
        <strong><p>增值服务序号对应名称</p></strong>
            <tr>
                <td>1：绿植租赁；2：办公设备；3：洗衣服务；4：公司注册；5：直饮水；6：室内保洁；7：洗车服务；8：3D看房;9：酒店；10：美食；11：办公家具；12：礼品定制；13：装饰设计；14：代理记账；15：宣传服务</td>
            </tr>
    </div>
    <br>
    <div style="color: red;">
        <strong><p>首页图标对应名称</p></strong>
        <tr>
            <td>1：自助开门；2：访客预约；3：停车缴费；4：生活缴费；5：物业公告；6：报检保修；7：房屋租赁；8：兴业有道；9：遗失登记；10：房屋委托；11：车位租赁</td>
        </tr>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'house_id',
            'access',
            'home',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
