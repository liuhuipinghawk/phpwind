<?php

namespace app\modules\API\controllers;

use app\models\Admin\ThirdParty;

class ThirdPartyController extends TmlController
{
    public function actionAdd()
    {
        $data = $this->post;
        $data['create_time'] = time();
        $m = new ThirdParty();
        $m->setAttributes($data, false);
        if (!$m->save()) {
            return json_encode(['status' => -200, 'message' => $m->getFirstErrors()]);
        }
        return json_encode(['code' => 200, 'msg' => '添加成功']);
    }

}
