<?php

namespace app\modules\API\controllers;

use Yii;
use yii\web\Controller;
use app\util\Map;
use app\models\Admin\O2oHotel;
use app\models\Admin\HotelFacilities;
use app\models\Admin\O2oBrand;
use app\models\Admin\House;
use app\models\Admin\HotelRoom;
use app\models\Admin\HotelImgs;
use app\models\Admin\HotelBooking;

class HotelController extends Controller{
    public $enableCsrfValidation = false;

	protected $request;
	protected $callback;

	/**	
	 * 初始化
	 **/
	public function init(){
		$this->request = Yii::$app->request;
	}
	
	/**	
	 * 获取酒店列表信息 tml 20171020
	 **/
	public function actionGetHotelList(){
		//附近
		$long = empty($this->request->get()['long']) ? 0 : $this->request->get()['long']; // 经度
		$lati = empty($this->request->get()['lati']) ? 0 : $this->request->get()['lati']; //纬度
		$len  = empty($this->request->get()['len']) ? 0 : $this->request->get()['len']; //距离
		//商圈
		$house_id = empty($this->request->get()['house_id']) ? 0 : $this->request->get()['house_id'];
		//星级
		$hotel_star = empty($this->request->get()['hotel_star']) ? 0 : $this->request->get()['hotel_star']; 
		//价格
		$min_price = empty($this->request->get()['min_price']) ? 0 : $this->request->get()['min_price']; //价格区间最小值
		$max_price = empty($this->request->get()['max_price']) ? 0 : $this->request->get()['max_price']; //价格区间最大值
		//排序[1：距离优先；2：低价优先；3：高价优先；4：人气优先；]
		$order = empty($this->request->get()['order']) ? 0 : $this->request->get()['order'];
		//筛选品牌
		$brand_id = empty($this->request->get()['brand_id']) ? 0 : $this->request->get()['brand_id'];
		//当前页码
		$pagenum = empty($this->request->get()['pagenum']) ? 1 : $this->request->get()['pagenum'];
		//每页显示条数
		$pagesize = empty($this->request->get()['pagesize']) ? 10 : $this->request->get()['pagesize'];

		//搜索条件
		$con = 'h.is_del=0 and h.audit_state=1 and h.state=1';
		//附近
		if (!empty($len)) {
			if (empty($long) || empty($lati)) {
				echo json_encode(['status'=>-200,'message'=>'请开启定位功能，否则无法搜索附近的商家','code'=>[]]);exit;
			}
			$arr = Map::getRange($long,$lati,$len);
			if (empty($arr)) {
				echo json_encode(['status'=>-200,'message'=>'附近搜索失败','code'=>[]]);exit;
			}

			$con .= ' and h.longitude >= '.$arr['minLng'].' and  h.longitude <= '.$arr['maxLng'].' and h.latitude >= '.$arr['minLat'].' and h.latitude <= '.$arr['maxLat'];
		}
		//商圈
		if (!empty($house_id)) {
			$con .= ' and h.house_id='.$house_id;
		}
		//星级
		if (!empty($hotel_star)) {
			$con .= ' and h.hotel_star='.$hotel_star;
		}
		//价格
		if (!empty($min_price)) {
			$con .= ' and h.price>='.$min_price;
		}
		if (!empty($max_price)) {
			$con .= ' and h.price<='.$max_price;
		}
		//品牌筛选
		if (!empty($brand_id)) {
			$con .= ' and h.brand_id<='.$brand_id;
		}
		$orderby = 'h.audit_time desc';
		if (!empty($order)) {
			if ($order == 2) {
				$orderby = 'h.price asc,h.audit_time desc';
			} elseif ($order == 3) {
				$orderby = 'h.price asc,h.audit_time desc';
			} elseif ($order == 4) {
				$orderby = 'h.likes desc,h.audit_time desc';
			} elseif ($order == 1) {
				$orderby = 'distance asc,h.audit_time desc';
			}
		}

		$sql = "select h.*,b.brand_name,SQRT(POWER(h.longitude-$long,2)+POWER(h.latitude-$lati,2)) as distance from o2o_hotel h left join o2o_brand b on h.brand_id=b.brand_id where ".$con." order by ".$orderby." limit ".($pagenum-1)*$pagesize.",".$pagenum*$pagesize;
		$list = Yii::$app->db->createCommand($sql)->queryAll();
		
		// echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;

		// var_dump(Map::getDistance(113.721861,34.709004,113.721861,34.709004));exit;

		$data = [];
		if ($list) {
			foreach ($list as $k => $v) {
				$item = [];
				$item['hotel_id']   = $v['hotel_id'];
				$item['hotel_name'] = $v['hotel_name'];
				$item['hotel_img']  = $v['hotel_img'];
				$item['price']      = $v['price'];
				// $item['facilities'] = HotelFacilities::find()->select('faci_icon')->where(['in','faci_id',explode(',', $v['facilities'])])->column();
				$item['hotel_star'] = $v['hotel_star'];
				$item['longitude']  = $v['longitude'];
				$item['latitude']   = $v['latitude'];
				$item['distance']   = Map::getDistance($long,$lati,$v['longitude'],$v['latitude']);
				$data[] = $item;
			}
		}
		// var_dump($data);exit;
		echo json_encode(['status'=>200,'message'=>'success','code'=>$data]);exit;
	}

