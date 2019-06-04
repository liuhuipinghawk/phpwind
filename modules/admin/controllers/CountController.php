<?php
namespace app\modules\admin\controllers;

use app\models\Admin\CountElectr;
use app\models\Admin\CountElectrattr;
use app\models\Admin\CountWater;
use app\models\Admin\CountWaterattr;
use app\models\Admin\Order;
use app\models\Admin\Stall;
use app\models\Admin\StallAttr;
use app\models\Admin\WaterPayment;
use app\models\Admin\ElectricOrder;
use Yii;
use app\models\Admin\AccountBase;
use app\models\Admin\HouseData;
use app\models\Admin\HouseLeaseReport;
use yii\data\Pagination;
use yii\db\Query;


/**
 * 物业缴费统计控制器
 */
class CountController extends CommonController
{	
	public $enableCsrfValidation = false;
	public $get;
	public $post;

	/**
	 * 初始化
	 * @Author   tml
	 * @DateTime 2018-04-11
	 * @return   [type]     [description]
	 */
	public function init()
	{
		$this->get  = Yii::$app->request->get();
		$this->post = Yii::$app->request->post();
	}

	/**
	 * 物业费统计
	 * @Author   tml
	 * @DateTime 2018-04-10
	 * @return   [type]     [description]
	 */
	public function actionPropertyFeeCount()
	{
		$this->layout = 'layout1';

		$time_tag     = empty($this->get['time_tag']) ? 'first_half' : $this->get['time_tag'];
		$house_choose = empty($this->get['house_choose']) ? 'all' : $this->get['house_choose'];
		$sdate        = empty($this->get['sdate']) ? date('Y-m-d') : $this->get['sdate'];
		$edate        = empty($this->get['edate']) ? date('Y-m-d') : $this->get['edate'];
		$house_id     = 0;
		$seat_id      = 0;

		$stime = 0;
		$etime = 0;
		switch ($time_tag) {
			case 'day':
				$stime = strtotime(date('Y-m-d').' 00:00:00');
				$etime = strtotime(date('Y-m-d').' 23:59:59');
				break;
			case 'week':
				$w     = intval(date('w',time())-1);
				$stime = strtotime(date('Y-m-d',strtotime("-$w days")).'00:00:00');
				$etime = $stime + 7*24*60*60 - 1;
				break;
			case 'month':
				$stime = strtotime(date('Y-m-01').' 00:00:00');
				$etime = strtotime(date('Y-m-t').' 23:59:59');
				break;
			case 'second_half':
				$stime = strtotime(date('Y').'-07-01 00:00:00');
				$etime = strtotime(date('Y').'-12-31 23:59:59');
				break;
			case 'year':
				$stime = strtotime(date('Y').'-01-01 00:00:00');
				$etime = strtotime(date('Y').'-12-31 23:59:59');
				break;
			case 'other':
				$stime = strtotime($sdate.' 00:00:00');
				$etime = strtotime($edate.' 23:59:59');
				break;
			default:
				$stime = strtotime(date('Y').'-01-01 00:00:00');
				$etime = strtotime(date('Y').'-06-30 23:59:59');
				break;
		}
		if ($house_choose != 'all') {
			$house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
			$seat_id  = empty($this->get['seat_id']) ? 0 : $this->get['seat_id'];
		}
		
		$total_money      = 0; //应收总金额
		$total_households = 0; //应收总户数
		$real_money       = 0; //实收总金额
		$real_households  = 0; //实收总户数
		$list = null;
		//应收金额和户数
		$num = 6;
		if ($time_tag == 'year') {
			$num = 12;
		}
		$con = [];
		if ($house_id) {
			$con['house_id'] = $house_id;
		}
		if ($seat_id) {
			$con['seat_id'] = $seat_id;
		}
		$res = (new \yii\db\Query())
			->select("SUM(property_fee*area*$num) as total_money,count(id) as total_households")
			->from('account_base')
			->where($con)
			->all();
		if ($res) {
			$total_money = $res[0]['total_money'] ? $res[0]['total_money'] : 0;
			$total_households = $res[0]['total_households'] ? $res[0]['total_households'] : 0;
		}
		//实际收取金额和户数
		$year = date('Y',$etime);
		$year_status = date('m',$etime) <= 6 ? 1 : (date('m',$stime) > 6 ? 2 : 0);
		$con1['status'] = 2;
		$con1['year'] = $year;
		if ($year_status) {
			$con1['year_status'] = $year_status;
		}
		if ($house_id) {
			$con1['house_id'] = $house_id;
		}
		if ($seat_id) {
			$con1['seat_id'] = $seat_id;
		}
		$res1 = (new \yii\db\Query())
			->select("SUM(money) as real_money,COUNT(id) as real_count")
			->from('property_pay')
			->where($con1)
			->andWhere(['between','pay_time',$stime,$etime])
			->all();
		if ($res1) {
			$real_money = empty($res1[0]['real_money']) ? 0 : $res1[0]['real_money'];
			$real_households  = empty($res1[0]['real_count']) ? 0 : $res1[0]['real_count'];
		}
		//列表
		$con2['p.status'] = 2;
		$con2['p.year']   = $year;
		if ($year_status) {
			$con2['p.year_status'] = $year_status;
		}
		if ($house_id) {
			$con2['p.house_id'] = $house_id;
		}
		if ($seat_id) {
			$con2['p.seat_id'] = $seat_id;
		}
		$query = (new \yii\db\Query())
			->select("a.owner,p.house_id,p.seat_id,h1.housename as house_name,h2.housename as seat_name,p.room,p.area,p.property_fee,(p.property_fee*p.area*$num) as total_money,SUM(p.money) as real_money")
			->from('property_pay p')
			->leftJoin('user_account a','p.account_id=a.account_id')
			->leftJoin('house h1','p.house_id=h1.id')
			->leftJoin('house h2','p.house_id=h2.id')
			->where($con2)
			->andWhere(['between','pay_time',$stime,$etime])
			->groupBy('p.house_id,p.seat_id,p.room')
			->orderBy('p.house_id,p.seat_id,p.room');
		$count = $query->count();
		$pages = new Pagination(['totalCount' => $count]);
		$list  = $query->offset($pages->offset)->limit($pages->limit)->all();

		$house = $this->getHouseInfo(0);

		return $this->render('property_fee_count',[
			'house'            => $house,
			'total_money'      => $total_money,
			'total_households' => $total_households,
			'real_money'       => $real_money,
			'real_households'  => $real_households,
			'list'             => $list,
			'num'              => $num,
			'pages'            => $pages
		]);
	}

