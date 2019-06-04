<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Admin\User;
use app\models\Admin\Order;
use app\models\Admin\OrderItem;
use app\models\Admin\OrderType;
use app\models\Admin\House;
use app\models\Admin\Propertynotice;
use app\vendor\JPush\JPush;
use yii\data\Pagination;
use app\util\MessageUtil;

// class OrderController extends CommonController{
class OrderController extends Controller{
    public $enableCsrfValidation = false;
	/**	
	 * 报检保修订单列表 tml 20171111
	 **/
	public function actionList(){
		$this->layout = 'layout1';

		$get = Yii::$app->request->get();
		$house_id  = empty($get['house_id']) ? 0 : $get['house_id'];
		$seat_id  = empty($get['seat_id']) ? 0 : $get['seat_id'];
		$content = empty($get['content']) ? 0 : $get['content'];
		$person_kw = empty($get['person_kw']) ? '' : $get['person_kw'];
		$repair_kw = empty($get['repair_kw']) ? '' : $get['repair_kw'];
		$state     = empty($get['state']) ? 0 : $get['state'];
		$txt_stime = empty($get['stime']) ? '' : strtotime($get['stime']);
		$txt_etime = empty($get['etime']) ? '' : strtotime($get['etime'])+24*3600;
		$order_type1 = empty($get['order_type1']) ? 0 : $get['order_type1']; //维修区域
		$order_type2 = empty($get['order_type2']) ? 0 : $get['order_type2']; //维修类型
		$con = [];
		$con['o.is_del'] = 0;
		$session = \Yii::$app->session;
		$lists = explode(',',$session['admin']['house_ids']);
		if (!empty($house_id)) {
			$con['o.HouseId'] = $house_id;
		}
		if(!empty($seat_id)){
			$con['o.SeatId'] = $seat_id;
		}
		if (!empty($state)) {
			$con['o.Status'] = $state;
		}
		if ($order_type1) {
			$con['o.area_id'] = $order_type1;
		}
		if ($order_type2) {
			$con['o.maintenanceType'] = $order_type2;
		}

		$query = (new \yii\db\Query())
			->select('
				o.Id as order_id,
				o.OrderId as order_no,
				o.UserId as user_id,
				o.HouseId as house_id,
				h1.housename as house_name,
				o.SeatId as seat_id,
				h2.housename as seat_name,
				o.RoomNum as room_num,
				o.Address as address,
				o.Company as company,
				o.Title as title,
				o.Content as content,
				o.OrderTime as order_time,
				o.Persion as persion,
				o.Number as persion_tel,
				o.Tumb as thumbs,
				o.Status as state,
				o.repair_id,
				o.repair_name,
				o.repair_tel,
				o.deal_time,
				o.deal_user,
				o.start_time,
				o.complate_time,
				o.audit_time,
				o.comment_time,
				o.score,
				o.comment,				
				t1.type_name as type_name,
				t2.type_name as area_name
			')
			->from('order o')
			->leftjoin('house h1','o.HouseId=h1.id')
			->leftjoin('house h2','o.SeatId=h2.id')
            ->leftjoin('order_type t1','o.maintenanceType=t1.id')
            ->leftjoin('order_type t2','o.area_id=t2.id')
			->where($con)->andWhere(['in','o.HouseId',$lists]);

		if (!empty($person_kw)) {
			$query = $query->andWhere(['or',['like','o.Persion',$person_kw],['like','o.Number',$person_kw]]);
		}
		if (!empty($content)) {
			$query = $query->andWhere(['like','o.Content',$content]);
		}
		if (!empty($repair_kw)) {
			$query = $query->andWhere(['or',['like','o.repair_name',$repair_kw],['like','o.repair_tel',$repair_kw]]);
		}
		if(!empty($txt_stime) && !empty($txt_etime)){
			$query = $query->andWhere(['between','unix_timestamp(o.OrderTime)',$txt_stime,$txt_etime]);
		}

		$count      = $query->count();
		$pagination = new Pagination(['totalCount' => $count]);
		$pagination->setPageSize(10);
		$list       = $query
			->orderBy('o.OrderTime desc')
			->offset($pagination->offset)
    		->limit($pagination->limit)
    		->all();

    	$house = House::find()->where(['parentId'=>0])->asArray()->all();
    	$order_type = OrderType::find()->where(['parent_id'=>0])->asArray()->all();
		return $this->render('list',[
			'list'=>$list,
			'house'=>$house,
			'order_type'=>$order_type,
			'pagination'=>$pagination,
			'stime'=>$txt_stime,
			'etime'=>$txt_etime,
			'count'=>$count
		]);
	}

	/**
	 * 派单页面 tml 20171111
	 **/
	public function actionAlOrder(){
		$this->layout = 'layout1';

		$id = Yii::$app->request->get('id');
		$tag = Yii::$app->request->get('tag');

		$order = (new \yii\db\Query())
			->select('
				o.Id as order_id,
				o.OrderId as order_no,
				o.UserId as user_id,
				o.HouseId as house_id,
				h1.housename as house_name,
				o.SeatId as seat_id,
				h2.housename as seat_name,
				o.RoomNum as room_num,
				o.Address as address,
				o.Company as company,
				o.Title as title,
				o.Content as content,
				o.OrderTime as order_time,
				o.Persion as persion,
				o.Number as persion_tel,
				o.Tumb as thumbs,
				o.Status as state,
				o.repair_id, 
				o.repair_name,
				o.repair_tel, 
				o.deal_time,
				o.deal_user, 
				o.start_time,
				o.complate_time,
				o.audit_time,
				o.comment_time, 
				o.score,
				o.comment,			
				t1.type_name as type_name,
				t2.type_name as area_name 
			')
			->from('order o')
			->leftjoin('house h1','o.HouseId=h1.id')
			->leftjoin('house h2','o.SeatId=h2.id')
            ->leftjoin('order_type t1','o.maintenanceType=t1.id')
            ->leftjoin('order_type t2','o.area_id=t2.id')
			->where(['o.Id'=>$id])
			->one();

		$audit = null;
		$house = null;
		if ($tag != 'dispatch') {
			$audit = OrderItem::find()->alias('oi')->select('oi.*,a.adminuser,u.TrueName,u.Tell')->leftjoin('admin a','oi.audit_user=a.adminid')->leftjoin('user u','oi.repair_id=u.id')->where(['oi.order_id'=>$id])->orderBy('oi.add_time desc')->asArray()->all();
		} else {
			$house = House::find()->where(['parentId'=>0])->asArray()->all();
		}	

		return $this->render('alorder',[
			'id'=>$id,
			'order'=>$order,
			'audit'=>$audit,
			'house'=>$house
		]);
	}

	/**
	 * ajax获取维修师傅信息
	 * @Author   tml
	 * @DateTime 2018-09-12
	 * @return   [type]     [description]
	 */
	public function actionAjaxGetRepairs()
	{
		$house_id = Yii::$app->request->post('house_id');
		$repair_name = Yii::$app->request->post('repair_name');
		$con['c.Status'] = 3;
		$con['u.PostId'] = 1;
		if (!empty($house_id)) {
			$con['c.HouseId'] = $house_id;
		}
		$con1 = [];
		if (!empty($repair_name)) {
			$con1 = ['like','u.TrueName',$repair_name];
		}

		$repairs = (new \yii\db\Query())
			->select('distinct(u.id),u.id,u.TrueName,u.Tell')
			->from('certification c')
			->leftjoin('user u','c.UserId=u.id')
			->where($con)
			->andWhere($con1)
			->all();
		foreach ($repairs as $k => $v) {
			$repairs[$k]['status2'] = Order::find()->where(['Status'=>2,'repair_id'=>$v['id']])->count();
			$repairs[$k]['status3'] = Order::find()->where(['Status'=>3,'repair_id'=>$v['id']])->count();
		}
		echo json_encode(['code'=>200,'data'=>$repairs]);exit;
	}

	/**
	 * 派单操作 tml 20171111
	 **/
	public function actionDoAppoint(){
		$postdata = Yii::$app->request->post();

		if (!$postdata['order_id'] || !$postdata['repair_id']) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}

		$user  = User::find()->where(['id'=>$postdata['repair_id']])->asArray()->one();

		$order = Order::find()->where(['Id'=>$postdata['order_id']])->asArray()->one();

		$data['Status']      = 2; // 已派单
		$data['repair_id']   = $postdata['repair_id'];
		$data['repair_name'] = $user['TrueName'];
		$data['repair_tel']  = $user['Tell'];
		$data['deal_time']   = time();
		$data['deal_user']   = 1;
		$res = Order::updateAll($data,['Id'=>$postdata['order_id']]);
		if ($res) {
			//发送短信通知
			if ($postdata['send_msg'] == "true") {
				// $str = '【爱办APP】尊敬的工程师傅，您有一个新的维修订单待接单，订单号：'.$order['OrderId'].'，请您登录爱办APP接单并及时维修。兴业物联祝您工作愉快！';
				$str = '【爱办APP】尊敬的工程师傅，您有一个新的维修订单：'.$order['OrderId'].'，请您登录爱办APP接单并及时维修。兴业物联祝您工作愉快！';
				MessageUtil::send($user['Tell'], $str);
			}
			//极光推送，向维修师傅推送新订单信息
			$client = new JPush();
			$client->push()
				->setPlatform(array('ios', 'android'))
				->addAlias('xy'.$postdata['repair_id'])
				->setNotificationAlert('您有新订单了')
				->addAndroidNotification('您有新订单了', '订单通知', 1, array('msg_type'=>1,'title'=>'订单通知','content'=>'您有新订单了','time'=>time()))
				->addIosNotification('您有新订单了', '订单通知', JPush::DISABLE_BADGE, true, 'iOS category', array('msg_type'=>1,'title'=>'订单通知','content'=>'您有新订单了','time'=>time()))
				->setMessage('您有新订单了', '订单通知', 'type', array('msg_type'=>1,'title'=>'订单通知','content'=>'您有新订单了','time'=>time()))
                ->setOptions(null, null, null, true)
				->send();
			// $art = Propertynotice::find()->orderBy('createTime desc')->asArray()->one();
			// $artId = $art['pNoticeId'] + 1;
			// $model = new Propertynotice();
			// $model->title = '订单通知';
			// $model->content = '有新订单啦！！！';
			// $model->cateId = 3; //系统通知
			// $model->url = "/index.php?r=mobile/default/proery-notice&id=".$artId."&cateid=".$model->cateId;
			// $model->createTime = date('Y-m-d H:i:s',time()); //系统通知
			// $res = $model->save();
			
			// 系统通知
			$noticeM = new Propertynotice();
			$noticeM->addNotice($postdata['repair_id'],'订单通知','您有新订单了',2);
			echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
	}

	/**
	 * 遗失登记列表 tml 20171111
	 **/
	public function actionLossRegister(){  
		$this->layout = 'layout1';
        $TrueName = empty(Yii::$app->request->get()['TrueName']) ? '' : Yii::$app->request->get()['TrueName'];
        $Tell = empty(Yii::$app->request->get()['Tell']) ? '' : Yii::$app->request->get()['Tell'];
		$house_id = empty(Yii::$app->request->get()['house_id']) ? '' : Yii::$app->request->get()['house_id'];
		$query = (new \yii\db\Query())
			->select('l.*,u.TrueName,u.Tell,l.name,l.mobile,h.housename')
			->from('loss_register l')
			->leftjoin('user u','u.id=l.reg_user')
			->leftjoin('house h','h.id=l.house_id');
		if(!empty($TrueName)){
		    $query = $query->andWhere(['like','u.TrueName',$TrueName]);
        }
        if(!empty($Tell)){
		    $query = $query->andWhere(['like','u.Tell',$Tell]);
        }
		if(!empty($house_id)){
			$query = $query->andWhere(['like','l.house_id',$house_id]);
		}
		$count      = $query->count();
		$pagination = new Pagination(['totalCount' => $count]);
		$pagination->setPageSize(10);

		$list       = $query
			->orderBy('l.reg_id desc')
			->offset($pagination->offset)
    		->limit($pagination->limit)
    		->all();
		$house = House::find()->where(['parentId'=>0])->asArray()->all();
		return $this->render('loss_register',[
			'list'=>$list,
			'pagination'=>$pagination,
			'house'=>$house
		]);
	}

	/**
	 * 报检保修订单导出
	 * @Author   tml
	 * @DateTime 2018-02-02
	 * @return   [type]     [description]
	 */
	public function actionAjaxOrderExport()
	{
		$post = Yii::$app->request->post();
		$house_id  = empty($post['house_id']) ? 0 : $post['house_id'];
		$seat_id  = empty($post['seat_id']) ? 0 : $post['seat_id'];
		$content = empty($post['content']) ? 0 : $post['content'];
		$person_kw = empty($post['person_kw']) ? '' : $post['person_kw'];
		$repair_kw = empty($post['repair_kw']) ? '' : $post['repair_kw'];
		$state     = empty($post['state']) ? 0 : $post['state'];
		$txt_stime = empty($post['stime']) ? '' : strtotime($post['stime']);
		$txt_etime = empty($post['etime']) ? '' : strtotime($post['etime'])+24*3600;
		$order_type1 = empty($post['order_type1']) ? 0 : $post['order_type1']; //维修区域
		$order_type2 = empty($post['order_type2']) ? 0 : $post['order_type2']; //维修类型

		if (empty($txt_stime) || empty($txt_etime)) {
			echo json_encode(['code'=>-200,'msg'=>'请选择开始结束时间']);exit;
		}

		$con = [];
		$con['o.is_del'] = 0;
		$session = \Yii::$app->session;
		$lists = explode(',',$session['admin']['house_ids']);
		if (!empty($house_id)) {
			$con['o.HouseId'] = $house_id;
		}
		if(!empty($seat_id)){
			$con['o.SeatId'] = $seat_id;
		}
		if (!empty($state)) {
			$con['o.Status'] = $state;
		}
		if ($order_type1) {
			$con['o.area_id'] = $order_type1;
		}
		if ($order_type2) {
			$con['o.maintenanceType'] = $order_type2;
		}

		$query = (new \yii\db\Query())
			->select('
				o.Id as order_id,
				o.OrderId as order_sn,
				o.UserId as user_id,
				o.HouseId as house_id,
				h1.housename as house_name,
				o.SeatId as seat_id,
				h2.housename as seat_name,
				o.RoomNum as room_num,
				o.Address as address,
				o.Company as company,
				o.Title as title,
				o.Content as content,
				o.OrderTime as order_time,
				o.Persion as person,
				o.Number as person_tel,
				o.Tumb as thumbs,
				o.Status as state,
				o.repair_id,
				o.repair_name,
				o.repair_tel,
				o.deal_time,
				o.deal_user,
				o.start_time,
				o.complate_time,
				o.audit_time,
				o.comment_time,
				o.score,
				o.comment,				
				t1.type_name as type_name,
				t2.type_name as area_name
			')
			->from('order o')
			->leftjoin('house h1','o.HouseId=h1.id')
			->leftjoin('house h2','o.SeatId=h2.id')
            ->leftjoin('order_type t1','o.maintenanceType=t1.id')
            ->leftjoin('order_type t2','o.area_id=t2.id')
			->where($con)->andWhere(['in','o.HouseId',$lists]);

		if (!empty($person_kw)) {
			$query = $query->andWhere(['or',['like','o.Persion',$person_kw],['like','o.Number',$person_kw]]);
		}
		if (!empty($content)) {
			$query = $query->andWhere(['like','o.Content',$content]);
		}
		if (!empty($repair_kw)) {
			$query = $query->andWhere(['or',['like','o.repair_name',$repair_kw],['like','o.repair_tel',$repair_kw]]);
		}
		if(!empty($txt_stime) && !empty($txt_etime)){
			$query = $query->andWhere(['between','unix_timestamp(o.OrderTime)',$txt_stime,$txt_etime]);
		}
		$list = $query->orderBy('o.OrderTime')->all();
		if ($list) {
			$this->exportExcel($list,'repair_data.xlsx');
			echo json_encode(['code'=>200,'msg'=>'success','path'=>'/web/repair_data.xlsx']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'暂无可导出的数据']);exit;
	}

	/**
	 * 导出excel
	 * @Author   tml
	 * @DateTime 2018-02-05
	 * @param    [type]     $data     [description]
	 * @param    [type]     $filename [description]
	 * @return   [type]               [description]
	 */
	function exportExcel($data,$filename)
	{
		require_once __DIR__ . '/../../../vendor/PHPExcel-1.8/PHPExcel.php';
		require_once __DIR__ . '/../../../vendor/PHPExcel-1.8/PHPExcel/Cell/DataType.php';

		$objPHPExcel = new \PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15); 
		//设置excel列名
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','日期');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','订单号');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','楼盘');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','楼座');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','地址');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','报修内容');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','报修人');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','报修时间');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1','派单时间');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1','维修师傅');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1','接单时间');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1','维修完成时间');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1','订单状态');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1','总计');

		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);
		
		$count = 0;
		$str = '';
		//把数据循环写入excel中
		foreach($data as $key => $value){
		    $key+=2;
		    $today = substr($value['order_time'],0,10);
		    if ($today == $str) {
		    	$count++;
		    	if ($count > 1) {
		    		$objPHPExcel->getActiveSheet()->unmergeCells('A'.($key-$count).':A'.($key-1));
		    	}
		    	$objPHPExcel->getActiveSheet()->mergeCells('A'.($key-$count).':A'.$key);
		    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($key-$count),$today."\n".'(共 '.($count+1).' 单)');
				$objPHPExcel->getActiveSheet()->getStyle('A'.($key-$count))->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle('A'.($key-$count))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);  //水平方向上两端对齐
				$objPHPExcel->getActiveSheet()->getStyle('A'.($key-$count))->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);  //垂直方向上中间居中
		    } else {
		    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key,$today."\n".'(共 1 单)');
				$objPHPExcel->getActiveSheet()->getStyle('A'.$key)->getAlignment()->setWrapText(true);
				$objPHPExcel->getActiveSheet()->getStyle('A'.$key)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);  //水平方向上两端对齐
				$objPHPExcel->getActiveSheet()->getStyle('A'.$key)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);  //垂直方向上中间居中
		    	$str = $today;
		    	$count = 0;
		    }

		    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('B'.$key,$value['order_sn'],\PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$value['house_name']);
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$value['seat_name']);
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$key,$value['room_num']);
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$key,$value['content']);
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$key,$value['person'].'('.$value['person_tel'].')');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$key,$value['order_time']);
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$key,$value['deal_time'] ? date('Y-m-d H:i:s',$value['deal_time']) : '--');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$key,$value['repair_name'].'('.$value['repair_tel'].')');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$key,$value['start_time'] ? date('Y-m-d H:i:s',$value['start_time']) : '--');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$key,$value['complate_time'] ? date('Y-m-d H:i:s',$value['complate_time']) : '--');
		    //1.未处理 2.已派单 3.已接单 4：已完成 5：已评价 6：已关闭
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$key,$value['state'] == 1 ? '未处理' : ($value['state'] == 2 ? '已派单' : ($value['state'] == 3 ? '已接单' : ($value['state'] == 4 ? '已完成' : ($value['state'] == 5 ? '已评价' : ($value['state'] == 6 ? '已完成' : '--'))))));
		}

		$total = count($data);
		$objPHPExcel->getActiveSheet()->mergeCells('N2:N'.($total+1));
    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2','共计： '.$total.' 单)');
    	$objPHPExcel->getActiveSheet()->getStyle('N2')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);  //水平方向上两端对齐
		$objPHPExcel->getActiveSheet()->getStyle('N2')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);  //垂直方向上中间居中

		//excel保存在根目录下
		$objPHPExcel->getActiveSheet()->setTitle('repair_data');
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save($filename);	
	}

	/**
	 * 下载
	 * @Author   tml
	 * @DateTime 2018-02-05
	 * @return   [type]     [description]
	 */
	public function actionDownload()
	{
		$get = Yii::$app->request->get();
		$path = empty($get['path']) ? '' : $get['path'];
		$app_path = dirname(dirname(dirname(__DIR__)));
        $wrstr = htmlspecialchars_decode(file_get_contents($app_path.$path));
        $outfile = time().'.'.'xlsx';
        header('Content-type: application/octet-stream; charset=utf8');
        Header("Accept-Ranges: bytes");
        header('Content-Disposition: attachment; filename='.$outfile);
        echo $wrstr;
        exit();
	}

	/**
	 * ajax进行订单删除操作
	 * @Author   tml
	 * @DateTime 2018-04-09
	 * @return   [type]     [description]
	 */
	public function actionAjaxOrderDel()
	{
		$order_id = empty(Yii::$app->request->post()['order_id']) ? 0 : Yii::$app->request->post()['order_id'];

		if (empty($order_id)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}

		$res = Order::updateAll(['is_del'=>1],['Id'=>$order_id]);

		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'删除成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'删除失败']);exit;
	}

	/**
	 * 报检保修区域维修类型列表
	 * @Author   tml
	 * @DateTime 2018-05-07
	 * @return   [type]     [description]
	 */
	public function actionOrderType()
	{
		$this->layout = 'layout1';
		$list = OrderType::find()->where(['is_del'=>0,'parent_id'=>0])->orderBy('id')->asArray()->all();
		if ($list) {
			foreach ($list as $k => $v) {
				$list[$k]['child'] = OrderType::find()->where(['is_del'=>0,'parent_id'=>$v['id']])->orderBy('id')->asArray()->all();
			}
		}
		return $this->render('order_type',[
			'list' => $list
		]);
	}

	/**
	 * 新增报检保修区域维修类型
	 * @Author   tml
	 * @DateTime 2018-05-07
	 * @return   [type]     [description]
	 */
	public function actionAddOrderType()
	{
		$this->layout = 'layout1';
		$id = empty(Yii::$app->request->get()['id']) ? 0 : Yii::$app->request->get()['id'];
		$model = null;
		if ($id) {
			$model = OrderType::find()->where(['id'=>$id])->one();
		}

		$type = OrderType::find()->where(['is_del'=>0,'parent_id'=>0])->asArray()->all();

		return $this->render('add_order_type',[
			'model' => $model,
			'type' => $type
		]);
	}

	/**
	 * 新增/编辑报检保修区域维修类型操作
	 * @Author   tml
	 * @DateTime 2018-05-07
	 * @return   [type]     [description]
	 */
	public function actionAjaxAddOrderType()
	{
		$post = Yii::$app->request->post();
		$id = empty($post['id']) ? 0 : $post['id'];
		$parent_id = empty($post['parent_id']) ? 0 : $post['parent_id'];
		$type_name = empty($post['type_name']) ? '' : $post['type_name'];
		$remark = empty($post['remark']) ? '' : $post['remark'];
		if (empty($type_name)) {
			echo json_encode(['code'=>-200,'msg'=>'类型名称不能为空']);exit;
		}
		if ($id) {
			$updata['type_name'] = $type_name;
			$updata['parent_id'] = $parent_id;
			$updata['remark'] = $remark;
			$updata['edit_time'] = time();
			$updata['edit_user'] = Yii::$app->session['admin']['adminid'];
			$res = OrderType::updateAll($updata,['id'=>$id]);
			if ($res) {
				echo json_encode(['code'=>200,'msg'=>'编辑成功']);exit;
			}
			echo json_encode(['code'=>-200,'msg'=>'编辑失败']);exit;
		} else {
			$model = new OrderType();
			$model->type_name = $type_name;
			$model->parent_id = $parent_id;
			$model->remark = $remark;
			$model->add_time = time();
			$model->add_user = Yii::$app->session['admin']['adminid'];
			$res = $model->save();
			if ($res) {
				echo json_encode(['code'=>200,'msg'=>'添加成功']);exit;
			}
			echo json_encode(['code'=>-200,'msg'=>'添加失败']);exit;
		}
	}

	/**
	 * 订单审核操作
	 * @Author   tml
	 * @DateTime 2018-05-15
	 * @return   [type]     [description]
	 */
	public function actionDoAudit()
	{
		$post = Yii::$app->request->post();
		$item_id = empty($post['item_id']) ? 0 : $post['item_id'];
		$audit_status = empty($post['audit_status']) ? 0 : $post['audit_status'];
		$audit_remark = empty($post['audit_remark']) ? '' : $post['audit_remark'];
		$audit_send_msg = empty($post['audit_send_msg']) ? 0 : $post['audit_send_msg'];
		// var_dump($audit_send_msg == "true");exit;
		if (empty($item_id) || empty($audit_status)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		if (!in_array($audit_status,[2,3])) {
			echo json_encode(['code'=>-200,'msg'=>'审核状态错误']);exit;
		}
		if ($audit_status == 3 && empty($audit_remark)) {
			echo json_encode(['code'=>-200,'msg'=>'请在审核备注栏输入不通过具体原因']);exit;
		}
		$model = OrderItem::find()->where(['item_id'=>$item_id])->asArray()->one();
		if (empty($model)) {
			echo json_encode(['code'=>-200,'msg'=>'订单明细不存在']);exit;
		}
		$audit_ret = 0;
		$order_ret = 0;
		if ($audit_status == 2) { //审核通过，关闭订单
			// 处理order_item表
			$audit_data['audit_status'] = $audit_status;
			$audit_data['audit_time'] = time();
			$audit_data['audit_user'] = Yii::$app->session['admin']['adminid'] ? Yii::$app->session['admin']['adminid'] : 0;
			$audit_data['audit_remark'] = $audit_remark;
			$audit_ret = OrderItem::updateAll($audit_data,['item_id'=>$item_id]);
			// 处理order表
			$order_data['Status'] = 6;//审核通过，关闭订单
			$order_data['audit_time'] = time();//审核通过，关闭订单时间
			$order_ret = Order::updateAll($order_data,['Id'=>$model['order_id']]);
		} else if ($audit_status == 3) { //审核不通过，返工重新维修
			// 处理order_item表
			$audit_data['audit_status'] = $audit_status;
			$audit_data['audit_time'] = time();
			$audit_data['audit_user'] = Yii::$app->session['admin']['adminid'] ? Yii::$app->session['admin']['adminid'] : 0;
			$audit_data['audit_remark'] = $audit_remark;
			$audit_ret = OrderItem::updateAll($audit_data,['item_id'=>$item_id]);
			// 处理order表
			$order_data['Status'] = 3;//审核不通过，返工重新维修
			$order_data['audit_time'] = time();////审核不通过，返工重新维修时间
			$order_ret = Order::updateAll($order_data,['Id'=>$model['order_id']]);
		}
		if ($audit_ret && $order_ret) {
			$user = User::find()->where(['id'=>$model['repair_id']])->asArray()->one();
			
			if ($user && $audit_send_msg == "true") {
				//发送短信通知
				// $str = '【爱办APP】尊敬的工程师傅，您的订单号为：'.$model['order_sn'].'，该订单维修上传结果后台已收到，恭喜您的订单已通过审核，您可登录爱办APP查看详情。兴业物联祝您工作愉快！';
				$str = '【爱办APP】尊敬的工程师傅，恭喜您的订单：'.$model['order_sn'].'已通过审核，您可登录爱办APP查看详情。兴业物联祝您工作愉快！';
				if ($audit_status == 3) {
					// $str = '【爱办APP】尊敬的工程师傅，您的订单号为：'.$model['order_sn'].'，该订单维修上传结果后台已收到，非常抱歉您的订单审核未通过，您可登录爱办APP查看详情。兴业物联祝您工作愉快！';
					$str = '【爱办APP】尊敬的工程师傅，非常抱歉您的订单：'.$model['order_sn'].'审核未通过，可登录爱办APP查看详情。兴业物联祝您工作愉快！';
				}
				MessageUtil::send($user['Tell'], $str);	
			}

			//极光推送，向维修师傅推送新订单信息
			$msg = '恭喜您，您的订单已审核通过，点击查看详情';
			$notice_type = 3;
			if ($audit_status == 3) {
				$msg = '非常抱歉，您的订单未通过审核，点击查看详情';
				$notice_type = 4;
			}
			$client = new JPush();
			$client->push()
				->setPlatform(array('ios', 'android'))
				->addAlias('xy'.$model['repair_id'])
				->setNotificationAlert($msg)
				->addAndroidNotification($msg, '订单通知', 1, array('msg_type'=>1,'title'=>'订单通知','content'=>$msg,'time'=>time()))
				->addIosNotification($msg, '订单通知', JPush::DISABLE_BADGE, true, 'iOS category', array('msg_type'=>1,'title'=>'订单通知','content'=>$msg,'time'=>time()))
				->setMessage($msg, '订单通知', 'type', array('msg_type'=>1,'title'=>'订单通知','content'=>$msg,'time'=>time()))
	            ->setOptions(null, null, null, true)
				->send();
			//系统通知
			$noticeM = new Propertynotice();
			$noticeM->addNotice($model['repair_id'],'订单通知',$msg,$notice_type,$model['order_id']);
			
			echo json_encode(['code'=>200,'msg'=>'审核成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'审核失败']);exit;
	}
	
	/**
	 * ajax根据维修区域回去维修类型信息
	 * @Author   tml
	 * @DateTime 2018-07-05
	 * @return   [type]     [description]
	 */
	public function actionAjaxGetOrderType()
	{
		$post = Yii::$app->request->post();
		$pid = empty($post['pid']) ? 0 : $post['pid'];
		$data = [];
		if ($pid) {
			$data = OrderType::find()->where(['parent_id'=>$pid])->asArray()->all();
		}
		echo json_encode(['code'=>200,'msg'=>'sussess','data'=>$data]);exit;
	}
}