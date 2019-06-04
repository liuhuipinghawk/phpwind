<?php
namespace app\modules\admin\controllers;

use yii\web\Controller;
use Yii;
use app\models\Admin\Lottery;
use app\models\Admin\LotteryAward;
use app\models\Admin\LotteryUser;
use app\models\Admin\House;
use yii\data\Pagination;

class LotteryController extends Controller
{
	public $enableCsrfValidation = false;
	protected $get;
	protected $post;
	/**
	 * 初始化
	 * @Author   tml
	 * @DateTime 2018-08-03
	 * @return   [type]     [description]
	 */
	public function init()
	{
		$this->get = Yii::$app->request->get();
		$this->post = Yii::$app->request->post();
	}

	/**
	 * 抽奖
	 * @Author   tml
	 * @DateTime 2018-08-03
	 * @return   [type]     [description]
	 */
	public function actionList()
	{
		$this->layout = "layout1";

		$count = Lottery::find()->where(['is_del'=>0])->orderBy('add_time desc')->count();
		$pagination = new Pagination(['totalCount' => $count]);
		$pagination->setPageSize(10);
		$list = Lottery::find()->where(['is_del'=>0])->orderBy('add_time desc')->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();

		return $this->render('list',[
			'list' => $list,
			'pagination'=>$pagination
		]);		
	}

	/**
	 * 添加页面
	 * @Author   tml
	 * @DateTime 2018-08-04
	 * @return   [type]     [description]
	 */
	public function actionAdd()
	{
		$this->layout = 'layout1';
		$id = empty($this->get['id']) ? 0 : $this->get['id'];
		$model = null;
		if ($id) {
			$model = Lottery::find()->where(['id'=>$id])->one();
		}
		return $this->render('add',[
			'model' => $model
		]);	
	}

	/**
	 * 添加操作
	 * @Author   tml
	 * @DateTime 2018-08-04
	 * @return   [type]     [description]
	 */
	public function actionDoAdd()
	{
		$id = empty($this->post['id']) ? 0 : $this->post['id'];
		$title = empty($this->post['title']) ? '' : $this->post['title'];
		$stime = empty($this->post['stime']) ? 0 : strtotime($this->post['stime']);
		$etime = empty($this->post['etime']) ? 0 : strtotime($this->post['etime']);
		$te = empty($this->post['te']) ? 0 : $this->post['te'];
		$yi = empty($this->post['yi']) ? 0 : $this->post['yi'];
		$er = empty($this->post['er']) ? 0 : $this->post['er'];
		$san = empty($this->post['san']) ? 0 : $this->post['san'];
		$can1 = empty($this->post['can1']) ? 0 : $this->post['can1'];
		$can2 = empty($this->post['can2']) ? 0 : $this->post['can2'];
		$kong = empty($this->post['kong']) ? 0 : $this->post['kong'];
		$time = time();
		if ($stime <= $time) {
			echo json_encode(['code'=>-200,'msg'=>'活动开始时间不可在当前时间之前']);exit;
		}
		if ($etime <= $stime) {
			echo json_encode(['code'=>-200,'msg'=>'活动结束时间不可在开始时间之前']);exit;
		}
		$award = [];
		$award['te'] = $te;
		$award['yi'] = $yi;
		$award['er'] = $er;
		$award['san'] = $san;
		$award['can1'] = $can1;
		$award['can2'] = $can2;
		$award['kong'] = $kong;
		$ser_award = serialize($award);
		if ($id) {
			$data['title'] = $title;
			$data['stime'] = $stime;
			$data['etime'] = $etime;
			$data['edit_time'] = time();
			$data['award'] = $ser_award;
			$data['award_remain'] = $ser_award;
			$ret = Lottery::updateAll($data,['id'=>$id]);
			if ($ret) {
				echo json_encode(['code'=>200,'msg'=>'修改成功']);exit;
			}
			echo json_encode(['code'=>-200,'msg'=>'修改失败']);exit;
		} else {
			$model = new Lottery();
			$model->title = $title;
			$model->stime = $stime;
			$model->etime = $etime;
			$model->add_time = $time;
			$model->award = $ser_award;
			$model->award_remain = $ser_award;
			$ret = $model->save();
			// var_dump($model->getErrors());exit;
			if ($ret) {
				echo json_encode(['code'=>200,'msg'=>'创建活动成功']);exit;
			}
			echo json_encode(['code'=>-200,'msg'=>'创建活动失败']);exit;
		}
	}

