<?php

namespace app\modules\admin\controllers;

// use app\modules\admin\controllers\CommonController;
use app\models\Admin\OrderRemind;
use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use app\models\Admin\UserAccount;
use app\models\Admin\House;
use app\models\Admin\ElectricOrder;
use app\models\Admin\ThirdAccountBase;
use app\models\Admin\ThirdAccountArea;
use app\models\Admin\ThirdAccountArch;

use app\util\CURLUtils;

/**
 * 生活缴费管理
 */
// class LivingPaymentController extends CommonController{
class LivingPaymentController extends Controller{
	public $enableCsrfValidation = false;
	public $get;
	public $post;
	public $host;

	public function init(){
		$this->get = Yii::$app->request->get();
		$this->post = Yii::$app->request->post();
		$this->host = \Yii::$app->params['third_url'];
	}

	/**
	 * 缴费账户
	 * @Author   tml
	 * @DateTime 2018-01-06
	 * @return   [type]     [description]
	 */
	public function actionUserAccount(){
		$this->layout = 'layout1';

		$house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
		$seat_id  = empty($this->get['seat_id']) ? 0 : $this->get['seat_id'];
		$room_num = empty($this->get['room_num']) ? 0 : $this->get['room_num'];

		$con['is_del'] = 0;
		if (!empty($house_id)) {
			$con['house_id'] = $house_id;
		}
		if (!empty($seat_id)) {
			$con['seat_id'] = $seat_id;
		}
		if (!empty($room_num)) {
			$con['room_num'] = $room_num;
		}
		$session = \Yii::$app->session;
		$list = explode(',',$session['admin']['house_ids']);
		$query = (new \yii\db\Query())
			->select('a.*,h1.housename as house_name,h2.housename as seat_name,u.Tell as mobile,u.TrueName as true_name')
			->from('user_account a')
			->leftJoin('house h1','a.house_id=h1.id')
			->leftJoin('house h2','a.seat_id=h2.id')
			->leftJoin('user u','a.user_id=u.id')
			->where($con)->andWhere(['in','a.house_id',$list]);

		$count = $query->count();

		$pagination = new Pagination(['totalCount'=>$count]);

		$list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('a.house_id,a.seat_id,a.room_num')
            ->all();

        $house = House::find()->where(['parentId'=>0])->asArray()->all();

        return $this->render('user_account',[
        	'list' => $list,
        	'pagination' => $pagination,
        	'house' => $house
        ]);
	}

	/**
	 * ajax根据楼盘Id获取楼座信息
	 * @Author   tml
	 * @DateTime 2018-01-08
	 * @return   [type]     [description]
	 */
	public function actionAjaxGetSeat(){
		$house_id = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
		if (empty($house_id)) {
			echo json_encode(['code'=>200,'data'=>[]]);exit;
		}
		$seat = House::find()->where(['parentId'=>$house_id])->asArray()->all();
		echo json_encode(['code'=>200,'data'=>$seat]);exit;
	}

