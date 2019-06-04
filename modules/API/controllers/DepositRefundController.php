<?php
/**
 * User: qilin
 * Date: 2018/5/7
 * Time: 17:54
 */
namespace app\modules\API\controllers;

use Yii;
use app\models\Admin\DepositRefund;

/**
 * API代码的编写
 */
class DepositRefundController extends TmlController
{
    public function actionAdd(){
        $data = $this->post;
        $data['create_time'] = time();
        $data['type'] = 1;
        $m = new DepositRefund();
        $m->setAttributes($data, false);
        if (!$m->save()) {
            return json_encode(['status' => -200, 'message' => $m->getFirstErrors()]);
        }
        return json_encode(['status' => 200, 'message' => '成功']);
    }
}