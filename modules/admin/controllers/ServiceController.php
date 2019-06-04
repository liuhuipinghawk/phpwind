<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use app\models\Admin\CarportOrder;
use app\models\Admin\ServiceOrder;
use app\models\Admin\House;
use app\models\Admin\O2oHouseEntrustment;
use yii\data\Pagination;

class ServiceController extends CommonController{
	public $enableCsrfValidation = false;

	protected $get;
	protected $post;

	public function init(){
		$this->get  = Yii::$app->request->get();
		$this->post = Yii::$app->request->post();
	}
	
	/**
	 * 车位租赁订单预约 tml 20171124
	 **/
	public function actionCarport(){
		$this->layout = 'layout1';

        $person_name = empty(Yii::$app->request->get()['person_name']) ? '' : Yii::$app->request->get()['person_name'];
        $person_tel = empty(Yii::$app->request->get()['person_tel']) ? '' : Yii::$app->request->get()['person_tel'];
        $state      = empty(Yii::$app->request->get()['state']) ? 0 : Yii::$app->request->get()['state'];

		$query = (new \yii\db\Query())
			->select('c.*,h.housename as house_name,h1.housename as seat_name')
			->from('carport_order c')
			->leftjoin('house h','h.id=c.house_id')
			->leftjoin('house h1','h1.id=c.seat_id')
			->where(['is_del'=>0]);
		if(!empty($person_name)){
		    $query = $query->andWhere(['like','person_name',$person_name]);
        }
        if(!empty($person_tel)){
		    $query = $query->andWhere(['like','person_tel',$person_tel]);
        }
        if(!empty($state)){
            $query = $query->andWhere(['state'=>$state]);
        }

		$count = $query->count();

		$pagination = new Pagination(['totalCount'=>$count]);
		$pagination->setPageSize(10);

		$list = $query
			->orderBy('c.order_id desc')
			->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		return $this->render('carport',[
			'list'=>$list,
			'pagination'=>$pagination
		]);
	}

	/**
	 * 更新租赁订单预约状态 tml 20171124
	 **/
	public function actionAjaxUpstateCarport(){
		$order_id = empty($this->post['order_id']) ? 0 : $this->post['order_id'];
		$state    = empty($this->post['state']) ? 0 : $this->post['state'];
		if (empty($order_id) || empty($state)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$res = CarportOrder::updateAll(['state'=>$state],['order_id'=>$order_id]);
		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
	}

	/**
	 * 生活服务预约订单 tml 20171125
	 **/
	public function actionServiceOrder(){
		$this->layout = 'layout1';

		$person_name = empty($this->get['person_name']) ? '' : $this->get['person_name'];
		$person_tel  = empty($this->get['person_tel']) ? '' : $this->get['person_tel'];
		$order_type  = empty($this->get['order_type']) ? '' : $this->get['order_type'];
		$state       = empty($this->get['state']) ? '' : $this->get['state'];

		$con['is_del'] = 0;
		if (!empty($order_type)) {
			$con['order_type'] = $order_type;
		}
		if (!empty($state)) {
			$con['state'] = $state;
		}

		$query = (new \yii\db\Query())
			->select('*')
			->from('service_order')
			->where($con);
		if (!empty($person_name)) {
			$query = $query->
				andWhere(['like','person_name',$person_name]);
		}
		if (!empty($person_tel)) {
			$query = $query->
				andWhere(['like','person_tel',$person_tel]);
		}
		// var_dump($query->createCommand()->getRawSql());exit;

		$count = $query->count();

		$pagination = new Pagination(['totalCount'=>$count]);
		$pagination->setPageSize(10);

		$list = $query
			->orderBy('order_id desc')
			->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		return $this->render('service_order',[
			'list'=>$list,
			'pagination'=>$pagination
		]);
	}

	/**
	 * 更新生活服务订单预约状态 tml 20171125
	 **/
	public function actionAjaxUpstateServiceOrder(){
		$order_id = empty($this->post['order_id']) ? 0 : $this->post['order_id'];
		$state    = empty($this->post['state']) ? 0 : $this->post['state'];
		if (empty($order_id) || empty($state)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$res = ServiceOrder::updateAll(['state'=>$state],['order_id'=>$order_id]);
		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
	}

	/**
	 * 房屋委托
	 * @Author   tml
	 * @DateTime 2018-02-13
	 * @return   [type]     [description]
	 */
	public function actionHouseEntrustment()
	{
		$this->layout = 'layout1';

		$house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
		$house_type = empty($this->get['house_type']) ? 0 : $this->get['house_type'];
		$person_name = empty($this->get['person_name']) ? 0 : $this->get['person_name'];
		$person_tel = empty($this->get['person_tel']) ? 0 : $this->get['person_tel'];
		$status = empty($this->get['status']) ? 0 : $this->get['status'];

		$con['o.is_del'] = 0;
		$con1 = [];
		if (!empty($house_id)) {
			$con['o.house_id'] = $house_id;
		}
		if (!empty($house_type)) {
			$con['o.house_type'] = $house_type;
		}
		if (!empty($status)) {
			$con['o.status'] = $status;
		}

		$query = (new \yii\db\Query())
			->select('o.*,u.TrueName as true_name,u.Tell as mobile,h.housename as house_name,a.adminuser as admin_name')
			->from('o2o_house_entrustment o')
			->leftjoin('user u','o.user_id=u.id')
			->leftjoin('house h','o.house_id=h.id')
			->leftjoin('admin a','o.deal_user=a.adminid')
			->where($con);		
		if (!empty($person_name)) {
			$query = $query->andWhere(['like','o.person_name',$person_name]);
		}
		if (!empty($person_tel)) {
			$query = $query->andWhere(['like','o.person_tel',$person_tel]);
		}

		$count = $query->count();

		$pagination = new Pagination(['totalCount'=>$count]);

		$list = $query
			->orderBy('o.id desc')
			->offset($pagination->offset)
			->limit($pagination->limit)
			->all();

		$pagination->setPageSize(10);

		$house = House::find()->where(['parentId'=>0])->orderBy('id')->asArray()->all();

		return $this->render('house_entrustment',[
			'list'=>$list,
			'pagination'=>$pagination,
			'house'=>$house
		]);
	}

	/**
	 * 更新房屋委托订单状态
	 * @Author   tml
	 * @DateTime 2018-02-14
	 * @return   [type]     [description]
	 */
	public function actionAjaxUpstateHouseEntrustment()
	{
		$id = empty($this->post['id']) ? 0 : $this->post['id'];
		$status = empty($this->post['status']) ? 0 : $this->post['status'];
		if (empty($id) || empty($status)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$updata['status'] = $status;
		$updata['deal_user'] = Yii::$app->session->get('admin')['adminid'];
		$updata['deal_time'] = time();		
		$res = O2oHouseEntrustment::updateAll($updata ,['id'=>$id]);
		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
	}

	/**
	 * 房屋委托ajax执行删除操作
	 * @Author   tml
	 * @DateTime 2018-02-14
	 * @return   [type]     [description]
	 */
	public function actionAjaxDeleteHouseEntrustment()
	{
		$id = empty($this->post['id']) ? 0 : $this->post['id'];
		if (empty($id)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$res = O2oHouseEntrustment::updateAll(['is_del'=>1],['id'=>$id]);
		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
	}
}