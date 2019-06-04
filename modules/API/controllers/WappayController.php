<?php

namespace app\modules\API\controllers;

use Yii;
use yii\web\Controller;
use app\models\Admin\ParkingPayment;
use app\models\Admin\PrePayment;
use app\common\wappay\Wxpay;
use app\common\wappay\Alipay;

class WappayController extends Controller{
	public $enableCsrfValidation = false;
	protected $post;

	/**
	 * 初始化
	 * @Author   tml
	 * @DateTime 2017-12-19
	 * @return   [type]     [description]
	 */
	public function init(){
		$this->post = Yii::$app->request->post();
	}

	/**
	 * 停车缴费去支付
	 * @Author   tml
	 * @DateTime 2017-12-21
	 * @return   [type]     [description]
	 */
	public function actionGoToPay(){

        // echo json_encode(['status' =>-200,'message'=>'服务升级中，请耐心等待...','code'=>(object)[]]);exit;

		$user_id      = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
		$pay_type     = empty($this->post['pay_type']) ? '' : $this->post['pay_type'];
		$record_code  = empty($this->post['record_code']) ? '' : $this->post['record_code'];
		$parking_code = empty($this->post['parking_code']) ? '' : $this->post['parking_code'];
		$parking_name = empty($this->post['parking_name']) ? '' : $this->post['parking_name'];
		$car_no       = empty($this->post['car_no']) ? '' : $this->post['car_no'];
		$park_card    = empty($this->post['park_card']) ? '' : $this->post['park_card'];
		$begin_time   = empty($this->post['begin_time']) ? 0 : strtotime($this->post['begin_time']);
		$parking_fee  = empty($this->post['parking_fee']) ? 0 : $this->post['parking_fee'];
		if (empty($user_id)) {
			echo json_encode(['status' =>-200,'message'=>'user_id为空','code'=>(object)[]]);exit;
		}
		if (empty($pay_type)) {  
			echo json_encode(['status' =>-200,'message'=>'pay_type为空','code'=>(object)[]]);exit;
		}
		if (!in_array($pay_type,[1,2])) {
			echo json_encode(['status' =>-200,'message'=>'pay_type参数值错误','code'=>(object)[]]);exit;
		}
		if (empty($record_code)) {
			echo json_encode(['status'=>-200,'message'=>'record_code为空','code'=>(object)[]]);exit;
		}
		if (empty($parking_code)) {
			echo json_encode(['status'=>-200,'message'=>'parking_code为空','code'=>(object)[]]);exit;
		}
		if (empty($parking_name)) {
			echo json_encode(['status'=>-200,'message'=>'parking_name为空','code'=>(object)[]]);exit;
		}
		if (empty($car_no)) {
			echo json_encode(['status'=>-200,'message'=>'car_no为空','code'=>(object)[]]);exit;
		}
		if (empty($begin_time)) {
			echo json_encode(['status'=>-200,'message'=>'begin_time为空','code'=>(object)[]]);exit;
		}
		if (empty($parking_fee)) {
			echo json_encode(['status'=>-200,'message'=>'parking_fee为空','code'=>(object)[]]);exit;
		}

		$order = ParkingPayment::find()->where(['record_code'=>$record_code,'parking_fee'=>$parking_fee])->one();
		$order_sn    = '';
		if (empty($order)) {
			//处理订单信息
			$order_sn = date('YmdHis',time()).rand(1000,9999);
			$parking_payment = new ParkingPayment();
			$parking_payment->user_id      = $user_id;
			$parking_payment->order_sn     = $order_sn;
			$parking_payment->record_code  = $record_code;
			$parking_payment->parking_code = $parking_code;
			$parking_payment->parking_name = $parking_name;
			$parking_payment->car_no       = $car_no;
			$parking_payment->park_card    = $park_card;
			$parking_payment->begin_time   = $begin_time;
			$parking_payment->parking_fee  = $parking_fee;
			$parking_payment->create_time  = time();
			$res = $parking_payment->save();
			if (!$res) {
				echo json_encode(['status'=>-200,'message'=>'停车缴费订单创建失败','code'=>(object)[]]);exit;
			}
		} else {			
			if ($order['status'] == 2 && !empty($order['pay_time'])) {
				echo json_encode(['status'=>-200,'message'=>'订单已成功支付，请不要重复支付','code'=>(object)[]]);exit;
			}
			$order_sn = $order['order_sn'];
		}
		
		$body = '兴业物联-停车缴费';

		if ($pay_type == 1) { //微信支付
			$wxpay = new Wxpay();
			$res = $wxpay->wxUnifiedOrder($body,$order_sn,$parking_fee,'parking_payment');
			if ($res['status'] == 200) {
				$res['data']['order_sn'] = $order_sn;
				echo json_encode(['status'=>200,'message'=>'SUCCESS','code'=>$res['data']]);exit;
			}
			echo json_encode(['status'=>-200,'message'=>$res['msg'],'code'=>(object)[]]);exit;
		} else if ($pay_type == 2) { //支付宝支付
			$alipay = new Alipay();
			$res = $alipay->alipay($body,$order_sn,$parking_fee,'parking_payment');
			echo json_encode(['status'=>200,'message'=>'SUCCESS','code'=>['ali_order_info'=>$res,'order_sn'=>$order_sn]]);exit;
		} 
	}

