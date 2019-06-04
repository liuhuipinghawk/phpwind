<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = '项目电梯数据列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <h1><?=$this->title ?></h1>
    <form class="form-inline" action="">
        <?php
        $house_id = empty(Yii::$app->request->get()['id']) ? '' : Yii::$app->request->get()['id'];
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
        <a href="/admin/work-life/add" class="btn btn-success">数据录入</a>
    </form>
    <br>
    <a href="javascript:void(0);" class="select btn btn-success" onclick="select()">生成订单</a><br><br>
    <form id="common-form">
        <input type="checkbox" name="check" value="1">半月 &nbsp;&nbsp;&nbsp;
        <input type="checkbox" name="check" value="2">季度 &nbsp;&nbsp;&nbsp;
        <input type="checkbox" name="check" value="3">半年 &nbsp;&nbsp;&nbsp;
        <input type="checkbox" name="check" value="4">全年
    </form><br>
    <table class="table table-striped table-bordered" style="text-align: center;">
        <thead>
        <tr>
            <th style="text-align: center;">选择</th>
            <th style="text-align: center;">电梯名称</th>
            <th style="text-align: center;">所属项目</th>
            <th style="text-align: center;">电梯类型</th>
            <th style="text-align: center;">添加时间</th>
            <th style="text-align: center;">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if($data):?>
            <?php foreach($data as $k => $v): ?>
                <tr>
                    <td>
                        <input type="checkbox" name="chkIds" value="<?=$v['id'] ?>">
                    </td>
                    <td><?= $v['name'] ?></td>
                    <td><?=$v['housename']?></td>
                    <td><?php if($v['type'] == 1) echo '电梯'; else echo '扶梯';?></td>
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
<?=Html::jsFile('@web/js/jquery-1.12.4.js')?>
<?=Html::jsFile('@web/js/jquery.min.js')?>
<script type="text/javascript">

    $(function() {
        $('#common-form').find('input[type=checkbox]').bind('click', function(){
            var id = $(this).attr("id");

            //当前的checkbox是否选中
            if(this.checked){
                //除当前的checkbox其他的都不选中
                $("#common-form").find('input[type=checkbox]').not(this).attr("checked", false);

                //选中的checkbox数量
//                var selectleng = $("input[type='checkbox']:checked").length;
//                console.log("选中的checkbox数量"+selectleng);
//            }else{
                //未选中的处理
//                console.log("未选中的处理");
            }
        });
    });
    function select(){
        var ids = '';
        $("[name='chkIds']:checked").each(function () {
            ids += $(this).val() + ",";
        });
        var cast = $("[name='check']:checked").val();
        if(ids.length >0){
            //如果获取到
            ids = ids.substring(0,ids.length - 1);
        }else{
            alert("内容不能为空！");
            return false;
        }
        if(cast == undefined){
            //如果获取到
            alert("时间不能为空！");
            return false;
        }
        var url = "/index.php?r=admin/work-order/add";
        $.post(url,{ids:ids,cast:cast},function(res){
            if (res.code == 200) {
                alert(res.msg);
//                location.reload();
                $(location).attr('href', '/admin/work-order/index');
            } else {
                alert(res.msg);
                return false;
            }
        },'JSON');
    }

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
