<?php
/**
 * User: qilin
 * Date: 2018/8/3
 * Time: 10:30
 */

namespace app\modules\API\controllers;

use app\models\Admin\House;
use app\models\Admin\Wenhao;
use yii\data\Pagination;
use Yii;

/**
 * WaterBaseController implements the CRUD actions for WaterBase model.
 */
class WenhaoController extends TmlController
{
    public function actionIndex(){
        $this->layout = 'layout1';
        $user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
        $pagenum = empty($this->post['pagenum']) ? 1 : $this->post['pagenum'];
        $page_size = \Yii::$app->params['APP_PAGE_SIZE'];
        if (!$user_id) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
        }
        $query = Wenhao::find()->where(['user_id'=>$user_id]);
        $count = $query->count();
        $data = $query->offset(($pagenum-1)*$page_size)
            ->limit($page_size)
            ->orderBy('id desc')->asArray()
            ->all();
        if ($data) {
            foreach ($data as $k => $v) {
                $data[$k]['time'] = empty($v['time']) ? '--' : date('Y-m-d H:i:s',$v['time']);
            }
        }
        echo json_encode(['status'=>200,'message'=>'success','code'=>$data]);exit;
    }
    public function actionAdd()
    {
        $data = $this->post;
        if ($data['user_id'] =='') {
            return json_encode(['status' => -200, 'message' => '参数错误']);
        }
        $data['time'] = time();
        $m = new Wenhao();
        $m->setAttributes($data, false);
        if (!$m->save()) {
            return json_encode(['status' => -200, 'message' => $m->getFirstErrors()]);
        }
        return json_encode(['status' => 200, 'message' => '申请成功','code'=>'【'.$m->id.'】'.$data['title']]);
    }
    public function actionHouse(){
        $m = new House();
        $data = $m->find()->select('id,housename')->where(['parentId'=>0])->asArray()->all();
        $n = [['id'=>-1,'housename'=>'综合部'],['id'=>-2,'housename'=>'工程部']];
        $list = array_merge($data,$n);
        echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;
    }
}
