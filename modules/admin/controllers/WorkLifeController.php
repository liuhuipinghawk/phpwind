<?php
/**
 * User: qilin
 * Date: 2018/8/3
 * Time: 10:30
 */

namespace app\modules\admin\controllers;

use app\models\Admin\House;
use app\models\Admin\WorkLife;
use yii\data\Pagination;
use Yii;

/**
 * WaterBaseController implements the CRUD actions for WaterBase model.
 */
class WorkLifeController extends CommonController
{
    public function actionIndex(){
        $this->layout = 'layout1';
        $house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
        $query = WorkLife::find()->select('w.*,h.housename')->alias('w')->leftJoin('house h','h.id = w.house_id');
        if (!empty($house_id)) {
            $query = $query->where(['w.house_id'=>$house_id]);
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
        $res = WorkLife::deleteAll(['id'=>$id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }
    public function actionAdd(){
        $this->layout = 'layout1';
        $house = House::find()->where(['parentId'=>0])->all();
        return $this->render('add',[
            'house'=>$house
        ]);
    }

    public function actionCreate(){
        $data = Yii::$app->request->post();
        if ($data['name'] == ""|| $data['house_id'] =='') {
            return json_encode(['status' => -200, 'message' => '缺少参数']);
        }
        $data['create_time'] = time();
        $m = new WorkLife();
        $m->setAttributes($data, false);
        if (!$m->save()) {
            return json_encode(['code' => -200, 'msg' => $m->getFirstErrors()]);
        }
        return json_encode(['code' => 200, 'msg' => '添加成功']);
    }
}
