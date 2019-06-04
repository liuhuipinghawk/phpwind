<?php
/**
 * User: qilin
 * Date: 2018/1/18
 * Time: 10:57
 */
namespace app\modules\API\controllers;

use Yii;
use app\models\Admin\Ad;

/**
 * API代码的编写
 */
class AdController extends TmlController
{
    /*
     * 兴业有道生活圈
     */
    public function actionIndex(){
        $data = Ad::find()->where(['pid'=>5])->asArray()->all();
        if(!$data){
            echo json_encode(['status'=>-200,'message'=>'error','code'=>[]]);exit;
        }
        echo json_encode(['status'=>200,'message'=>'success','code'=>$data]);exit;
    }
}