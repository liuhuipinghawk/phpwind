<?php
/**
 * User: qilin
 * Date: 2018/7/7
 * Time: 16:30
 */
namespace app\modules\API\controllers;

use app\models\Admin\Blacklist;
use Yii;

/**
 * API代码的编写
 */
class PassRecordController extends TmlController
{

    public function actionIndex(){
        $data    = Yii::$app->request->post();
        if(!$data['user_id'] || !$data['pass_time'] || !$data['equipment_id'] || !$data['floor'] || !$data['user_type'] || !$data['house_id'] || !$data['community_id']){
            return json_encode(['code'=>'-200','msg'=>'缺少参数']);
        }
        $model = new \app\models\Admin\PassRecord();
        $model->user_id = $data['user_id'];
        $model->pass_time = $data['pass_time'];
        $model->equipment_id = $data['equipment_id'];
        $model->floor = $data['floor'];
        $model->user_type = $data['user_type'];
        $model->house_id = $data['house_id'];
        $model->community_id = $data['community_id'];
        if($data['user_type'] == 2){
            $model->name = $data['name'];
            $model->mobile = $data['mobile'];
            $model->card = $data['card'] ? $data['card'] : '';
        }
        $res = $model->save();
        if(!$res){
            return json_encode(['code'=>'-200','msg'=>'添加失败']);
        }
        return json_encode(['code'=>'200','msg'=>'添加成功']);
    }

    public function actionGetPhone(){
        $data    = Yii::$app->request->get();
        $phone = empty($this->get['phone']) ? '' : $this->get['phone'];
        if (empty($phone)) {
            return json_encode(['status'=>-200,'message'=>'参数错误']);
        }
        $user = new Blacklist();
        $res = $user->find()->where(['phone'=>$phone])->count();
        if($res !=0){
            return json_encode(['code'=>'-200','msg'=>'您的账号有风险，请联系项目客服人员']);
        }
        return json_encode(['code'=>'200','msg'=>'成功']);
    }
}