<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '电费月报录入';
$this->params['breadcrumbs'][] = ['label' => '电费管理月报', 'url' => ['view','id'=>$electr_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?=$this->title ?></h1>
</div>
<?php
    $time = date('Y-m-d',strtotime(date('Y-m-01')));
?>
<div class="article-form">
    <p style="color: #aa0000;"><strong>备注：电费统计必须按月份顺序添加,每个月份每年只能选择一次,如果当月没有数据,就上传0</strong></p>
    <form action="/admin/count-electr/add" method="post">
        <div class="form-group">
            <label class="control-label">电费统计月份</label>
            <input type="date" class="form-control" name="time" required="required" value="<?=$time?>">
        </div>
        <div class="form-group">
            <label class="control-label">总用电量</label>
            <input type="text" class="form-control" placeholder="" name="total" required="required">
        </div>
        <div class="form-group field-user-logintime">
            <label class="control-label">公区用电量</label>
            <input class="form-control" type="text" placeholder="" required="required" name="public">
        </div>
        <div class="form-group field-user-logintime">
            <label class="control-label">办公用电量</label>
            <input class="form-control" type="text" placeholder="" required="required" name="office">
        </div>
        <div class="form-group field-user-logintime">
            <label class="control-label">住户用电量</label>
            <input class="form-control" type="text" placeholder="" required="required" name="hold">
        </div>
        <div class="form-group field-user-logintime">
            <label class="control-label">物业自用电量</label>
            <input class="form-control" type="text" placeholder="" required="required" name="self">
        </div>
        <div class="form-group field-user-logintime">
            <label class="control-label">商业用电</label>
            <input class="form-control" type="text" placeholder="" required="required" name="shop">
        </div>
        <div class="form-group field-user-logintime">
            <label class="control-label">多种经营用电</label>
            <input class="form-control" type="text" placeholder="" required="required" name="sell">
        </div>
        <div class="form-group field-user-logintime">
            <label class="control-label">商业预存电</label>
            <input class="form-control" type="text" placeholder="" required="required" name="shop_pre">
        </div>
        <div class="form-group field-user-logintime">
            <label class="control-label">业主预存电</label>
            <input class="form-control" type="text" placeholder="" required="required" name="hold_pre">
        </div>
        <div class="form-group">
            <label class="control-label">抄表日期</label>
            <input type="date" class="form-control" name="meter_time" required="required" value="<?=$time?>">
        </div>
        <input type="hidden" value="<?=$electr_id?>" name="electr_id">
        <div class="form-group">
            <button class="btn btn-success" type="submit">提交</button>
        </div>
    </form>
</div>