    /**
     * 获取订单信息及列表
     */
    public function actionOrderList(){
        $data = array();
        $arr = array();
        $user_id = empty(Yii::$app->request->get()['user_id']) ? '' : Yii::$app->request->get()['user_id'];
        $page_num = Yii::$app->request->get('pagenum') ? Yii::$app->request->get('pagenum') : 1;
        if (empty($user_id) || empty($page_num)) {
            echo json_encode([
                'code' => $data,
                'status' => 205,
                'message' => '参数不为空！',
            ]);
            exit;
        }
        if (empty($page_num)) {
            $page_num = 1;
        }
        $pageSize = 6;
        $where['user_id'] = $user_id;
        $where['status']  = 2;
        $PageRow = ($page_num - 1) * $pageSize;
        $parking = ParkingPayment::find()->where($where)->offset($PageRow)->limit($pageSize)->orderBy('pay_time desc')->asArray()->all();
        $jsonobj = array();
        if(!empty($parking)){
            for ($i=0;$i<count($parking);$i++){
                $arr[$i]['order_id'] = $parking[$i]['order_id'];
                $arr[$i]['parking_name'] = $parking[$i]['parking_name'];
                $arr[$i]['pay_time'] = date('Y-m-d H:i:s',$parking[$i]['pay_time']);
                $arr[$i]['begin_time'] = date('Y-m-d H:i:s',$parking[$i]['begin_time']);
                $arr[$i]['timelength'] = $this->Sec2Time($parking[$i]['pay_time'] - $parking[$i]['begin_time']);
                $arr[$i]['pay_type'] = $parking[$i]['pay_type'];
                $arr[$i]['parking_fee'] = $parking[$i]['parking_fee']."元";
                $arr[$i]['car_no'] = $parking[$i]['car_no'];
                $jsonobj = json_encode(array('code'=>$arr,'status'=>200,'message'=>'加载成功'));
            }
            echo $jsonobj;
            exit;
        }else{
            echo json_encode([
                'code' => $parking,
                'status' => 200,
                'message' => '暂时没数据！',
            ]);
            exit;
        }
    }

    /**
     * 订单详情
     */
    public function actionOrderView(){
        $data = array();
        $order_id = empty(Yii::$app->request->get()['order_id']) ? '' : Yii::$app->request->get()['order_id'];
        if(empty($order_id)){
            echo json_encode([
                'code' => $data,
                'status' => 205,
                'message' => '参数不为空！',
            ]);
            exit;
        }
        $where['order_id'] = $order_id;
        $parking = ParkingPayment::find()->where($where)->asArray()->one();
        $parking_fee = $parking['parking_fee'];
        $parking_name = $parking['parking_name'];
        $car_no = $parking['car_no'];
        $parking_code = $parking['parking_code'];
        $begin_time = $parking['begin_time'];
        $pay_time = $parking['pay_time'];
        $stop = $pay_time - $begin_time;
        $stop = $this->Sec2Time($stop);
        $datas = array(
            'parking_fee'=>$parking_fee,
            'parking_name'=>$parking_name,
            'car_no'=>$car_no,
            'parking_code'=>$parking_code,
            'begin_time'=>date('Y-m-d H:i:s',$begin_time),
            'pay_time'=>date('Y-m-d H:i:s',$pay_time),
            'pay_type'=>$parking['pay_type'],
            'timelength'=>$stop,
            'fee_scale'=>'10.00元/小时',
        );
        if (empty($parking)) {
            echo json_encode([
                'code' => $datas,
                'status' => 200,
                'message' => '暂时没数据！',
            ]);
            exit;
        } else {
            echo json_encode([
                'code' => $datas,
                'status' => 200,
                'message' => '主页数据加载成功！',
            ]);
            exit;
        }

    }

