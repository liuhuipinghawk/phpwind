<?php 
namespace app\modules\API\controllers;

use Yii;
use yii\web\Controller;
use app\models\Admin\User;
use app\models\Admin\Order;
use app\models\Admin\OrderType;
use app\models\Admin\OrderItem;
use app\models\Admin\LossRegister;
use app\models\Admin\Log;
use app\modules\API\controllers\TmlController;

class RepairController extends Controller{
    public $enableCsrfValidation = false;
	protected $request;
	/**
	 * 初始化
	 **/
	public function init(){
		$this->request = Yii::$app->request;
	}
	/**	
	 * 报检保修列表
	 **/
	public function actionRepairList(){
		$get  = $this->request->get();
		$user_id   = isset($get['userId']) ? $get['userId'] : 0;
		$state     = isset($get['state']) ? $get['state'] : 0;
		$pagenum   = isset($get['pagenum']) ? $get['pagenum'] : 1;
		$psize	   = isset($get['psize']) ? $get['psize'] : 10;
		$tag	   = isset($get['tag']) ? $get['tag'] : 'bx';

		if (!$user_id || !$pagenum || !$psize) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
		}

		$user = User::find()->where(['id'=>$user_id])->asArray()->one();
		if (!$user) {
			echo json_encode(['status'=>-200,'message'=>'用户不存在','code'=>'']);exit;
		}

		$con['o.is_del'] = 0;
		if ($user_id) {
			if ($tag == 'bx') {
				$con['o.UserId'] = $user_id;
			} else if($tag == 'wx') {
				$con['o.repair_id'] = $user_id;
			}
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
			->where($con);
		if ($state && $state != 4) {
			$query = $query->andWhere(['o.Status'=>$state]);
		} else if ($state && $state == 4) {
			$query = $query->andWhere(['in','o.Status',[4,6]]);
		}
		$list = $query->offset(($pagenum-1)*$psize)
			->limit($psize)
			->orderBy('o.OrderTime desc')
			->all();
		if ($list) {
			foreach ($list as $k => $v) {
				$item = OrderItem::find()->where(['order_id'=>$v['order_id']])->orderBy('add_time desc')->asArray()->one();
				$list[$k]['item_id'] = $item ? $item['item_id'] : 0;
				$list[$k]['audit_status'] = $item ? $item['audit_status'] : 0;
				$list[$k]['deal_time'] = empty($v['deal_time']) ? '--' : date('Y-m-d H:i:s',$v['deal_time']);
				$list[$k]['start_time'] = empty($v['start_time']) ? '--' : date('Y-m-d H:i:s',$v['start_time']);
				$list[$k]['complate_time'] = empty($v['complate_time']) ? '--' : date('Y-m-d H:i:s',$v['complate_time']);
				$list[$k]['comment_time'] = empty($v['comment_time']) ? '--' : date('Y-m-d H:i:s',$v['comment_time']);
			}
		}
		echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;
	}

