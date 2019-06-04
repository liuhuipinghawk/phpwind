<?php
namespace app\modules\admin\controllers;

use app\models\Admin\Admin;
use app\models\AuthAssignments;
use yii\web\Controller;
use app\models\Admin\UserRole;
use app\models\Admin\House;


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/3
 * Time: 15:06
 */

class CommonController extends Controller{

    // public function beforeAction($action)
    // {
    //     $session = \Yii::$app->session;
    //     $userid = Admin::find()->where(array('adminuser'=>$session['admin']['adminuser']))->asArray()->one();
    //    $controller = \Yii::$app->controller->id;
    //    $action = \Yii::$app->controller->action->id;
    //    $cations = $controller."/".$action;
    //    $assign = AuthAssignments::find()->where(array('item_name'=>$cations,'user_id'=>$userid['adminid']))->asArray()->one();
    //    if(!empty($assign)){
    //        return true;
    //       // \Yii::$app->getSession()->setFlash('csss','对不起，您现在还没获此操作的权限！');
    //       // throw new \yii\web\UnauthorizedHttpException('对不起，您现在还没获此操作的权限！');
    //    }else{
    //        return $this->redirect(['/admin/site/error'])->send();
    //    }
    // }

    public function init()
    {
        $session = \Yii::$app->session['admin'];
        $pass = empty($session['pass'])?0:$session['pass'];
        $admin = Admin::find()->where(['adminuser'=>$session['adminuser'],'adminpass'=>$pass])->count();
        if ($admin == 0) {
            return $this->redirect(['/admin/site/login']);
        }
    }

    /**
     * 获取楼盘信息
     * @Author   tml
     * @DateTime 2018-03-21
     * @return   [type]     [description]
     */
    public function getHouseInfo($parent_id)
    {
        return House::find()->select('id,housename')->where(['parentId'=>$parent_id])->asArray()->all();
    }

    /**
     * 获取开始结束日期之间的所有月份数组
     * @Author   tml
     * @DateTime 2018-05-02
     * @param    [type]     $stime [description]
     * @param    [type]     $etime [description]
     * @return   [type]            [description]
     */
    public function getMonthArray($stime,$etime)
    {
        $s_year = date('Y',$stime);
        $s_month = date('n',$stime);
        $e_year = date('Y',$etime);
        $e_month = date('n',$etime);
        $month = [];
        $year_diff = intval($e_year-$s_year);

        if ($year_diff == 0) {
            for ($i=$s_month; $i <= $e_month; $i++) { 
                array_push($month,"$s_year-$i");
            }
        } else {
            for ($y = $s_year; $y <= $e_year; $y++) { 
                if ($y == $s_year) {
                    for ($a=$s_month; $a <= 12; $a++) { 
                        array_push($month,"$y-$a");
                    }
                } else if ($y == $e_year) {
                    for ($b=1; $b <= $e_month; $b++) { 
                        array_push($month,"$y-$b");
                    }
                } else {
                    for ($c=1; $c <= 12; $c++) { 
                        array_push($month,"$y-$c");
                    }
                }
            }
        }
        return $month;
    }
}