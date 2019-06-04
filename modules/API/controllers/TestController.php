<?php

namespace app\modules\API\controllers;

class TestController extends TmlController
{
    public function actionIndex()
    {
        $data = empty($this->post) ? "" : $this->post;
        if($data==""){
            return json_encode(['code'=>200,'data'=>'你提交的数据是空的']);
        }else{
            return json_encode(['code'=>200,'data'=>$data]);
        }
    }

}
