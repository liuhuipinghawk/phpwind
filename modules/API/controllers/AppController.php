<?php

namespace app\modules\API\controllers;

use app\models\Admin\House;
use app\modules\admin\controllers\CertificationController;
use app\util\Fushi;
use Yii;
use yii\web\Controller;
use app\models\Admin\User;
use app\models\Admin\UserBase;
use app\models\Admin\Certification;
use app\models\Admin\UserPost;
use app\models\Admin\UserPosition;
header('Access-Control-Allow-Origin:*');

class AppController extends Controller{
	public $enableCsrfValidation = false;
	protected $get;
	protected $post;
	protected $session;
	protected $user_id;
	/**
	 * 初始化
	 * @Author   tml
	 * @DateTime 2017-12-12
	 * @return   [type]     [description]
	 */
	public function init(){
		$this->get  = Yii::$app->request->get();
		$this->post = Yii::$app->request->post();
		$this->session = Yii::$app->session;
//		if (empty($this->session['userinfo']) || $this->session['userinfo']['expire_time'] < time()) {
//			echo json_encode(['status'=>205,'message'=>'用户信息丢失，请重新登录','code'=>[]]);exit;
//		}
		$this->user_id = $this->session['userinfo']['userId'];
	}

	/**
	 * 实名认证提交接口
	 * @Author   tml
	 * @DateTime 2017-12-12
	 * @return   [type]     [description]
	 */
	public function actionRealNameCertification(){
		$cate_id   = empty($this->post['cate_id']) ? 0 : $this->post['cate_id'];
		$post_id   = empty($this->post['post_id']) ? 0 : $this->post['post_id'];
		$position_id = empty($this->post['position_id']) ? 0 : $this->post['position_id'];
		$true_name = empty($this->post['true_name']) ? '' : $this->post['true_name'];
		$mobile	   = empty($this->post['mobile']) ? '' : $this->post['mobile'];
		$company   = empty($this->post['company']) ? '' : $this->post['company'];
		// var_dump(strlen($company));exit;
		if (empty($cate_id)) {
			echo json_encode(['status'=>-200,'message'=>'请选择用户身份','code'=>[]]);exit;
		}
		if (!in_array($cate_id,[1,2])) {
			echo json_encode(['status'=>-200,'message'=>'用户身份错误','code'=>[]]);exit;
		}
		if ($cate_id == 1) {
			if (empty($post_id)) {
				echo json_encode(['status'=>-200,'message'=>'请选择您的岗位','code'=>[]]);exit;
			}
			if (empty($position_id)) {
				echo json_encode(['status'=>-200,'message'=>'请选择您的职位','code'=>[]]);exit;
			}
		}
		if (empty($true_name)) {
			echo json_encode(['status'=>-200,'message'=>'真实姓名不能为空','code'=>[]]);exit;
		}
		if (mb_strlen($true_name) > 20) {
			echo json_encode(['status'=>-200,'message'=>'真实姓名需控制在20字符以内','code'=>[]]);exit;
		}
		if (empty($mobile)) {
			echo json_encode(['status'=>-200,'message'=>'手机号不能为空','code'=>[]]);exit;
		}
		if (!$this->checkMobile($mobile)) {
			echo json_encode(['status'=>-200,'message'=>'手机号格式不正确','code'=>[]]);exit;
		}
		if (empty($company)) {
			echo json_encode(['status'=>-200,'message'=>'公司名称不能为空','code'=>[]]);exit;
		}
		if (strlen($company) > 150) {
			echo json_encode(['status'=>-200,'message'=>'公司名称需控制在50字符以内','code'=>[]]);exit;
		}
		$user = User::find()->where(['id'=>$this->user_id])->one();
		if (empty($user) || $mobile != $user['Tell']) {
			echo json_encode(['status'=>-200,'message'=>'实名认证手机号与注册手机号不一致','code'=>[]]);exit;
		}
		// 根据手机号去用户基础信息表获取用户基础信息
		$res = UserBase::find()->where(['mobile'=>$mobile])->one();
		/**
		 * 如果用户信息存在并且真实姓名与提交姓名一致，则通过实名认证，认证状态为审核通过
		 * 否则实名匹配验证不通过，认证状态为等待审核状态
		 */
		if ($res && $res['true_name'] == $true_name && $res['user_type'] == $cate_id) { 
			$time = date('Y-m-d H:i:s',time());
			$data['Tell']     = $mobile;
			$data['TrueName'] = $res['true_name'];
			$data['HouseId']  = $res['house_id'];
			$data['Seat']     = $res['seat_id'];
			$data['Address']  = $res['room_num'];
			$data['Company']  = $res['company'];
			$data['Position'] = $position_id;
			$data['PostId']   = $post_id;
			$data['CateId']   = $cate_id;
			$data['Status']   = 3;
			$data['UpdateTime'] = $time;
			$res1 = User::updateAll($data,['id'=>$this->user_id]);

			if ($res1) {
				$model = new Certification();
				$model->UserId  = $this->user_id;
				$model->HouseId = $res['house_id'];
				$model->SeatId  = $res['seat_id'];
				$model->Address = $res['room_num'];
				$model->Status  = 3;
				$model->CreateTime = $time;
				$model->UpdateTime = $time;
				$res2 = $model->save();
				if ($res2) {
					if($res['house_id'] == 3 || $res['house_id'] == 7){
						$list = Certification::find()->alias('c')->select('h.housename')->leftJoin('house h','h.id = c.SeatId')->
						where(['c.UserId'=>$this->user_id,'c.HouseId'=>$res['house_id'],'c.Status'=>3])->asArray()->all();
						$seatlist = [];
						foreach($list as $k=>$v){
							$r[]=$v['housename'];
						}
						$seatlist = $r;
						$this->OwnerImport($res['house_id'],$user['TrueName'],$user['Tell'],$seatlist);
					}
					if($res['house_id'] == 1 || $res['house_id'] ==2 || $res['house_id'] == 6 || $res['house_id'] == 3 || $res['house_id'] == 4){
						$res = $this->ShiWei($user['Tell']);
					}
					echo json_encode(['status'=>200,'message'=>'实名认证匹配审核通过','code'=>['status'=>3]]);exit;
				}
				echo json_encode(['status'=>-200,'message'=>'默认通行区域匹配失败','code'=>[]]);exit;
			} 
			echo json_encode(['status'=>-200,'message'=>'实名认证匹配审核失败','code'=>[]]);exit;
		} else {
			$time = date('Y-m-d H:i:s',time());
			$data['Tell']     = $mobile;
			$data['TrueName'] = $true_name;
			$data['Company']  = $company;
			$data['Position'] = $position_id;
			$data['PostId']   = $post_id;
			$data['CateId']   = $cate_id;
			$data['Status']   = 2;
			$data['UpdateTime'] = $time;
			$res1 = User::updateAll($data,['id'=>$this->user_id]);
			if ($res1) {
				echo json_encode(['status'=>200,'message'=>'提交成功，请耐心等待审核...','code'=>['status'=>2]]);exit;
			}
			echo json_encode(['status'=>-200,'message'=>'提交失败','code'=>[]]);exit;
		}
	}

