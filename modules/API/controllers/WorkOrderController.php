<?php
/**
 * User: qilin
 * Date: 2018/8/3
 * Time: 10:30
 */

namespace app\modules\API\controllers;

use app\models\Admin\WorkLife;
use app\models\Admin\WorkOrder;
use app\models\Admin\WorkWeibao;
use yii\data\Pagination;
use Yii;

/**
 * WaterBaseController implements the CRUD actions for WaterBase model.
 */
class WorkOrderController extends TmlController
{
    public function actionIndex(){
        $user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
        $pagenum = empty($this->post['pagenum']) ? 1 : $this->post['pagenum'];
        $status = empty($this->post['status']) ? 0 : $this->post['status'];
        $page_size = \Yii::$app->params['APP_PAGE_SIZE'];
        if (!$user_id) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
        }
        $query = WorkOrder::find()->alias('o')->select('o.*,l.name,h.housename')->where(['o.user_id'=>$user_id])->andWhere(['o.status'=>$status])
        ->leftJoin('work_life l','l.id = o.life_id')->leftJoin('house h','h.id = l.house_id');
        $count = $query->count();
        $data = $query->offset(($pagenum-1)*$page_size)
            ->limit($page_size)
            ->orderBy('o.id desc')->asArray()
            ->all();
        $cast = [1=>'半月',2=>'季度',3=>'半年',4=>'全年'];
        if ($data) {
            foreach ($data as $k => $v) {
                $data[$k]['cast_name'] =$cast[$data[$k]['cast']];
                $data[$k]['create_time'] = empty($v['create_time']) ? '--' : date('Y-m-d H:i:s',$v['create_time']);
                $data[$k]['single_time'] = empty($v['single_time']) ? '--' : date('Y-m-d H:i:s',$v['single_time']);
                $data[$k]['order_time'] = empty($v['order_time']) ? '--' : date('Y-m-d H:i:s',$v['order_time']);
                $data[$k]['finish_time'] = empty($v['finish_time']) ? '--' : date('Y-m-d H:i:s',$v['finish_time']);
                $data[$k]['audit_time'] = empty($v['audit_time']) ? '--' : date('Y-m-d H:i:s',$v['audit_time']);
            }
        }
        echo json_encode(['status'=>200,'message'=>'success','code'=>$data]);exit;
    }

    public function actionStatus(){
        $id    = empty($this->post['id']) ? 0 : $this->post['id'];
        $state = empty($this->post['status']) ? 0 : $this->post['status'];
        if (!$id || !$state) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
        }

        $model = WorkOrder::find()->where(['id'=>$id])->one();
        if (!$model) {
            echo json_encode(['status'=>-200,'message'=>'订单不存在','code'=>'']);exit;
        }
        $con['status'] = $state;
        if($state == 3){
            $con['order_time'] = time();
        }elseif($state == 4){
            $con['finish_time'] = time();
        }else{
            return json_encode(['status' => -200, 'message' => '参数错误', 'code' => '']);
        }

        $res = WorkOrder::updateAll($con,['id'=>$id]);
        if ($res) {
            echo json_encode(['status'=>200,'message'=>'操作成功','code'=>'']);exit;
        }
        echo json_encode(['status'=>-200,'message'=>'操作失败','code'=>'']);exit;
    }

    public function actionDetail(){
        $cast    = empty($this->post['cast']) ? 0 : $this->post['cast'];
        $life_id = empty($this->post['life_id']) ? 0 : $this->post['life_id'];
        $life = WorkLife::find()->where(['id'=>$life_id])->asArray()->one();
        $res = WorkWeibao::find()->where(['cast'=>$cast])->andWhere(['type'=>$life['type']])->asArray()->all();
        if ($res) {
            echo json_encode(['status'=>200,'message'=>'操作成功','code'=>$res]);exit;
        }
        echo json_encode(['status'=>-200,'message'=>'操作失败','code'=>$res]);exit;
    }
}
