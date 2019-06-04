<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\bootstrap\Alert;
use app\models\Admin\Certification;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '闸机黑名单管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Html::jsFile('/layui/layui.js')?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <form class="form-inline" action="">
        <?php
        $Tell = empty(Yii::$app->request->get()['phone']) ? '' : Yii::$app->request->get()['phone'];
        $remark = empty(Yii::$app->request->get()['remark']) ? '' : Yii::$app->request->get()['remark'];
        $house_id = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
        ?>
        <div class="form-group">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="请输入手机号" value="<?php echo $Tell;?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="remark" name="remark" placeholder="请输入备注" value="<?php echo $remark; ?>">
        </div>
        <div class="form-group">
            <select class="form-control" id="house_id" name="house_id">
                <?php if($house):?>
                    <option value ="">请选择项目</option>
                    <?php foreach($house as $k => $v): ?>
                        <option value ="<?=$v['id'] ?>" <?php if($v['id'] == $house_id) echo 'selected';?>><?=$v['housename'] ?></option>
                    <?php endforeach; ?>
                <?php endif;?>
            </select>
        </div>
        <button type="submit" class="btn btn-default">查询</button>
    </form><br>
    <p>
        <a href="javascript:void(0);" id="btn_add" class="btn btn-success">添加黑名单</a>
    </p>
    <br>
    <table class="table table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>手机号</th>
            <th>项目名称</th>
            <th>备注</th>
            <th>添加时间</th>
            <th>操作</th>
        </tr>
        <?php if ($list): ?>
            <?php foreach ($list as $k => $v): ?>
                <tr>
                    <td><?=$v['id']?></td>
                    <td><?=$v['phone']?></td>
                    <td><?=$v['housename']?></td>
                    <td><?=$v['remark']?></td>
                    <td><?php if($v['add_time']) echo date('Y-m-d H:i:s',$v['add_time']); else echo '--'; ?></td>
                    <td>
                        <a href="javascript:void(0);" class="btn_del" data-id="<?=$v['id']?>">删除</a>
                    </td>
                </tr>
            <?php endforeach ?>
        <?php endif ?>    
    </table>
    <div class="pagination-part">
        <nav>
            <?php
            echo LinkPager::widget([
                'pagination' => $pagination,
                'nextPageLabel' => '下一页',
                'prevPageLabel' => '上一页',
                'firstPageLabel' => '首页',
                'lastPageLabel' => '尾页',
            ]);
            ?>
        </nav>
    </div>
</div>

<script type="text/javascript" src="/js/jquery-1.12.4.js"></script>
<script type="text/javascript">
    //layer新增、修改弹出层
    layui.use('layer', function(){
        var layer = layui.layer;
        //添加/修改
        $('#btn_add,.btn_update').click(function(){
            layer.open({
                type:2,
                content:'/index.php?r=admin/blacklist/add',
                area:['500px','350px']
            });
        });
    });
    //删除
    $('.btn_del').click(function(){
        if (confirm('确定要删除吗？')) {
            var op_id = $(this).data('id');
            if (op_id == undefined || op_id.length == 0) {
                alert('参数错误');return false;
            }
            $.post('/index.php?r=admin/blacklist/ajax-del',{op_id:op_id},function(res){
                if (res.code == 200) {
                    alert(res.msg);
                    location.reload();
                } else {
                    alert(res.msg);
                    return false;
                }
            },'JSON');
        }
    });
</script>