	/**
	 * 获取岗位和职位信息
	 * @Author   tml
	 * @DateTime 2017-12-13
	 * @return   [type]     [description]
	 */
	public function actionGetPostPosition(){
		$post_list     = UserPost::find()->asArray()->all();
		$position_list = UserPosition::find()->asArray()->all();
		echo json_encode(['status'=>200,'message'=>'success','code'=>['post'=>$post_list,'position'=>$position_list]]);exit;
	}

	/**
	 * 添加通行区域
	 * @Author   tml
	 * @DateTime 2017-12-14
	 * @return   [type]     [description]
	 */
	public function actionAddPassArea(){
		$house_id = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
		$seat_id  = empty($this->post['seat_id']) ? 0 : $this->post['seat_id'];
		$address  = empty($this->post['address']) ? 0 : $this->post['address'];
		$tell  = empty($this->post['tell']) ? 0 : $this->post['tell'];
		if (empty($house_id)) {
			echo json_encode(['status'=>-200,'message'=>'请选择楼盘信息']);exit;
		}
		if (empty($seat_id)) {
			echo json_encode(['status'=>-200,'message'=>'请选择楼座信息']);exit;
		}
		if (!empty($address) && mb_strlen($address) > 100) {
			echo json_encode(['status'=>-200,'message'=>'地址信息需控制在100字符内']);exit;
		}
		$pass_area = Certification::find()->where(['UserId'=>$this->user_id,'HouseId'=>$house_id,'SeatId'=>$seat_id])->one();
		if (!empty($pass_area)) {
			echo json_encode(['status'=>-200,'message'=>'不可添加重复的通行区域','code'=>[]]);exit;
		}
		if(empty($tell)){
			$user = User::find()->where(['id'=>$this->user_id])->one();
		}else{
			$user = User::find()->where(['Tell'=>$tell])->one();
		}
		$model = new Certification();
		$model->UserId  = $user['id'];
		$model->HouseId = $house_id;
		$model->SeatId  = $seat_id;
		$model->Address = $address;
		$model->CreateTime = date('Y-m-d H:i:s',time());
		$model->UpdateTime = date('Y-m-d H:i:s',time());
		if ($user['Status'] == 3 && $user['CateId'] == 1) {
			$model->Status = 3;
		}
		$res = $model->save();
		if ($res) {
			if ($user['Status'] == 3 && $user['CateId'] == 1) {
				if($house_id == 3 || $house_id == 7){
					$list = Certification::find()->alias('c')->select('h.housename')->leftJoin('house h','h.id = c.SeatId')->
					where(['c.UserId'=>$this->user_id,'c.HouseId'=>$house_id,'c.Status'=>3])->asArray()->all();
					$seatlist = [];
					foreach($list as $k=>$v){
						$r[]=$v['housename'];
					}
					$seatlist = $r;
					$res = $this->OwnerImport($house_id,$user['TrueName'],$user['Tell'],$seatlist);
				}
				if($house_id == 1 || $house_id ==2 || $house_id == 6 || $house_id == 3 || $house_id == 4){
					$res = $this->ShiWei($user['Tell']);
				}

//				var_dump($res);exit;

			}
			echo json_encode(['status'=>200,'message'=>'添加通行区域成功','code'=>[]]);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'添加通行区域失败','code'=>[]]);exit;
	}

	/**
	 * 删除通行区域
	 * @Author   tml
	 * @DateTime 2018-04-20
	 * @return   [type]     [description]
	 */
	public function actionDelPassArea()
	{
		$cert_id = empty($this->get['cert_id']) ? 0 : $this->get['cert_id'];
		if (empty($cert_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误']);exit;
		}
		$model = Certification::findOne($cert_id);
		$ret = $model->delete();
		if ($ret) {
			echo json_encode(['status'=>200,'message'=>'删除成功']);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'删除失败']);exit;
	}
	/**
	 * 导入业主信息
	 * @Author   tml
	 * @DateTime 2018-04-03
	 * @return   [type]     [description]
	 */
	public function OwnerImport($house_id,$username,$mobile,$role)
	{
		$params = Yii::$app->params['house_config'];
		$url = '/public/OwnerImportList';
		$timestamp = time();
		$owner['Name'] = $username;
		$owner['Phone'] = $mobile;
		$owner['IdCard'] = '';
		$owner['HeadPhoto'] = '';
		$owner['BuildingNum'] = $role;

		$data['SmallCode']   = $params[$house_id]['SmallCode'];
		$data['SmallCodeId'] = $params[$house_id]['SmallCodeId'];
		$data['OwnerPhone'] = '18898709497';
		$data['OwnerList'][] = $owner;
		$fushi = new Fushi();
		$res = $fushi->doSomthing($url,json_encode($data),$timestamp);
		if($res !==false){
			return $res;
		}
		return false;
	}

	function ShiWei($phone){
		$url ="http://test.haoxiangkaimen.cn/api/ZSUserInfoServer?phone=".$phone;

		$ch = curl_init();
		//设置选项，包括URL
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);

		//执行并获取HTML文档内容
		$output = curl_exec($ch);
		//释放curl句柄
		curl_close($ch);
		return $output;
	}

	/**
	 * 获取通行区域列表
	 * @Author   tml
	 * @DateTime 2017-12-14
	 * @return   [type]     [description]
	 */
	public function actionGetPassArea(){
		$status = empty($this->get['status']) ? 0 : $this->get['status'];
		// var_dump($status);exit;
		$con['c.UserId'] = $this->user_id;
		if (!empty($status)) {
			$con['c.Status'] = $status;
		}
		$list = (new \yii\db\Query())
			->select('c.CertificationId as cert_id,u.TrueName as true_name,u.Company as company,h.id as house_id,h.housename as house_name,h1.id as seat_id,h1.housename as seat_name,c.address,c.Status as status')
			->from('certification c')
			->leftjoin('user u','c.UserId=u.id')
			->leftjoin('house h','c.HouseId=h.id')
			->leftjoin('house h1','c.SeatId=h1.id')
			->where($con)
			->orderBy('c.Status desc')
			->all();
		echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;
	}

	/**
	 * 正则校验手机号格式
	 * @Author   tml
	 * @DateTime 2017-12-12
	 * @param    [type]     $mobile [description]
	 * @return   [type]             [description]
	 */
	public function checkMobile($mobile){
		return preg_match('/^1[3|4|5|6|7|8|9][0-9]{9}$/', $mobile);
	}
}