<?php
namespace app\modules\admin\controllers;

use yii\web\Controller;


/**
 * 权限和角色！
 */
class AuthController extends CommonController{

    /**
     * 创建一个许可 Permiassion
     * @param $item
     */
    public function actionCreatePermission($item){
        $auth = \Yii::$app->authManager;
        $createPost = $auth->createPermission($item);
        $createPost->description = '创建了'.$item.'许可';
        $auth->add($createPost);
    }

    /**
     * 创建一个角色
     * @param $item
     */
    public function actionCreateRole($item)
    {
        $auth = \Yii::$app->authManager;
        $role = $auth->createRole($item);
        $role->description = '创建了'.$item.'角色';
        $auth->add($role);
    }

    /**
     * 给角色分配许可
     * @param $item1
     * @param $item2
     */
    public function actionCreateEmpowerment($item1,$item2){
        $auth = \Yii::$app->authManager;
        $parent = $auth->createRole($item1);
        $child = $auth->createPermission($item2);
        $auth->addChild($parent,$child);
    }
    public function actionCreateAssign($item1,$item2){
        $auth = \Yii::$app->authManager;
        $role = $auth->createRole($item1);
        $auth->assign($role,$item2);
    }

}