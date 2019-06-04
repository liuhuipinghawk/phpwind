<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = '意见反馈';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::jsFile('/js/jquery-1.12.4.js')?>

<div>
    <h1><?=$this->title ?></h1>
    <br>
    <br>
    <table class="table table-striped table-bordered" style="text-align: center;">
        <thead>
        <tr>
            <th style="text-align: center;">标题</th>
            <th style="text-align: center;">发布人</th>
            <th style="text-align: center;">项目</th>
            <th style="text-align: center;">电话</th>
            <th style="text-align: center;">类型</th>
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
                    <td><?=$v['TrueName'] ?></td>
                    <td><?=$v['housename'] ?></td>
                    <td><?=$v['Tell'] ?></td>
                    <td><?php
                        if($v['type'] == 1) echo '投诉';
                        elseif($v['type'] == 2) echo '建议';
                        elseif($v['type'] == 3) echo '意见反馈';
                        ?></td>
                    <td><?php if($v['create_time']) echo date('Y-m-d H:i:s',$v['create_time']); else echo '--'; ?></td>
                    <td><?=$v['suggestionContent'] ?></td>
                    <td>
<!--                        <a href="javascript:void(0);" class="btn_del" data-id="--><?//=$v['suggestionId']?><!--" style="color: red;">删除</a>-->
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
                $.post('/index.php?r=admin/suggestion/del', {op_id: op_id}, function (res) {
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