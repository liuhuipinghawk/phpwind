<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\bootstrap\Alert;
use app\models\Admin\Certification;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = '实名认证管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <form class="form-inline" action="">
        <?php
        $Tell = empty(Yii::$app->request->get()['Tell']) ? '' : Yii::$app->request->get()['Tell'];
        $TrueName = empty(Yii::$app->request->get()['TrueName']) ? '' : Yii::$app->request->get()['TrueName'];
        $Company = empty(Yii::$app->request->get()['Company']) ? '' : Yii::$app->request->get()['Company'];
        $Status      = empty(Yii::$app->request->get()['Status']) ? 0 : Yii::$app->request->get()['Status'];
        ?>
        <div class="form-group">
            <input type="text" class="form-control" id="Tell" name="Tell" placeholder="请输入手机号" value="<?php echo $Tell;?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="TrueName" name="TrueName" placeholder="请输入真实姓名" value="<?php echo $TrueName; ?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" id="Company" name="Company" placeholder="请输入公司名称" value="<?php echo $Company; ?>">
        </div>
        <div class="form-group">
            <select class="form-control" name="Status" id="Status">
                <option value="0">请选择状态</option>
                <option value="2" <?php if($Status == 2) echo 'selected';?>>审核中</option>
                <option value="3" <?php if($Status == 3) echo 'selected';?>>审核完成</option>
            </select>
        </div>
        <button type="submit" class="btn btn-default">查询</button>
    </form>
    <br>
    <table class="table table-striped table-bordered">
        <tr>
            <th>ID</th>
            <th>手机号</th>
            <th>真实姓名</th>
            <th>用户类型</th>
            <th>公司名称</th>
            <th>岗位</th>
            <th>职位</th>
            <th>注册时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <?php if ($list): ?>
            <?php foreach ($list as $k => $v): ?>
                <tr>
                    <td><?=$v['user_id']?></td>
                    <td><?=$v['mobile']?></td>
                    <td><?=$v['true_name']?></td>
                    <td><?=$v['user_type'] == 1 ? '内部员工' : '普通用户'?></td>
                    <td><?=$v['company']?></td>
                    <td><?=$v['post_name'] ? $v['post_name'] : '--'?></td>
                    <td><?=$v['position_name'] ? $v['position_name'] : '--'?></td>
                    <td><?=$v['add_time']?></td>
                    <td><?=$v['cert_status'] ? ($v['cert_status'] == 2 ? '<span style="color:orange;"> 审核中 </span>' : '<span style="color:#4cae4c;"> 审核完成 </span>') : '<span style="color:red;"> 未添加通行区域 </span>'?></td>
                    <td>
                        <a href="javascript:void(0);" class="btn_edit" data-id="<?=$v['user_id']?>" data-tag="edit">编辑用户信息</a>&nbsp;&nbsp;
                        <a href="/admin/certification/view?id=<?=$v['user_id']?>">认证通行区域</a>
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
    $(function(){
        $(".btn_edit").click(function(){
            var id = $(this).data("id");
            var tag = $(this).data("tag");
            if (tag == "edit") {
                $(this).data("tag","save").html("保存");
                //姓名
                $(this).parents("tr").find("td:eq(2)").html("<input type=\"text\" name=\"td_true_name\" value=\""+$(this).parents("tr").find("td:eq(2)").html()+"\"/>");
                //用户类型
                var _option = "<option value=\"1\">内部员工</option>";
                var _style = "";
                if ($(this).parents("tr").find("td:eq(3)").html() == "普通用户") {
                    _option += "<option value=\"2\" selected>普通用户</option>";
                    _style = "style=\"display:none;\"";
                } else {
                    _option += "<option value=\"2\">普通用户</option>";
                }
                $(this).parents("tr").find("td:eq(3)").html("<select name=\"td_user_type\">"+_option+"</select>");
                //公司
                $(this).parents("tr").find("td:eq(4)").html("<input type=\"text\" name=\"td_company\" style=\"width:100%;\" value=\""+$(this).parents("tr").find("td:eq(4)").html()+"\"/>");
                //岗位
                var post_option = getOption('post',id);
                $(this).parents("tr").find("td:eq(5)").html("<select name=\"td_post\""+_style+"><option value=\"\">选择岗位</option>"+post_option+"</select>");
                //职位
                var position_option = getOption('position',id);
                $(this).parents("tr").find("td:eq(6)").html("<select name=\"td_position\""+_style+"><option value=\"\">选择职位</option>"+position_option+"</select>");
            } else {                
                var true_name = $(this).parents("tr").find("input[name=td_true_name]").val();
                var user_type = $(this).parents("tr").find("select[name=td_user_type]").val();
                var company = $(this).parents("tr").find("input[name=td_company]").val();
                var post = "";
                var position = "";
                if (id == undefined || id.length == 0 || id == 0) {
                    alert("参数错误");
                    return false;
                }
                if (true_name == undefined || true_name.length == 0) {
                    alert("请输入真实姓名");
                    return false;
                }
                if (company == undefined || company.length == 0) {
                    alert("请输入公司名称");
                    return false;
                }
                if (user_type == undefined || user_type.length == 0) {
                    alert("请选择用户类型");
                    return false;
                }
                if (user_type != 1 && user_type != 2) {
                    alert("参数错误");
                    return false;
                }
                if (user_type == 1) {
                    post = $(this).parents("tr").find("select[name=td_post]").val();
                    position = $(this).parents("tr").find("select[name=td_position]").val();
                    if (post == undefined || post.length == 0) {
                        alert("请选择岗位");
                        return false;
                    }
                    if (position == undefined || position.length == 0) {
                        alert("请选择职位");
                        return false;
                    }
                }
                $.post("/admin/certification/do-edit-user",{
                    id:id,
                    true_name:true_name,
                    user_type:user_type,
                    company:company,
                    post:post,
                    position:position
                },function(res){
                    if (res.code == 200) {
                        alert(res.msg);
                        location.reload();
                    } else {
                        alert(res.msg);
                        return false;
                    }
                },"JSON");
            }
            
        });
        $("table").on("change","select[name=td_user_type]",function(){
            if ($(this).val() == 1) {
                $(this).parents("tr").find("select[name=td_position]").show();
                $(this).parents("tr").find("select[name=td_post]").show();
            } else {                
                $(this).parents("tr").find("select[name=td_position]").hide();
                $(this).parents("tr").find("select[name=td_post]").hide();
            }
        });
    });

    function getOption(type,user_id)
    {
        var option = "";
        $.ajax({
            type:"post",
            dataType:"json",
            url:"/admin/certification/get-option",
            async:false,
            data:{
                type:type,
                user_id:user_id
            },
            success:function(res){
                if (res.code == 200) {
                    option = res.data;
                }
            }
        });
        return option;
    }
</script>