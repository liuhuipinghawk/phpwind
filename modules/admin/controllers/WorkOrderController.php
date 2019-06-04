<?php
/**
 * User: qilin
 * Date: 2018/8/3
 * Time: 10:30
 */

namespace app\modules\admin\controllers;

use app\models\Admin\House;
use app\models\Admin\WorkOrder;
use yii\data\Pagination;
use Yii;

/**
 * WaterBaseController implements the CRUD actions for WaterBase model.
 */
class WorkOrderController extends CommonController
{
    public function actionIndex(){
        $this->layout = 'layout1';
        $house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
        $type = empty(Yii::$app->request->get()['type']) ? 0 : Yii::$app->request->get()['type'];
        $cast = empty(Yii::$app->request->get()['cast']) ? 0 : Yii::$app->request->get()['cast'];
        $status = empty(Yii::$app->request->get()['status']) ? 0 : Yii::$app->request->get()['status'];
        $query = WorkOrder::find()->select('wo.*,wl.name,wl.type,h.housename,u.TrueName')->alias('wo')->
        leftJoin('work_life wl','wl.id = wo.life_id')->
        leftJoin('house h','h.id = wl.house_id')->
        leftJoin('user u','u.id = wo.user_id');
        if (!empty($house_id)) {
            $query = $query->where(['wl.house_id'=>$house_id]);
        }
        if (!empty($type)) {
            $query = $query->where(['wl.type'=>$type]);
        }
        if (!empty($cast)) {
            $query = $query->andWhere(['wo.cast'=>$cast]);
        }
        $count = $query->count();
        $pagination = new Pagination(['totalCount'=>$count]);
        $data = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();
        $house = House::find()->where(['parentId'=>0])->all();
        return $this->render('index',[
            'data'=>$data,
            'pagination' => $pagination,
            'house'=>$house
        ]);
    }
    public function actionDel(){
        $id = empty(Yii::$app->request->post()['id']) ? 0 : Yii::$app->request->post()['id'];
        if (empty($id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $res = WorkOrder::deleteAll(['id'=>$id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }

    public function actionSingle(){
        $this->layout = 'layout1';
        $op_id = empty(Yii::$app->request->get()['op_id']) ? 0 : Yii::$app->request->get()['op_id'];
        $house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
        $repair_name = empty(Yii::$app->request->get()['repair_name']) ? 0 : Yii::$app->request->get()['repair_name'];
        $house  = House::find()->where(['parentId'=>0])->asArray()->all();
        $con['c.Status'] = 3;
        $con['u.PostId'] = 1;
        $con['u.CateId'] = 1;
        if (!empty($house_id)) {
            $con['c.HouseId'] = $house_id;
        }
        $con1 = [];
        if (!empty($repair_name)) {
            $con1 = ['like','u.TrueName',$repair_name];
        }
        $repairs = (new Yii\db\Query())
            ->select('distinct(u.id),u.id,u.TrueName,u.Tell')
            ->from('certification c')
            ->leftjoin('user u','c.UserId=u.id')
            ->where($con)
            ->andWhere($con1)
            ->all();
        foreach ($repairs as $k => $v) {
            $repairs[$k]['status2'] = WorkOrder::find()->where(['Status'=>2,'user_id'=>$v['id']])->count();
            $repairs[$k]['status3'] = WorkOrder::find()->where(['Status'=>3,'user_id'=>$v['id']])->count();
        }
        return $this->render('single',[
            'op_id' => $op_id,
            'repairs' => $repairs,
            'house'  => $house
        ]);
    }

    public function actionDoSingle(){
        $data = Yii::$app->request->post();
        if ($data['user_id'] == ""|| $data['order_id'] =='') {
            return json_encode(['status' => -200, 'message' => '缺少参数']);
        }
        $res = WorkOrder::updateAll(['single_time'=>time(),'user_id'=>$data['user_id'],'status'=>2],['id'=>$data['order_id']]);
        if (!$res) {
            return json_encode(['code' => -200, 'msg' => '派单失败']);
        }
        return json_encode(['code' => 200, 'msg' => '派单成功']);
    }

    public function actionAdd(){
        $data = Yii::$app->request->post();
        $session = \Yii::$app->session;
        $data['admin_id'] = $session['admin']['adminid'];
        $ids = explode(',',$data['ids']);
        $data['create_time'] = time();
        $m = new WorkOrder();
        foreach($ids as $v){
            $data['life_id'] = $v;
            $m->setAttributes($data, false);
        }
        if (!$m->save()) {
            return json_encode(['code' => -200, 'msg' => $m->getFirstErrors()]);
        }
        return json_encode(['code' => 200, 'msg' => '添加成功']);
    }

    public function actionAudit(){
        $id = empty(Yii::$app->request->post()['id']) ? 0 : Yii::$app->request->post()['id'];
        if (empty($id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $res = WorkOrder::updateAll(['status'=>5],['id'=>$id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }
}
