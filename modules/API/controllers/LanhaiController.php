<?php
/**
 * User: qilin
 * Date: 2018/7/16
 * Time: 15:21
 */
namespace app\modules\API\controllers;

use app\util\MagicCrypt;
use app\models\Admin\User;

Class LanhaiController extends TmlController{

    /*
     * 世为访客连接
     */
    public function actionIndex(){

        $user_id = empty($this->post['user_id']) ? '' : $this->post['user_id'];
        $house_id = empty($this->post['house_id']) ? '' : $this->post['house_id'];
        $seat_id = empty($this->post['seat_id']) ? '' : $this->post['seat_id'];
        $name = empty($this->post['name']) ? '' : $this->post['name'];
        $mobile = empty($this->post['mobile']) ? '' : $this->post['mobile'];
        $end_time = empty($this->post['end_time']) ? '' : $this->post['end_time'];
        if(!$user_id ||!$house_id ||!$seat_id ||!$name ||!$mobile ||!$end_time){
            return json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);
        }
        $data = strtotime(date('Y-m-d H:i:s',strtotime('+'.$end_time.' hour')));
        $params = \Yii::$app->params['house_config'][$house_id];
        $encryptString = $user_id.'_'.$name.'_'.$mobile.','.bcmul(time(),1000,0).','.$params['code'].',1,97,97,'.implode(',',$params[$seat_id]);
        $encryptObj = new MagicCrypt();
        $ret = $encryptObj->encrypt($encryptString);
//        $url = 'http://106.15.127.161:8088/index.php?r=API/h5/visitor-book'.$house_id.'-'.$seat_id.'&token='.$ret.'&end_time='.$data.'&house_id='.$house_id.'&seat_id='.$seat_id;
        $url = 'http://106.15.127.161/index.php?r=API/h5/visitor-book'.$house_id.'-'.$seat_id.'&token='.$ret.'&end_time='.$data;
        return json_encode(['status'=>200,'message'=>'success','code'=>$url]);
    }

    /**
     * 根据手机号获取用户通行权限
     * @Author   tml
     * @DateTime 2019-03-05
     * @return   [type]     [description]
     */
    public function actionGetUserPermission(){
        $phone = empty($this->get['phone']) ? '' : $this->get['phone'];
        if (empty($phone)) {
            return json_encode(['status'=>-200,'message'=>'参数错误']);
        }
        $user = new User();
        $res = $user->getUserPermission($phone);
        echo json_encode($res);exit;
    }

    public function actionPostData($url,$param,$sign,$timestamp)
    {
        $header = array();
        $header[] = 'Content-Type:application/json;charset=utf-8';
        $header[] = 'appid:'.$this->appid;
        $header[] = 'sign:'.$sign;
        $header[] = 'timestamp:'.$timestamp;

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_HEADER,true);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);//用post方法传送参数
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);
        $ret = substr($response, $headerSize);
        return json_decode($ret,true);
    }
}