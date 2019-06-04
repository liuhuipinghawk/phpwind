<?php
namespace app\modules\API\controllers;

use yii\web\Controller;
use Yii;
use app\models\Admin\User;
use app\models\Admin\Lottery;
use app\models\Admin\LotteryUser;
use app\models\Admin\LotteryAward;
use app\vendor\JPush\JPush;

class LotteryController extends Controller
{
	public $enableCsrfValidation = false;
	protected $post;
	/**
	 * 初始化
	 * @Author   tml
	 * @DateTime 2018-08-03
	 * @return   [type]     [description]
	 */
	public function init()
	{
		$this->post = Yii::$app->request->post();
	}

	/**
	 * 抽奖页面初始接口
	 * @Author   tml
	 * @DateTime 2018-08-06
	 * @return   [type]     [description]
	 */
	public function actionIndex()
	{
		$user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
		$house_id = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
		if (empty($user_id) || empty($house_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误']);exit;
		}
		// 1.判断用户是否实名认证
		$user = User::find()->where(['id'=>$user_id])->one();
		if ($user && $user['Status'] == 3) {
			$lottery = $this->getCurrentLottery();
			if ($lottery) {
				$lottery_user = LotteryUser::find()->where(['user_id'=>$user_id,'lottery_id'=>$lottery['id']])->one();
				$nums = 0;
				if (empty($lottery_user)) {
					$model = new LotteryUser();
					$model->user_id = $user_id;
					$model->house_id = $house_id;
					$model->lottery_id = $lottery['id'];
					$model->nums = 3;
					$model->add_time = time();
					$ret = $model->save();	
					if ($ret) {
						$nums = 3;
					}			
				} else {
					$nums = $lottery_user['nums'];
				}
				echo json_encode(['status'=>200,'code'=>['lottery_id'=>$lottery['id'],'nums'=>$nums]]);exit;
			}
			echo json_encode(['status'=>-200,'message'=>'暂无抽奖活动，请关注最新活动动态']);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'抱歉，请先进行实名认证，审核通过，才可以参与抽奖活动']);exit;
	}

