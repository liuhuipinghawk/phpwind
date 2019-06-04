<?php 
namespace app\modules\API\controllers;

use Yii;
use app\models\Admin\Region;
use app\models\Admin\HouseImg;
use app\models\Admin\Showings;

/**
 * 房屋租赁
 */
class LeaseController extends TmlController
{
	/**
	 * 获取房屋租赁区域信息
	 * @Author   tml
	 * @DateTime 2018-02-24
	 * @return   [type]     [description]
	 */
	public function actionGetRegion()
	{
		$parent_id = isset($this->post['parent_id']) ? intval($this->post['parent_id']) : '';
		$list = [];
		if ($parent_id === '') { // 获取所有区域信息
			$list = $this->getRegionByPid(0);
			foreach ($list as $k => $v) {
				$list[$k]['child'] = $this->getRegionByPid($v['region_id']);
			}

		} else {
			$list = $this->getRegionByPid($parent_id);
		}
		echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;
	}

	/**
	 * 根据父ID获取区域信息
	 * @Author   tml
	 * @DateTime 2018-02-24
	 * @param    [type]     $parent_id [description]
	 * @return   [type]                [description]
	 */
	public function getRegionByPid($parent_id)
	{
		$list = Region::find()->where(['parent_id' => $parent_id])->asArray()->all();
		return $list;
	}

	/**
	 * 招商租赁列表
	 * @Author   tml
	 * @DateTime 2018-02-24
	 * @return   [type]     [description]
	 */
	public function actionLeaseList()
	{
		$pagenum = empty($this->post['pagenum']) ? 1 : $this->post['pagenum'];
		$pagesize = empty($this->post['pagesize']) ? Yii::$app->params['APP_PAGE_SIZE'] : $this->post['pagesize'];
		$region_id = empty($this->post['region_id']) ? 0 : $this->post['region_id'];
		$house_type = empty($this->post['house_type']) ? 0 : $this->post['house_type'];
		$price = empty($this->post['price']) ? '' : $this->post['price'];
		$space = empty($this->post['space']) ? '' : $this->post['space'];
		$age = empty($this->post['age']) ? '' : $this->post['age'];

		$where = 'p.status=1 and p.is_del=0';
		//区域筛选
		if (!empty($region_id)) {
			$where .= ' and p.region_id='.$region_id;
		}
		//房源类型筛选
		if (!empty($house_type)) {
			$where .= ' and p.house_type='.$house_type;
			//价格区间筛选
			if (!empty($price)) {
				$price_arr = explode('-',$price);
				if (count($price_arr) == 2) {
					$where .= ' and p.price>='.$price_arr[0].' and p.price<='.$price_arr[1];
				}
			}
		}
		//面积筛选
		if (!empty($space)) {
			$space_arr = explode('-',$space);
			if (count($space_arr) == 2) {
				$where .= ' and p.space>='.$space_arr[0].' and p.space<='.$space_arr[1];
			}
		}
		//房龄筛选
		if (!empty($age)) {
			$age_arr = explode('-',$age);
			$year = date('Y',time());
			if (count($age_arr) == 2) {
				$where .= ' and ('.$year.'-p.age)>='.$age_arr[0].' and ('.$year.'-p.age)<='.$age_arr[1];
			}
		}

		$sql = 'select p.*,h.housename as house_name,s.subway_name as station_name,s1.subway_name,d.deco_name,o.orien_name'
		 . ' from house_publish p'
		 . ' left join house h on p.house_id=h.id'
		 . ' left join app_subway s on p.subway_id=s.subway_id'
		 . ' left join app_subway s1 on s.parent_id=s1.subway_id'
		 . ' left join house_decoration d on p.deco_id=d.deco_id'
		 . ' left join house_orientation o on p.orien_id=o.orien_id'
		 . ' where ' . $where
		 . ' order by p.publish_time desc'
		 . ' limit ' . ($pagenum-1)*$pagesize . ',' . $pagesize;
		$list = Yii::$app->db->createCommand($sql)->queryAll();
		if (!empty($list)) {
			foreach ($list as $k => $v) {
				$list[$k]['imgs'] = HouseImg::find()->where(['publish_id'=>$v['publish_id']])->asArray()->all();
			}
		}
		echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;
	}

	/**
	 * 房屋租赁详情
	 * @Author   tml
	 * @DateTime 2018-02-26
	 * @return   [type]     [description]
	 */
	public function actionLeaseDetail()
	{
		$publish_id = empty($this->post['publish_id']) ? 0 : $this->post['publish_id'];
		if (empty($publish_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>(object)[]]);exit;
		}
		$where = 'p.status=1 and p.is_del=0 and p.publish_id='.$publish_id;
		$sql = 'select p.*,h.housename as house_name,s.subway_name as station_name,s1.subway_name,d.deco_name,o.orien_name'
		 . ' from house_publish p'
		 . ' left join house h on p.house_id=h.id'
		 . ' left join app_subway s on p.subway_id=s.subway_id'
		 . ' left join app_subway s1 on s.parent_id=s1.subway_id'
		 . ' left join house_decoration d on p.deco_id=d.deco_id'
		 . ' left join house_orientation o on p.orien_id=o.orien_id'
		 . ' where ' . $where;
		$res = Yii::$app->db->createCommand($sql)->queryOne();
		if ($res) {
			$res['imgs'] = HouseImg::find()->where(['publish_id'=>$publish_id])->asArray()->all();
			$res['house_desc'] = htmlspecialchars_decode($res['house_desc']);
			echo json_encode(['status'=>200,'message'=>'success','code'=>$res]);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'房源信息不存在','code'=>(object)[]]);exit;
	}

	/**
	 * 3D看房列表页
	 * @Author   tml
	 * @DateTime 2018-03-24
	 * @return   [type]     [description]
	 */
	public function actionShowingsList()
	{
		$house_name = empty($this->post['house_name']) ? '' : $this->post['house_name'];

		$con['s.is_del'] = 0;
		$con['s.status'] = 1;
		$con['s.type'] = 0;
		$query = (new \yii\db\Query())
			->select('s.house_id,s.address,s.tag,s.img_thumb,h.housename as house_name')
			->from('3d_showings s')
			->leftJoin('house h','s.house_id=h.id')
			->where($con);
		if (!empty($house_name)) {
			$query = $query->andWhere(['like','h.housename',$house_name]);
		}
		$list = $query->orderBy('s.house_id')->all();
		echo str_replace('\/', '/', json_encode(['status'=>200,'message'=>'success','code'=>$list]));exit;
	}

	/**
	 * 3D看房详情页面
	 * @Author   tml
	 * @DateTime 2018-03-24
	 * @return   [type]     [description]
	 */
	public function actionShowings()
	{
		$house_id = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
		if (empty($house_id)) {
			echo json_encode(['status'=>-200,'message'=>'请选择楼盘','code'=>[]]);exit;
		}
		$list = (new \yii\db\Query())
			->select('type,type_name,img_thumb,img_path')
			->from('3d_showings')
			->where(['is_del'=>0,'status'=>1,'house_id'=>$house_id])
			->andWhere(['<>','type',0])
			->groupBy('type')
			->orderBy('type')
			->all();
		foreach ($list as $k => $v) {
			if ($v['type'] == 4) {
				$list[$k]['rooms'] = Showings::find()->select('id,room_num,img_thumb,img_path')->where(['is_del'=>0,'status'=>1,'house_id'=>$house_id,'type'=>4])->orderBy('room_num')->asArray()->all();
			}
		}
		echo str_replace('\/', '/', json_encode(['status'=>200,'message'=>'success','code'=>$list]));exit;
	}
}
