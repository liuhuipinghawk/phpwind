<?php 

namespace app\modules\API\controllers;

use Yii;
use yii\web\Controller;
use app\models\Admin\House;
use app\models\Admin\CarportOrder;
use app\models\Admin\ServiceOrder;
use app\models\Admin\O2oHouseEntrustment;
use app\modules\API\controllers;

class ServiceController extends TmlController
{
	protected $user_id;

	/**
	 * 初始化 tml 20171124
	 **/
	public function init(){
		parent::init();
		$this->user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
		if (!$this->user_id) {
			$session = Yii::$app->session;
			if (empty($session['userinfo']) || $session['userinfo']['expire_time'] < time()) {
				echo json_encode(['status'=>205,'message'=>'用户信息过期，请重新登录获取','code'=>[]]);exit;
			}
			$this->user_id = $session['userinfo']['userId'];
		}
	}
	
	/**
	 * 根据父ID获取楼盘信息 tml 20171124
	 **/
	public function actionGetHouseByPid(){
		$city_id = empty($this->post['city_id']) ? 1 : $this->post['city_id'];
		$pid     = empty($this->post['pid']) ? 0 : $this->post['pid'];

		$con['cityid']   = $city_id;
		$con['parentId'] = $pid;
		if($pid == 0){
			$con['status'] = 1;
		}

		$list = House::find()->select('id as house_id,housename as house_name')->where($con)->asArray()->all();

		echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;
	}