	/**	
	 * 获取品牌信息 tml 20171020
	 **/
	public function actionGetBrand(){
		$type = empty($this->request->get()['type']) ? 1 : $this->request->get()['type'];
		$list = O2oBrand::find()->where(['type'=>$type])->asArray()->all();
		echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;
	}

	/**	
	 * 获取商圈信息 tml 20171020
	 **/
	public function actionGetHouse(){
		$city_id = empty($this->request->get()['city_id']) ? 1 : $this->request->get()['city_id'];
		$list = House::find()->select('id as house_id,housename as house_name')->where(['cityid'=>$city_id,'parentId'=>0])->asArray()->all();
		echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;
	}

	/**	
	 * 获取酒店首页信息 tml 20171020
	 **/
	public function actionGetHotel(){
		$hotel_id = empty($this->request->get()['hotel_id']) ? 0 : $this->request->get()['hotel_id'];
		$long = empty($this->request->get()['longitude']) ? 0 : $this->request->get()['longitude'];
		$lati = empty($this->request->get()['latitude']) ? 0 : $this->request->get()['latitude'];
		if (empty($hotel_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>[]]);exit;
		}

		$hotel = O2oHotel::find()->where(['hotel_id'=>$hotel_id])->one();

		$data = [];

		if ($hotel) {
			$data['hotel_id']   = $hotel['hotel_id'];
			$data['hotel_name'] = $hotel['hotel_name'];
			$data['hotel_img']  = $hotel['hotel_img'];
			$data['address']    = $hotel['address'];
			$data['longitude']  = $hotel['longitude'];
			$data['latitude']   = $hotel['latitude'];
			$data['distance']   = Map::getDistance($long,$lati,$hotel['longitude'],$hotel['latitude']);
			$data['room_list']  = HotelRoom::find()->select('room_id,room_name,price')->where(['is_del'=>0,'audit_state'=>1,'state'=>1])->asArray()->all();
		}