	/**
	 * ajax获取楼盘楼座信息
	 * @Author   tml
	 * @DateTime 2018-04-12
	 * @return   [type]     [description]
	 */
	public function actionAjaxGetHouse()
	{
		$parent_id = empty($this->post['parent_id']) ? 0 : $this->post['parent_id'];
		if (empty($parent_id)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$list = $this->getHouseInfo($parent_id);
		echo json_encode(['code'=>200,'data'=>$list]);exit;
	}

	/**
	 * 房屋租赁收费动态统计
	 * @Author   tml
	 * @DateTime 2018-04-13
	 * @return   [type]     [description]
	 */
	public function actionHouseLeaseCount()
	{
		$this->layout = 'layout1';
		$time_tag     = empty($this->get['time_tag']) ? 'first_half' : $this->get['time_tag'];
		$house_choose = empty($this->get['house_choose']) ? 'all' : $this->get['house_choose'];
		$sdate        = empty($this->get['sdate']) ? date('Y-m-d') : $this->get['sdate'];
		$edate        = empty($this->get['edate']) ? date('Y-m-d') : $this->get['edate'];
		$house_type   = 0;
		$house_id     = 0;

		$stime = 0;
		$etime = 0;
		switch ($time_tag) {
			case 'day':
				$stime = strtotime(date('Y-m-d').' 00:00:00');
				$etime = strtotime(date('Y-m-d').' 23:59:59');
				break;
			case 'week':
				$w     = intval(date('w',time())-1);
				$stime = strtotime(date('Y-m-d',strtotime("-$w days")).'00:00:00');
				$etime = $stime + 7*24*60*60 - 1;
				break;
			case 'month':
				$stime = strtotime(date('Y-m-01').' 00:00:00');
				$etime = strtotime(date('Y-m-t').' 23:59:59');
				break;
			case 'second_half':
				$stime = strtotime(date('Y').'-07-01 00:00:00');
				$etime = strtotime(date('Y').'-12-31 23:59:59');
				break;
			case 'year':
				$stime = strtotime(date('Y').'-01-01 00:00:00');
				$etime = strtotime(date('Y').'-12-31 23:59:59');
				break;
			case 'other':
				$stime = strtotime($sdate.' 00:00:00');
				$etime = strtotime($edate.' 23:59:59');
				break;
			default:
				$stime = strtotime(date('Y').'-01-01 00:00:00');
				$etime = strtotime(date('Y').'-06-30 23:59:59');
				break;
		}
		if ($house_choose != 'all') {
			$house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
			$house_type = empty($this->get['house_type']) ? 0 : $this->get['house_type'];
		}

		$con['is_del'] = 0;
		if ($house_id) {
			$con['house_id'] = $house_id;
		}
		if ($house_type) {
			$con['house_type'] = $house_type;
		}

		// 查询总户数、可租户数、不可租户数、总面积、可租面积、不可租面积
		$sub_query = (new Query())->select('*')->from('house_lease')->where($con)->andWhere(['between','add_time',$stime,$etime])->orderBy('add_time desc')->groupBy('house_id,house_type');
		$lease_count = (new Query())->select('sum(total_nums) as total_nums,sum(rent_nums) as rent_nums,sum(unrent_nums) as unrent_nums,sum(total_space) as total_space,sum(rent_space) as rent_space,sum(unrent_space) as unrent_space')->from(['s'=>$sub_query])->one();
		// 查询总佣金、签约户数、签约面积
		$report_count = (new Query())->select('sum(get_money) as get_money,sum(space) as space,count(report_id) as nums')->from('house_lease_report')->where($con)->andWhere(['between','add_time',$stime,$etime])->orderBy('add_time desc')->one();
		// 统计图-走势图
		$month_arr = $this->getMonthArray($stime,$etime);
		$zoushi['x'] = [];
		$zoushi['y'] = [];
		foreach ($month_arr as $k => $v) {
			$r = explode('-', $v);
			array_push($zoushi['x'],$r[0].'年'.$r[1].'月');
			$y = HouseLeaseReport::find()->select('sum(get_money)')->where($con)->andWhere(['between','add_time',$stime,$etime])->andWhere(['year'=>$r[0],'month'=>$r[1]])->scalar();
			array_push($zoushi['y'],$y ? $y : 0);
		}
		// 统计图-饼状图
		// 佣金占比
		$chart1['office'] = HouseLeaseReport::find()->select('sum(get_money)')->where($con)->andWhere(['between','add_time',$stime,$etime])->andWhere(['house_type'=>1])->scalar();
		$chart1['shops'] = HouseLeaseReport::find()->select('sum(get_money)')->where($con)->andWhere(['between','add_time',$stime,$etime])->andWhere(['house_type'=>2])->scalar();
		$chart1['apartment'] = HouseLeaseReport::find()->select('sum(get_money)')->where($con)->andWhere(['between','add_time',$stime,$etime])->andWhere(['house_type'=>3])->scalar();
		// 户数占比
		$chart2['office'] = HouseLeaseReport::find()->select('count(report_id)')->where($con)->andWhere(['between','add_time',$stime,$etime])->andWhere(['house_type'=>1])->scalar();
		$chart2['shops'] = HouseLeaseReport::find()->select('count(report_id)')->where($con)->andWhere(['between','add_time',$stime,$etime])->andWhere(['house_type'=>2])->scalar();
		$chart2['apartment'] = HouseLeaseReport::find()->select('count(report_id)')->where($con)->andWhere(['between','add_time',$stime,$etime])->andWhere(['house_type'=>3])->scalar();
		// 面积占比
		$chart3['office'] = HouseLeaseReport::find()->select('sum(space)')->where($con)->andWhere(['between','add_time',$stime,$etime])->andWhere(['house_type'=>1])->scalar();
		$chart3['shops'] = HouseLeaseReport::find()->select('sum(space)')->where($con)->andWhere(['between','add_time',$stime,$etime])->andWhere(['house_type'=>2])->scalar();
		$chart3['apartment'] = HouseLeaseReport::find()->select('sum(space)')->where($con)->andWhere(['between','add_time',$stime,$etime])->andWhere(['house_type'=>3])->scalar();
		// 列表
		$list = (new Query())->select('h.housename,s.house_id,sum(s.total_nums) as total_nums,sum(s.rent_nums) as rent_nums,sum(s.unrent_nums) as unrent_nums,sum(s.total_space) as total_space,sum(s.rent_space) as rent_space,sum(s.unrent_space) as unrent_space')->from(['s'=>$sub_query])->leftJoin('house h','s.house_id=h.id')->groupBy('s.house_id')->all();
		foreach ($list as $k => $v) {
			$list[$k]['get_total_money'] = HouseLeaseReport::find()->select('sum(get_money)')->where($con)->andWhere(['between','add_time',$stime,$etime])->andWhere(['house_id'=>$v['house_id']])->scalar();
			$list[$k]['total_count'] = HouseLeaseReport::find()->select('count(report_id)')->where($con)->andWhere(['between','add_time',$stime,$etime])->andWhere(['house_id'=>$v['house_id']])->scalar();
			$list[$k]['total_space'] = HouseLeaseReport::find()->select('sum(space)')->where($con)->andWhere(['between','add_time',$stime,$etime])->andWhere(['house_id'=>$v['house_id']])->scalar();
		}

		$house = $this->getHouseInfo(0);

		return $this->render('house_lease_count',[
			'house' => $house,
			'lease_count' => $lease_count,
			'report_count' => $report_count,
			'zoushi' => $zoushi,
			'chart1' => $chart1,
			'chart2' => $chart2,
			'chart3' => $chart3,
			'list' => $list,
		]);
	}

	/**
	 * 车位统计管理
	 * @Author   tml
	 * @DateTime 2018-04-13
	 * @return   [type]     [description]
	 */
	public function actionParkingCount()
	{
		$this->layout = 'layout1';
		$time_tag     = empty($this->get['time_tag']) ? 'first_half' : $this->get['time_tag'];
		$house_choose = empty($this->get['house_choose']) ? 'all' : $this->get['house_choose'];
		$sdate        = empty($this->get['sdate']) ? date('Y-m-d') : $this->get['sdate'];
		$edate        = empty($this->get['edate']) ? date('Y-m-d') : $this->get['edate'];
		$currentPage        = empty($this->get['currentPage']) ? 1 : $this->get['currentPage'];
		$house_id     = 0;

		$stime = 0;
		$etime = 0;
		switch ($time_tag) {
			case 'day':
				$stime = strtotime(date('Y-m-d').' 00:00:00');
				$etime = strtotime(date('Y-m-d',strtotime("+1 day")));
				break;
			case 'week':
				$w     = intval(date('w',time())-1);
				$stime = strtotime(date('Y-m-d',strtotime("-$w days")).'00:00:00');
				$etime = $stime + 7*24*60*60 - 1;
				break;
			case 'month':
				$stime = strtotime(date('Y-m-01').' 00:00:00');
				$etime = strtotime(date('Y-m-t').' 23:59:59');
				break;
			case 'second_half':
				$stime = strtotime(date('Y').'-07-01 00:00:00');
				$etime = strtotime(date('Y').'-12-31 23:59:59');
				break;
			case 'year':
				$stime = strtotime(date('Y').'-01-01 00:00:00');
				$etime = strtotime(date('Y').'-12-31 23:59:59');
				break;
			case 'other':
				$stime = strtotime($sdate);
				$etime = strtotime($edate);
				break;
			default:
				$stime = strtotime(date('Y').'-01-01 00:00:00');
				$etime = strtotime(date('Y').'-06-30 23:59:59');
				break;
		}
		if ($house_choose != 'all') {
			$house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
		}
		$con = [];$con1 = [];
		if ($house_id!=0) {
			$con['house_id'] = $house_id;
		}
		$stall = Stall::find()->select('stall.*,sum(stall_num) as num')->where($con)->andWhere(['between','stall.time',$stime,$etime])->asArray()->one();
		if($house_choose != 'all'){
			$con1['stall_id'] = $stall['id'];
		}
		$attr = StallAttr::find()->select('sum(rent) as rent,sum(sold) as sold, sum(other) as other')->where($con1)->andWhere(['between','create_time',$stime,$etime])->asArray()->one();
		$house = $this->getHouseInfo(0);
		array_unshift($house,['id'=>0,'housename'=>'请选择楼盘','parentId'=>0]);
		if($house_choose != 'all'){
			$id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
			if($id == 3){
				$id = 'D7348B36-7995-4697-ABA7-CB19CC0E7EE8';
				$hexie  = json_decode($this->Chechang($id,'GetTempMoney',date('Y-m-d',$stime),date('Y-m-d',$etime),$currentPage));
				$linting['count'] = $hexie->SumCount;
				$linting['money'] = $hexie->TranAmount;
				$linting['list'] = json_decode($this->Chechang($id,'GetTempDetails',date('Y-m-d',$stime),date('Y-m-d',$etime),$currentPage))->TrList;
//				foreach($linting['list'] as $k=>$v){
//					$linting['list'][$k]->housename = '正商和谐大厦';
//				}
			}elseif($id == 7){
				$id = '6300BBEE-5F0B-4995-AF08-451EEFEFE832';
				$jianzheng  = json_decode($this->Chechang($id,'GetTempMoney',date('Y-m-d',$stime),date('Y-m-d',$etime),$currentPage));
				$linting['count'] = $jianzheng->SumCount;
				$linting['money'] = $jianzheng->TranAmount;
				$linting['list'] = json_decode($this->Chechang($id,'GetTempDetails',date('Y-m-d',$stime),date('Y-m-d',$etime),$currentPage))->TrList;
//				foreach($linting['list'] as $k=>$v){
//					$linting['list'][$k]->housename = '正商建正东方中心';
//				}
			}else{
				$linting['count'] = '暂无数据';
				$linting['money'] = '暂无数据';
				$linting['list'] = '';
			}

		}else{
			$hid = 'D7348B36-7995-4697-ABA7-CB19CC0E7EE8';
			$jid = '6300BBEE-5F0B-4995-AF08-451EEFEFE832';
			$jianzheng = json_decode($this->Chechang($jid,'GetTempMoney',date('Y-m-d',$stime),date('Y-m-d',$etime),$currentPage));
			$hexie = json_decode($this->Chechang($hid,'GetTempMoney',date('Y-m-d',$stime),date('Y-m-d',$etime),$currentPage));
			$linting['count'] = $jianzheng->SumCount + $hexie->SumCount;
			$linting['money'] = $jianzheng->TranAmount + $hexie->TranAmount;
			$linting['list'] = json_decode($this->Chechang($hid,'GetTempDetails',date('Y-m-d',$stime),date('Y-m-d',$etime),$currentPage))->TrList;
//			foreach($linting['list'] as $k=>$v){
//				$linting['list'][$k]->housename = '正商和谐大厦';
//			}
			$linting['list1'] = json_decode($this->Chechang($jid,'GetTempDetails',date('Y-m-d',$stime),date('Y-m-d',$etime),$currentPage))->TrList;
//			foreach($linting['list1'] as $k=>$v){
//				$linting['list1'][$k]->housename = '正商建正东方中心';
//			}
			array_merge($linting['list']?$linting['list']:[],$linting['list1']?$linting['list1']:[]);
		}
		// 统计图-走势图
		$month_arr = $this->getMonthArray($stime,$etime);
		$zoushi['x'] = [];
		foreach ($month_arr as $k => $v) {
			$r = explode('-', $v);
			array_push($zoushi['x'],$r[0].'年'.$r[1].'月');
		}
		$list = Stall::find()->alias('s')->select('s.house_id,h.housename,s.stall_num,sum(sa.sold) as sold,sum(sa.rent) as rent,sum(sa.other) as other')->
		leftJoin('stall_attr sa','sa.stall_id=s.id')->
		leftJoin('house h','h.id = s.house_id')->where($con)->andWhere(['between','s.time',$stime,$etime])->groupBy('s.house_id')->asArray()->all();
		foreach($list as $k => $v){
			if($v['house_id'] == 3){
				$list[$k]['count'] = $hexie->SumCount;
				$list[$k]['money'] = $hexie->TranAmount;
			}elseif($v['house_id'] == 7){
				$list[$k]['count'] = $jianzheng->SumCount;
				$list[$k]['money'] = $jianzheng->TranAmount;
			}else{
				$list[$k]['count'] = '暂无数据';
				$list[$k]['money'] = '暂无数据';
			}
		}
		return $this->render('parking_count',[
			'house'=> $house,
			'stall'=>$stall,
			'attr'=>$attr,
			'linting'=>$linting,
			'zoushi'=>(array)$zoushi,
			'list' =>$list
		]);
	}
	public function Chechang($id,$controller,$sta,$end,$currentPage) {
		$header = array();
		$header[] = 'Content-Type:application/json;charset=utf-8';
		//列表
//		$remote_server = 'http://120.79.12.33:60001/api/core/GetTempDetails';
		//详情
//		$remote_server = 'http://120.79.12.33:60001/api/core/GetTempMoney';
		//和谐
//		$serialize = ['projectNo'=>'D7348B36-7995-4697-ABA7-CB19CC0E7EE8','startTime'=>'2018-01-01','endTime'=>'2018-06-01','currentPage'=>'1','pageSize'=>10];
		//建正
//		$serialize = ['projectNo'=>'6300BBEE-5F0B-4995-AF08-451EEFEFE832','startTime'=>'2018-01-01','endTime'=>'2018-06-01','currentPage'=>'1','pageSize'=>10];
		$remote_server = 'http://211.162.71.186:60002/api/core/'.$controller;
		$serialize = ['projectNo'=>$id,'startTime'=>$sta,'endTime'=>$end,'currentPage'=>$currentPage,'pageSize'=>10];
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

	public function actionCheShi() {
		$header = array();
		$header[] = 'Content-Type:application/json;charset=utf-8';
		//列表
		$remote_server = 'http://e7.fujica.com.cn:60021/api/core/GetTempDetails';
//		$remote_server = 'http://211.162.71.186:60002/api/core/GetTempDetails';
		//详情
//		$remote_server = 'http://e7.fujica.com.cn:60009/api/RpCommonView/GetRuncProc';
		//和谐
//		$serialize = ['projectNo'=>'D7348B36-7995-4697-ABA7-CB19CC0E7EE8','startTime'=>'2018-01-01','endTime'=>'2018-06-01','currentPage'=>'1','pageSize'=>10];
		//建正
		$serialize = ['projectNo'=>'6300BBEE-5F0B-4995-AF08-451EEFEFE832','startTime'=>'2018-12-01','endTime'=>'2018-12-30','currentPage'=>'1','pageSize'=>10];
//		$remote_server = 'http://120.79.12.33:60001/api/core/'.$controller;
//		$serialize = ['projectNo'=>$id,'startTime'=>$sta,'endTime'=>$end,'currentPage'=>$currentPage,'pageSize'=>10];
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
		echo '<pre>';
		var_dump(json_decode($ret));
	}

	/**
	 * 电费统计
	 * @Author   tml
	 * @DateTime 2018-04-13
	 * @return   [type]     [description]
	 */
	public function actionElectricCount()
	{
		$this->layout = 'layout1';
		$time_tag     = empty($this->get['time_tag']) ? 'first_half' : $this->get['time_tag'];
		$house_choose = empty($this->get['house_choose']) ? 'all' : $this->get['house_choose'];
		$sdate        = empty($this->get['sdate']) ? date('Y-m-d') : $this->get['sdate'];
		$edate        = empty($this->get['edate']) ? date('Y-m-d') : $this->get['edate'];
		$house_id     = 0;

		$stime = 0;
		$etime = 0;
		switch ($time_tag) {
			case 'day':
				$stime = strtotime(date('Y-m-d').' 00:00:00');
				$etime = strtotime(date('Y-m-d').' 23:59:59');
				break;
			case 'week':
				$w     = intval(date('w',time())-1);
				$stime = strtotime(date('Y-m-d',strtotime("-$w days")).'00:00:00');
				$etime = $stime + 7*24*60*60 - 1;
				break;
			case 'month':
				$stime = strtotime(date('Y-m-01').' 00:00:00');
				$etime = strtotime(date('Y-m-t').' 23:59:59');
				break;
			case 'second_half':
				$stime = strtotime(date('Y').'-07-01 00:00:00');
				$etime = strtotime(date('Y').'-12-31 23:59:59');
				break;
			case 'year':
				$stime = strtotime(date('Y').'-01-01 00:00:00');
				$etime = strtotime(date('Y').'-12-31 23:59:59');
				break;
			case 'other':
				$stime = strtotime($sdate);
				$etime = strtotime($edate);
				break;
			default:
				$stime = strtotime(date('Y').'-01-01 00:00:00');
				$etime = strtotime(date('Y').'-06-30 23:59:59');
				break;
		}
		if ($house_choose != 'all') {
			$house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
		}
		$con = [];
		$conh = [];
		if ($house_id!=0) {
			$con['ce.house_id'] = $house_id;
			$conh['house_id'] = $house_id;
		}
		$house = $this->getHouseInfo(0);
		array_unshift($house,['id'=>0,'housename'=>'请选择楼盘','parentId'=>0]);
		$data = CountElectr::find()->alias('ce')->
		select('sum(cea.total) as totals,sum(cea.public) as publics,sum(cea.self) as self,sum(cea.shop) as shop,sum(cea.hold) as hold,sum(cea.shop_pre) as shop_pre,sum(cea.hold_pre) as hold_pre,sum(cea.sell) as sell')->
		leftJoin('count_electrattr cea','cea.electr_id = ce.id')->
		where($con)->andWhere(['between','cea.time',$stime,$etime])->asArray()->one();

		// $money = WaterPayment::find()->alias('w')->
		// leftJoin('user_account cw','cw.account_id = w.account_id')->
		// select('sum(w.water_fee) as money')->where($con)->
		// andwhere(['w.status'=>2])->andWhere(['between','w.create_time',$stime,$etime])->asArray()->one();
		$money = ElectricOrder::find()->select('sum(money) as money')->where($conh)->andWhere(['pay_status'=>2])->andWhere(['between','pay_time',$stime,$etime])->asArray()->one();

		$list = CountElectr::find()->alias('ce')->select('sum(cea.hold) as hold,sum(cea.total) as total,ce.id,h.housename,sum(cea.public) as public,sum(cea.office) as office,ce.area,sum(cea.public)/ce.area as val')->
		leftJoin('count_electrattr cea','ce.id=cea.electr_id')->
		leftJoin('house h','h.id = ce.house_id')->where($con)->andWhere(['between','cea.time',$stime,$etime])->groupBy('ce.house_id')->asArray()->all();	

		$item = [];
		foreach($list as $k=>$v){
			$res = CountElectrattr::find()->alias('c')->leftJoin('count_electr ce','ce.id = c.electr_id')->select('c.public,ce.area')->where(['c.electr_id'=>$v['id']])->andWhere(['between','c.time',$stime,$etime])->orderBy('c.time asc')->asArray()->all();
			$v['sn'] = [];
			foreach($res as $n){
				$v['sn'][] = sprintf("%.2f", $n['public']/$n['area']);
			}
			$item[] = $v;
		}
		// 统计图-走势图
		$month_arr = $this->getMonthArray($stime,$etime);
		$zoushi['x'] = [];
		foreach ($month_arr as $k => $v) {
			$r = explode('-', $v);
			array_push($zoushi['x'],$r[0].'年'.$r[1].'月');
		}
		$jquery = (new \yii\db\Query())->select('eo.order_sn,h1.housename,h2.housename as seatname,eo.money,eo.room_num,eo.rate,eo.pay_time')->from('electric_order eo')
				->leftJoin('house h1','h1.id=eo.house_id')
				->leftJoin('house h2','h2.id=eo.house_id')->
				where(['eo.pay_status'=>2,'eo.house_id'=>$house_id]);
		$count = $jquery->count();
		$pagination = new Pagination(['totalCount'=>$count],10);

		$n = $jquery->offset($pagination->offset)->limit($pagination->limit)->orderBy('eo.pay_time desc')->all();

		return $this->render('electric_count',[
				'house'=> $house,
				'data'=>$data,
				'list'=>$item,
				'pagination'=>$pagination,
				'n'=>$n,
				'zoushi'=>$zoushi,
				'money' => $money
		]);
	}

	/**
	 * 水费统计
	 * @Author   tml
	 * @DateTime 2018-04-13
	 * @return   [type]     [description]
	 */
	public function actionWaterCount()
	{
		$this->layout = 'layout1';
		$time_tag     = empty($this->get['time_tag']) ? 'first_half' : $this->get['time_tag'];
		$house_choose = empty($this->get['house_choose']) ? 'all' : $this->get['house_choose'];
		$sdate        = empty($this->get['sdate']) ? date('Y-m-d') : $this->get['sdate'];
		$edate        = empty($this->get['edate']) ? date('Y-m-d') : $this->get['edate'];
		$house_id     = 0;

		$stime = 0;
		$etime = 0;
		switch ($time_tag) {
			case 'day':
				$stime = strtotime(date('Y-m-d').' 00:00:00');
				$etime = strtotime(date('Y-m-d').' 23:59:59');
				break;
			case 'week':
				$w     = intval(date('w',time())-1);
				$stime = strtotime(date('Y-m-d',strtotime("-$w days")).'00:00:00');
				$etime = $stime + 7*24*60*60 - 1;
				break;
			case 'month':
				$stime = strtotime(date('Y-m-01').' 00:00:00');
				$etime = strtotime(date('Y-m-t').' 23:59:59');
				break;
			case 'second_half':
				$stime = strtotime(date('Y').'-07-01 00:00:00');
				$etime = strtotime(date('Y').'-12-31 23:59:59');
				break;
			case 'year':
				$stime = strtotime(date('Y').'-01-01 00:00:00');
				$etime = strtotime(date('Y').'-12-31 23:59:59');
				break;
			case 'other':
				$stime = strtotime($sdate);
				$etime = strtotime($edate);
				break;
			default:
				$stime = strtotime(date('Y').'-01-01 00:00:00');
				$etime = strtotime(date('Y').'-06-30 23:59:59');
				break;
		}
		if ($house_choose != 'all') {
			$house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
		}
		$con = [];
		if ($house_id!=0) {
			$con['cw.house_id'] = $house_id;
		}
		$house = $this->getHouseInfo(0);
		array_unshift($house,['id'=>0,'housename'=>'请选择楼盘','parentId'=>0]);
		$data = CountWater::find()->alias('cw')->
		select('sum(cwa.total) as totals,sum(cwa.public) as publics,sum(cwa.office) as offices,sum(cwa.hold) as holds')->
				leftJoin('count_waterattr cwa','cwa.water_id = cw.id')->
				where($con)->andWhere(['between','cwa.time',$stime,$etime])->asArray()->one();
		//总金额
		$money = WaterPayment::find()->alias('w')->
		leftJoin('user_account cw','cw.account_id = w.account_id')->
		select('sum(w.water_fee) as money')->where($con)->
		andwhere(['w.status'=>2])->andWhere(['between','w.create_time',$stime,$etime])->asArray()->one();

		$list = CountWater::find()->alias('cw')->select('sum(cwa.hold) as hold,sum(cwa.total) as total,cw.id,h.housename,sum(cwa.public) as public,sum(cwa.office) as office,cw.area,sum(cwa.public)/cw.area as val')->
				leftJoin('count_waterattr cwa','cw.id=cwa.water_id')->
		leftJoin('house h','h.id = cw.house_id')->where($con)->andWhere(['between','cwa.time',$stime,$etime])->groupBy('cw.house_id')->asArray()->all();
		$item = [];
		foreach($list as $k=>$v){
			$res = CountWaterattr::find()->alias('c')->leftJoin('count_water cw','cw.id = c.water_id')->select('c.public,cw.area')->where(['c.water_id'=>$v['id']])->andWhere(['between','c.time',$stime,$etime])->orderBy('c.time asc')->asArray()->all();
			$v['sn'] = [];
			foreach($res as $n){
				$v['sn'][] = sprintf("%.2f", $n['public']/$n['area']);
			}
			$item[] = $v;
		}
		// 统计图-走势图
		$month_arr = $this->getMonthArray($stime,$etime);
		$zoushi['x'] = [];
		foreach ($month_arr as $k => $v) {
			$r = explode('-', $v);
			array_push($zoushi['x'],$r[0].'年'.$r[1].'月');
		}
		$jquery = (new \yii\db\Query())->select('w.order_sn,u.owner,h1.housename,h2.housename as seatname,u.room_num,w.water_consumption,w.water_fee')->from('water_payment w')->
		leftJoin('user_account u','u.account_id = w.account_id')
				->leftJoin('house h1','h1.id=u.house_id')
				->leftJoin('house h2','h2.id=u.house_id')->
		where(['w.status'=>2,'u.house_id'=>$house_id]);
		$count = $jquery->count();
		$pagination = new Pagination(['totalCount'=>$count],10);
		$n = $jquery->offset($pagination->offset)->limit($pagination->limit)->orderBy('w.water_time desc')->all();
		return $this->render('water_count',[
				'house'=> $house,
				'data'=>$data,
				'list'=>$item,
				'pagination'=>$pagination,
				'n'=>$n,
				'zoushi'=>$zoushi,
				'money'=>$money
		]);
	}


	/**
	 * 房屋动态统计
	 * @Author   tml
	 * @DateTime 2018-04-23
	 * @return   [type]     [description]
	 */
	public function actionHouseCount()
	{
		$this->layout = 'layout1';

		$time_tag     = empty($this->get['time_tag']) ? 'first_half' : $this->get['time_tag'];
		$house_choose = empty($this->get['house_choose']) ? 'all' : $this->get['house_choose'];
		$sdate        = empty($this->get['sdate']) ? date('Y-m-d') : $this->get['sdate'];
		$edate        = empty($this->get['edate']) ? date('Y-m-d') : $this->get['edate'];
		$tab          = empty($this->get['tab']) ? 1 : $this->get['tab'];
		$house_id     = 0;
		$stime = 0;
		$etime = 0;
		switch ($time_tag) {
			case 'day':
				$stime = strtotime(date('Y-m-d').' 00:00:00');
				$etime = strtotime(date('Y-m-d').' 23:59:59');
				break;
			case 'week':
				$w     = intval(date('w',time())-1);
				$stime = strtotime(date('Y-m-d',strtotime("-$w days")).'00:00:00');
				$etime = $stime + 7*24*60*60 - 1;
				break;
			case 'month':
				$stime = strtotime(date('Y-m-01').' 00:00:00');
				$etime = strtotime(date('Y-m-t').' 23:59:59');
				break;
			case 'second_half':
				$stime = strtotime(date('Y').'-07-01 00:00:00');
				$etime = strtotime(date('Y').'-12-31 23:59:59');
				break;
			case 'year':
				$stime = strtotime(date('Y').'-01-01 00:00:00');
				$etime = strtotime(date('Y').'-12-31 23:59:59');
				break;
			case 'other':
				$stime = strtotime($sdate.' 00:00:00');
				$etime = strtotime($edate.' 23:59:59');
				break;
			default:
				$stime = strtotime(date('Y').'-01-01 00:00:00');
				$etime = strtotime(date('Y').'-06-30 23:59:59');
				break;
		}
		if ($house_choose != 'all') {
			$house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
		}
		// 公用查询条件
		$con['is_del'] = 0;
		if ($house_id) {
			$con['house_id'] = $house_id;
		}

		// 交房数据汇总
		$a = (new Query())->select('*')->from('house_data')->where($con)->andWhere((['between','add_time',$stime,$etime]) or (['between','edit_time',$stime,$etime]))->orderBy('add_time desc');
		$b = (new Query())->select('house_id,seat_id,house_type,total_nums,sale_nums,unsale_nums,match_nums,unmatch_nums,already_nums,unalready_nums,total_money,real_money,rent_live,rent_office,hotel,dormitory,self_office,self_live,vacant')->from(['a'=>$a])->groupBy('house_id,seat_id,house_type');
		$data1 = (new Query())->select('sum(total_nums) as total_nums,sum(unsale_nums) as unsale_nums,sum(sale_nums) as sale_nums,sum(match_nums) as match_nums,sum(unalready_nums) as unalready_nums,sum(already_nums) as already_nums,sum(total_money) as total_money,sum(real_money) as real_money')->from(['b'=>$b])->andWhere(['!=','house_type',4])->one();
		$data1['jfl'] = '--';
		$data1['sfl'] = '--';
		if ($data1['already_nums'] > 0 && $data1['match_nums'] > 0) {
			$data1['jfl'] = round(bcdiv($data1['already_nums'],$data1['match_nums'],5)*100,2).'%';
		}
		if ($data1['real_money'] > 0 && $data1['total_money'] > 0) {
			$data1['sfl'] = round(bcdiv($data1['real_money'],$data1['total_money'],5)*100,2).'%';
		}
		// 交房汇总列表
		$list1 = (new Query())
			->select('h.housename,sum(b.total_nums) as total_nums,sum(b.unsale_nums) as unsale_nums,sum(b.sale_nums) as sale_nums,sum(b.match_nums) as match_nums,sum(b.unalready_nums) as unalready_nums,sum(b.already_nums) as already_nums,sum(b.total_money) as total_money,sum(b.real_money) as real_money')
			->from(['b'=>$b])
			->leftJoin('house h','b.house_id=h.id')
			->groupBy('b.house_id')
			->all();
		// 房屋动态汇总
		$res = (new Query())->select('house_type,sum(total_nums) as total_nums,sum(unsale_nums) as unsale_nums,sum(unmatch_nums) as unmatch_nums,sum(unalready_nums) as unalready_nums,sum(already_nums) as already_nums,sum(rent_live) as rent_live,sum(rent_office) as rent_office,sum(hotel) as hotel,sum(dormitory) as dormitory,sum(self_office) as self_office,sum(self_live) as self_live,sum(vacant) as vacant')->from(['b'=>$b])->groupBy('house_type')->orderBy('house_type')->all();
		$data2[1] = []; //办公
		$data2[2] = []; //商铺
		$data2[3] = []; //公寓
		foreach ($res as $k => $v) {
			if($v['house_type'] == 1)
				$data2[1] = $res[$k];
			if($v['house_type'] == 2)
				$data2[2] = $res[$k];
			if($v['house_type'] == 3)
				$data2[3] = $res[$k];
		}
		foreach ($data2 as $k => $v) {
			if ($v && $v['already_nums']) {
				$data2[$k]['jfl'] = round(($v['already_nums']/($v['already_nums']+$v['unalready_nums']))*100,2).'%';
			}
		}

		//交付收费率汇总
		$a3 = (new Query())->select('*')->from('house_charge')->where($con)->andWhere((['between','add_time',$stime,$etime]) or (['between','edit_time',$stime,$etime]))->orderBy('add_time desc')->groupBy('house_id,seat_id,house_type');
		//房屋动态收费率汇总
		$data3_house = (new Query())
			->select('sum(total_money) as total_money,sum(get_money) as get_money,sum(current_money) as current_money,sum(unget_money) as unget_money,sum(total_nums) as total_nums,sum(get_nums) as get_nums,sum(current_nums) as current_nums,sum(unget_nums) as unget_nums')
			->from(['a'=>$a3])
			->where(['!=','a.house_type',4])
			->one();
		//停车位收费率汇总
		$data3_parking = (new Query())
			->select('sum(total_money) as total_money,sum(get_money) as get_money,sum(current_money) as current_money,sum(unget_money) as unget_money,sum(total_nums) as total_nums,sum(get_nums) as get_nums,sum(current_nums) as current_nums,sum(unget_nums) as unget_nums')
			->from(['a'=>$a3])
			->where(['a.house_type'=>4])
			->one();

		$month_arr = $this->getMonthArray($stime,$etime);
		
		$data3_chart['x'] = [];
		$data3_chart['house'] = []; //房屋动态收费率走势图
		$data3_chart['parking'] = []; //停车位收费率走势图
		foreach ($month_arr as $k => $v) {
			$r = explode('-', $v);
			array_push($data3_chart['x'],$r[0].'年'.$r[1].'月');
			$sub_query = (new Query())->select('*')->from('house_charge')->where($con)->andWhere((['between','add_time',$stime,$etime]) or (['between','edit_time',$stime,$etime]))->andWhere(['year'=>$r[0],'month'=>$r[1]])->orderBy('add_time desc')->groupBy('house_id,seat_id,house_type');
			$h = (new Query())->select('sum(get_money)')->from(['s'=>$sub_query])->andWhere(['!=','house_type',4])->scalar();
			array_push($data3_chart['house'],$h ? $h : 0);
			$p = (new Query())->select('sum(get_money)')->from(['s'=>$sub_query])->andWhere(['house_type'=>4])->scalar();
			array_push($data3_chart['parking'],$p ? $p : 0);
		}

		$sub_query1 = (new Query())->select('*')->from('house_charge')->where($con)->andWhere((['between','add_time',$stime,$etime]) or (['between','edit_time',$stime,$etime]))->orderBy('add_time desc')->groupBy('house_id,seat_id,house_type');
		//房屋动态统计列表
		$list3_house = (new Query())->select('h.housename,sum(s.total_money) as total_money,sum(s.get_money) as get_money,sum(s.current_money) as current_money,sum(s.unget_money) as unget_money,sum(s.total_nums) as total_nums,sum(s.get_nums) as get_nums,sum(s.current_nums) as current_nums,sum(s.unget_nums) as unget_nums')->from(['s'=>$sub_query1])->leftJoin('house h','h.id=s.house_id')->where(['!=','s.house_type',4])->groupBy('s.seat_id')->all();
		$list3_total = (new Query())->select('sum(s.total_money) as total_money,sum(s.get_money) as get_money,sum(s.current_money) as current_money,sum(s.unget_money) as unget_money,sum(s.total_nums) as total_nums,sum(s.get_nums) as get_nums,sum(s.current_nums) as current_nums,sum(s.unget_nums) as unget_nums')->from(['s'=>$sub_query1])->where(['!=','s.house_type',4])->one();
		if ($house_id) {
			$list3_house = (new Query())->select('h.housename,sum(s.total_money) as total_money,sum(s.get_money) as get_money,sum(s.current_money) as current_money,sum(s.unget_money) as unget_money,sum(s.total_nums) as total_nums,sum(s.get_nums) as get_nums,sum(s.current_nums) as current_nums,sum(s.unget_nums) as unget_nums')->from(['s'=>$sub_query1])->leftJoin('house h','h.id=s.seat_id')->where(['!=','s.house_type',4])->groupBy('s.seat_id')->all();
			$list3_total = (new Query())->select('sum(s.total_money) as total_money,sum(s.get_money) as get_money,sum(s.current_money) as current_money,sum(s.unget_money) as unget_money,sum(s.total_nums) as total_nums,sum(s.get_nums) as get_nums,sum(s.current_nums) as current_nums,sum(s.unget_nums) as unget_nums')->from(['s'=>$sub_query1])->where(['!=','s.house_type',4])->one();
		}
		//停车位统计列表
		$list3_parking = (new Query())->select('sum(s.total_money) as total_money,sum(s.get_money) as get_money,sum(s.current_money) as current_money,sum(s.unget_money) as unget_money,sum(s.total_nums) as total_nums,sum(s.get_nums) as get_nums,sum(s.current_nums) as current_nums,sum(s.unget_nums) as unget_nums')->from(['s'=>$sub_query1])->where(['s.house_type'=>4])->one();

		//装修办理统计
		$sub_query4 = (new Query())->select('*')->from('renovation')->where($con)->andWhere((['between','add_time',$stime,$etime]) or (['between','edit_time',$stime,$etime]))->orderBy('add_time desc')->groupBy('house_id,seat_id,house_type');
		$data4 = (new Query())->select('sum(renovation_nums) as renovation_nums,sum(check_nums) as check_nums,sum(return_nums) as return_nums,sum(nowing_nums) as nowing_nums,sum(current_nums) as current_nums')->from(['s'=>$sub_query4])->one();
		if ($data4 && $data1['total_nums']) {
			$data4['zxl'] = round($data4['check_nums']/$data1['total_nums']*100,2).'%';
			$data4['wzx'] = intval($data1['total_nums']-$data4['check_nums']);
		} else {
			if (empty($data4)) {
				$data4['renovation_nums'] = 0;
				$data4['check_nums'] = 0;
				$data4['return_nums'] = 0;
				$data4['nowing_nums'] = 0;
				$data4['current_nums'] = 0;
			}
			$data4['zxl'] = '--';
			$data4['wzx'] = 0;
		}
		//装修办理列表	
		$list4 = null;	
		if ($house_id) {
			$list4 = (new Query())->select('h.housename,s.house_id,s.seat_id,sum(s.renovation_nums) as renovation_nums,sum(s.check_nums) as check_nums,sum(s.return_nums) as return_nums,sum(s.nowing_nums) as nowing_nums,sum(s.current_nums) as current_nums')->from(['s'=>$sub_query4])->leftJoin('house h','s.seat_id=h.id')->where(['s.house_id'=>$house_id])->groupBy('s.seat_id')->all();
		} else {
			$list4 = (new Query())->select('h.housename,s.house_id,s.seat_id,sum(s.renovation_nums) as renovation_nums,sum(s.check_nums) as check_nums,sum(s.return_nums) as return_nums,sum(s.nowing_nums) as nowing_nums,sum(s.current_nums) as current_nums')->from(['s'=>$sub_query4])->leftJoin('house h','s.house_id=h.id')->groupBy('s.house_id')->all();
		}
		if ($list4) {
			foreach ($list4 as $k => $v) {
				$cond = [];
				if ($house_id) {
					$cond['house_id'] = $house_id;
					$cond['seat_id'] = $v['seat_id'];
				} else {
					$cond['house_id'] = $v['house_id'];
				}				
				$total_nums = HouseData::find()->select('sum(total_nums)')->where($con)->andWhere((['between','add_time',$stime,$etime]) or (['between','edit_time',$stime,$etime]))->andWhere(['!=','house_type',4])->andWhere($cond)->scalar();
				if ($total_nums) {
					$list4[$k]['zxl'] = round($v['check_nums']/$total_nums*100,2).'%';
				} else {
					$list4[$k]['zxl'] = '--';
				}
			}
		}

		$house = $this->getHouseInfo(0);

		return $this->render('house_count',[
			'house' => $house,
			'data1' => $data1,
			'list1' => $list1,
			'data2' => $data2,
			'data3_house' => $data3_house,
			'data3_parking' => $data3_parking,
			'data3_chart' => $data3_chart,
			'list3_house' => $list3_house,
			'list3_total' => $list3_total,
			'list3_parking' => $list3_parking,
			'data4' => $data4,
			'list4' => $list4
		]);
	}
	/*
	 * 工程统计
	 */
	public function actionEngineering()
	{
		$this->layout = 'layout1';
		$time_tag     = empty($this->get['time_tag']) ? 'first_half' : $this->get['time_tag'];
		$house_choose = empty($this->get['house_choose']) ? 'all' : $this->get['house_choose'];
		$sdate        = empty($this->get['sdate']) ? date('Y-m-d') : $this->get['sdate'];
		$edate        = empty($this->get['edate']) ? date('Y-m-d') : $this->get['edate'];
		$house_id     = 0;

		$stime = 0;
		$etime = 0;
		switch ($time_tag) {
			case 'day':
				$stime = strtotime(date('Y-m-d').' 00:00:00');
				$etime = strtotime(date('Y-m-d').' 23:59:59');
				break;
			case 'week':
				$w     = intval(date('w',time())-1);
				$stime = strtotime(date('Y-m-d',strtotime("-$w days")).'00:00:00');
				$etime = $stime + 7*24*60*60 - 1;
				break;
			case 'month':
				$stime = strtotime(date('Y-m-01').' 00:00:00');
				$etime = strtotime(date('Y-m-t').' 23:59:59');
				break;
			case 'second_half':
				$stime = strtotime(date('Y').'-07-01 00:00:00');
				$etime = strtotime(date('Y').'-12-31 23:59:59');
				break;
			case 'year':
				$stime = strtotime(date('Y').'-01-01 00:00:00');
				$etime = strtotime(date('Y').'-12-31 23:59:59');
				break;
			case 'other':
				$stime = strtotime($sdate);
				$etime = strtotime($edate);
				break;
			default:
				$stime = strtotime(date('Y').'-01-01 00:00:00');
				$etime = strtotime(date('Y').'-06-30 23:59:59');
				break;
		}
		$house = $this->getHouseInfo(0);
		array_unshift($house,['id'=>0,'housename'=>'请选择楼盘','parentId'=>0]);
		if ($house_choose != 'all') {
			$house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
		}
		// 公用查询条件
		$con = [];
		if ($house_id) {
			$con['HouseId'] = $house_id;
		}
		$data['num'] = Order::find()->where($con)->andWhere(['between','deal_time',$stime,$etime])->andWhere(['is_del'=>0])->count();
		$data['do'] = Order::find()->where($con)->andWhere(['between','deal_time',$stime,$etime])->andWhere(['in','Status',[4,5,6]])->andWhere(['is_del'=>0])->count();
		$data['close'] = Order::find()->where($con)->andWhere(['between','deal_time',$stime,$etime])->andWhere(['in','Status',[5,6]])->andWhere(['is_del'=>0])->count();
		$data['com'] = Order::find()->select('sum(score) as score,count(id) as com')->where($con)->andWhere(['between','deal_time',$stime,$etime])->andWhere(['Status'=>5])->andWhere(['is_del'=>0])->asArray()->one();
//		$list = Order::find()->alias('o')->select('count(o.id) as num,h.housename')->leftJoin('house h','h.id=o.HouseId')->where($con)->andWhere(['between','o.deal_time',$stime,$etime])->
//		andWhere(['o.is_del'=>0])->groupBy('o.HouseId')->asArray()->all();
//		$list['housename'] = array_column($list, 'housename');
//		$list['num'] = array_column($list, 'num');
//		$list['do'] = Order::find()->select('count(id) as do')->where($con)->andWhere(['between','deal_time',$stime,$etime])->andWhere(['in','Status',[4,5,6]])->andWhere(['is_del'=>0])->groupBy('HouseId')->asArray()->all();
//		$list['do'] = array_column($list['do'], 'do');
//		$list['close'] = Order::find()->select('count(id) as close')->where($con)->andWhere(['between','deal_time',$stime,$etime])->andWhere(['in','Status',[5,6]])->andWhere(['is_del'=>0])->groupBy('HouseId')->asArray()->all();
//		$list['close'] = array_column($list['close'], 'close');
//		$list['comm'] = Order::find()->select('count(id) as com,sum(score) as score')->where($con)->andWhere(['between','deal_time',$stime,$etime])->andWhere(['Status'=>5])->andWhere(['is_del'=>0])->groupBy('HouseId')->asArray()->all();
//		$list['com'] = array_column($list['comm'], 'com');
//		$list['score'] = array_column($list['comm'], 'score');
//		//市区维修队  王高兴
		$w= [];
		$w['num'] = Order::find()->where($con)->andWhere(['repair_id'=>2665])->andWhere(['between','deal_time',$stime,$etime])->andWhere(['is_del'=>0])->count();
		$w['do'] = Order::find()->where($con)->andWhere(['between','deal_time',$stime,$etime])->andWhere(['is_del'=>0])->andWhere(['repair_id'=>2665])->andWhere(['in','Status',[4,5,6]])->count();
		$w['close'] = Order::find()->where($con)->andWhere(['between','deal_time',$stime,$etime])->andWhere(['is_del'=>0])->andWhere(['repair_id'=>2665])->andWhere(['in','Status',[5,6]])->count();
		$w['com'] = Order::find()->select('count(id) as com,sum(score) as score')->where($con)->andWhere(['between','deal_time',$stime,$etime])->andWhere(['is_del'=>0])->andWhere(['repair_id'=>2665])->andWhere(['Status'=>5])->asArray()->one();
//		//项目无数据取零
//		$num = count($list['num']);//个数
//		for($i=0; $i<$num; $i++){
//			if(!isset($list['do'][$i])){
//				$list['do'][$i] = 0;
//			}
//			if(!isset($list['close'][$i])){
//				$list['close'][$i] = 0;
//			}
//			if(!isset($list['com'][$i])){
//				$list['com'][$i] = 0;
//			}
//			if(!isset($list['score'][$i])){
//				$list['score'][$i] = 0;
//			}
//		}
//		array_push($list['housename'],'合并','市区维修组');
//		array_push($list['num'],$data['num'],$w['num']?$w['num']:0);
//		array_push($list['do'],$data['do'],$w['do']?$w['do']:0);
//		array_push($list['close'],$data['close'],$w['close']?$w['close']:0);
//		array_push($list['com'],$data['com']['com'],$w['com']['com']?$w['com']['com']:0);
//		array_push($list['score'],$data['com']['score'],$w['com']['score']?$w['com']['score']:0);
//		$num = count($list['num']);//个数
//		//比例
//		for($i=0; $i<$num; $i++){
//			if($list['num'][$i] !=0){
//				$list['do_pro'][] = round($list['do'][$i]/$list['num'][$i]*100,2);
//			}else{
//				$list['do_pro'][$i] = 0;
//			}
//			if($list['do'][$i] !=0){
//				$list['close_pro'][] = round(($list['close'][$i])/$list['do'][$i]*100,2);
//			}else{
//				$list['close_pro'][$i] = 0;
//			}
//		}

		$res = Order::find()->alias('o')->select('count(o.id) as num,h.housename,o.HouseId')->leftJoin('house h','h.id=o.HouseId')->where($con)->andWhere(['between','o.deal_time',$stime,$etime])->
		andWhere(['o.is_del'=>0])->groupBy('o.HouseId')->asArray()->all();
		foreach($res as $k=>$v){
			$res[$k]['do'] = Order::find()->where($con)->andWhere(['between','deal_time',$stime,$etime])->andWhere(['is_del'=>0])->andWhere(['HouseId'=>$v['HouseId']])->andWhere(['in','Status',[4,5,6]])->count();
			$res[$k]['close'] = Order::find()->where($con)->andWhere(['between','deal_time',$stime,$etime])->andWhere(['is_del'=>0])->andWhere(['HouseId'=>$v['HouseId']])->andWhere(['in','Status',[5,6]])->count();
			$res[$k]['com'] = Order::find()->select('count(id) as com,sum(score) as score')->where($con)->andWhere(['between','deal_time',$stime,$etime])->andWhere(['HouseId'=>$v['HouseId']])->andWhere(['Status'=>5])->andWhere(['is_del'=>0])->asArray()->one();
		}
		if(empty($res)){
			$list['num'][] = '';
			$list['do'][] = '';
			$list['close'][] = '';
			$list['com'][] = '';
			$list['score'][] = '';
			$list['do_pro'][] = '';
			$list['close_pro'][] = '';
			$list['housename'][] = '';
		}else{
			$list = [];
			foreach($res as $k=>$v){
				$list['num'][] = $res[$k]['num'];
				$list['do'][] = $res[$k]['do'];
				$list['close'][] = $res[$k]['close'];
				$list['com'][] = $res[$k]['com']['com'];
				$list['score'][] = $res[$k]['com']['score'];
				$list['do_pro'][] = round($res[$k]['do']/$res[$k]['num']*100,2);
				if($res[$k]['do'] == 0){
					$list['close_pro'][] = 0;
				}else{
					$list['close_pro'][] = round(($res[$k]['close'])/$res[$k]['do']*100,2);
				}
				$list['housename'][] = $res[$k]['housename'];
			}
			array_push($list['housename'],'合并','市区维修组');
			array_push($list['num'],$data['num'],$w['num']?$w['num']:0);
			array_push($list['do'],$data['do'],$w['do']?$w['do']:0);
			array_push($list['close'],$data['close'],$w['close']?$w['close']:0);
			array_push($list['com'],$data['com']['com'],$w['com']['com']?$w['com']['com']:0);
			array_push($list['score'],$data['com']['score'],$w['com']['score']?$w['com']['score']:0);
			array_push($list['do_pro'],round($data['do']/$data['num']*100,2),round($w['do']/($w['num']?$w['num']:1)*100,2));
			array_push($list['close_pro'],round($data['close']/$data['do']*100,2),round($w['close']/($w['do']?$w['do']:1)*100,2));
		}
//		echo '<pre>';
//		var_dump($list);die;
		return $this->render('engineering',[
			'house'=>$house,
			'data'=>$data,
			'list'=>$list,
			'res'=>$res,
			'w'=>$w
		]);
	}
}