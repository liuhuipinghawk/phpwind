<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Admin\UserRole;

AppAsset::register($this);
AppAsset::addCss($this,"/layout/css/bootstrap.min.css");
AppAsset::addCss($this,"/layout/css/font-awesome.min.css");
AppAsset::addCss($this,"/layout/font/iconfont.css");
AppAsset::addCss($this,"/layout/css/sidebar-menu.css");
// AppAsset::addCss($this,"/css/umeditor/themes/default/css/umeditor.css");
// AppAsset::addScript($this,"/css/umeditor/third-party/template.min.js");
// AppAsset::addScript($this,"/css/umeditor/umeditor.config.js");
// AppAsset::addScript($this,"/css/umeditor/umeditor.min.js");
// AppAsset::addScript($this,"/css/umeditor/lang/zh-cn/zh-cn.js");

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<style type="text/css">
    .wrap{width: 100%; height: 100%; margin:0; padding: 0; overflow-y: hidden;}
    #nav{width: 100%; height: 50px; display: block;}
    /*#left_menu{width: 12%; height: 100%; display: block; float: left; background: #333f52;overflow-y: scroll;}*/
    /*#right_main{width: 86%; height: 90%; display: block; float: left; margin: 1%; padding-right: 1%; overflow-y: scroll;}*/
    #right_main{padding-left: 220px;margin-top: 54px;width: 100%;height: 90%;display: block;float: left;overflow-y: scroll}
    #daohang{width: 100%; display: block;}
    body{font-family:"微软雅黑"!important;}
    .message-list {
    font-size: 15px;
    background: rgba(0, 0, 0, 0.6) url(/img/bulletin.gif) no-repeat scroll 10px 5px;
    color: #ffffff;
    width: 100%;
    height: 32px;
    min-height: 32px;
    overflow: hidden;
     position: fixed;
        top: 58px;
        left: 205px;
}
.message-list ul {
    list-style:none;
    width:100%;
    height:100%;
}
.message-list ul li {
    width:100%;
    height:40px;
    box-sizing:border-box;
    line-height:32px;
    padding-left: 8px;
}
.message-list ul li:hover{
    cursor: pointer;
}
</style>
<?php
    $group_house = Yii::$app->session['admin']['house_ids'];$list = explode(',',$group_house);
    $order = (new \yii\db\Query())->select('or.*,h.housename,h1.housename as seatname')->from('order_remind or')->
                leftJoin('house h','h.id = or.house_id')->
                leftJoin('house h1','h1.id = or.seat_id');
if($group_house){
    $order = $order->where(['in','or.house_id',$list]);
}
    $order = $order->orderBy('or.id desc')->all();
