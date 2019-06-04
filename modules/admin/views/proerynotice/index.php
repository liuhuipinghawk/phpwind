<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = '物业通知管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::jsFile('/js/jquery-1.12.4.js')?>

<div>
    <h1><?=$this->title ?></h1>
    <br>
    <form class="form-inline" action="/admin/proerynotice/index">
        <?php
        $house_id = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
        ?>
        <div class="form-group">
            <select class="form-control" id="house_id" name="house_id">
                <option value="">选择楼座</option>
                <?php foreach ($house as $k => $v): ?>
                    <option value="<?=$v['id']?>" <?php if ($v['id'] == $house_id) echo 'selected'; ?>><?=$v['housename']?></option>
                <?php endforeach ?>
            </select>
        </div>
        <button type="submit" class="btn btn-default">查询</button>
        <a href="/admin/proerynotice/add" class="btn btn-success" style="margin-left: 10px;">发布公告</a>
    </form>
    <br>
    <br>
    <table class="table table-striped table-bordered" style="text-align: center;">
        <thead>
        <tr>
            <th style="text-align: center;">标题</th>
            <th style="text-align: center;">发布人</th>
            <th style="text-align: center;">项目名称</th>
            <th style="text-align: center;">发布时间</th>
            <th style="text-align: center;">内容</th>
            <th style="text-align: center;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if($data):?>
            <?php foreach($data as $k => $v): ?>
                <tr style="table-layout:fixed;">
                    <td><?=$v['title'] ?></td>
                    <td><?=$v['author'] ?></td>
                    <td><?=$v['housename'] ?></td>
                    <td><?=$v['createTime'] ?></td>
                    <td><?=$v['content'] ?></td>
                    <td>
                        <a href="javascript:void(0);" class="btn_del" data-id="<?=$v['pNoticeId']?>" style="color: red;">删除</a>
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
    $(function() {
        $('.btn_del').click(function () {
            if (confirm('确定要删除吗？')) {
                var op_id = $(this).data('id');
                if (op_id == undefined || op_id.length == 0) {
                    alert('参数错误');
                    return false;
                }
                $.post('/index.php?r=admin/proerynotice/del', {op_id: op_id}, function (res) {
                    if (res.code == 200) {
                        alert(res.msg);
                        location.reload();
                    } else {
                        alert(res.msg);
                        return false;
                    }
                }, 'JSON');
            }
        });
    })
</script>