	/**
	 * ajax删除账户
	 * @Author   tml
	 * @DateTime 2018-01-08
	 * @return   [type]     [description]
	 */
	public function actionAjaxDelAccount(){
		$account_id = empty($this->post['account_id']) ? 0 : $this->post['account_id'];
		if (empty($account_id)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$res = UserAccount::updateAll(['is_del'=>1],['account_id'=>$account_id]);
		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
	}

	/**
	 * 电费预充值订单列表
	 * @Author   tml
	 * @DateTime 2018-01-12
	 * @return   [type]     [description]
	 */
	public function actionElectricOrder(){
		$this->layout = 'layout1';

		$house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
		$seat_id  = empty($this->get['seat_id']) ? 0 : $this->get['seat_id'];
		$room_num = empty($this->get['room_num']) ? 0 : $this->get['room_num'];
		$order_sn = empty($this->get['order_sn']) ? '': $this->get['order_sn'];
		$order_status = empty($this->get['order_status']) ? 0 : $this->get['order_status'];
		$stime = empty($this->get['stime']) ? 0 : strtotime($this->get['stime'] . ' 00:00:00');
		$etime = empty($this->get['etime']) ? 0 : strtotime($this->get['etime'] . ' 23:59:59');
		$pagenum  = empty($this->get['pagenum']) ? 1 : $this->get['pagenum'];

		$con['o.is_del'] = 0;
		if (!empty($house_id)) {
			$con['o.house_id'] = $house_id;
		}
		if (!empty($seat_id)) {
			$con['o.seat_id'] = $seat_id;
		}
		if (!empty($room_num)) {
			$con['o.room_num'] = $room_num; 
		}
		if (!empty($order_status)) {
			$con['o.order_status'] = $order_status;
		}
		$session = \Yii::$app->session;
		$list = explode(',',$session['admin']['house_ids']);
		$query = (new \yii\db\Query())
			->select('o.*,h1.housename as house_name,h2.housename as seat_name,u.Tell as mobile,u.TrueName as true_name,a.adminuser as admin_user')
			->from('electric_order o')
			->leftJoin('house h1','o.house_id=h1.id')
			->leftJoin('house h2','o.seat_id=h2.id')
			->leftJoin('user u','o.user_id=u.id')
			->leftJoin('admin a','o.op_user=a.adminid')
			->where($con)->andWhere(['in','o.house_id',$list]);
		if (!empty($order_sn)) {
			$query = $query->andWhere(['like','o.order_sn',$order_sn]);
		}
		if (!empty($stime) && !empty($etime)) {
			$query = $query->andWhere(['between','o.add_time',$stime,$etime]);
		}
		$count = $query->count();

		$pagination = new Pagination(['totalCount'=>$count]);

		$list = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->orderBy('o.pay_time desc')
			->all();

		// var_dump($list);exit;

		$house = House::find()->where(['parentId'=>0])->asArray()->all();

		return $this->render('electric_order',[
			'list' => $list,
			'pagination' => $pagination,
			'house' => $house
		]);
	}

	/**
	 * ajax删除电费预充值订单
	 * @Author   tml
	 * @DateTime 2018-01-12
	 * @return   [type]     [description]
	 */
	public function actionAjaxDelElectricOrder(){
		$order_id = empty($this->post['order_id']) ? 0 : $this->post['order_id'];
		if (empty($order_id)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$res = ElectricOrder::updateAll(['is_del'=>1],['order_id'=>$order_id]);
		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
	}

	/**
	 * ajax确认送电操作
	 * @Author   tml
	 * @DateTime 2018-01-12
	 * @return   [type]     [description]
	 */
	public function actionAjaxSendElectric(){
		$order_id = empty($this->post['order_id']) ? 0 : $this->post['order_id'];
		if (empty($order_id)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$res = ElectricOrder::updateAll(['order_status'=>3,'send_time'=>time(),'op_user'=>Yii::$app->session['admin']['adminid']],['order_id'=>$order_id]);
		if ($res) {
			OrderRemind::deleteAll(['order_id' => $order_id]);
			echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
	}

	/**
	 * ajax修改缴费通道
	 * @Author   tml
	 * @DateTime 2018-01-18
	 * @return   [type]     [description]
	 */
	public function actionAjaxUpPaymentChannel(){
		$account_id = empty($this->post['account_id']) ? 0 : $this->post['account_id'];
		$is_open    = empty($this->post['tag']) ? 0 : $this->post['tag'];
		if (empty($account_id) || empty($is_open)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$res = UserAccount::updateAll(['is_open'=>$is_open],['account_id'=>$account_id]);
		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
	}

	/**
	 * 第三方基础信息管理
	 * @Author   tml
	 * @DateTime 2018-01-24
	 * @return   [type]     [description]
	 */
	public function actionThirdInfo(){
		$this->layout = 'layout1';
		$house_ids = empty(Yii::$app->session['admin']['house_ids']) ? '0' : Yii::$app->session['admin']['house_ids'];
		// var_dump(explode(',',$house_ids));exit;
		$list = ThirdAccountArea::find()->where(['in','house_id',explode(',',$house_ids)])->asArray()->all();
		foreach ($list as $k => $v) {
			$arch_list = ThirdAccountArch::find()->where(['area_id'=>$v['area_id']])->orderBy('arch_id')->asArray()->all();
			if ($arch_list) {
				foreach ($arch_list as $kk => $vv) {
					$room_list = ThirdAccountBase::find()->where(['area_id'=>$v['area_id'],'arch_id'=>$vv['arch_id']])->orderBy('room_name')->orderBy('room_name')->asArray()->all();
					$floor = ThirdAccountBase::find()->select('distinct(floor)')->where(['area_id'=>$v['area_id'],'arch_id'=>$vv['arch_id']])->orderBy('floor')->column();
					$arch_list[$kk]['room_list'] = $room_list;
					$arch_list[$kk]['floor'] = $floor;
				}
			}
			$list[$k]['arch'] = $arch_list;
		}
		return $this->render('third_info',[
			'list'=>$list
		]);
	}

	/**
	 * 获取第三方区域信息
	 * @Author   tml
	 * @DateTime 2018-01-23
	 * @return   [type]     [description]
	 */
	public function actionGetAreaInfo(){
		$url = $this->host . '/getAreaInfo';		
        $ret = CURLUtils::_request($url,false,'POST');
        $xml = simplexml_load_string($ret);
        $resultInfo = $xml->resultInfo;
        if ($resultInfo->result == 1) { //成功
        	$success = 0;
        	$fail = 0;
        	$data = [];
            $areaInfoList = $xml->areaInfoList;
            foreach ($areaInfoList->areaInfo as $k => $v) {
            	$area_id = (string)$v->AreaID;
            	$area_name = (string)$v->AreaName;
                $info = ThirdAccountArea::find()->where(['area_id'=>$area_id,'area_name'=>$area_name])->one();
                if (empty($info)) {
                	$house_id = House::find()->where(['housename'=>$area_name])->scalar();
                	if (!empty($house_id)) {
                		$model = new ThirdAccountArea();
	                	$model->area_id   = $area_id;
	                	$model->area_name = $area_name;
	                	$model->house_id  = $house_id;
	                	$res = $model->save();
	                	if ($res) {
	                		$success++;
	                	}
                	} else {
                		$fail++;
                		$item['area_name'] = $area_name;
                		$item['error'] = '区域信息在House表中未找到对应信息';
                		$data[] = $item;
                	}
                }
            }
            echo json_encode(['code'=>200,'msg'=>'更新成功，成功：'.$success.'条；失败：'
            	.$fail.'条；','data'=>$data]);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>$resultInfo->msg]);exit;
	}

	/**
	 * 获取建筑信息
	 * @Author   tml
	 * @DateTime 2018-01-15
	 * @return   [type]     [description]
	 */
	public function actionGetArchInfo(){
		$id = empty($this->post['id']) ? 0 : $this->post['id'];
		if (empty($id)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$area = ThirdAccountArea::find()->where(['id'=>$id])->one();
		// var_dump($area);exit;
		if (empty($area)) {
			echo json_encode(['code'=>-200,'msg'=>'区域信息不存在']);exit;
		}
		$url = $this->host . '/getArchitectureInfo';	
		$data = "Area_ID=".$area['area_id'];	
        $ret = CURLUtils::_request($url,false,'POST',$data);
        $xml = simplexml_load_string($ret);
        $resultInfo = $xml->resultInfo;
        if ($resultInfo->result == 1) { //成功
        	$success = 0;
        	$fail = 0;
        	$data = [];
            $architectureInfoList = $xml->architectureInfoList;
            // var_dump($architectureInfoList);exit;
            foreach ($architectureInfoList->architectureInfo as $k => $v) {
            	$arch_id     = (string)$v->ArchitectureID;
            	$arch_name   = (string)$v->ArchitectureName;
            	$arch_storys = (string)$v->ArchitectureStorys;
            	$arch_begin  = (string)$v->ArchitectureBegin;
            	$arch_unit   = (string)$v->ArchitectureUnit;
            	$housename = '';
            	// var_dump($arch_name);exit;
            	if ($area['house_id'] == 50) { //正商经开广场
	            	$archname = $this->cut_str($arch_name,2,0);
	            	// var_dump($archname);
	            	if ($archname == '一栋') {
	            		$housename = '1栋';
	            	} else if ($archname == '二栋') {
	            		$housename = '2栋';
	            	} else if ($archname == '三栋') {
	            		$housename = '3栋';
	            	} else if ($archname == '四栋') {
	            		$housename = '4栋';
	            	} else if ($archname == '五栋') {
	            		$housename = '5栋';
	            	} else if ($archname == '六栋') {
	            		$housename = '6栋';
	            	} else if ($archname == '七栋') {
	            		$housename = '7栋';
	            	} else if ($archname == '八栋') {
	            		$housename = '8栋';
	            	} else if ($archname == '九栋') {
	            		$housename = '9栋';
	            	}
            	}
            	// var_dump($housename);exit;
                $info = ThirdAccountArch::find()->where(['arch_id'=>$arch_id,'arch_name'=>$arch_name])->one();
                if (empty($info)) {                	
                	$seat_id = House::find()->where(['parentId'=>$area['house_id'],'housename'=>$arch_name])->scalar();
                	// var_dump($housename);exit;
                	if ($area['house_id'] == 50) { //正商经开广场
                		$seat_id = House::find()->where(['parentId'=>$area['house_id'],'housename'=>$housename])->scalar();
                	}
                	if (!empty($seat_id)) {
                		$model = new ThirdAccountArch();
	                	$model->area_id   = $area['area_id'];
	                	$model->house_id  = $area['house_id'];
	                	$model->arch_id   = $arch_id;
	                	$model->arch_name = $arch_name;
	                	$model->seat_id   = $seat_id;
	                	$model->arch_storys = $arch_storys;
	                	$model->arch_begin  = $arch_begin;
	                	$model->arch_unit   = $arch_unit;
	                	$res = $model->save();
	                	// var_dump($model->getErrors());exit;
	                	if ($res) {
	                		$success++;
	                	}
                	} else {
                		$fail++;
                		$item['arch_name'] = $arch_name;
                		$item['error'] = '建筑信息在House表中未找到对应信息';
                		$data[] = $item;
                	}
                }
            }
            // exit;
            echo json_encode(['code'=>200,'msg'=>'更新成功，成功：'.$success.'条；失败：'
            	.$fail.'条；','data'=>$data]);exit;
        }
		echo json_encode(['code'=>-200,'msg'=>$resultInfo->msg]);exit;
	}

	/**
	 * 更新房间信息
	 * @Author   tml
	 * @DateTime 2018-01-25
	 * @return   [type]     [description]
	 */
	public function actionGetRoomInfo(){
		$id = empty($this->post['id']) ? 0 : $this->post['id'];
		if (empty($id)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$arch = ThirdAccountArch::find()->where(['id'=>$id])->one();
		if (empty($arch)) {
			echo json_encode(['code'=>-200,'msg'=>'建筑信息不存在']);exit;
		}
		$url = $this->host . '/getRoomInfo';	
		$arch_storys = $arch['arch_storys'];
		$arch_begin  = $arch['arch_begin'];
		$ret_data = [];
		if ($arch_storys) {
			for ($i=$arch_begin; $i <= $arch_storys ; $i++) { 
				$data = 'Architecture_ID='.$arch['arch_id'].'&Floor='.$i;
				$res = $this->getRoomInfo($url,$data,$arch,$i);
				$ret_data[] = $i.'楼:'.$res['msg'].';';
			}
		}
		echo json_encode(['code'=>200,'data'=>$ret_data]);exit;
	}

	/**
	 * 调取第三方房间信息
	 * @Author   tml
	 * @DateTime 2018-01-25
	 * @param    [type]     $url   [description]
	 * @param    [type]     $data  [description]
	 * @param    [type]     $arch  [description]
	 * @param    [type]     $floor [description]
	 * @return   [type]            [description]
	 */
	public function getRoomInfo($url,$data,$arch,$floor){
		$ret = CURLUtils::_request($url,false,'POST',$data);
        $xml = simplexml_load_string($ret);
        $resultInfo = $xml->resultInfo;
        if ($resultInfo->result == 1) { //成功
        	$success = 0;
        	$fail = 0;
        	$data = [];
            $roomInfoList = $xml->roomInfoList;
            foreach ($roomInfoList->roomInfo as $k => $v) {
            	$ammeter_id = (string)$v->AmMeter_ID;
            	$room_name  = (string)$v->RoomName;
                $info = ThirdAccountBase::find()->where(['arch_id'=>$arch['arch_id'],'room_name'=>$room_name])->one();
                if (empty($info)) {
                	$model = new ThirdAccountBase();
                	$model->area_id  = $arch['area_id'];
                	$model->arch_id  = $arch['arch_id'];
                	$model->house_id = $arch['house_id'];
                	$model->seat_id  = $arch['seat_id'];
                	$model->floor    = $floor;
                	$model->room_name  = $room_name;
                	$model->ammeter_id = $ammeter_id;
                	$res = $model->save();
                	if ($res) {
                		$success++;
                	} else {
                		$fail++;
                	}
                }
            }
            return array('code'=>200,'msg'=>'执行成功'.$success.'条，失败'.$fail.'条');
        }
		return array('code'=>-200,'msg'=>$resultInfo->msg);exit;
	}

	/**
	 * 电费订单导出
	 * @Author   tml
	 * @DateTime 2018-07-12
	 * @return   [type]     [description]
	 */
	public function actionAjaxOrderExport()
	{
		$house_id = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
		$seat_id = empty($this->post['seat_id']) ? 0 : $this->post['seat_id'];
		$room_num = empty($this->post['room_num']) ? 0 : $this->post['room_num'];
		$order_sn = empty($this->post['order_sn']) ? 0 : $this->post['order_sn'];
		$order_status = empty($this->post['order_status']) ? 0 : $this->post['order_status'];
		$stime = empty($this->post['stime']) ? 0 : strtotime($this->post['stime'] . ' 00:00:00');
		$etime = empty($this->post['etime']) ? 0 : strtotime($this->post['etime'] . ' 23:59:59');

		$con['o.is_del'] = 0;
		if (!empty($house_id)) {
			$con['o.house_id'] = $house_id;
		}
		if (!empty($seat_id)) {
			$con['o.seat_id'] = $seat_id;
		}
		if (!empty($room_num)) {
			$con['o.room_num'] = $room_num; 
		}
		if (!empty($order_status)) {
			$con['o.order_status'] = $order_status;
		}
		$session = \Yii::$app->session;
		$list = explode(',',$session['admin']['house_ids']);
		$query = (new \yii\db\Query())
			->select('o.*,h1.housename as house_name,h2.housename as seat_name,u.Tell as mobile,u.TrueName as true_name,a.adminuser as admin_user')
			->from('electric_order o')
			->leftJoin('house h1','o.house_id=h1.id')
			->leftJoin('house h2','o.seat_id=h2.id')
			->leftJoin('user u','o.user_id=u.id')
			->leftJoin('admin a','o.op_user=a.adminid')
			->where($con)->andWhere(['in','o.house_id',$list]);
		if (!empty($order_sn)) {
			$query = $query->andWhere(['like','o.order_sn',$order_sn]);
		}
		if (!empty($stime) && !empty($etime)) {
			$query = $query->andWhere(['between','o.add_time',$stime,$etime]);
		}
		$list = $query->orderBy('o.add_time desc')->all();
		if ($list) {
			$this->exportExcel($list,'electric_order_data.xlsx');
			echo json_encode(['code'=>200,'msg'=>'success','path'=>'/web/electric_order_data.xlsx']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'暂无可导出的数据']);exit;
	}

	/**
	 * 导出
	 * @Author   tml
	 * @DateTime 2018-07-12
	 * @param    [type]     $data     [description]
	 * @param    [type]     $filename [description]
	 * @return   [type]               [description]
	 */
	function exportExcel($data,$filename)
	{
		require_once __DIR__ . '/../../../vendor/PHPExcel-1.8/PHPExcel.php';
		require_once __DIR__ . '/../../../vendor/PHPExcel-1.8/PHPExcel/Cell/DataType.php';

		$objPHPExcel = new \PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25); 
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25); 
		//设置excel列名
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','订单编号');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','入户信息');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','充值金额');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','创建时间');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','支付类型');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','支付状态');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','支付时间');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','缴费人');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I1','送电时间');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J1','订单状态');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K1','发票类型');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1','姓名/公司');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M1','手机号/纳税人识别号');

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
	
		//把数据循环写入excel中
		foreach($data as $key => $value){	
			$key+=2;	    
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('A'.$key,$value['order_sn'],\PHPExcel_Cell_DataType::TYPE_STRING);
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$key,$value['house_name'].'-'.$value['seat_name'].'-'.$value['room_num']);
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$key,$value['money']);
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$key,$value['add_time'] ? date('Y-m-d H:i:s',$value['add_time']) : '--');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$key,$value['pay_type'] == 1 ? '微信' : ($value['pay_type'] == 2 ? '支付宝' : '--'));
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$key,$value['pay_status'] == 1 ? '待支付' : ($value['pay_status'] == 2 ? '支付成功' : ($value['pay_status'] == 3 ? '支付失败' : '--')));
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$key,$value['pay_time'] ? date('Y-m-d H:i:s',$value['pay_time']) : '--');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$key,$value['true_name'].'('.$value['mobile'].')');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$key,$value['send_time'] ? date('Y-m-d H:i:s',$value['send_time']) : '--');
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$key,$value['order_status'] == 1 ? '待支付' : ($value['order_status'] == 2 ? '已支付，等待送电' : '充电完成'));
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$key,$value['invoice_type'] == 1 ? '个人' : ($value['invoice_type'] == 2 ? '公司' : '不开发票'));
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$key,$value['invoice_name']);
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('M'.$key,$value['invoice_num']);
		}

		//excel保存在根目录下
		$objPHPExcel->getActiveSheet()->setTitle('electric_order_data');
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save($filename);	
	}

	/*
	Utf-8、gb2312都支持的汉字截取函数
	cut_str(字符串, 截取长度, 开始长度, 编码);
	编码默认为 utf-8
	开始长度默认为 0
	*/
	  
	function cut_str($string, $sublen, $start = 0, $code = 'UTF-8')
	{
		if($code == 'UTF-8')
		{
			$pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
			preg_match_all($pa, $string, $t_string);
	  
			if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen));
			return join('', array_slice($t_string[0], $start, $sublen));
		}
		else
		{
			$start = $start*2;
			$sublen = $sublen*2;
			$strlen = strlen($string);
			$tmpstr = '';
	  
			for($i=0; $i< $strlen; $i++)
			{
				if($i>=$start && $i< ($start+$sublen))
				{
					if(ord(substr($string, $i, 1))>129)
					{
						$tmpstr.= substr($string, $i, 2);
	        		}
	        		else
	        		{
	        			$tmpstr.= substr($string, $i, 1);
	        		}
	      		}
	      		if(ord(substr($string, $i, 1))>129) $i++;
	    	}
	    	if(strlen($tmpstr)< $strlen )
	    		return $tmpstr;
	  	}
	}

}
