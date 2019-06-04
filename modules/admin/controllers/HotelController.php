<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Admin\O2oHotel;
use app\models\Admin\HotelFacilities;
use app\models\Admin\House;
use app\models\Admin\HotelImgs;
use app\models\Admin\O2oBrand;
use app\models\Admin\HotelRoom;
use app\models\Admin\RoomType;
use app\models\Admin\City;
use app\models\Admin\HotelBooking;
use yii\data\Pagination;

class HotelController extends CommonController{
    public $enableCsrfValidation = false;
	protected $post;
	protected $get;
	protected $session;
	/**
	 * 初始化
	 **/
	public function init(){
		$this->post = Yii::$app->request->post();
		$this->get  = Yii::$app->request->get();
		$this->session = Yii::$app->session;
	}

	/**
	 * 基础设施管理 tml 20171115 
	 **/
	public function actionFacilities(){
		$this->layout = 'layout1';

		$list = HotelFacilities::find()->where(['<>','state',-1])->all();

		return $this->render('facilities',[
			'list'=>$list
		]);
	}

	/**
	 * 新增基础设施 tml 20171115 
	 **/
	public function actionAddFacilities(){
		$this->layout = 'layout1';

		$id = empty($this->get['id']) ? 0 : $this->get['id'];

		$model = null;
		if (!empty($id)) {
			$model = HotelFacilities::find()->where(['faci_id'=>$id,'state'=>2])->one();
		}		

		return $this->render('add_facilities',[
			'model'=>$model
		]);
	}

