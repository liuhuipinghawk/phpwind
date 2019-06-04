<?php
/**
 * User: qilin
 * Date: 2018/11/27
 * Time: 15:15
 */

namespace app\modules\admin\controllers;

use Yii;
use app\API\models\Suggestion;
use yii\data\Pagination;
use app\models\Admin\House;


class SuggestionController extends CommonController
{

    public function actionIndex()
    {
        $this->layout = "layout1";
        $jquery = Suggestion::find()->alias('s')->select('s.*,u.TrueName,u.Tell,h.housename')->leftJoin('user u', 'u.id = s.userId')->
        leftJoin('certification c','c.UserId = s.userId')->leftJoin('house h','h.id = c.HouseId');
        $count = $jquery->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $data = $jquery
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('s.suggestionId desc')
            ->asArray()
            ->all();
        return $this->render('index', [
            'data' => $data,
            'pagination' => $pagination,
        ]);
    }

    public function actionDel(){
        $op_id = empty(Yii::$app->request->post()['op_id']) ? 0 : Yii::$app->request->post()['op_id'];
        $res = Suggestion::deleteAll(['suggestionId'=>$op_id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }
}
