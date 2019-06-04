<?php
namespace app\modules\admin\controllers;

use yii\web\Controller;
use app\util\Fushi;
use app\models\Admin\House;
use Yii;

header("content-Type: text/html; charset=Utf-8");

/**
 * 富士业主访客通行记录
 */
class FushiController extends Controller
{
	protected $get;
	protected $params;
	private $small_code = '';
	private $small_code_id = '';

	public function init()
	{
		$this->get = Yii::$app->request->get();
		$this->params = Yii::$app->params['house_config'];
		$house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
		if (!empty($house_id)) {
			$this->small_code = empty($this->params[$house_id]['SmallCode']) ? '' : $this->params[$house_id]['SmallCode'] ;
			$this->small_code_id = empty($this->params[$house_id]['SmallCodeId']) ? '' : $this->params[$house_id]['SmallCodeId'] ;
		}
	}

	// /**
	//  * 集团获取小区列表（2.0接口，弃用）
	//  * @Author   tml
	//  * @DateTime 2018-03-30
	//  * @return   [type]     [description]
	//  */
	// public function actionGetGroupList()
	// {
	// 	$group_code = 'G10000ZSJT';

	// 	$url = '/public/GroupGetSmallList';
	// 	$timestamp  = time();
	// 	$data['GroupCode'] = $group_code;

	// 	$fushi = new Fushi();
	// 	$res = $fushi->doSomthing($url,json_encode($data),$timestamp);
	// 	var_dump($res);exit;
	// }

	// /**
	//  * 访客提交访问请求（2.0接口，弃用）
	//  * @Author   tml
	//  * @DateTime 2018-03-30
	//  * @return   [type]     [description]
	//  */
	// public function actionVisitorApply()
	// {
	// 	$url = '/public/VisitorApply';
	// 	$timestamp  = time();

	// 	$apply_request['VisitorName']  = 'tml';
	// 	$apply_request['VisitorPhone'] = '18039180215';
	// 	$apply_request['StartTime']    = '2018-04-02 16:00';
	// 	$apply_request['EndTime']      = '2018-04-02 18:00';
	// 	$apply_request['OwnerPhone']   = '18898709497';
	// 	$apply_request['VisitorQuantity'] = 1;

	// 	$data['SmallCode'] = $this->small_code;
	// 	$data['SmallCodeId'] = $this->small_code_id;
	// 	$data['VisitorApplyRequest'] = $apply_request;

	// 	$fushi = new Fushi();
	// 	$res = $fushi->doSomthing($url,json_encode($data),$timestamp);
	// 	var_dump($res);exit;
	// }

	/**
	 * 导入业主信息（接口测试）
	 * @Author   tml
	 * @DateTime 2018-04-03
	 * @return   [type]     [description]
	 */
	public function actionOwnerImport()
	{
		$url = '/public/OwnerImportList';
		$timestamp = time();
		$house_id = 3;
		$owner['Name'] = '徐胜杰';
		$owner['Phone'] = '15515215103';
		$owner['IdCard'] = '';
		$owner['HeadPhoto'] = '';
		$owner['BuildingNum'] = ["A座"];
		$data['SmallCode']   = $this->params[$house_id]['SmallCode'];
		$data['SmallCodeId'] = $this->params[$house_id]['SmallCodeId'];
		$data['OwnerPhone'] = '18898709497';
		$data['OwnerList'][] = $owner;

		$fushi = new Fushi();
		$res = $fushi->doSomthing($url,json_encode($data),$timestamp);
		var_dump($res);exit;
	}

	/**
	 * 业主二维码（接口测试）
	 * @Author   tml
	 * @DateTime 2018-04-07
	 * @return   [type]     [description]
	 */
	public function actionOwnerCode()
	{
		$url = '/public/OwnerSelfQrCode';
		$timestamp = time();

		$data['SmallCode']   = $this->small_code;
		$data['SmallCodeId'] = $this->small_code_id;
		$data['OwnerPhone'] = '18538236048';

		$fushi = new Fushi();
		$res = $fushi->doSomthing($url,json_encode($data),$timestamp);
		var_dump($res);exit;
	}
	

	/**
	 * 获取所有出入记录
	 * @Author   tml
	 * @DateTime 2018-04-01
	 * @return   [type]     [description]
	 */
	public function actionGetInoutRecord()
	{
		$this->layout = 'layout1';

		$page_index = empty($this->get['page']) ? 1 : $this->get['page'];
		$stime = empty($this->get['stime']) ? date('Y-m-d',strtotime(date('Y-m-01'))) : $this->get['stime'];
		$etime = empty($this->get['etime']) ? date('Y-m-d',time()) : $this->get['etime'];

		$url = '/public/QueryInOutHisoryByMonth';
		$timestamp = time();

		$data['SmallCode']   = $this->small_code;
		$data['SmallCodeId'] = $this->small_code_id;
		$data['VisitDate']   = date('Y-m-01',strtotime($stime));
		$data['VisitStartTime'] = $stime . ' 00:00:00';
		$data['VisitEndTime'] = $etime . ' 23:59:59';
		$data['PageIndex']   = $page_index;

		$fushi = new Fushi();
		$res = $fushi->doSomthing($url,json_encode($data),$timestamp);
		$data = [];
		$count = 0;
		$message = 'success';
		if ($res['StatusCode'] == 200) {
			$data = $res['Data'];
			$count = $res['DataCount'];
		} else {
			$message = $res['Message'];
		}
		$total_page = $count ? ($count%10 ? intval($count/10)+1 : $count/10) : 0;

		$house = House::find()->where(['parentId'=>0])->asArray()->all();

		return $this->render('inout_record',[
			'house'=>$house,
			'data'=>$data,
			'message'=>$message,
			'page'=>$page_index,
			'total_page'=>$total_page
		]);
	}


