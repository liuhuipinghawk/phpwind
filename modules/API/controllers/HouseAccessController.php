<?php

namespace app\modules\API\controllers;

class HouseAccessController extends TmlController
{
    public function actionIndex()
    {
        $id = empty($this->post['id']) ? 0 : $this->post['id'];
        if (!$id) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
        }
        $m = (new \yii\db\Query())->select('h.id,h.housename,ha.access,ha.home,ha.ios_home')->from('house h')->
        leftJoin('house_access ha','ha.house_id = h.id')->where(['h.id'=>$id])->all();
        return json_encode(['status'=>200,'message'=>'成功','code'=>$m]);
    }

}