	/**
	 * 启用/禁用操作
	 * @Author   tml
	 * @DateTime 2018-08-06
	 * @return   [type]     [description]
	 */
	public function actionDoUpstatus()
	{
		$id = empty($this->post['id']) ? 0 : $this->post['id'];
		$status = empty($this->post['status']) ? 0 : $this->post['status'];
		if (empty($id)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$ret = Lottery::updateAll(['status'=>$status],['id'=>$id]);
		if ($ret) {
			echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
	}

	/**
	 * 删除操作
	 * @Author   tml
	 * @DateTime 2018-08-06
	 * @return   [type]     [description]
	 */
	public function actionDoDel()
	{

		$id = empty($this->post['id']) ? 0 : $this->post['id'];
		if (empty($id)) {
			echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
		}
		$ret = Lottery::updateAll(['is_del'=>1],['id'=>$id]);
		if ($ret) {
			echo json_encode(['code'=>200,'msg'=>'删除成功']);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'删除失败']);exit;
	}

	/**
	 * 中奖纪录
	 * @Author   tml
	 * @DateTime 2018-08-08
	 * @return   [type]     [description]
	 */
	public function actionAwardRecord()
	{
		$this->layout = 'layout1';
		$lottery_id = empty($this->get['id']) ? 0 : $this->get['id'];
		$lottery = [];
		if ($lottery_id) {
			$lottery = Lottery::find()->where(['id'=>$lottery_id])->asArray()->one();
		}
		$aa = (new \yii\db\Query())->select('u.CateId,count(l.id) as nums')->from('lottery_user l')->leftjoin('user u','l.user_id=u.id')->where(['l.lottery_id'=>$lottery_id])->groupBy('u.CateId')->all();
		$nb = 0;
		$pt = 0;
		if ($aa) {
			foreach ($aa as $k => $v) {
				if ($v['CateId'] == 1) {
					$nb = $v['nums'];
				}
				if ($v['CateId'] == 2) {
					$pt = $v['nums'];
				}
			}
		}
		$count = [];
		$count[] = [
			'housename' => '总计',
			'total_user' => $this->getTotalUser($lottery_id,0)."（内部员工：$nb 人，普通用户：$pt 人)",
			'total_nums' => $this->getTotalNums($lottery_id,0),
			'total_award' => $this->getTotalAward($lottery_id,0)
		];
		$c_item = [];
		$house = House::find()->select('id,housename')->where(['parentId'=>0])->asArray()->all();
		foreach ($house as $k => $v) {
			$c_item['housename'] = $v['housename'];
			$c_item['total_user'] = $this->getTotalUser($lottery_id,$v['id']);
			$c_item['total_nums'] = $this->getTotalNums($lottery_id,$v['id']);
			$c_item['total_award'] = $this->getTotalAward($lottery_id,$v['id']);
			$count[] = $c_item;
		}
		$list = [];
		$l_item = [];
		$award = unserialize($lottery['award']);
		$award_remain = unserialize($lottery['award_remain']);
		foreach ($award as $k => $v) {
			$l_item['award_name'] = Yii::$app->params['award'][$k];
			$l_item['init_count'] = $v;
			$l_item['remain_count'] = $award_remain[$k];
			$l_item['award_count'] = $this->getCount($lottery_id,$k);
			$list[] = $l_item;
		}
		$thanks = $this->getCount($lottery_id,'thanks');
		return $this->render('award_record',[
			'lottery' => $lottery,
			'count' => $count,
			'list' => $list,
			'thanks' => $thanks
		]);
	}

	/**
	 * 获取中奖数量
	 * @Author   tml
	 * @DateTime 2018-08-08
	 * @return   [type]     [description]
	 */
	public function getCount($id,$k){
		$count = LotteryAward::find()->where(['lottery_id'=>$id,'award'=>$k])->count();
		return $count;
	}

	/**
	 * 获取参与总人数
	 * @Author   tml
	 * @DateTime 2018-08-08
	 * @return   [type]     [description]
	 */
	public function getTotalUser($id,$house_id)
	{
		$con['lottery_id'] = $id;
		if ($house_id) {
			$con['house_id'] = $house_id;
		}
		$count = LotteryUser::find()->where($con)->count();
		return $count;
	}

	/**
	 * 获取参与抽奖总次数
	 * @Author   tml
	 * @DateTime 2018-08-08
	 * @param    [type]     $id       [description]
	 * @param    [type]     $house_id [description]
	 * @return   [type]               [description]
	 */
	public function getTotalNums($id,$house_id)
	{
		$con['lottery_id'] = $id;
		if ($house_id) {
			$con['house_id'] = $house_id;
		}
		$count = LotteryAward::find()->where($con)->count();
		return $count;
	}

	/**
	 * 获取中奖总数
	 * @Author   tml
	 * @DateTime 2018-08-08
	 * @param    [type]     $id       [description]
	 * @param    [type]     $house_id [description]
	 * @return   [type]               [description]
	 */
	public function getTotalAward($id,$house_id)
	{
		$con['lottery_id'] = $id;
		if ($house_id) {
			$con['house_id'] = $house_id;
		}
		$count = LotteryAward::find()->where($con)->andWhere(['award'=>['te','yi','er','san','can1','can2']])->count();
		return $count;
	}

	/**
	 * 中奖纪录
	 * @Author   tml
	 * @DateTime 2018-08-08
	 * @return   [type]     [description]
	 */
	public function actionRecordList()
	{
		$this->layout = 'layout1';
		$award = Yii::$app->params['award'];
		$id = empty($this->get['id']) ? 0 : $this->get['id'];
		$house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
		$keyword = empty($this->get['award']) ? '' : $this->get['award'];
		$user_type = empty($this->get['user_type']) ? '' : $this->get['user_type'];
		$con['la.lottery_id'] = $id;
		if ($house_id) {
			$con['la.house_id'] = $house_id;
		}
		if ($keyword) {
			$con['la.award'] = $keyword;
		}
		if ($user_type) {
			$con['u.CateId'] = $user_type;
		}
		$query = (new \yii\db\Query())
			->select('la.id,h.housename,u.Tell,u.TrueName,u.CateId,u.Company,la.award_name,la.add_time')
			->from('lottery_award la')
			->leftjoin('house h','h.id=la.house_id')
			->leftjoin('user u','u.id=la.user_id')
			->where($con)
			->orderBy('la.add_time desc');
		$pagination = new Pagination(['totalCount' => $query->count()]);
		$pagination->setPageSize(15);
		$list = $query->offset($pagination->offset)->limit($pagination->limit)->all();
		$house = House::find()->select('id,housename')->where(['parentId'=>0])->asArray()->all();
		return $this->render('record_list',[
			'id' => $id,
			'keyword' => $keyword,
			'award' => $award,
			'user_type' => $user_type,
			'list' => $list,
			'pagination' => $pagination,
			'house' => $house,
			'house_id' => $house_id
		]);
	}
}