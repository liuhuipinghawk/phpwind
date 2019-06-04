<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = '出入管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/layui/layui.js')?>
<div>
    <h1><?=$this->title ?></h1>
    <br>
    <form class="form-inline" action="/admin/in-out/index">
        <?php
        $username = empty(Yii::$app->request->get()['username']) ? '' : Yii::$app->request->get()['username'];
        $mobile = empty(Yii::$app->request->get()['mobile']) ? '' : Yii::$app->request->get()['mobile'];
        $house_id = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
        ?>
        <div class="form-group">
            <input type="text" class="form-control" id="username" name="username" placeholder="出入人" value="<?=$username?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="出入人手机号" value="<?=$mobile?>">
        </div>
        <div class="form-group">
            <select class="form-control" id="house_id" name="house_id">
                <option value="">选择楼座</option>
                <?php foreach ($house as $k => $v): ?>
                    <option value="<?=$v['id']?>" <?php if ($v['id'] == $house_id) echo 'selected'; ?>><?=$v['housename']?></option>
                <?php endforeach ?>
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
            <th style="text-align: center;">申请人</th>
            <th style="text-align: center;">楼盘名称</th>
            <th style="text-align: center;">房间号</th>
            <th style="text-align: center;">身份证</th>
            <th style="text-align: center;">出入人</th>
            <th style="text-align: center;">出入人联系方式</th>
            <th style="text-align: center;">出入时间</th>
            <th style="text-align: center;">状态</th>
            <th style="text-align: center;">添加时间</th>
            <th style="text-align: center;">内容</th>
            <th style="text-align: center;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if($data):?>
            <?php foreach($data as $k => $v): ?>
                <tr style="table-layout:fixed;">
                    <td><?=$v['id'] ?></td>
                    <td><?=$v['TrueName'] ?></td>
                    <td><?=$v['housename'] ?></td>
                    <td><?=$v['room'] ?></td>
                    <td><?=$v['card'] ?></td>
                    <td><?=$v['username'] ?></td>
                    <td><?=$v['mobile'] ?></td>
                    <td><?=date('Y-m-d',$v['time']) ?></td>
                    <td><?php if($v['status']==1) echo '待审核';else echo '已审核'; ?></td>
                    <td><?=date('Y-m-d',$v['create_time']) ?></td>
                    <td style="word-break:break-all;overflow:hidden;width: 400px;">
                        <?php
                        $name = explode(',',$v['name']);
                        $num = explode(',',$v['num']);
                        for($i=0;$i<count($name);$i++){
                            if($v['name']!=""){
                                echo '名称：'.$name[$i].','.'数量：'.$num[$i].'<br>';
                            }else{
                                echo "";
                            }

                        }
                        ?>
                    </td>
                    <td>
                        <?php if($v['status']==1): ?>
                            <a href="javascript:void(0);" class="btn_del" data-id="<?=$v['id']?>" style="color: red;">删除</a>
                            <a href="javascript:void(0);" class="btn_sh" data-id="<?=$v['id']?>" style="color: #337ab7;">审核</a>
                        <?php elseif($v['status']==2): ?>
                            <a href="javascript:void(0);" class="btn_del" data-id="<?=$v['id']?>" style="color: red;">删除</a>
                        <?php endif;?>
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
                $.post('/index.php?r=admin/in-out/del',{op_id:op_id},function(res){
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
        $('.btn_sh').click(function(){
            if (confirm('确定要审核吗？')) {
                var op_id = $(this).data('id');
                if (op_id == undefined || op_id.length == 0) {
                    alert('参数错误');return false;
                }
                $.post('/index.php?r=admin/in-out/sh',{op_id:op_id},function(res){
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