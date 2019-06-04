<?php
namespace app\modules\admin\controllers;
use app\models\Admin\Showings;
use app\models\Admin\ShowingsImgs;
use app\models\Admin\House;
use Yii;
use yii\data\Pagination;

/**
 * 3d看房控制器
 */
class ShowingsController extends CommonController
{
	public $enableCsrfValidation = false;
	public $get;
	public $post;
	protected $admin_id;
	/**
	 * 初始化
	 * @Author   tml
	 * @DateTime 2018-03-21
	 * @return   [type]     [description]
	 */
	public function init()
	{
		$this->get      = Yii::$app->request->get();
		$this->post     = Yii::$app->request->post();
		$this->admin_id = Yii::$app->session['admin']['adminid'];
	}

	/**
	 * 3d看房列表
	 * @Author   tml
	 * @DateTime 2018-03-17
	 * @return   [type]     [description]
	 */
	public function actionShowingsList()
	{
		$this->layout = 'layout1';

		$house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
		$type     = empty($this->get['type']) ? 0 : $this->get['type'];
		$room_num = empty($this->get['room_num']) ? 0 : $this->get['room_num'];

		$con['s.is_del'] = 0;
		if (!empty($house_id)) {
			$con['s.house_id'] = $house_id;
		}
		if (!empty($type)) {
			$con['s.type'] = $type;
		}
		if (!empty($room_num)) {
			$con['s.room_num'] = $room_num;
		}

		$query = (new \yii\db\Query())
			->select('s.*,h1.housename as house_name,h2.housename as seat_name')
			->from('3d_showings s')
			->leftJoin('house h1','h1.id=s.house_id')
			->leftJoin('house h2','h2.id=s.seat_id')
			->where($con);

		$count      = $query->count();
		$pagination = new Pagination(['totalCount' => $count]);
		$list       = $query
			->orderBy('s.house_id,s.seat_id,s.room_num')
			->offset($pagination->offset)
    		->limit($pagination->limit)
    		->all();

		$house = House::find()->where(['parentId'=>0])->asArray()->all();
		return $this->render('showings_list',[
			'list'=>$list,
			'pagination'=>$pagination,
			'house'=>$house
		]);
	}

	/**
	 * 添加3d看房
	 * @Author   tml
	 * @DateTime 2018-03-17
	 * @return   [type]     [description]
	 */
	public function actionAddShowings()
	{
		$this->layout = 'layout1';
		$id = empty($this->get['id']) ? 0 : $this->get['id'];
		$model = null;
		$attch = null;
		if (!empty($id)) {
			$model = Showings::find()->where(['id'=>$id])->asArray()->one();
			if ($model && $model['type'] == 4) {
				$attch = ShowingsImgs::find()->where(['show_id'=>$id])->asArray()->all();
			}
		}

		$house = $this->getHouseInfo(0);
		return $this->render('add_showings',[
			'id'=>$id,
			'model'=>$model,
			'attch'=>$attch,
			'house'=>$house
		]);
	}

	/**
	 * 获取楼盘信息
	 * @Author   tml
	 * @DateTime 2018-03-21
	 * @return   [type]     [description]
	 */
	public function actionGetHouseInfo()
	{
		$parent_id = empty($this->post['parent_id']) ? 0 : $this->post['parent_id'];
		$house = $this->getHouseInfo($parent_id);
		echo json_encode(['code'=>200,'data'=>$house]);exit;
	}