	/**
	 * 车位租赁预约 tml 20171124
	 **/
	public function actionCarportOrder(){
		$house_id = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
		$seat_id  = empty($this->post['seat_id']) ? 0 : $this->post['seat_id'];
		$person_name = empty($this->post['person_name']) ? 0 : $this->post['person_name'];
		$person_tel  = empty($this->post['person_tel']) ? 0 : $this->post['person_tel'];
		$order_type  = empty($this->post['order_type']) ? 0 : $this->post['order_type'];

		if (empty($house_id)) {
			echo json_encode(['status'=>-200,'message'=>'请选择楼盘项目','code'=>[]]);exit;
		}
		if (empty($seat_id)) {
			echo json_encode(['status'=>-200,'message'=>'请选择楼盘座号','code'=>[]]);exit;
		}
		if (empty($person_name)) {
			echo json_encode(['status'=>-200,'message'=>'请输入您的姓名','code'=>[]]);exit;
		}
		if (empty($person_tel)) {
			echo json_encode(['status'=>-200,'message'=>'请输入您的联系方式','code'=>[]]);exit;
		}
		if (empty($order_type)) {
			echo json_encode(['status'=>-200,'message'=>'请选择租赁时间','code'=>[]]);exit;
		}

		$model = new CarportOrder();
		$model->house_id = $house_id;
		$model->seat_id  = $seat_id;
		$model->person_name = $person_name;
		$model->person_tel  = $person_tel;
		$model->order_type  = $order_type;
		$model->user_id  = $this->user_id;
		$model->add_time = time();
		$res = $model->save();
		if ($res) {
			echo json_encode(['status'=>200,'message'=>'预约成功','code'=>[]]);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'预约失败','code'=>[]]);exit;
	}

	/**
	 * 生活服务预约 tml 20171124
	 **/
	public function actionServiceOrder(){
		//预约服务类型，1：洗衣服务；2：公司注册；3：直饮水；4：石材养护；5：室内清洁；6：甲醛治理；7：洗车服务； 8: 办公设备； 9: 办公家具； 10: 花卉租赁； 11:招商租赁；12:酒店；13：美食;14：办公家具；15：礼品定制；16：装饰设计;17：代理记账；18：宣传服务
		$order_type  = empty($this->post['order_type']) ? 0 : $this->post['order_type'];
		$person_name = empty($this->post['person_name']) ? 0 : $this->post['person_name'];
		$person_tel  = empty($this->post['person_tel']) ? 0 : $this->post['person_tel'];
        $type_id  = empty($this->post['type_id']) ? 0 : $this->post['type_id']; //关联Id,
		if (empty($order_type) || !in_array($order_type,[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18])) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>[]]);exit;
		}
		if (empty($person_name)) {
			echo json_encode(['status'=>-200,'message'=>'请填写联系人','code'=>[]]);exit;
		}
		if (empty($person_tel)) {
			echo json_encode(['status'=>-200,'message'=>'请填写联系方式','code'=>[]]);exit;
		}

		$model = new ServiceOrder();
		$model->order_type  = $order_type;
		$model->person_name = $person_name;
		$model->person_tel  = $person_tel;
		$model->order_user  = $this->user_id;
		$model->type_id = $type_id;
		$model->add_time    = time();
		$res = $model->save();

		if ($res) {
			echo json_encode(['status'=>200,'message'=>'预约成功','code'=>[]]);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'预约失败','code'=>[]]);exit;
	}

	/**
	 * 生活服务订单预约列表
	 * @Author   tml
	 * @DateTime 2018-01-19
	 * @return   [type]     [description]
	 */
	public function actionServiceOrderList(){
		$pagenum = empty($this->get['pagenum']) ? 1 : $this->get['pagenum'];
		$pagesize = Yii::$app->params['APP_PAGE_SIZE'];
		$offset = ($pagenum-1)*$pagesize;
		$connection = Yii::$app->db;
		$sql = "SELECT *,
					CASE 
						WHEN order_type=0 THEN '车位租赁' 
						WHEN order_type=1 THEN '洗衣服务'
						WHEN order_type=2 THEN '公司注册'
						WHEN order_type=3 THEN '直饮水'
						WHEN order_type=4 THEN '石材养护'
						WHEN order_type=5 THEN '室内清洁'
						WHEN order_type=6 THEN '甲醛治理'
						WHEN order_type=7 THEN '洗车服务'
						WHEN order_type=8 THEN '办公设备'
						WHEN order_type=9 THEN '办公家具'
						WHEN order_type=10 THEN '花卉租赁'
						WHEN order_type=11 THEN '招商租赁'
						WHEN order_type=12 THEN '招商租赁'
						WHEN order_type=13 THEN '招商租赁'
						WHEN order_type=14 THEN '招商租赁'
						WHEN order_type=15 THEN '招商租赁'
						WHEN order_type=16 THEN '招商租赁'
						WHEN order_type=17 THEN '代理记账'
						WHEN order_type=18 THEN '宣传服务'
					ELSE '其他' END AS type_name 
				FROM (
				SELECT a.order_id,a.order_user as user_id,a.order_type,a.person_name,a.person_tel,a.state,from_unixtime(a.add_time,'%Y-%m-%d %H:%i') as add_time,a.type_id as item_id 
				FROM service_order a 
				UNION ALL 
				SELECT b.order_id,b.user_id,0 as order_type,b.person_name,b.person_tel,b.state,from_unixtime(b.add_time,'%Y-%m-%d %H:%i') as add_time,0 as item_id 
				FROM carport_order b
				) z 
				WHERE z.user_id=$this->user_id 
				ORDER BY z.add_time DESC 
				LIMIT $offset,$pagesize";
		$command = $connection->createCommand($sql);
		$res = $command->queryAll();
		echo json_encode(['status'=>200,'message'=>'success','code'=>$res]);exit;
	}

	/**
	 * 生活服务订单预约详情
	 * @Author   tml
	 * @DateTime 2018-01-20
	 * @return   [type]     [description]
	 */
	public function actionServiceOrderDetail(){
		$order_id   = empty($this->get['order_id']) ? 0 : $this->get['order_id'];
		$order_type = empty($this->get['order_type']) ? 0 : $this->get['order_type'];
		$item_id    = empty($this->get['item_id']) ? 0 : $this->get['item_id'];
		if (empty($order_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>(object)[]]);exit;
		}
		if (!in_array($order_type,[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18])) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>(object)[]]);exit;
		}
		if (in_array($order_type,[8,9,10]) && empty($item_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>(object)[]]);exit;
		}
		//停车位租赁
		if ($order_type == 0) {
			# code...
		} else if ($order_type == 8) { //办公设备租赁
			# code...
		} else if ($order_type == 9) { //办公家具
			# code...
		} else if ($order_type == 10) { //花卉租赁
			# code...
		} else { //洗衣服务、公司注册、直饮水、石材养护、室内清洁、甲醛治理、洗车服务
			# code...
		}
	}

	/**
	 * 房屋委托
	 * @Author   tml
	 * @DateTime 2018-02-12
	 * @return   [type]     [description]
	 */
	public function actionHouseEntrustment()
	{
		$user_id    = empty($this->user_id) ? 0 :$this->user_id;
		$house_id   = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
		$house_type = empty($this->post['house_type']) ? 0 : $this->post['house_type'];
		$house_area = empty($this->post['house_area']) ? 0 : $this->post['house_area'];
		$address    = empty($this->post['address']) ? '' : $this->post['address'];
		$person_name = empty($this->post['person_name']) ? '' : $this->post['person_name'];
		$person_tel = empty($this->post['person_tel']) ? '' : $this->post['person_tel'];

		if (empty($user_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
		}
		if (empty($house_id)) {
			echo json_encode(['status'=>-200,'message'=>'请选择楼盘','code'=>(object)[]]);exit;
		}
		if (empty($house_type) || !in_array($house_type,[1,2,3])) {
			echo json_encode(['status'=>-200,'message'=>'请选择房屋类型','code'=>(object)[]]);exit;
		}
		if (empty($house_area) || $house_area <= 0) {
			echo json_encode(['status'=>-200,'message'=>'请输入正确的房屋面积','code'=>(object)[]]);exit;
		}
		if (strlen($address) > 85) {
			echo json_encode(['status'=>-200,'message'=>'地址不可以超过85个汉字','code'=>(object)[]]);exit;
		}
		if (empty($person_name)) {
			echo json_encode(['status'=>-200,'message'=>'请输入联系人姓名','code'=>(object)[]]);exit;
		}
		if (empty($person_tel)) {
			echo json_encode(['status'=>-200,'message'=>'请输入联系方式','code'=>(object)[]]);exit;
		}
		if (!$this->checkMobile($person_tel)) {
			echo json_encode(['status'=>-200,'message'=>'联系方式格式不正确','code'=>(object)[]]);exit;
		}

		$model = new O2oHouseEntrustment();
		$model->user_id = $user_id;
		$model->house_id = $house_id;
		$model->house_type = $house_type;
		$model->house_area = $house_area;
		$model->address = $address;
		$model->person_name = $person_name;
		$model->person_tel = $person_tel;
		$model->add_time = time();
		$res = $model->save();
		if ($res) {
			echo json_encode(['status'=>200,'message'=>'委托成功，请耐心等待工作人员与您联系','code'=>(object)[]]);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'委托失败','code'=>(object)[]]);exit;
	}

	/**
	 * 我的委托
	 * @Author   tml
	 * @DateTime 2018-02-23
	 * @return   [type]     [description]
	 */
	public function actionMyEntrustment()
	{
		$sql = "select o.house_type,o.house_area,o.address,o.person_name,o.person_tel,o.status,h.housename as house_name,from_unixtime(o.add_time,'%Y-%m-%d %H:%i') as publish_time from o2o_house_entrustment o left join house h on o.house_id=h.id where o.is_del=0 and o.user_id=".$this->user_id;
		$list = Yii::$app->db->createCommand($sql)->queryAll();
		echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;
	}
}