	/**	
	 * 报检保修详情
	 **/
	public function actionRepairDetail(){
		$id = $this->request->get('id',0);
		if (!$id) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
		}
		$data = (new \yii\db\Query())
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
				u.HeaderImg as repair_head,
				u1.HeaderImg as person_head,
				t1.type_name as type_name,
				t2.type_name as area_name
			')
			->from('order o')
			->leftjoin('house h1','o.HouseId=h1.id')
			->leftjoin('house h2','o.SeatId=h2.id')
            ->leftjoin('order_type t1','o.maintenanceType=t1.id')
            ->leftjoin('order_type t2','o.area_id=t2.id')
			->leftjoin('user u','u.id=o.repair_id')
			->leftjoin('user u1','u1.id=o.UserId')
			->where(['o.Id'=>$id])
			->one();
		if ($data) {
			$data['deal_time'] = empty($data['deal_time']) ? '--' : date('Y-m-d H:i:s',$data['deal_time']);
			$data['start_time'] = empty($data['start_time']) ? '--' : date('Y-m-d H:i:s',$data['start_time']);
			$data['complate_time'] = empty($data['complate_time']) ? '--' : date('Y-m-d H:i:s',$data['complate_time']);
			$data['comment_time'] = empty($data['comment_time']) ? '--' : date('Y-m-d H:i:s',$data['comment_time']);
			$repairer_star = Order::find()->select('avg(score)')->where(['Status'=>5,'repair_id'=>$data['repair_id']])->scalar();
			$data['repairer_star'] = empty($repairer_star) ? 5 : round($repairer_star,2);

			$order_item = OrderItem::find()->alias('oi')->select('oi.add_time,oi.complate_time,oi.audit_time,oi.audit_status,oi.audit_remark,u.TrueName as true_name')->leftjoin('user u','oi.repair_id=u.id')->where(['oi.order_id'=>$id])->orderBy('oi.add_time')->asArray()->all();
			$audit = [];
			if ($data['state'] == 1) {
				array_unshift($audit, ['title'=>$data['persion'].'提交报修','time'=>$data['order_time']]);
			} else {
				array_unshift($audit, ['title'=>$data['persion'].'提交报修','time'=>$data['order_time']]);
				array_unshift($audit, ['title'=>'维修派工：'.$data['repair_name'],'time'=>$data['deal_time']]);
			}
			if ($order_item) {
				foreach ($order_item as $k => $v) {
					if ($v['audit_status'] == 0) {
						array_unshift($audit, ['title'=>'维修派工：'.$v['true_name'].'接单','time'=>date('Y-m-d H:i:s',$v['add_time'])]);
					}
					if ($v['audit_status'] == 1) {
						array_unshift($audit, ['title'=>'维修派工：'.$v['true_name'].'接单','time'=>date('Y-m-d H:i:s',$v['add_time'])]);
						array_unshift($audit, ['title'=>'维修审核：后台审核中','time'=>date('Y-m-d H:i:s',$v['complate_time'])]);
					}
					if (in_array($v['audit_status'],[2,3])) {
						array_unshift($audit, ['title'=>'维修派工：'.$v['true_name'].'接单','time'=>date('Y-m-d H:i:s',$v['add_time'])]);
						array_unshift($audit, ['title'=>'维修审核：后台审核中','time'=>date('Y-m-d H:i:s',$v['complate_time'])]);
						if ($v['audit_status'] == 2) {
							array_unshift($audit, ['title'=>'维修结果：审核通过','time'=>date('Y-m-d H:i:s',$v['audit_time'])]);
						}
						if ($v['audit_status'] == 3) {
							array_unshift($audit, ['title'=>'维修结果：审核未通过，原因：'.$v['audit_remark'],'time'=>date('Y-m-d H:i:s',$v['audit_time'])]);
						}
					}
				}
			}			
			if ($data['state'] == 6) {
				array_unshift($audit, ['title'=>'维修完成：等待评价','time'=>date('Y-m-d H:i:s',$data['audit_time'])]);
			} else if ($data['state'] == 5) {
				array_unshift($audit, ['title'=>'维修完成：等待评价','time'=>date('Y-m-d H:i:s',$data['audit_time'])]);
				array_unshift($audit, ['title'=>'评价完成：用户已评价：'.$data['comment'],'time'=>$data['comment_time']]);
			}
			// krsort($audit);
			$data['audit'] = $audit;

			echo json_encode(['status'=>200,'message'=>'success','code'=>$data]);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'报检保修不存在','code'=>'']);exit;
	}

	/**	
	 * 报检保修状态更新
	 **/
	public function actionRepairUpstate(){
		$id    = $this->request->get('id',0);
		$state = $this->request->get('state',0);
		if (!$id || !$state) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
		}

		$model = Order::find()->where(['Id'=>$id])->one();
		if (!$model) {
			echo json_encode(['status'=>-200,'message'=>'报检保修不存在','code'=>'']);exit;
		}
		$res = 0;
		$con['Status'] = $state;
		if ($state == 3) { 
			//接单，往order_item表中插入一条接单明细
			if (!$id || !$model['repair_id']) {
				echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
			}
			$ret = $this->addOrderItem($id,$model['OrderId'],$model['repair_id']);
			if (!$ret) {
				echo json_encode(['status'=>-200,'message'=>'创建接单明细失败','code'=>'']);exit;
			}
			$con['start_time'] = time();
		} else {
//			$this->addLog('报检保修',$id,$state,'repair/repair-upstate');
			echo json_encode(['status'=>-200,'message'=>'操作失败，请将APP更新至最新版','code'=>'']);exit;
		}

		$res = Order::updateAll($con,['Id'=>$id]);
		if ($res) {
			echo json_encode(['status'=>200,'message'=>'操作成功','code'=>'']);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'操作失败','code'=>'']);exit;
	}

	/**
	 * 维修评价
	 **/
	public function actionRepairComment(){
		$id      = $this->request->post('id',0);
		$score   = $this->request->post('score',0);
		$comment = $this->request->post('comment','');
		if (!$id || !$score) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
		}
		if (!in_array($score,array(1,2,3,4,5))) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
		}
		if (mb_strlen($comment,'UTF8') > 200) {
			echo json_encode(['status'=>-200,'message'=>'评价内容不能超过200字符','code'=>'']);exit;
		}

		$con['Status']       = 5; //已评价
		$con['score']        = $score;
		$con['comment']      = $comment;
		$con['comment_time'] = time();

		$res = Order::updateAll($con,['Id'=>$id]);
		if ($res) {
			echo json_encode(['status'=>200,'message'=>'评价成功','code'=>'']);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'评价失败','code'=>'']);exit;
	}

	/**
	 * 遗失登记 tml 20171122
	 **/
	public function actionLossRegister(){
		$session = Yii::$app->session;
		if (empty($session['userinfo']) || $session['userinfo']['expire_time'] < time()) {
			echo json_encode(['status'=>205,'message'=>'用户信息过期，请重新登录获取','code'=>[]]);exit;
		}
		$user_id = $session['userinfo']['userId'];

		$content = empty($this->request->post()['content']) ? '' : $this->request->post()['content'];
		if (empty($content)) {
			echo json_encode(['status'=>-200,'message'=>'请输入遗失登记内容','code'=>[]]);exit;
		}
		$name = empty($this->request->post()['name']) ? '' : $this->request->post()['name'];
		if (empty($name)) {
			echo json_encode(['status'=>-200,'message'=>'请输入遗失人姓名','code'=>[]]);exit;
		}
		$mobile = empty($this->request->post()['mobile']) ? '' : $this->request->post()['mobile'];
		if (empty($mobile)) {
			echo json_encode(['status'=>-200,'message'=>'请输入遗失人联系方式','code'=>[]]);exit;
		}
		if (!preg_match('/^1[3456789]\d{9}$/', $mobile)) {
			echo json_encode(['status'=>-200,'message'=>'手机号不正确','code'=>(object)[]]);exit;
		}
		if (mb_strlen($content,'UTF8') > 200) {
			echo json_encode(['status'=>-200,'message'=>'遗失登记内容不可超过200字符','code'=>[]]);exit;
		}
		$house_id = empty($this->request->post()['house_id']) ? '' : $this->request->post()['house_id'];
		if (empty($house_id)) {
			echo json_encode(['status'=>-200,'message'=>'请选择项目','code'=>[]]);exit;
		}
		$model = new LossRegister();
		$model->content = $content;
		$model->reg_user = $user_id;
		$model->reg_time = time();
		$model->name=$name;
		$model->house_id=$house_id;
		$model->mobile=$mobile;

		$res = $model->save();
		if ($res) {
			echo json_encode(['status'=>200,'message'=>'登记成功','code'=>[]]);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'登记失败','code'=>[]]);exit;
	}

	/**
	 * 报检保修订单统计
	 * @Author   tml
	 * @DateTime 2018-02-08
	 * @return   [type]     [description]
	 */
	public function actionGetOrderCount()
	{
		$get  = $this->request->get();

		$user_id   = isset($get['userId']) ? $get['userId'] : 0;
		$tag	   = isset($get['tag']) ? $get['tag'] : 'bx';
		if (empty($user_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>'']);exit;
		}
		$con = [];
		if ($user_id) {
			if ($tag == 'bx') {
				$con['UserId'] = $user_id;
			} else if($tag == 'wx') {
				$con['repair_id'] = $user_id;
			}
		}

		$res['shz'] = Order::find()->where($con)->andWhere(['Status'=>1])->count();
		$res['ypd'] = Order::find()->where($con)->andWhere(['Status'=>2])->count();
		$res['yjd'] = Order::find()->where($con)->andWhere(['Status'=>3])->count();
		$res['ywc'] = Order::find()->where($con)->andWhere(['Status'=>4])->count();
		$res['ypj'] = Order::find()->where($con)->andWhere(['Status'=>5])->count();

		echo json_encode(['status'=>200,'message'=>'success','code'=>$res]);exit;
	}

	/**
	 * 获取订单类型
	 * @Author   tml
	 * @DateTime 2018-05-07
	 * @return   [type]     [description]
	 */
	public function actionGetOrderType()
	{
		$parent_id = empty($this->request->post()['parent_id']) ? 0 : $this->request->post()['parent_id'];
		$order_type = OrderType::find()->select('id,type_name,remark')->where(['is_del'=>0,'parent_id'=>$parent_id])->orderBy('id')->asArray()->all();
		echo json_encode(['status'=>200,'message'=>'','code'=>$order_type]);exit;
	}

	/**
	 * 接单，往order_item表中插入一条接单明细
	 * @Author   tml
	 * @DateTime 2018-05-11
	 */
	public function addOrderItem($id=0,$order_sn='',$repair_id=0)
	{
		$model = new OrderItem();
		$model->order_id  = $id;
		$model->order_sn  = $order_sn;
		$model->repair_id = $repair_id;
		$model->add_time  = time();
		$ret = $model->save();
		return $ret;
	}

	/**
	 * 维修完成上传图片和文字描述
	 * @Author   tml
	 * @DateTime 2018-05-12
	 * @return   [type]     [description]
	 */
	public function actionComplateUpload()
	{
		$item_id = empty($this->request->post()['item_id']) ? 0 : $this->request->post()['item_id'];
		$complate_img = empty($this->request->post()['complate_img']) ? '' : $this->request->post()['complate_img'];
		$complate_remark = empty($this->request->post()['complate_remark']) ? 0 : $this->request->post()['complate_remark'];
		$tag = empty($this->request->post()['tag']) ? 'first' : $this->request->post()['tag'];
		if (empty($item_id) || !in_array($tag,['first','again'])) {
			echo json_encode(['status'=>-200,'message'=>'订单过期，请联系后台维护人员','code'=>'']);exit;
		}
		if (empty($complate_img)) {
			echo json_encode(['status'=>-200,'message'=>'至少上传一张维修完成图片','code'=>'']);exit;
		}
		$model = OrderItem::findOne($item_id);
		if (!$model) {
			echo json_encode(['status'=>-200,'message'=>'接单明细不存在','code'=>'']);exit;
		}
		$ret = 0;
		if ($tag == 'first') {
			$updata['complate_img']    = $complate_img;
			$updata['complate_remark'] = $complate_remark;
			$updata['complate_time']   = time();
			$updata['audit_status']    = 1;
			$ret = OrderItem::updateAll($updata,['item_id'=>$item_id]);	
		} else if ($tag == 'again') {
			if ($model['audit_status'] != 3) {
				echo json_encode(['status'=>-200,'message'=>'审核状态错误，不可进行提交操作','code'=>'']);exit;
			}
			$item = new OrderItem();
			$item->order_id        = $model['order_id'];
			$item->order_sn        = $model['order_sn'];
			$item->repair_id       = $model['repair_id'];
			$item->add_time        = $model['audit_time'];
			$item->complate_img    = $complate_img;
			$item->complate_remark = $complate_remark;
			$item->complate_time   = time();
			$item->audit_status    = 1;
			$ret = $item->save();
		}
		if ($ret) {
			$data['Status'] = 4;
			$data['complate_time'] = time();
			Order::updateAll($data,['Id'=>$model['order_id']]);
//			$this->addLog('报检保修',$model['order_id'],4,'repair/complate-upload','ret:'.$ret);
			echo json_encode(['status'=>200,'message'=>'提交成功，请耐心等待后台审核','code'=>'']);exit;
		}
//		$this->addLog('报检保修',$model['order_id'],555,'repair/complate-upload','ret:'.$ret);
		echo json_encode(['status'=>-200,'message'=>'提交失败','code'=>'']);exit;
	}

	/**
	 * 添加日志记录
	 * @Author   tml
	 * @DateTime 2018-05-28
	 * @param    [type]     $title  [description]
	 * @param    [type]     $id     [description]
	 * @param    [type]     $status [description]
	 * @param    [type]     $method [description]
	 */
	public function addLog($title='',$id=0,$status=0,$method='',$remark='')
	{
		$model = new Log();
		$model->log_title = $title;
		$model->log_id = $id;
		$model->log_status = $status;
		$model->log_time = time();
		$model->log_method = $method;
		$model->remark = $remark;
		$model->save();
	}
}