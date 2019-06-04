<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\app\assets\AppAsset::register($this);
$this->title = '系统管理员权限管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index" style="margin-left:210px">
    <h1><?= Html::encode($this->title) ?></h1>
    <form class="form-inline" action="">
        <?php
        $adminuser = empty(Yii::$app->request->get()['adminuser']) ? '' : Yii::$app->request->get()['adminuser'];
        $adminemail = empty(Yii::$app->request->get()['adminemail']) ? '' : Yii::$app->request->get()['adminemail'];
        ?>
        <div class="form-group">
            <input type="text" class="form-control" id="adminuser" name="adminuser" placeholder="请输入真实姓名" value="<?php echo $adminuser;?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="adminemail" name="adminemail" placeholder="请输入邮箱" value="<?php echo $adminemail; ?>">
        </div>
        <button type="submit" class="btn btn-default">查询</button>
    </form>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <table class="table table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>真实姓名</th>
            <th>邮箱</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        <?php foreach ($model as $val){ ?>
            <tr>
                <td><?php echo $val['adminid']; ?></td>
                <td><?php echo $val['adminuser'];  ?></td>
                <td><?php echo $val['adminemail'];  ?></td>
                <td><?php echo $val['createtime'];  ?></td>
                <td><a href="<?php echo \yii\helpers\Url::to(['role-permission/role-create','id'=>$val['adminid']]) ?>">添加用户角色</a>&nbsp;<a href="<?php echo \yii\helpers\Url::to(['role-permission/permission-create','id'=>$val['adminid']]) ?>">添加用户权限</a></td>
            </tr>
        <?php  } ?>
    </table>
    <?= LinkPager::widget(['pagination' => $pages]); ?>
</div>
<?=Html::jsFile('@web/js/jquery-1.12.4.js')?>