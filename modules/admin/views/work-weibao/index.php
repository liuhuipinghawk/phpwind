<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = '维保基础数据列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?=$this->title ?></h1>
    <form class="form-inline" action="">
        <?php
        $type = empty(Yii::$app->request->get()['type']) ? '' : Yii::$app->request->get()['type'];
        $cast = empty(Yii::$app->request->get()['cast']) ? '' : Yii::$app->request->get()['cast'];
        ?>
        <div class="form-group">
            <select class="form-control" id="type" name="type">
                <option value="">电梯类别</option>
                <option value="1" <?php if($type == 1) echo 'selected';?>>直梯</option>
                <option value="2" <?php if($type == 2) echo 'selected';?>>扶梯</option>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" id="cast" name="cast">
                <option value="">维护周期</option>
                <option value="1" <?php if($cast == 1) echo 'selected';?>>半月</option>
                <option value="2" <?php if($cast == 2) echo 'selected';?>>季度</option>
                <option value="3" <?php if($cast == 3) echo 'selected';?>>半年</option>
                <option value="4" <?php if($cast == 4) echo 'selected';?>>全年</option>
            </select>
        </div>
        <button type="submit" class="btn btn-default">查询</button>
        <a href="javascript:void(0);" class="btn btn-default" onclick="location.reload();">刷新</a>
        <a href="/admin/work-weibao/add" class="btn btn-success">数据录入</a>
    </form>
    <br>
    <table class="table table-striped table-bordered" style="text-align: center;">
        <thead>
        <tr>
            <th style="text-align: center;">编号</th>
            <th style="text-align: center;">类别</th>
            <th style="text-align: center;">周期</th>
            <th style="text-align: center;">维护保养项目</th>
            <th style="text-align: center;">维护保养要求</th>
            <th style="text-align: center;">添加时间</th>
            <th style="text-align: center;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if($data):?>
            <?php foreach($data as $k => $v): ?>
                <tr>
                    <td><?= $v['id'] ?></td>
                    <td><?php
                        if($v['type'] == 1) echo '直梯';
                        elseif($v['type'] == 2) echo '扶梯';
                        ?>
                    </td>
                    <td><?php
                        if($v['cast'] == 1) echo '半月';
                        elseif($v['cast'] == 2) echo '季度';
                        elseif($v['cast'] == 3) echo '半年';
                        elseif($v['cast'] == 4) echo '全年';
                        ?>
                    </td>
                    <td><?=$v['content']?></td>
                    <td><?=$v['need']?></td>
                    <td><?php if($v['create_time']) echo date('Y-m-d H:i:s',$v['create_time']); else echo '--'; ?></td>
                    <td>
                        <a href="javascript:void(0);" class="btn_del" onclick="del(<?=$v['id']?>)">删除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif;?>
        </tbody>
    </table>
    <div class="pagination-part">
        <nav>
            <?php
            echo LinkPager::widget([
                'pagination' => $pagination,
            ]);
            ?>
        </nav>
    </div>
</div>

<script type="text/javascript">
    function del(id){
        if (confirm('确定要删除吗？')) {
            var op_id = id;
            if (op_id == undefined || op_id.length == 0) {
                alert('参数错误');return false;
            }
            $.post('/admin/work-weibao/del',{id:op_id},function(res){
                if (res.code == 200) {
                    alert(res.msg);
                    location.reload();
                } else {
                    alert(res.msg);
                    return false;
                }
            },'JSON');
        }
    }
</script>