	/**
	 * 获取业主所有访客通行记录
	 * @Author   tml
	 * @DateTime 2018-04-07
	 * @return   [type]     [description]
	 */
	public function actionGetOwnersVisitor()
	{
		$this->layout = 'layout1';

		$page_index = empty($this->get['page']) ? 1 : $this->get['page'];
		$owner_phone = empty($this->get['owner_phone']) ? '' : $this->get['owner_phone'];
		$stime = empty($this->get['stime']) ? date('Y-m-d',strtotime(date('Y-m-01'))) : $this->get['stime'];
		$etime = empty($this->get['etime']) ? date('Y-m-d',time()) : $this->get['etime'];

		$url = '/public/QueryOwnersVisitorInOutHisory';
		$timestamp = time();

		$data['SmallCode']   = $this->small_code;
		$data['SmallCodeId'] = $this->small_code_id;
		$data['OwnerPhone']  = $owner_phone;
		$data['VisitStartTime'] = $stime . ' 00:00:00';
		$data['VisitEndTime'] = $etime . ' 23:59:59';
		$data['PageIndex']   = $page_index;

		$fushi = new Fushi();
		$res = $fushi->doSomthing($url,json_encode($data),$timestamp);
		// var_dump($res);exit;
		$data = [];
		$count = 0;
		$message = 'success';
		if ($res['StatusCode'] == 200) {
			$data = $res['Data'];
			$count = $res['DataCount'];
		} else {
			$message = $res['Message'];
		}
		$total_page = $count ? ($count%10 ? intval($count/10)+1 : $count/10) : 0;

		$house = House::find()->where(['parentId'=>0])->asArray()->all();

		return $this->render('owners_visitor',[
			'house'=>$house,
			'data'=>$data,
			'message'=>$message,
			'page'=>$page_index,
			'total_page'=>$total_page
		]);
	}

	/**
	 * 获取访客所有通行记录
	 * @Author   tml
	 * @DateTime 2018-04-07
	 * @return   [type]     [description]
	 */
	public function actionGetVisitorRecord()
	{
		$this->layout = 'layout1';

		$page_index = empty($this->get['page']) ? 1 : $this->get['page'];
		$visitor_phone = empty($this->get['visitor_phone']) ? '' : $this->get['visitor_phone'];
		$stime = empty($this->get['stime']) ? date('Y-m-d',strtotime(date('Y-m-01'))) : $this->get['stime'];
		$etime = empty($this->get['etime']) ? date('Y-m-d',time()) : $this->get['etime'];

		$url = '/public/QueryVisitorInOutHistory';
		$timestamp = time();

		$apply_request['VisitorPhone'] = $visitor_phone;

		$data['SmallCode']   = $this->small_code;
		$data['SmallCodeId'] = $this->small_code_id;
		$data['VisitStartTime'] = $stime . ' 00:00:00';
		$data['VisitEndTime'] = $etime . ' 23:59:59';
		$data['PageIndex']   = $page_index;
		$data['VisitorApplyRequest'] = $apply_request;

		$fushi = new Fushi();
		$res = $fushi->doSomthing($url,json_encode($data),$timestamp);
		// var_dump($res);exit;
		$data = [];
		$count = 0;
		$message = 'success';
		if ($res['StatusCode'] == 200) {
			$data = $res['Data'];
			$count = $res['DataCount'];
		} else {
			$message = $res['Message'];
		}
		$total_page = $count ? ($count%10 ? intval($count/10)+1 : $count/10) : 0;

		$house = House::find()->where(['parentId'=>0])->asArray()->all();

		return $this->render('visitor_record',[
			'house'=>$house,
			'data'=>$data,
			'message'=>$message,
			'page'=>$page_index,
			'total_page'=>$total_page
		]);
	}
	public function actionChechang() {
		$header = array();
		$header[] = 'Content-Type:application/json;charset=utf-8';
		//列表
//		$remote_server = 'http://120.79.12.33:60001/api/core/GetTempDetails';
		//详情
		$remote_server = 'http://120.79.12.33:60001/api/core/GetTempMoney';
		//和谐
//		$serialize = ['projectNo'=>'D7348B36-7995-4697-ABA7-CB19CC0E7EE8','startTime'=>'2018-01-01','endTime'=>'2018-06-01','currentPage'=>'1','pageSize'=>10];
		//建正
		$serialize = ['projectNo'=>'6300BBEE-5F0B-4995-AF08-451EEFEFE832','startTime'=>'2018-01-01','endTime'=>'2018-06-01','currentPage'=>'1','pageSize'=>10];
		$param = json_encode($serialize);
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_HEADER,true);
		curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
		curl_setopt($ch, CURLOPT_URL, $remote_server);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "jb51.net's CURL Example beta");
		$data = curl_exec($ch);
		$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		curl_close($ch);
		$ret = substr($data, $headerSize);
		return $ret;
	}
}