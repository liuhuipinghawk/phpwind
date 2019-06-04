<?php
/**
 * User: qilin
 * Date: 2018/1/10
 * Time: 17:49
 */
namespace app\modules\API\controllers;
use app\models\Admin\WaterPayment;
use app\models\Admin\User;

/**
 * 水费缴费
 */
Class WaterPaymentController extends TmlController{

    /*
     * 记录和详情
     */
    public function actionAccountList()
    {
        $user_id = empty($this->get['user_id']) ? 0 : $this->get['user_id'];
        $pagenum = empty($this->get['pagenum']) ? 1 : $this->get['pagenum'];
        $page_size = \Yii::$app->params['APP_PAGE_SIZE'];
        if (!$user_id || !$pagenum) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
        }
        $user = User::find()->where(['id'=>$user_id])->asArray()->one();
        if (!$user) {
            echo json_encode(['status'=>-200,'message'=>'用户不存在','code'=>'']);exit;
        }
        $list = (new \yii\db\Query())
            ->select('p.account_id,p.order_sn,p.water_time as pay_time,p.water_fee as money,h1.housename as house_name,h2.housename as seat_name,p.pay_type,a.room_num')
            ->from('water_payment p')
            ->leftJoin('user_account a','a.account_id=p.account_id')
            ->leftJoin('house h1','a.house_id=h1.id')
            ->leftJoin('house h2','a.seat_id=h2.id')
            ->where(['p.user_id'=>$user_id,'p.status'=>2])
			->orderBy('p.order_id desc')
            ->offset(($pagenum-1)*$page_size)
            ->limit($page_size)
            ->all();
        if ($list) {
            foreach ($list as $k => $v) {
                $list[$k]['pay_time'] = empty($v['pay_time']) ? '--' : date('Y-m-d H:i:s',$v['pay_time']);
            }
        }

        echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;
    }
}