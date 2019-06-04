<?php
/**
 * User: qilin
 * Date: 2018/11/27
 * Time: 15:15
 */

namespace app\modules\admin\controllers;

use app\models\Admin\House;
use app\models\Admin\PassRecord;
use Yii;
use yii\data\Pagination;


class PassRecordController extends CommonController
{

    public function actionIndex()
    {
        $this->layout = "layout1";
        $house_id = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
        $type = empty(Yii::$app->request->get()['user_type']) ? '' : Yii::$app->request->get()['user_type'];
        $stime = empty(Yii::$app->request->get()['stime']) ? '' : Yii::$app->request->get()['stime'];
        $etime = empty(Yii::$app->request->get()['etime']) ? '' : Yii::$app->request->get()['etime'];
        $session = \Yii::$app->session;
        $lists = explode(',',$session['admin']['house_ids']);
        $jquery = PassRecord::find()->alias('p')->select('p.*,u.TrueName,u.Tell,h.housename')->leftJoin('user u', 'u.id = p.user_id')
        ->leftJoin('house h','h.id = p.house_id')->where(['in','p.house_id',$lists]);
        if (!empty($house_id)) {
            $jquery = $jquery->andWhere(['p.house_id'=> $house_id]);
        }
        if (!empty($type)) {
            $jquery = $jquery->andWhere(['p.user_type'=> $type]);
        }
        if(!empty($stime) && !empty($etime)){
            $query = $jquery->andWhere(['between','FROM_UNIXTIME(p.pass_time/1000,\'%Y-%m-%d\')',$stime,$etime]);
        }
        $count = $jquery->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $data = $jquery
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('p.id desc')
            ->asArray()
            ->all();
        $house = House::find()->where(['parentId' => 0])->asArray()->all();
        return $this->render('index', [
            'data' => $data,
            'pagination' => $pagination,
            'house' => $house,
            'count' => $count
        ]);
    }
}
