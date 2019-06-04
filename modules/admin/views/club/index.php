<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '企业入驻管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index" style="margin-left:210px">

    <h1><?= Html::encode($this->title) ?></h1>
    <form class="form-inline" action="">
        <?php
        $Tell = empty(Yii::$app->request->get()['mobile']) ? '' : Yii::$app->request->get()['mobile'];
        $TrueName = empty(Yii::$app->request->get()['name']) ? '' : Yii::$app->request->get()['name'];
        $Company = empty(Yii::$app->request->get()['company']) ? '' : Yii::$app->request->get()['company'];
        $Status      = empty(Yii::$app->request->get()['status']) ? 0 : Yii::$app->request->get()['status'];
        ?>
        <div class="form-group">
            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="请输入手机号" value="<?php echo $Tell;?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="name" name="name" placeholder="请输入真实姓名" value="<?php echo $TrueName; ?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="company" name="company" placeholder="请输入公司名称" value="<?php echo $Company; ?>">
        </div>
        <div class="form-group">
            <select class="form-control" name="status" id="status">
                <option value="0">请选择状态</option>
                <option value="1" <?php if($Status == 1) echo 'selected';?>>审核中...</option>
                <option value="2" <?php if($Status == 2) echo 'selected';?>>实名信息审核完成！</option>
            </select>
        </div>
        <button type="submit" class="btn btn-default">查询</button>
    </form>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
    if(Yii::$app->getSession()->hasFlash('success')){
        echo Alert::widget([
            'options' => [
                'class' => 'alert-success', //这里是提示框的class
            ],
            'body' => Yii::$app->getSession()->getFlash('success'), //消息体
        ]);
    }else if(Yii::$app->getSession()->hasFlash('error')){
        echo Alert::widget([
            'options' => [
                'class' => 'alert-error', //这里是提示框的class
            ],
            'body' => Yii::$app->getSession()->getFlash('error'), //消息体
        ]);
    }
    ?>
    <table class="table table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>手机号</th>
            <th>真实姓名</th>
            <th>公司名称</th>
            <th>logo</th>
            <th>添加时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <?php foreach ($model as $val){ ?>
            <tr>
                <td><?php echo $val['id']; ?></td>
                <td><?php echo $val['mobile'];  ?></td>
                <td><?php echo $val['name'];  ?></td>
                <td><?php echo $val['company']; ?></td>
                <td><img src="<?php echo $val['image']; ?>" style="width: 140px;height: 60px;"></td>
                <td><?php echo $val['create_time']; ?></td>
                <td><?php if($val['status']==1){ ?>
                        <?php echo "<font color='green'>审核中...</font>"; ?>
                    <?php }else if($val['status']==2){?>
                        <?php echo "<font color='red'>信息审核完成！</font>"; ?>
                    <?php } ?>
                </td>
                <td>
                    <?php if($val['status']==1){ ?>
                        <a href="<?php echo \yii\helpers\Url::to(['club/status','id'=>$val['id']]) ?>"><?php echo "<font color='green'>认证通过</font>";?></a>
                        <a href="<?php echo \yii\helpers\Url::to(['club/edit','id'=>$val['id']]) ?>"><?php echo "<font color='green'>编辑</font>";?></a>
                    <?php }else if($val['status']==2){?>
                        <a href="<?php echo \yii\helpers\Url::to(['club/status','id'=>$val['id']]) ?>"><?php echo "<font color='red'>取消认证</font>";?></a>
                    <?php } ?>
                </td>
            </tr>
        <?php  } ?>
    </table>
    <?= LinkPager::widget(['pagination' => $pages]); ?>
</div>