    function Sec2Time($time){
        if(is_numeric($time)){
            $value = array(
                "years" => 0, "days" => 0, "hours" => 0,
                "minutes" => 0, "seconds" => 0,
            );
            if($time >= 31556926){
                $value["years"] = floor($time/31556926);
                $time = ($time%31556926);
            }
            if($time >= 86400){
                $value["days"] = floor($time/86400);
                $time = ($time%86400);
            }
            if($time >= 3600){
                $value["hours"] = floor($time/3600);
                $time = ($time%3600);
            }
            if($time >= 60){
                $value["minutes"] = floor($time/60);
                $time = ($time%60);
            }
            $value["seconds"] = floor($time);
            if(empty($value["years"])){
                $t= $value["days"] ."天". $value["hours"] ."小时". $value["minutes"] ."分".$value["seconds"]."秒";
            }elseif (empty($value['years']) || empty($value['days'])){
                $t= $value["hours"] ."小时". $value["minutes"] ."分".$value["seconds"]."秒";
            }elseif (empty($value['years']) || empty($value['days']) || empty($value['hours'])){
                $t= $value["minutes"] ."分".$value["seconds"]."秒";
            }elseif (empty($value['years']) || empty($value['days']) || empty($value['hours']) || empty($value['minutes'])){
                $t= $value["seconds"]."秒";
            }else{
                $t='';        
            }
            //$t=$value["years"] ."年". $value["days"] ."天". $value["hours"] ."小时". $value["minutes"] ."分".$value["seconds"]."秒";
            Return $t;

        }else{
            return (bool) FALSE;
        }
    }

    /**
     * 订单支付状态查询
     * @Author   tml
     * @DateTime 2017-12-25
     * @return   [type]     [description]
     */
    public function actionOrderPayStatusQuery(){
    	$out_trade_no = empty($this->post['out_trade_no']) ? '' : $this->post['out_trade_no'];
    	$trade_no     = empty($this->post['trade_no']) ? '' : $this->post['trade_no'];
    	$type         = empty($this->post['type']) ? '' : $this->post['type'];
    	if (empty($out_trade_no) || empty($type) || !in_array($type, [1,2])) {
    		echo json_encode(['status'=>-200,'message'=>'查询参数错误','code'=>[]]);exit;
    	}
    	if ($type == 1) {
            $wxpay = new Wxpay();
    		$res = $wxpay->wxpayOrderQuery($out_trade_no);
    		if ($res) {
    			echo json_encode(['status'=>200,'message'=>'支付成功','code'=>['order_sn'=>$out_trade_no]]);exit;
    		}
    		echo json_encode(['status'=>-200,'message'=>'支付失败','code'=>(object)[]]);exit;
    	} else if ($type == 2) {
    		if (empty($trade_no)) {
    			echo json_encode(['status'=>-200,'message'=>'查询参数错误','code'=>(object)[]]);exit;
    		}
            $alipay = new Alipay();
    		$res = $alipay->alipayOrderQuery($out_trade_no,$trade_no);
    		if ($res) {
    			echo json_encode(['status'=>200,'message'=>'支付成功','code'=>['order_sn'=>$out_trade_no]]);exit;
    		}
    		echo json_encode(['status'=>-200,'message'=>'支付失败','code'=>(object)[]]);exit;
    	}
    }
}
