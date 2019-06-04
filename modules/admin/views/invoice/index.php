<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = '发票信息管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<div>
    <h1><?=$this->title ?></h1>
    <br>
    <form class="form-inline" action="/admin/invoice/index">
        <?php
            $title = empty(Yii::$app->request->get()['title']) ? '' : Yii::$app->request->get()['title'];
            $mobile = empty(Yii::$app->request->get()['mobile']) ? '' : Yii::$app->request->get()['mobile'];
        ?>
        <div class="form-group">
            <input type="text" class="form-control" id="title" name="title" placeholder="请输入名称" value="<?=$title?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="请输入手机号" value="<?=$mobile?>">
        </div>
        <div class="form-group">
            <select class="form-control" id="type" name="type">
                <option value="">选择发票类型</option>
                <option value="1">增值税普通发票</option>
                <option value="2">增值税专用发票</option>
            </select>
        </div>
        <button type="submit" class="btn btn-default">查询</button>
    </form>
    <br>
<br>
<table class="table table-striped table-bordered" style="text-align: center;">
    <thead>
    <tr>
        <th style="text-align: center;">ID</th>
        <th style="text-align: center;">名称</th>
        <th style="text-align: center;">添加人</th>
        <th style="text-align: center;">手机号</th>
        <th style="text-align: center;">纳税人识别号</th>
        <th style="text-align: center;">座机电话</th>
        <th style="text-align: center;">地址</th>
        <th style="text-align: center;">开户银行</th>
        <th style="text-align: center;">开户账号</th>
        <th style="text-align: center;">发票类型</th>
        <th style="text-align: center;">添加时间</th>
        <th style="text-align: center;">操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if($data):?>
        <?php foreach($data as $k => $v): ?>
            <tr>
                <td><?=$v['id'] ?></td>
                <td><?=$v['title'] ?></td>
                <td><?=$v['TrueName'] ?></td>
                <td><?=$v['mobile'] ?></td>
                <td><?=$v['number'] ?></td>
                <td><?=$v['tell'] ?></td>
                <td><?=$v['address'] ?></td>
                <td><?=$v['bank'] ?></td>
                <td><?=$v['account_nub'] ?></td>
                <td><?php if ($v['type']==1){
                        echo '增值税普通发票';
                    }elseif($v['type']==2){
                        echo '增值税专用发票';
                    }else{
                        echo '--';
                    } ?></td>
                <td><?=date('Y-m-d',$v['create_time']) ?></td>
                <td>
                    <a href="javascript:void(0);" class="btn_del" data-id="<?=$v['id']?>">删除</a>
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
    $(function(){
        $('.btn_del').click(function(){
            if (confirm('确定要删除吗？')) {
                var op_id = $(this).data('id');
                if (op_id == undefined || op_id.length == 0) {
                    alert('参数错误');return false;
                }
                $.post('/index.php?r=admin/invoice/del',{op_id:op_id},function(res){
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
    });
</script>