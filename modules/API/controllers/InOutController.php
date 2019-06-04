<?php
/**
 * User: qilin
 * Date: 2018/4/10
 * Time: 9:55
 */
namespace app\modules\API\controllers;

use app\models\Admin\House;
use Yii;
use app\models\Admin\InOut;

class InOutController extends TmlController
{

    public function actionIndex(){
        $user_id = empty($this->post['user_id']) ? '' : $this->post['user_id'];
        $pagenum = empty($this->post['pagenum']) ? 1 : $this->post['pagenum'];
        $page_size = 6;
        if (!$user_id) {
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
        }
        $data = InOut::find()->where(['user_id'=>$user_id])->offset(($pagenum-1)*$page_size)
            ->limit($page_size)->orderBy('id desc')->asArray()->all();
        $item = [];
        foreach($data as $v){
            $v['time'] = date('Y-m-d',$v['time']);
            $house = House::find()->select('housename')->where(['id'=>$v['seat_id']])->asArray()->one();
            $v['seatname'] = $house['housename'];
            $name = explode(',',$v['name']);
            $num = explode(',',$v['num']);
            if(count($name) == 1){
                $v['attr'][] =$name[0].','.$num[0];
            }
            if(count($name) == 2){
                $v['attr'][] =$name[0].','.$num[0];
                $v['attr'][] =$name[1].','.$num[1];
            }
            if(count($name) > 2){
                for($i=0;$i<3;$i++){
                    $v['attr'][] =$name[$i].','.$num[$i];

                }
            }
            if($v['name'] ==""){
                $v['attr'] =[];
            }
            $item[] = $v;
        }
        if(!$item){
            echo json_encode(['status'=>200,'message'=>'没有了','code'=>[]]);exit;
        }
        echo json_encode(['status'=>200,'message'=>'success','code'=>$item]);exit;
    }
    public function actionAdd()
    {
        $data = $this->post;
        if ($data['time'] == ""|| $data['user_id'] =='') {
            return json_encode(['status' => -200, 'message' => '参数错误']);
        }
        $data['create_time'] = time();
        $data['time'] = strtotime($data['time']);
        $m = new InOut();
        $m->setAttributes($data, false);
        if (!$m->save()) {
            return json_encode(['status' => -200, 'message' => $m->getFirstErrors()]);
        }
        return json_encode(['status' => 200, 'message' => '成功']);
    }
    public function actionDel()
    {
        $data = $this->post;
        if ($data['id'] == "") {
            return json_encode(['status' => -200, 'message' => '参数错误']);
        }
        $res = InOut::deleteAll(['id'=>$data['id']]);
        if (!$res) {
            return json_encode(['status' => -200, 'message' => '删除失败']);
        }
        return json_encode(['status' => 200, 'message' => '成功']);
    }
    public function actionDet(){
        $id = $this->post;
        if(empty($id['id']) || $id==''){
            echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
        }
        $data = InOut::find()->where(['id'=>$id])->asArray()->one();
        $data['time'] = date('Y-m-d',$data['time']);
        $house = House::find()->select('housename')->where(['id'=>$data['seat_id']])->asArray()->one();
        $house1 = House::find()->select('housename')->where(['id'=>$data['house_id']])->asArray()->one();
        $data['seatname'] = $house['housename'];
        $data['housename'] = $house1['housename'];
        $name = explode(',',$data['name']);
        $num = explode(',',$data['num']);
        for($i=0;$i<count($name);$i++){
            if($data['name']!=""){
                $data['attr'][] =$name[$i].','.$num[$i];
            }else{
                $data['attr'] =[];
            }
        }
        if(!$data){
            echo json_encode(['status'=>200,'message'=>'没有了','code'=>[]]);exit;
        }
        echo json_encode(['status'=>200,'message'=>'success','code'=>$data]);exit;
    }
}