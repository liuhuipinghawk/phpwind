<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Admin\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '服务器运维状况';
$this->params['breadcrumbs'][] = $this->title;
?>
<div style="margin-left:210px">
    <h1><?= Html::encode($this->title) ?></h1>
<table class="table table-striped table-bordered">
    <tr>
        <th>系统类型版本号:</th>
        <td><?php echo $data['uname']; ?></td>
    </tr>
    <tr>
        <th>PHP运行方式:</th>
        <td><?php echo $data['php_sapi']; ?></td>
    </tr>
    <tr>
        <th>php版本号:</th>
        <td><?php echo $data['php_version']; ?></td>
    </tr>
    <tr>
        <th>zend版本号:</th>
        <td><?php echo $data['zend_version']; ?></td>
    </tr>

    <tr>
        <th>服务器解译引擎:</th>
        <td><?php echo $data['service']; ?></td>
    </tr>
    <tr>
        <th>服务器语言:</th>
        <td><?php echo $data['http_accept_language']; ?></td>
    </tr>
    <tr>
        <th>浏览器信息:</th>
        <td><?php echo substr($_SERVER['HTTP_USER_AGENT'],0,40) ?></td>
    </tr>
    <tr>
        <th>服务器web端口:</th>
        <td><?php echo $data['server_port']; ?></td>
    </tr>
    <tr>
        <th>服务器域名Ip:</th>
        <td><?php echo $data['http_post']; ?></td>
    </tr>
    <tr>
        <th>剩余空间:</th>
        <td><?php echo $data['free_space']; ?></td>
    </tr>
    <tr>
        <th>上传附件限制:</th>
        <td><?php echo $data['upload_max_filesize']; ?></td>
    </tr>
    <tr>
        <th>执行时间限制:</th>
        <td><?php echo $data['execution_time']; ?></td>
    </tr>
    <tr>
        <th>脚本运行占用最大内存:</th>
        <td><?php echo get_cfg_var("memory_limit")?get_cfg_var("memory_limit"):"无"; ?></td>
    </tr>
    <tr>
        <th>服务器时间:</th>
        <td><?php echo $data['service_time']; ?></td>
    </tr>
    <tr>
        <th>北京时间:</th>
        <td><?php echo $data['njtime']; ?></td>
    </tr>
</table>
</div>