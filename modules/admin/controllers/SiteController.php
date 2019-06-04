<?php
namespace app\modules\admin\controllers;

use app\models\Admin\Admin;
use Yii;
use yii\web\Controller;


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/2
 * Time: 16:32
 */

class SiteController extends Controller{

    public $enableCsrfValidation=false;

    public function  actionLogin(){
        $this->layout = false;
        $model = new Admin;
        if(\Yii::$app->request->isPost){
            $post = yii::$app->request->post();
            if($model->login($post)){
                $this->redirect(['default/index']);
                Yii::$app->end();
            }
        }
        return $this->render('login',['model'=>$model]);
    }
    public function actionLogout(){
        Yii::$app->session->removeAll();
        if(!isset(YII::$app->session['admin']['isLogin'])){
           return $this->redirect(['site/login']);
        }

    }
    public function actionError(){
        $this->layout = "layout1";
        \Yii::$app->getSession()->setFlash('permission','对不起，您现在还没获此操作的权限！');
        return $this->render('error');
    }
}