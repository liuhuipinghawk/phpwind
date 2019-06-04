<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '车位日报录入';
$this->params['breadcrumbs'][] = ['label' => '车位管理日报', 'url' => ['view','id'=>$stall_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?=$this->title ?></h1>
</div>
<div class="article-form">
    <p style="color: red;">备注：日报每个项目每日只能录入一次</p>
    <form action="/admin/stall/add" method="post">
        <div class="form-group">
            <label class="control-label">今日售出车位</label>
            <input type="text" class="form-control" placeholder="" name="sold" required="required">
        </div>
        <div class="form-group field-user-logintime">
            <label class="control-label">今日出租车位</label>
            <input class="form-control" type="text" placeholder="" required="required" name="rent">
        </div>
        <div class="form-group field-user-logintime">
            <label class="control-label">今日其他车位</label>
            <input class="form-control" type="text" placeholder="" required="required" name="other">
        </div>
        <input type="hidden" value="<?=$stall_id?>" name="stall_id">
        <div class="form-group">
            <button class="btn btn-success" type="submit">提交</button>
        </div>
    </form>
</div>