	/**
	 * 抽奖
	 * @Author   tml
	 * @DateTime 2018-08-03
	 * @return   [type]     [description]
	 */
	public function actionLottery()
	{
		$user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
		$house_id = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
		$lottery_id = empty($this->post['lottery_id']) ? 0 : $this->post['lottery_id'];
		if (empty($user_id) || empty($house_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误']);exit;
		}
		// 1.判断用户是否实名认证
		$user = User::find()->where(['id'=>$user_id])->one();
		if (!$user || $user['Status'] != 3) {
			echo json_encode(['status'=>-200,'message'=>'抱歉，请先进行实名认证，审核通过，才可以参与抽奖活动']);exit;
		}
		// 2.获取当前抽奖活动，并判断活动状态
		$lottery = $this->getCurrentLottery();
		if (empty($lottery)) {
			echo json_encode(['status'=>-200,'message'=>'暂无抽奖活动，请关注最新活动动态']);exit;
		}
		if ($lottery && $lottery['id'] != $lottery_id) {
			echo json_encode(['status'=>-200,'message'=>'当前活动信息已失效，请退出重新进入活动页面']);exit;
		}
		$time = time();
		if ($lottery && $lottery['stime'] > $time) {
			echo json_encode(['status'=>-200,'message'=>'本期活动即将开始，请耐心等待...']);exit;
		}
		if ($lottery && $lottery['etime'] < $time) {
			// $next_lottery = Lottery::find()->where(['is_del'=>0,'status'=>1])->andWhere(['>','stime',$time])->orderBy('stime asc')->asArray()->one();
			// if ($next_lottery) {
			// 	$stime = $next_lottery['stime'];
			// 	echo json_encode(['status'=>-200,'message'=>'本期活动已结束，下期活动时间为：'.date('Y-m-d H:i',$stime).'，敬请关注...']);exit;
			// }
			echo json_encode(['status'=>-200,'message'=>'本期活动已结束，下期活动敬请期待...']);exit;
		}
		// 3.判断用户剩余抽奖次数
		$lottery_user = LotteryUser::find()->where(['user_id'=>$user_id,'lottery_id'=>$lottery['id']])->one();
		if ($lottery_user && $lottery_user['nums'] > 0) {
			$nums = $lottery_user['nums'] - 1;
			$ret = LotteryUser::updateAll(['nums'=>$nums],['id'=>$lottery_user['id']]);
			if ($ret) {
				$this->luckDraw($user_id,$house_id,$lottery_id);
			}
		}
		echo json_encode(['status'=>-200,'message'=>'本期抽奖次数已用完']);exit;
	}

	/**
	 * 出奖
	 * @Author   tml
	 * @DateTime 2018-08-04
	 * @return   [type]     [description]
	 */
	public function luckDraw($user_id,$house_id,$lottery_id)
	{
		$lottery = Lottery::find()->where(['id'=>$lottery_id])->one();
		if (empty($lottery)) {
			echo json_encode(['status'=>-200,'message'=>'活动不存在']);exit;
		}
		$award = 'thanks';
		$lottery_award = LotteryAward::find()->where(['user_id'=>$user_id,'lottery_id'=>$lottery_id])->andWhere(['award'=>['te','yi','er','san','can1','can2']])->one();
		if (empty($lottery_award)) {
			$award_remain = unserialize($lottery['award_remain']);
			$arr = [];
			foreach ($award_remain as $k => $v) {
				for ($i=0; $i < $v; $i++) { 
					array_push($arr, $k);
				}
			}
			shuffle($arr);
			if ($arr) {
				$award = $arr[array_rand($arr,1)];
				switch ($award) {
					case 'te':
						$award_remain['te'] = $award_remain['te'] - 1;
						break;
					case 'yi':
						$award_remain['yi'] = $award_remain['yi'] - 1;
						break;
					case 'er':
						$award_remain['er'] = $award_remain['er'] - 1;
						break;
					case 'san':
						$award_remain['san'] = $award_remain['san'] - 1;
						break;
					case 'can1':
						$award_remain['can1'] = $award_remain['can1'] - 1;
						break;
					case 'can2':
						$award_remain['can2'] = $award_remain['can2'] - 1;
						break;
					case 'kong':
						$award_remain['kong'] = $award_remain['kong'] - 1;
						break;
				}
				// 更新奖品剩余数量
				Lottery::updateAll(['award_remain'=>serialize($award_remain)],['id'=>$lottery_id]);
			}
		}
		// 获奖记录入库
		$award_name = Yii::$app->params['award'][$award];
		$model = new LotteryAward();
		$model->lottery_id = $lottery_id;
		$model->user_id = $user_id;
		$model->house_id = $house_id;
		$model->award = $award;
		$model->award_name = $award_name;
		$model->add_time = time();
		$model->save();

		if (in_array($award,['te','yi','er','san','can1','can2'])) {
			$user = User::find()->where(['id'=>$user_id])->one();
			// 极光推送,推送中奖纪录
			$client = new JPush();
			$client->push()
				->setPlatform('all')
				->addAllAudience()
				->setMessage('恭喜您，中奖啦', '获奖通知', 'type', array('mobile'=>$user['Tell'],'award_name'=>$award_name,'time'=>time()))
				->send();
		}
		echo json_encode(['status'=>200,'code'=>['award'=>$award,'award_name'=>$award_name]]);exit;
		
	}

	/**
	 * 获取当前活动
	 * @Author   tml
	 * @DateTime 2018-08-06
	 * @return   [type]     [description]
	 */
	public function getCurrentLottery($flag = false)
	{
		$list = Lottery::find()->where(['is_del'=>0,'status'=>1])->orderBy('stime asc')->asArray()->all();
		$time = time();
		$lottery_id = 0;
		if ($list) {
			foreach ($list as $k => $v) {
				if ($v['stime'] <= $time && $v['etime'] >= $time) {
					$lottery_id = $v['id'];
					break;
				} else if ($v['stime'] >= $time) {
					if ($k == 0) {
						$lottery_id = $v['id'];
						break;
					} else {
						$lottery_id = $list[$k-1]['id'];
						break;
					}
				} else {
					$lottery_id = $v['id'];
				}
			}
		}
		if ($flag == true) {
			return $lottery_id;
		}
		$lottery = Lottery::find()->where(['id'=>$lottery_id])->one();
		return $lottery;
	}

	/**
	 * 中奖纪录
	 * @Author   tml
	 * @DateTime 2018-08-06
	 * @return   [type]     [description]
	 */
	public function actionAwardRecord()
	{
		$lottery_id = $this->getCurrentLottery(true);

		$list = (new \yii\db\Query())
			->select('l.award_name,l.add_time,h.housename as house_name,u.Tell as mobile,u.NickName as nick_name,u.TrueName as true_name,u.Company as company')
			->from('lottery_award l')
			->leftjoin('house h','l.house_id=h.id')
			->leftjoin('user u','l.user_id=u.id')
			->where(['lottery_id'=>$lottery_id])
			->andWhere(['award' => ['te', 'yi', 'er', 'san', 'can1', 'can2']])
			->orderBy('l.add_time desc')
			->all();
		echo json_encode(['status'=>200,'code'=>$list]);exit;
	}

	/**
	 * 我的奖品
	 * @Author   tml
	 * @DateTime 2018-08-07
	 * @return   [type]     [description]
	 */
	public function actionMyAward()
	{
		$user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
		if (empty($user_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误']);exit;
		}
		$list = (new \yii\db\Query())
			->select('l.title,la.award,la.award_name,la.add_time,h.housename as house_name')
			->from('lottery_award la')
			->leftjoin('house h','la.house_id=h.id')
			->leftjoin('lottery l','la.lottery_id=l.id')
			->where(['la.user_id'=>$user_id])
			->andWhere(['la.award' => ['te', 'yi', 'er', 'san', 'can1', 'can2']])
			->orderBy('la.add_time desc')
			->all();
		if ($list) {
			foreach ($list as $k => $v) {
				$life_time = strtotime(date('Y-m-d',$v['add_time'])) + 60*60*24*6 + 60*60*18;
				$list[$k]['add_time'] = $life_time;
			}
		}
		echo json_encode(['status'=>200,'code'=>$list]);exit;
	}
}