<?php
/**
 * User: qilin
 * Date: 2018/8/3
 * Time: 10:30
 */

namespace app\modules\admin\controllers;

use app\models\Admin\Wenhao;
use yii\data\Pagination;
use app\models\Admin\House;
use Yii;

/**
 * WaterBaseController implements the CRUD actions for WaterBase model.
 */
class WenhaoController extends CommonController
{
    public function actionIndex(){
        $this->layout = 'layout1';
        $house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
        $session = \Yii::$app->session;
        $list = explode(',',$session['admin']['house_ids']);
        $group_id = $session['admin']['group_id'];
        $query = Wenhao::find()->where(['in','house_id',$list]);
        if (!empty($house_id)) {
            $query = $query->andWhere(['house_id'=>$house_id]);
        }
        $count = $query->count();
        $pagination = new Pagination(['totalCount'=>$count]);
        $data = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('id desc')->asArray()
            ->all();
        $house = House::find()->where(['parentId'=>0])->asArray()->all();
        return $this->render('index',[
            'data'=>$data,
            'pagination' => $pagination,
            'house'=>$house,
            'group_id'=>$group_id
        ]);
    }
    public function actionDel(){
        $id = empty(Yii::$app->request->post()['id']) ? 0 : Yii::$app->request->post()['id'];
        if (empty($id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $res = Wenhao::deleteAll(['id'=>$id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }
}