		echo json_encode(['status'=>200,'message'=>'success','code'=>$data]);exit;
	}

	/**	
	 * 获取酒店详情信息 tml 20171020
	 **/
	public function actionGetHotelDetail(){
		$hotel_id = empty($this->request->get()['hotel_id']) ? 0 : $this->request->get()['hotel_id'];
		if (empty($hotel_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>[]]);exit;
		}

		$hotel = O2oHotel::find()->select('hotel_name,hotel_star,hotel_tel,hotel_intro,open_year,update_year,in_time,leave_time,total_rooms,deposit')->where(['hotel_id'=>$hotel_id])->asArray()->one();

		echo json_encode(['status'=>200,'message'=>'success','code'=>$hotel]);exit;
	}

	/**	
	 * 获取酒店设施 tml 20171020
	 **/
	public function actionGetFacilities(){
		$hotel_id = empty($this->request->get()['hotel_id']) ? 0 : $this->request->get()['hotel_id'];
		if (empty($hotel_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>[]]);exit;
		}

		$faci = O2oHotel::find()->select('facilities')->where(['hotel_id'=>$hotel_id])->scalar();
		
		$facilities = HotelFacilities::find()->select('faci_name,faci_icon')->where(['in','faci_id',explode(',', $faci)])->asArray()->all();

		echo json_encode(['status'=>200,'message'=>'success','code'=>$facilities]);exit;
	}

	/**	
	 * 获取酒店相册信息 tml 20171021
	 **/
	public function actionGetHotelImgs(){
		$hotel_id = empty($this->request->get()['hotel_id']) ? 0 : $this->request->get()['hotel_id'];
		if (empty($hotel_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>[]]);exit;
		}

		$imgs = HotelImgs::find()->select('path')->where(['hotel_id'=>$hotel_id])->column();

		echo json_encode(['status'=>200,'message'=>'success','code'=>$imgs]);exit;
	}

	/**	
	 * 获取酒店客房详情信息 tml 20171021
	 **/
	public function actionGetRoomDetail(){
		$room_id = empty($this->request->get()['room_id']) ? 0 : $this->request->get()['room_id'];
		if (empty($room_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>[]]);exit;
		}

		$room = (new \yii\db\Query())
			->select('r.hotel_id,h.hotel_name,r.room_id,r.room_name,r.room_img,r.bed_type,r.breakfast,r.wifi,r.room_window,r.to_live,r.bathroom,r.room_space,r.floor')
			->from('hotel_room r')
			->leftjoin('o2o_hotel h','r.hotel_id=h.hotel_id')
			->where(['r.is_del'=>0,'r.audit_state'=>1,'r.state'=>1,'r.room_id'=>$room_id])
			->all();

		echo json_encode(['status'=>200,'message'=>'success','code'=>$room]);exit;
	}

	/**	
	 * 酒店预定下单 tml 20171021
	 **/
	public function actionHotelBook(){
		$hotel_id    = empty($this->request->post()['hotel_id']) ? 0 : $this->request->post()['hotel_id'];
		$room_id     = empty($this->request->post()['room_id']) ? 0 : $this->request->post()['room_id'];
		$userId      = empty($this->request->post()['userId']) ? 0 : $this->request->post()['userId'];
		$in_date     = empty($this->request->post()['in_date']) ? '' : $this->request->post()['in_date'];
		$out_date    = empty($this->request->post()['out_date']) ? '' : $this->request->post()['out_date'];
		$room_nums   = empty($this->request->post()['room_nums']) ? 1 : $this->request->post()['room_nums'];
		$person_name = empty($this->request->post()['person_name']) ? '' : $this->request->post()['person_name'];
		$person_tel  = empty($this->request->post()['person_tel']) ? '' : $this->request->post()['person_tel'];
		$in_time     = empty($this->request->post()['in_time']) ? '' : $this->request->post()['in_time'];

		if (empty($hotel_id) || empty($room_id) || empty($userId)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>[]]);exit;
		}
		if (empty($in_date) || empty($out_date) || !strtotime($in_date) || !strtotime($out_date)) {
			echo json_encode(['status'=>-200,'message'=>'请选择正确的入住/离店日期','code'=>[]]);exit;
		}
		if (strtotime($in_date) < strtotime(date('Y-m-d',time()))) {
			echo json_encode(['status'=>-200,'message'=>'不可预定在今天之前日期','code'=>[]]);exit;
		}
		if (strtotime($in_date) >= strtotime($out_date)) {
			echo json_encode(['status'=>-200,'message'=>'入住日期不可在离店日期之后','code'=>[]]);exit;
		}
		if (empty($person_name)) {
			echo json_encode(['status'=>-200,'message'=>'请输入联系人姓名','code'=>[]]);exit;
		}
		if (empty($person_tel)) {
			echo json_encode(['status'=>-200,'message'=>'请输入联系方式','code'=>[]]);exit;
		}
		if (empty($in_time)) {
			echo json_encode(['status'=>-200,'message'=>'请选择预计到达时间','code'=>[]]);exit;
		}

		$con['is_del']      = 0;
		$con['state']       = 1;
		$con['audit_state'] = 1;
		$con['hotel_id']    = $hotel_id;
		$con['room_id']     = $room_id;
		$room = HotelRoom::find()->where($con)->asArray()->one();
		if (!$room) {
			echo json_encode(['status'=>-200,'message'=>'客房信息错误','code'=>[]]);exit;
		}
		$days = (strtotime($out_date)-strtotime($in_date))/60/60/24;
		$price = $room['price'];
		$total_price = bcmul($price,bcmul($days, $room_nums));

		$model = new HotelBooking();
		$model->hotel_id    = $hotel_id;
		$model->room_id     = $room_id;
		$model->in_date     = $in_date;
		$model->out_date    = $out_date;
		$model->days        = intval($days);
		$model->room_nums   = $room_nums;
		$model->price       = $price;
		$model->total_price = $total_price;
		$model->person_name = $person_name;
		$model->person_tel  = $person_tel;
		$model->in_time     = $in_time;
		$model->book_time   = time();
		$model->book_user   = $userId;
		$res = $model->save();
		if ($res) {
			echo json_encode(['status'=>200,'message'=>'预定成功','code'=>[]]);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'预定失败','code'=>[]]);exit;
	}

}