	/**
	 * 添加3D看房操作
	 * @Author   tml
	 * @DateTime 2018-03-22
	 * @return   [type]     [description]
	 */
	public function actionDoAddShowings()
	{
		$id        = empty($this->post['id']) ? 0 : $this->post['id'];
		$type      = empty($this->post['type']) ? 0 : $this->post['type'];
		$type_name = empty($this->post['type_name']) ? '' : $this->post['type_name'];
		$house_id  = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
		$address   = empty($this->post['address']) ? '' : $this->post['address'];
		$tag       = empty($this->post['tag']) ? '' : $this->post['tag'];
		$seat_id   = empty($this->post['seat_id']) ? 0 : $this->post['seat_id'];
		$desc      = empty($this->post['desc']) ? '' : $this->post['desc'];
		$room_num  = empty($this->post['room_num']) ? '' : $this->post['room_num'];
		$img_thumb = empty($this->post['img_thumb']) ? '' : $this->post['img_thumb'];
		$img_path  = empty($this->post['img_path']) ? '' : $this->post['img_path'];

		if (empty($type_name)) {
			echo json_encode(['code'=>-200,'msg'=>'请选择类型']);exit;
		}
		if (empty($house_id)) {
			echo json_encode(['code'=>-200,'msg'=>'请选择楼盘']);exit;
		}
		if ($type == 0 && empty($address)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入楼盘地址']);exit;
		}
		if ($type == 0 && empty($tag)) {
			echo json_encode(['code'=>-200,'msg'=>'请勾选楼盘标识']);exit;
		}
		// if ($type != 0 && empty($seat_id)) {
		// 	echo json_encode(['code'=>-200,'msg'=>'请选择楼座']);exit;
		// }
		if (empty($img_thumb)) {
			echo json_encode(['code'=>-200,'msg'=>'请上传缩略图']);exit;
		}
		if ($type != 0 && empty($img_path)) {
			echo json_encode(['code'=>-200,'msg'=>'请上传全景图']);exit;
		}
		if ($type == 4 && empty($room_num)) {
			echo json_encode(['code'=>-200,'msg'=>'请输入房间号']);exit;
		}

		$con['is_del']   = 0;
		$con['house_id'] = $house_id;
		$con['seat_id']  = $seat_id;
		$con['type']     = $type;
		$con['room_num'] = $room_num;

		if (empty($id)) {
			$count = Showings::find()->where($con)->count();
		} else {
			$count = Showings::find()->where($con)->andWhere(['<>','id',$id])->count();
		}
		
		if ($count > 0) {
			echo json_encode(['code'=>-200,'msg'=>'提交记录已存在，不可重复提交']);exit;
		}

		$res = 0;
		if ($id) {
			$updata['type']      = $type;
			$updata['type_name'] = $type_name;
			$updata['house_id']  = $house_id;
			$updata['address']   = $address;
			$updata['tag']       = $tag;
			$updata['seat_id']   = $seat_id;
			$updata['desc']      = $desc;
			$updata['room_num']  = $room_num;
			$updata['img_thumb'] = $img_thumb;
			$updata['img_path']  = $img_path;
			$updata['edit_time'] = time();
			$updata['edit_user'] = $this->admin_id;
			$res = Showings::updateAll($updata,['id'=>$id]);
		} else {
			$model = new Showings();
			$model->type      = $type;
			$model->type_name = $type_name;
			$model->house_id  = $house_id;
			$model->address   = $address;
			$model->tag       = $tag;
			$model->seat_id   = $seat_id;
			$model->desc      = $desc;
			$model->room_num  = $room_num;
			$model->img_thumb = $img_thumb;
			$model->img_path  = $img_path;
			$model->add_time  = time();
			$model->add_user  = $this->admin_id;
			$res = $model->save();
		}
		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'提交成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'提交失败']);exit;
	}

	/**
	 * 3D看房删除操作
	 * @Author   tml
	 * @DateTime 2018-03-23
	 * @return   [type]     [description]
	 */
	public function actionDoDelShowings()
	{
		$id = empty($this->post['id']) ? 0 : $this->post['id'];
		if (empty($id)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$res = Showings::updateAll(['is_del'=>1],['id'=>$id]);
		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'删除成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'删除失败']);exit;
	}

	/**
	 * 3D看房上下架操作
	 * @Author   tml
	 * @DateTime 2018-03-23
	 * @return   [type]     [description]
	 */
	public function actionDoUpstatusShowings()
	{
		$id     = empty($this->post['id']) ? 0 : $this->post['id'];
		$status = empty($this->post['status']) ? 0 : $this->post['status'];
		if (empty($id) || empty($status) || !in_array($status,[1,2])) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$res = Showings::updateAll(['status'=>$status],['id'=>$id]);
		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
	}
}