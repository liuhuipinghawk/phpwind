<?php
/**
 * User: qilin
 * Date: 2018/8/3
 * Time: 10:30
 */

namespace app\modules\admin\controllers;

use app\models\Admin\WorkWeibao;
use yii\data\Pagination;
use Yii;

/**
 * WaterBaseController implements the CRUD actions for WaterBase model.
 */
class WorkWeibaoController extends CommonController
{
    public function actionIndex(){
        $this->layout = 'layout1';
        $type = empty(Yii::$app->request->get()['type']) ? 0 : Yii::$app->request->get()['type'];
        $cast = empty(Yii::$app->request->get()['cast']) ? 0 : Yii::$app->request->get()['cast'];
        $query = WorkWeibao::find();
        if (!empty($type)) {
            $query = $query->where(['type'=>$type]);
        }
        if (!empty($cast)) {
            $query = $query->andWhere(['cast'=>$cast]);
        }
        $count = $query->count();
        $pagination = new Pagination(['totalCount'=>$count]);
        $data = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();
        return $this->render('index',[
            'data'=>$data,
            'pagination' => $pagination,
        ]);
    }
    public function actionDel(){
        $id = empty(Yii::$app->request->post()['id']) ? 0 : Yii::$app->request->post()['id'];
        if (empty($id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $res = WorkWeibao::deleteAll(['id'=>$id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }
    public function actionAdd(){
        $this->layout = 'layout1';
        return $this->render('add');
    }

    public function actionCreate(){
        $data = Yii::$app->request->post();
        if ($data['content'] == ""|| $data['need'] =='') {
            return json_encode(['status' => -200, 'message' => '缺少参数']);
        }
        $data['create_time'] = time();
        $m = new WorkWeibao();
        $m->setAttributes($data, false);
        if (!$m->save()) {
            return json_encode(['code' => -200, 'msg' => $m->getFirstErrors()]);
        }
        return json_encode(['code' => 200, 'msg' => '添加成功']);
    }
}