	/**
	 * 新增基础设施提交操作 tml 20171116 
	 **/
	public function actionAjaxAddFacilities(){
		$faci_id   = empty($this->post['faci_id']) ? 0 : $this->post['faci_id'];
		$faci_name = empty($this->post['faci_name']) ? '' : $this->post['faci_name'];
		$faci_type = empty($this->post['faci_type']) ? '' : $this->post['faci_type'];
		$url = empty($this->post['url']) ? '' : $this->post['url'];
		if (empty($faci_name)) {
			echo json_encode(['code'=>-200,'msg'=>'基础设施名称不能为空']);exit;
		}
		if (empty($faci_type)) {
			echo json_encode(['code'=>-200,'msg'=>'基础设施所属类型不能为空']);exit;
		}
		if (empty($url)) {
			echo json_encode(['code'=>-200,'msg'=>'请上传设施图标']);exit;
		}
		$res = 0;
		$facilities = HotelFacilities::find()->where(['faci_name'=>$faci_name])->andWhere(['<>','faci_id',$faci_id])->andWhere(['<>','state',-1])->one();
		if ($facilities) {
			echo json_encode(['code'=>-200,'msg'=>'基础设施名称已存在']);exit;
		}
		if (empty($faci_id)) {
			$model = new HotelFacilities();
			$model->faci_name = $faci_name;
			$model->faci_type = $faci_type;
			$model->faci_icon = $url;
			$model->add_time  = time();
			$model->add_user  = $this->session->get('admin')['adminid'];
			$res = $model->save();
		} else {
			$update['faci_name'] = $faci_name;
			$update['faci_type'] = $faci_type;
			$update['faci_icon'] = $url;
			$update['update_time'] = time();
			$update['update_user'] = $this->session->get('admin')['adminid'];
			$res = HotelFacilities::updateAll($update,['faci_id'=>$faci_id]);
		}
		if ($res) {
			echo json_encode(['code'=>'200','msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>'-200','msg'=>'操作失败']);exit;
	}

	/**
	 * 新增基础设施提交操作 tml 20171116 
	 **/
	public function actionAjaxUpstateFacilities(){
		$faci_id = empty($this->post['id']) ? 0 : $this->post['id'];
		$state   = empty($this->post['state']) ? 0 : $this->post['state'];
		if (empty($faci_id) || empty($state)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		if (!in_array($state,[1,2,-1])) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$res = HotelFacilities::updateAll(['state'=>$state],['faci_id'=>$faci_id]);
		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
	}

	/**
	 * 酒店列表管理 tml 20171116 
	 **/
	public function actionHotel(){
		$this->layout = 'layout1';

		$con['is_del'] = 0;

		$query = (new \yii\db\Query())
			->select('oh.*,h.housename as house_name,b.brand_name')
			->from('o2o_hotel oh')
			->leftjoin('house h','oh.house_id=h.id')
			->leftjoin('o2o_brand b','oh.brand_id=b.brand_id')
			->where($con);

		$count = $query->count();
		$pagination = new Pagination(['totalCount' => $count]);
		$pagination->setPageSize(10);

		$list = $query
			->orderBy('oh.hotel_id desc')
			->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		return $this->render('hotel',[
			'list'=>$list,
			'pagination'=>$pagination
		]);
	}

	/**
	 * 新增酒店信息 tml 20171116 
	 **/
	public function actionAddHotel(){
		$this->layout = 'layout1';

		$hotel_id = empty($this->get['id']) ? 0 : $this->get['id'];

		$model = O2oHotel::find()->where(['hotel_id'=>$hotel_id])->one();
		$house = House::find()->where(['parentId'=>0])->all();
		$brand = O2oBrand::find()->where(['type'=>1])->all();
		$city  = City::find()->all();
		$facilities = HotelFacilities::find()->where(['faci_type'=>1,'state'=>1])->all();
		$hotel_imgs = HotelImgs::find()->where(['hotel_id'=>$hotel_id,'room_id'=>0,'type'=>1])->all();

		return $this->render('add_hotel',[
			'model'=>$model,
			'house'=>$house,
			'brand'=>$brand,
			'city'=>$city,
			'facilities'=>$facilities,
			'hotel_imgs'=>$hotel_imgs
		]);
	}

	/**
	 * 新增酒店操作 tml 20171117
	 **/
	public function actionAjaxAddHotel(){
		$postdata    = $this->post['data'];
		$hotel_id    = empty($postdata['hotel_id']) ? 0 : $postdata['hotel_id'];
		$hotel_name  = empty($postdata['hotel_name']) ? '' : $postdata['hotel_name'];
		$hotel_type  = empty($postdata['hotel_type']) ? 0 : $postdata['hotel_type'];
		$city_id     = empty($postdata['city_id']) ? 0 : $postdata['city_id'];
		$house_id    = empty($postdata['house_id']) ? 0 : $postdata['house_id'];
		$brand_id    = empty($postdata['brand_id']) ? 0 : $postdata['brand_id'];
		$hotel_star  = empty($postdata['hotel_star']) ? 0 : $postdata['hotel_star'];
		$hotel_intro = empty($postdata['hotel_intro']) ? '' : $postdata['hotel_intro'];
		$hotel_img   = empty($postdata['hotel_img']) ? '' : $postdata['hotel_img'];
		$price       = empty($postdata['price']) ? 0 : $postdata['price'];
		$hotel_tel   = empty($postdata['hotel_tel']) ? '' : $postdata['hotel_tel'];
		$open_year   = empty($postdata['open_year']) ? 0 : $postdata['open_year'];
		$update_year = empty($postdata['update_year']) ? 0 : $postdata['update_year'];
		$in_time     = empty($postdata['in_time']) ? '' : $postdata['in_time'];
		$leave_time  = empty($postdata['leave_time']) ? '' : $postdata['leave_time'];
		$total_rooms = empty($postdata['total_rooms']) ? 0 : $postdata['total_rooms'];
		$deposit     = empty($postdata['deposit']) ? '入住需要押金，金额以前台为准' : $postdata['deposit'];
		$facilities  = empty($postdata['facilities']) ? '' : $postdata['facilities'];
		$address     = empty($postdata['address']) ? '' : $postdata['address'];
		$longitude   = empty($postdata['longitude']) ? 0 : $postdata['longitude'];
		$latitude    = empty($postdata['latitude']) ? 0 : $postdata['latitude'];

		if (empty($hotel_name)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入酒店名称']);exit;
		}
		if (empty($hotel_type)) {
			echo json_encode(['code'=>-200,'msg'=>'请选择酒店类型']);exit;
		}
		if (empty($city_id)) {
			echo json_encode(['code'=>-200,'msg'=>'请选择所属区域']);exit;
		}
		if (empty($house_id)) {
			echo json_encode(['code'=>-200,'msg'=>'请选择所属楼盘']);exit;
		}
		if (empty($brand_id)) {
			echo json_encode(['code'=>-200,'msg'=>'请选择酒店品牌']);exit;
		}
		if (empty($hotel_star)) {
			echo json_encode(['code'=>-200,'msg'=>'请选择酒店星级']);exit;
		}
		if (empty($hotel_img)) {
			echo json_encode(['code'=>-200,'msg'=>'请上传酒店主图']);exit;
		}
		if (empty($price)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入酒店价格']);exit;
		}
		if (empty($hotel_tel)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入酒店电话']);exit;
		}
		if (empty($open_year)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入酒店开业年份']);exit;
		}
		if (empty($update_year)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入酒店装修年份']);exit;
		}
		if (empty($in_time)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入酒店入住时间']);exit;
		}
		if (empty($leave_time)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入酒店离店时间']);exit;
		}
		if (empty($total_rooms)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入酒店客房总数']);exit;
		}
		if (empty($address)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入酒店详细地址']);exit;
		}
		if (empty($longitude) || empty($latitude)) {
			echo json_encode(['code'=>-200,'msg'=>'请选择酒店坐标']);exit;
		}

		$hotel = O2oHotel::find()->where(['hotel_name'=>$hotel_name])->andWhere(['<>','hotel_id',$hotel_id])->andWhere(['<>','is_del',-1])->one();
		if ($hotel) {
			echo json_encode(['code'=>-200,'msg'=>'酒店名称已存在']);exit;
		}

		$res = 0;
		if (empty($hotel_id)) {
			$model = new O2oHotel();
			$model->hotel_name = $hotel_name;
			$model->hotel_type = $hotel_type;
			$model->city_id = $city_id;
			$model->house_id = $house_id;
			$model->brand_id = $brand_id;
			$model->hotel_star = $hotel_star;
			$model->hotel_intro = $hotel_intro;
			$model->hotel_img = explode(',', $hotel_img)[0];
			$model->price = $price;
			$model->hotel_tel = $hotel_tel;
			$model->open_year = $open_year;
			$model->update_year = $update_year;
			$model->in_time = $in_time;
			$model->leave_time = $leave_time;
			$model->total_rooms = $total_rooms;
			$model->deposit = $deposit;			
			$model->facilities = $facilities;
			$model->address = $address;
			$model->longitude = $longitude;
			$model->latitude = $latitude;
			$model->add_time = time();
			$model->add_user = $this->session->get('admin')['adminid'];
			$model->audit_time = time();
			$model->audit_state = 1;
			$model->audit_user = $this->session->get('admin')['adminid'];
			$res = $model->save();
			$hotel_id = $model->attributes['hotel_id'];
		} else {
			$update['hotel_name']  = $hotel_name;
			$update['hotel_type']  = $hotel_type;
			$update['city_id']     = $city_id;
			$update['house_id']    = $house_id;
			$update['brand_id']    = $brand_id;
			$update['hotel_star']  = $hotel_star;
			$update['hotel_intro'] = $hotel_intro;
			$update['hotel_img']   = explode(',', $hotel_img)[0];
			$update['price']       = $price;
			$update['hotel_tel']   = $hotel_tel;
			$update['open_year']   = $open_year;
			$update['update_year'] = $update_year;
			$update['in_time']     = $in_time;
			$update['leave_time']  = $leave_time;
			$update['total_rooms'] = $total_rooms;
			$update['deposit'] = $deposit;
			$update['facilities']  = $facilities;
			$update['address']     = $address;
			$update['longitude']   = $longitude;
			$update['latitude']    = $latitude;
			$update['update_time'] = time();
			$update['update_user'] = $this->session->get('admin')['adminid'];
			$res = O2oHotel::updateAll($update,['hotel_id'=>$hotel_id]);
		}

		if ($res) {
			$data = [];
			$hotel_imgs = explode(',', $hotel_img); 
			foreach ($hotel_imgs as $v) {
				if ($v) {
					$data[] = [$hotel_id,0,1,$v];
				}
			}
			$himgs_model = new HotelImgs();
			$himgs_model->deleteAll(['hotel_id'=>$hotel_id,'type'=>1]);
			Yii::$app->db->createCommand()->batchInsert(HotelImgs::tableName(), ['hotel_id','room_id','type','path'], $data)->execute();
			echo json_encode(['code'=>200,'msg'=>'提交成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'提交失败']);exit;
	}

	/**
	 * 修改酒店状态操作 tml 20171117
	 **/
	public function actionAjaxUpstateHotel(){
		$hotel_id = empty($this->post['hotel_id']) ? 0 : $this->post['hotel_id'];
		$tag    = empty($this->post['tag']) ? '' : $this->post['tag'];
		$state    = empty($this->post['state']) ? 0 : $this->post['state'];
		if (empty($hotel_id) || empty($state)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		if (!in_array($tag,['state','del']) || !in_array($state,[1,2,-1])) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$res = 0;
		if ($tag == 'del' && $state == -1) {
			$res = O2oHotel::updateAll(['is_del'=>$state],['hotel_id'=>$hotel_id]);
		}
		if ($tag == 'state' && in_array($state, [1,2])) {
			$res = O2oHotel::updateAll(['state'=>$state],['hotel_id'=>$hotel_id]);
		}
		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
	}

	/**
	 * 品牌管理 tml 20171117
	 **/
	public function actionBrand(){
		$this->layout = 'layout1';

		return $this->render('brand');
	}

	/**
	 * 客房列表 tml 20171118
	 **/
	public function actionRooms(){
		$this->layout = 'layout1';
		
		$hotel_id = empty($this->get['hotel_id']) ? 0 : $this->get['hotel_id'];

		$con['is_del'] = 0;
		$con['hotel_id'] = $hotel_id;

		$list = (new \yii\db\Query())
			->select('r.*,t.type_name')
			->from('hotel_room r')
			->leftjoin('room_type t','r.room_type=t.type_id')
			->where($con)
			->orderBy('r.room_id desc')
			->all();

		return $this->render('rooms',[
			'list'=>$list,
			'hotel_id'=>$hotel_id
		]);
	}

	/**
	 * 新增客房 tml 20171118
	 **/
	public function actionAddRoom(){
		$this->layout = 'layout1';

		$hotel_id = empty($this->get['hotel_id']) ? 0 : $this->get['hotel_id'];
		$room_id = empty($this->get['room_id']) ? 0 : $this->get['room_id'];

		$model = HotelRoom::find()->where(['room_id'=>$room_id])->one();
		$room_type = RoomType::find()->all();

		$room_imgs = null;
		if (!empty($room_id)) {
			$room_imgs = HotelImgs::find()->where(['room_id'=>$room_id])->all();
		}
				
		return $this->render('add_room',[
			'model'=>$model,
			'room_type'=>$room_type,
			'room_imgs'=>$room_imgs,
			'hotel_id'=>$hotel_id
		]);
	}

	/**
	 * ajax新增客房操作 tml 20171118
	 **/
	public function actionAjaxAddRoom(){
		$hotel_id  = empty($this->post['hotel_id']) ? 0 : $this->post['hotel_id'];
		$room_id   = empty($this->post['room_id']) ? 0 : $this->post['room_id'];
		$room_name = empty($this->post['room_name']) ? '' : $this->post['room_name'];
		$room_type = empty($this->post['room_type']) ? 0 : $this->post['room_type'];
		$price     = empty($this->post['price']) ? 0 : $this->post['price'];
		$bed_type  = empty($this->post['bed_type']) ? '' : $this->post['bed_type'];
		$breakfast = empty($this->post['breakfast']) ? '' : $this->post['breakfast'];
		$wifi      = empty($this->post['wifi']) ? '' : $this->post['wifi'];
		$room_window = empty($this->post['room_window']) ? '' : $this->post['room_window'];
		$to_live   = empty($this->post['to_live']) ? '' : $this->post['to_live'];
		$bathroom  = empty($this->post['bathroom']) ? '' : $this->post['bathroom'];
		$room_space = empty($this->post['room_space']) ? '' : $this->post['room_space'];
		$floor     = empty($this->post['floor']) ? '' : $this->post['floor'];
		$room_imgs = empty($this->post['room_imgs']) ? '' : $this->post['room_imgs'];
		
		if (empty($hotel_id)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		if (empty($room_name)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入客房名称']);exit;
		}
		if (empty($room_type)) {
			echo json_encode(['code'=>-200,'msg'=>'请选择客房类型']);exit;
		}
		if (empty($price)) {
			echo json_encode(['code'=>-200,'msg'=>'请选择客房价格']);exit;
		}
		if (empty($bed_type)) {
			echo json_encode(['code'=>-200,'msg'=>'请选择客房床型']);exit;
		}
		if (empty($breakfast)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入早餐信息']);exit;
		}
		if (empty($wifi)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入上网信息']);exit;
		}
		if (empty($room_window)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入客房窗户信息']);exit;
		}
		if (empty($to_live)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入客房可住信息']);exit;
		}
		if (empty($bathroom)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入客房浴室信息']);exit;
		}
		if (empty($room_space)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入客房面积']);exit;
		}
		if (empty($floor)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入楼层']);exit;
		}
		if (empty($room_imgs)) {
			echo json_encode(['code'=>-200,'msg'=>'请上传客房图片']);exit;
		}

		$res = 0;
		if (empty($room_id)) {
			$model = new HotelRoom();
			$model->hotel_id = $hotel_id;
			$model->room_name = $room_name;
			$model->room_type = $room_type;
			$model->price = $price;
			$model->bed_type = $bed_type;
			$model->breakfast = $breakfast;
			$model->wifi = $wifi;
			$model->room_window = $room_window;
			$model->to_live = $to_live;
			$model->bathroom = $bathroom;
			$model->room_space = $room_space;
			$model->floor = $floor;
			$model->room_img = explode(',', $room_imgs)[0];
			$model->add_time = time();
			$model->add_user = $this->session->get('admin')['adminid'];
			$model->audit_state = 1;
			$model->audit_time = time();
			$model->audit_user = $this->session->get('admin')['adminid'];
			$res = $model->save();
			$room_id = $model->attributes['room_id'];
			// var_dump($model->getErrors());exit;
		} else {
			$update['room_name'] = $room_name;
			$update['room_type'] = $room_type;
			$update['price'] = $price;
			$update['bed_type'] = $bed_type;
			$update['breakfast'] = $breakfast;
			$update['wifi'] = $wifi;
			$update['room_window'] = $room_window;
			$update['to_live'] = $to_live;
			$update['bathroom'] = $bathroom;
			$update['room_space'] = $room_space;
			$update['floor'] = $floor;
			$update['room_img'] = explode(',', $room_imgs)[0];
			$update['update_time'] = time();
			$update['update_user'] = $this->session->get('admin')['adminid'];
			$res = HotelRoom::updateAll($update,['room_id'=>$room_id]);
		}

		if ($res) {
			$data = [];
			$img_arr = explode(',', $room_imgs); 
			foreach ($img_arr as $v) {
				if ($v) {
					$data[] = [$hotel_id,$room_id,2,$v];
				}
			}
			$himgs_model = new HotelImgs();
			$himgs_model->deleteAll(['room_id'=>$room_id,'type'=>2]);
			Yii::$app->db->createCommand()->batchInsert(HotelImgs::tableName(), ['hotel_id','room_id','type','path'], $data)->execute();
			echo json_encode(['code'=>200,'msg'=>'提交成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'提交失败']);exit;
	}

	/**
	 * ajax更新客房状态 tml 20171118
	 **/
	public function actionAjaxUpstateRoom(){
		$room_id = empty($this->post['room_id']) ? 0 : $this->post['room_id'];
		$tag     = empty($this->post['tag']) ? '' : $this->post['tag'];
		$state   = empty($this->post['state']) ? 0 : $this->post['state'];
		if (empty($room_id) || empty($state)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		if (!in_array($tag,['state','del']) || !in_array($state,[1,2,-1])) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$res = 0;
		if ($tag == 'del' && $state == -1) {
			$res = HotelRoom::updateAll(['is_del'=>$state],['room_id'=>$room_id]);
		}
		if ($tag == 'state' && in_array($state, [1,2])) {
			$res = HotelRoom::updateAll(['state'=>$state],['room_id'=>$room_id]);
		}
		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
	}

	/**
	 * 酒店预定列表 tml 20171121
	 **/
	public function actionBooking(){
		$this->layout = 'layout1';

		$con['b.is_del'] = 0;

		$query = (new \yii\db\Query())
			->select('b.*,h.hotel_name,h.hotel_tel,r.room_name,a.adminuser')
			->from('hotel_booking b')
			->leftjoin('o2o_hotel h','h.hotel_id=b.hotel_id')
			->leftjoin('hotel_room r','r.room_id=b.room_id')
			->leftjoin('admin a','a.adminid=b.deal_user')
			->where($con);

		$count = $query->count();
		$pagination = new Pagination(['totalCount' => $count]);
		$pagination->setPageSize(10);

		$list = $query
			->orderBy('b.book_id desc')
			->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		return $this->render('booking',[
			'list'=>$list,
			'pagination'=>$pagination
		]);
	}

	public function actionAjaxUpstateBooking(){
		$book_id = empty($this->post['book_id']) ? 0 : $this->post['book_id'];
		$state   = empty($this->post['state']) ? 0 : $this->post['state'];

		if (empty($book_id)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		if (empty($state) || !in_array($state, [2,3])) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}

		$con['state']     = $state;
		$con['deal_time'] = time();
		$con['deal_user'] = $this->session->get('admin')['adminid'];
		$res = HotelBooking::updateAll($con,['book_id'=>$book_id]);

		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
	}
}