<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = '电梯维保订单列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?=$this->title ?></h1>
    <form class="form-inline" action="">
        <?php
        $house_id = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
        $type = empty(Yii::$app->request->get()['type']) ? '' : Yii::$app->request->get()['type'];
        $cast = empty(Yii::$app->request->get()['cast']) ? '' : Yii::$app->request->get()['cast'];
        ?>
        <div class="form-group">
            <select class="form-control" id="house_id" name="house_id">
                <option value="">选择楼盘</option>
                <?php if ($house) : ?>
                    <?php foreach($house as $k => $v): ?>
                        <option value="<?=$v['id']?>" <?php if($v['id'] == $house_id) echo 'selected'; ?>><?=$v['housename']?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control" id="type" name="type">
                <option value="">选择电梯类型</option>
                <option value="1" <?php if(1 == $type) echo 'selected'; ?>>电梯</option>
                <option value="2" <?php if(2 == $type) echo 'selected'; ?>>扶梯</option>
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
    </form>
    <br>
    <table class="table table-striped table-bordered" style="text-align: center;">
        <thead>
        <tr>
            <th style="text-align: center;">订单id</th>
            <th style="text-align: center;">电梯名称</th>
            <th style="text-align: center;">所属项目</th>
            <th style="text-align: center;">电梯类型</th>
            <th style="text-align: center;">生成订时间</th>
            <th style="text-align: center;">订单状态</th>
            <th style="text-align: center;">维保人</th>
            <th style="text-align: center;">维保周期</th>
            <th style="text-align: center;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if($data):?>
            <?php foreach($data as $k => $v): ?>
                <tr>
                    <td><?= $v['id'] ?></td>
                    <td><?= $v['name'] ?></td>
                    <td><?=$v['housename']?></td>
                    <td><?php if($v['type'] == 1) echo '电梯'; else echo '扶梯';?></td>
                    <td><?php if($v['create_time']) echo date('Y-m-d H:i:s',$v['create_time']); else echo '--'; ?></td>
                    <td>
                        <?php
                        if($v['status'] == 1) echo '未派单';
                        elseif($v['status'] == 2) echo '已派单';
                        elseif($v['status'] == 3) echo '已接单';
                        elseif($v['status'] == 4) echo '维保完成';
                        elseif($v['status'] == 5) echo '审核通过';
                        ?>
                    </td>
                    <td><?=$v['TrueName']?$v['TrueName']:'--'?></td>
                    <td><?php
                        if($v['cast'] == 1) echo '半月';
                        elseif($v['cast'] == 2) echo '季度';
                        elseif($v['cast'] == 3) echo '半年';
                        elseif($v['cast'] == 4) echo '全年';
                        ?>
                    </td>
                    <td>
                        <?php if($v['status'] == 1): ?>
                        <a href="single?op_id=<?=$v['id']?>" title="派单" id="btn_add" class="btn btn-success">派单</a>&nbsp;&nbsp;
                        <a href="javascript:void(0);" class="btn_del btn btn-danger" onclick="del(<?=$v['id']?>)">删除</a>
                        <?php endif; ?>
                        <?php if($v['status'] == 4): ?>
                            <a href="javascript:void(0);" class="btn_del btn btn-danger" onclick="audit(<?=$v['id']?>)">审核</a>
                        <?php endif; ?>
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
<?=Html::jsFile('@web/js/jquery-1.12.4.js')?>
<script type="text/javascript">
    function del(id){
        if (confirm('确定要删除吗？')) {
            var op_id = id;
            if (op_id == undefined || op_id.length == 0) {
                alert('参数错误');return false;
            }
            $.post('/admin/work-order/del',{id:op_id},function(res){
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
    function audit(id){
        if (confirm('确定要审核吗？')) {
            var op_id = id;
            if (op_id == undefined || op_id.length == 0) {
                alert('参数错误');return false;
            }
            $.post('/admin/work-order/del',{id:op_id},function(res){
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
