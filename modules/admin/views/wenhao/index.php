<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = '文号列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?=$this->title ?></h1>
    <form class="form-inline" action="">
        <?php
        $house_id = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
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
        <button type="submit" class="btn btn-default">查询</button>
        <a href="javascript:void(0);" class="btn btn-default" onclick="location.reload();">刷新</a>
    </form>
    <br>
    <table class="table table-striped table-bordered" style="text-align: center;">
        <thead>
        <tr>
            <th style="text-align: center;">文号编号</th>
            <th style="text-align: center;">申请人</th>
            <th style="text-align: center;">项目名称</th>
            <th style="text-align: center;">部门名称</th>
            <th style="text-align: center;">岗位名称</th>
            <th style="text-align: center;">标题</th>
            <th style="text-align: center;">申请时间</th>
            <th style="text-align: center;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if($data):?>
            <?php foreach($data as $k => $v): ?>
                <tr>
                    <td><?= $v['id'] ?></td>
                    <td><?=$v['name'] ?></td>
                    <td><?=$v['cases']?></td>
                    <td><?=$v['department']?></td>
                    <td><?=$v['position']?></td>
                    <td><?=$v['title']?></td>
                    <td><?php if($v['time']) echo date('Y-m-d H:i:s',$v['time']); else echo '--'; ?></td>
                    <td>
                    <?php if ($group_id == 1): ?>
                        <a href="javascript:void(0);" class="btn_del" onclick="del(<?=$v['id']?>)">删除</a>
                    <?php endif ?>
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
            $.post('/admin/wenhao/del',{id:op_id},function(res){
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