?>
<div class="wrap">
    <div class="auto-message">
        <div class="message-list">
            <?php if (!empty($order)): ?>
            <ul>
                <?php foreach ($order as $k => $v): ?>
                    <li><?=$v['housename'] ?>-<?=$v['seatname'] ?>-<?=$v['room_num'] ?>有<?php if($v['remind_type']==1){
                            echo '电费';
                        }elseif($v['remind_type']==2) {
                            echo '水费';
                        }elseif($v['remind_type']==3) {
                            echo '物业费';
                        }?>订单了，充值金额<?=$v['money'] ?>，请尽快确认订单！</li>
                <?php endforeach ?>
            </ul>
            <?php endif ?>
        </div>
    </div>
    <div id="nav">
        <?php
        NavBar::begin([
            'brandLabel' => '爱办app后台管理系统',
            'brandUrl' => '/index.php?r=admin/default/index',
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                (
                    '<li>'
                    . Html::beginForm(['site/logout'], 'post')
                    . Html::submitButton(
                        'Logout (' . Yii::$app->session['admin']['adminuser'] . ')',
                        ['class' => 'btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
                )
                //['label' => 'logout', 'url' => ['site/logout']],
            ],
        ]);
        NavBar::end();
        ?>
    </div>
    <div id="left_menu" class="main-sidebar">
        <section  class="sidebar">
            <ul class="sidebar-menu">
                <li class="header"><img src="/layout/log.png"></li>
                <li class="treeview">
                    <a href="/admin/default/index">
                        <i class="iconfont icon-shouye"></i> <span>后台首页</span>
                    </a>
                </li>

                <?php
                $group_role = Yii::$app->session['admin']['group_role'];

                $menu1 = UserRole::find()->where(['status'=>1,'pid'=>0,'column'=>1])->andWhere(['id'=>explode(',',$group_role)])->asArray()->all();
                if (!empty($menu1)) {
                    foreach ($menu1 as $k => $v) {
                        $menu1[$k]['child'] = UserRole::find()->where(['status'=>1,'pid'=>$v['id']])->andWhere(['id'=>explode(',',$group_role)])->asArray()->all();
                    }
                }

                $menu2 = UserRole::find()->where(['status'=>1,'pid'=>0,'column'=>2])->andWhere(['id'=>explode(',',$group_role)])->asArray()->all();
                if (!empty($menu2)) {
                    foreach ($menu2 as $k => $v) {
                        $menu2[$k]['child'] = UserRole::find()->where(['status'=>1,'pid'=>$v['id']])->andWhere(['id'=>explode(',',$group_role)])->asArray()->all();
                    }
                }

                $menu3 = UserRole::find()->where(['status'=>1,'pid'=>0,'column'=>3])->andWhere(['id'=>explode(',',$group_role)])->asArray()->all();
                if (!empty($menu3)) {
                    foreach ($menu3 as $k => $v) {
                        $menu3[$k]['child'] = UserRole::find()->where(['status'=>1,'pid'=>$v['id']])->andWhere(['id'=>explode(',',$group_role)])->asArray()->all();
                    }
                }

                $menu4 = UserRole::find()->where(['status'=>1,'pid'=>0,'column'=>4])->andWhere(['id'=>explode(',',$group_role)])->asArray()->all();
                if (!empty($menu4)) {
                    foreach ($menu4 as $k => $v) {
                        $menu4[$k]['child'] = UserRole::find()->where(['status'=>1,'pid'=>$v['id']])->andWhere(['id'=>explode(',',$group_role)])->asArray()->all();
                    }
                }

                $menu5 = UserRole::find()->where(['status'=>1,'pid'=>0,'column'=>5])->andWhere(['id'=>explode(',',$group_role)])->asArray()->all();
                if (!empty($menu5)) {
                    foreach ($menu5 as $k => $v) {
                        $menu5[$k]['child'] = UserRole::find()->where(['status'=>1,'pid'=>$v['id']])->andWhere(['id'=>explode(',',$group_role)])->asArray()->all();
                    }
                }

                $menu6 = UserRole::find()->where(['status'=>1,'pid'=>0,'column'=>6])->andWhere(['id'=>explode(',',$group_role)])->asArray()->all();
                if (!empty($menu6)) {
                    foreach ($menu6 as $k => $v) {
                        $menu6[$k]['child'] = UserRole::find()->where(['status'=>1,'pid'=>$v['id']])->andWhere(['id'=>explode(',',$group_role)])->asArray()->all();
                    }
                }
                ?>

                <?php if (!empty($menu1)): ?>
                    <li class="treeview">
                        <a href="javascript:void(0);">
                            <i class="iconfont icon-yonghu"></i> <span>用户数据管理</span>
                            <i class="iconfont icon-you pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php foreach ($menu1 as $k => $v): ?>
                                <li>
                                    <a href="<?=$v['url']?'/admin/'.$v['url']:'javascript:void(0);' ?>"><?=$v['name'] ?> <?php if (!empty($v['child'])): ?><i class="iconfont icon-you pull-right"></i><?php endif ?></a>
                                    <?php if (!empty($v['child'])): ?>
                                        <ul class="treeview-menu">
                                            <?php foreach ($v['child'] as $kk => $vv): ?>
                                                <li><a href="/admin/<?=$vv['url'] ?>"><?=$vv['name'] ?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    <?php endif ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php endif ?>

                <?php if (!empty($menu2)): ?>
                    <li class="treeview">
                        <a href="javascript:void(0);">
                            <i class="iconfont icon-news_icon"></i> <span>新闻广告管理</span>
                            <i class="iconfont icon-you pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php foreach ($menu2 as $k => $v): ?>
                                <li>
                                    <a href="<?=$v['url']?'/admin/'.$v['url']:'javascript:void(0);' ?>"><?=$v['name'] ?> <?php if (!empty($v['child'])): ?><i class="iconfont icon-you pull-right"></i><?php endif ?></a>
                                    <?php if (!empty($v['child'])): ?>
                                        <ul class="treeview-menu">
                                            <?php foreach ($v['child'] as $kk => $vv): ?>
                                                <li><a href="/admin/<?=$vv['url'] ?>"><?=$vv['name'] ?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    <?php endif ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php endif ?>

                <?php if (!empty($menu3)): ?>
                    <li class="treeview">
                        <a href="javascript:void(0);">
                            <i class="iconfont icon-erji-zengzhifuwu"></i> <span>增值服务</span>
                            <i class="iconfont icon-you pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php foreach ($menu3 as $k => $v): ?>
                                <li>
                                    <a href="<?=$v['url']?'/admin/'.$v['url']:'javascript:void(0);' ?>"><?=$v['name'] ?> <?php if (!empty($v['child'])): ?><i class="iconfont icon-you pull-right"></i><?php endif ?></a>
                                    <?php if (!empty($v['child'])): ?>
                                        <ul class="treeview-menu">
                                            <?php foreach ($v['child'] as $kk => $vv): ?>
                                                <li><a href="/admin/<?=$vv['url'] ?>"><?=$vv['name'] ?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    <?php endif ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php endif ?>

                <?php if (!empty($menu4)): ?>
                    <li class="treeview">
                        <a href="javascript:void(0);">
                            <i class="iconfont icon-wuyefeiyongchuzhang"></i> <span>物业服务管理</span>
                            <i class="iconfont icon-you pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php foreach ($menu4 as $k => $v): ?>
                                <li>
                                    <a href="<?=$v['url']?'/admin/'.$v['url']:'javascript:void(0);' ?>"><?=$v['name'] ?> <?php if (!empty($v['child'])): ?><i class="iconfont icon-you pull-right"></i><?php endif ?></a>
                                    <?php if (!empty($v['child'])): ?>
                                        <ul class="treeview-menu">
                                            <?php foreach ($v['child'] as $kk => $vv): ?>
                                                <li><a href="/admin/<?=$vv['url'] ?>"><?=$vv['name'] ?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    <?php endif ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php endif ?>

                <?php if (!empty($menu5)): ?>
                    <li class="treeview">
                        <a href="javascript:void(0);">
                            <i class="iconfont icon-shezhi"></i> <span>系统设置</span>
                            <i class="iconfont icon-you pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php foreach ($menu5 as $k => $v): ?>
                                <li>
                                    <a href="<?=$v['url']?'/admin/'.$v['url']:'javascript:void(0);' ?>"><?=$v['name'] ?> <?php if (!empty($v['child'])): ?><i class="iconfont icon-you pull-right"></i><?php endif ?></a>
                                    <?php if (!empty($v['child'])): ?>
                                        <ul class="treeview-menu">
                                            <?php foreach ($v['child'] as $kk => $vv): ?>
                                                <li><a href="/admin/<?=$vv['url'] ?>"><?=$vv['name'] ?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    <?php endif ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php endif ?>
                <?php if (!empty($menu6)): ?>
                    <li class="treeview">
                        <a href="javascript:void(0);">
                            <i class="iconfont icon-shezhi"></i> <span>物管数据统计管理</span>
                            <i class="iconfont icon-you pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php foreach ($menu6 as $k => $v): ?>
                                <li>
                                    <a href="<?=$v['url']?'/admin/'.$v['url']:'javascript:void(0);' ?>"><?=$v['name'] ?> <?php if (!empty($v['child'])): ?><i class="iconfont icon-you pull-right"></i><?php endif ?></a>
                                    <?php if (!empty($v['child'])): ?>
                                        <ul class="treeview-menu">
                                            <?php foreach ($v['child'] as $kk => $vv): ?>
                                                <li><a href="/admin/<?=$vv['url'] ?>"><?=$vv['name'] ?></a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    <?php endif ?>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php endif ?>

            </ul>
        </section>
    </div>
    <div id="right_main">
        <div id="daohang">
            <?= Breadcrumbs::widget([
                'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
                'homeLink' => [
                    'label' => '首页',
                    'url' => ['/index.php?r=admin/default/index'],
                    'template' => "<li><b>{link}</b></li>\n",
                    'class' => 'myhome'
                ],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        </div>
        <div id="main_content">
            <?= $content ?>
        </div>
    </div>

    <!-- 遮罩层 -->
    <div class="container-fluid text-center">
        <!-- <h2>遮罩层DEMO</h2> -->
        <!-- 按钮触发模态框 -->
        <button id="zzc" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style="display: none;">打开遮罩层</button>
 
        <!-- 模态框（Modal） -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">遮罩层标题</h4>
                    </div>
                    <div class="modal-body" id="myModalBody">
                        在这里添加一些文本
                    </div>
                    <div class="modal-footer" id="zzc_close">
                        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary">提交更改</button> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
    <script src="/layout/js/sidebar-menu.js"></script>
    <script src="/js/auto-message.js"></script>
    <script>
        $.sidebarMenu($('.sidebar-menu'))
    </script>
    <script type="text/javascript">
        $(function(){
            $('#main_content').find('div:eq(0)').removeAttr('style');
            var href = location.href;
            $('#left_menu').find('a').each(function(){
                if (href.indexOf($(this).attr('href')) >= 0) {
                    $(this).parents('li').addClass('active');
                    $(this).parents('ul.treeview-menu').addClass('menu-open');
                }
            });
        });
    </script>
</body>
</html>
<?php $this->endPage() ?>
