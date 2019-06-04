<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\app\assets\AppAsset::register($this);
$this->title = '通行区域';
$this->params['breadcrumbs'][] = ['label' => '实名认证管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <p style="color: red;">
        注：实名认证审核操作步骤：1：先勾选左侧需审核的复选框；2：点击“确定”按钮，即可审核通过。
    </p>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <!--<button class="all">获得所有项</button>-->

    <table class="table table-striped table-bordered">
        <tr>
            <th>选择</th>
            <th>通行区域ID</th>
            <th>用户Id</th>
            <th>真实姓名</th>
            <th>通行区域地址</th>
            <th>通行单元</th>
            <th>房间号</th>
            <th>楼层权限(多层权限以英文逗号隔开)</th>
            <th>联系方式</th>
            <th>审核时间</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        <?php foreach ($model as $val){ ?>
            <tr>
                <td>
                    <?php if($val['Status']!=3):?>
                        <input type="checkbox" name="chkId" value="<?php echo $val['CertificationId']; ?>" data-seat ="<?php echo $val['SeatName'];?>" data-house =<?php echo $val['house_id'];  ?> >
                    <?php endif?>
                </td>
                <td><?php echo $val['CertificationId']; ?></td>
                <td><?php echo $val['UserId'];  ?></td>
                <td><?php echo $val['TrueName'];  ?></td>
                <td><?php echo $val['housename'];  ?></td>
                <td><?php echo $val['SeatName'];  ?></td>
                <td><?php echo $val['Address'];  ?></td>
                <td><?php echo $val['floor'];  ?></td>
                <td><?php echo $val['Tell'];  ?></td>
                <td><?php echo $val['UpdateTime'];  ?></td>
                <td><?php if($val['Status']==1){ ?>
                        <?php echo "<font color='#7fffd4'>未审核</font>"; ?>
                    <?php }else if($val['Status']==2){?>
                        <?php echo "<font color='orange'>审核中</font>"; ?>
                    <?php }else if($val['Status']==3){ ?>
                        <?php echo "<font color='red'>审核完成</font>"; ?>
                    <?php } ?>
                </td>

                <td>
                    <a href="javascript:void(0);" class="del" data-id="<?=$val['CertificationId']?>">删除</a>&nbsp;&nbsp;
                    <a href="javascript:void(0);" class="btn_edit" data-id="<?=$val['CertificationId']?>" data-tag="edit">编辑楼层权限</a>
                </td>
                    
            </tr>
        <?php  } ?>   
    </table>
    <button class="select btn btn-success margin-top">审核通过</button>

    <?= LinkPager::widget(['pagination' => $pages]); ?>
</div>
<!--<?=Html::jsFile('@web/js/jquery-1.12.4.js')?>-->
<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
<script type="text/javascript">
    $(function(){
        //var val = '';
        var strSel = '';
        /**$(".all").click(function(){
            $("[name='chkId']").each(function(index, element){
                val += $(this).val() + ",";
            });
            alert("所有项:"+val);
        })**/
        var house = ''; var seat = '';
        $(".select").click(function(){
            $("[name='chkId']:checked").each(function(index, element){
                strSel += $(this).val() + ",";
                house += $(this).data('house')+ ",";
                seat += $(this).data('seat')+ ",";
            });
            if(strSel.length >0){
                //如果获取到
                strSel = strSel.substring(0,strSel.length - 1);
            }else{
                alert("内容不能为空！");
                return false;
            }
            if(house.length >0){
                //如果获取到
                house = house.substring(0,house.length - 1);
            }else{
                alert("不能为空！");
                return false;
            }
            if(seat.length >0){
                //如果获取到
                seat = seat.substring(0,seat.length - 1);
            }else{
                alert("不能为空！");
                return false;
            }
            var userid = '<?php echo $_GET['id']; ?>';
            var url = "/index.php?r=admin/certification/confirm";
            $.ajax({
                'url':url,
                'type':'GET',
                'dataType':'json',
                'data':{CertificationId:strSel,UserId:userid,house_id:house,seat:seat},
                success:function (data) {
                   if(data.status==200){
                       alert(data.message);
                       window.location.reload();
                       return false;
                   }else{
                       alert(data.message);
                       window.location.reload();
                       return false;
                   }
                }
            });
            return false;
        });

        $(".del").click(function(){
            if (!confirm("确定要删除吗？")) {
                return false;
            }
            var cert_id = $(this).data("id");
            if (cert_id == undefined || cert_id.length == 0) {
                alert("参数错误");return false;
            }
            $.post("/admin/certification/do-del",{cert_id:cert_id},function(res){
                if (res.code == 200) {
                    alert("删除成功");
                    location.reload();
                } else {
                    alert("删除失败");
                    return false;
                }
            },"JSON");
        });
    });
    $(function(){
        $(".btn_edit").click(function(){
            var id = $(this).data("id");
            var tag = $(this).data("tag");
            if (tag == "edit") {
                $(this).data("tag","save").html("保存");
                //姓名
                $(this).parents("tr").find("td:eq(7)").html("<input type=\"text\" name=\"td_floor\" value=\""+$(this).parents("tr").find("td:eq(7)").html()+"\"/>");

            } else {
                var floor = $(this).parents("tr").find("input[name=td_floor]").val();
                if (id == undefined || id.length == 0 || id == 0) {
                    alert("参数错误");
                    return false;
                }
                if (floor == undefined || floor.length == 0) {
                    alert("请输入真实姓名");
                    return false;
                }
                $.post("/admin/certification/do-edit-floor",{
                    id:id,
                    floor:floor
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
    });
</script>