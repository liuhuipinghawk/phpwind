<?php
namespace app\modules\API\controllers;

use yii\db\Expression;
use app\models\Admin\Learn;
use app\models\Admin\LearnType;
use app\models\Admin\LearnLike;
use app\models\Admin\LearnComment;

/**
 * 学习园地控制器
 */
class LearnController extends TmlController
{
	/**
	 * 学习园地首页推荐轮播,取最新5条
	 * @Author   tml
	 * @DateTime 2018-11-01
	 * @return   [type]     [description]
	 */
	public function actionRecommend()
	{
		$recommend = Learn::find()->select('id,title,image')->orderBy('status desc,create_time desc')->limit(5)->asArray()->all();
		echo json_encode(['status'=>200,'message'=>'success','code'=>$recommend]);exit;
	}

	/**
	 * 学习园地列表
	 * @Author   tml
	 * @DateTime 2018-11-01
	 * @return   [type]     [description]
	 */
	public function actionLearnList()
	{
		$type = empty($this->post['type']) ? 0 : $this->post['type'];
		$orderby = empty($this->post['orderby']) ? '' : $this->post['orderby'];
		$page = empty($this->post['page']) ? 1 : $this->post['page'];
		$page_size = empty($this->post['page_size']) ? 10 : $this->post['page_size'];
		$con = [];
		if ($type) {
			$con['l.type'] = $type;
		}
		if ($orderby == 'read') { // 阅读量
			$orderby = 'read_num desc';
		} else if ($orderby == 'download') { // 下载量
			$orderby = ' download_num desc';
		} else {
			$orderby = 'create_time desc';
		}
		$list = (new \yii\db\Query())
			->select(new Expression('l.id,l.title,l.image,l.read_num,comment_num,from_unixtime(l.create_time,"%Y-%m-%d %H:%i") as create_time,t.name as type_name'))
			->from('learn l')
			->leftjoin('learn_type t','l.type=t.id')
			->where($con)
			->orderBy($orderby)
			->offset(($page-1)*$page_size)
			->limit($page_size)
			->all();
		if ($list) {
			echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;
		} 
		echo json_encode(['status'=>-200,'message'=>'暂无更多数据','code'=>$list]);exit;
	}

	/**
	 * 获取类型
	 * @Author   tml
	 * @DateTime 2018-11-02
	 * @return   [type]     [description]
	 */
	public function actionGetType()
	{
		$type = LearnType::find()->asArray()->all();
		echo json_encode(['status'=>200,'message'=>'success','code'=>$type]);exit;
	}

	/**
	 * 学习园地详情
	 * @Author   tml
	 * @DateTime 2018-11-01
	 * @return   [type]     [description]
	 */
	public function actionLearn()
	{
		$id = empty($this->post['id']) ? 0 : $this->post['id'];
		$user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
		if (empty($id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>[]]);exit;
		}
		$learn = Learn::find()->where(['id'=>$id])->select(new Expression('id,title,content,image,upload,from_unixtime(create_time,"%Y-%m-%d %H:%i") as create_time,comment_num,download_num,read_num,like_num'))->asArray()->one();
		if ($learn) {
			$learn['is_like'] = LearnLike::find()->where(['learn_id'=>$id,'user_id'=>$user_id])->count();
			$this->addNums($id,'read');
			echo json_encode(['status'=>200,'message'=>'success','code'=>$learn]);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'资料不存在','code'=>[]]);exit;
	}

	/**
	 * 下载量增加
	 * @Author   tml
	 * @DateTime 2018-11-01
	 * @return   [type]     [description]
	 */
	public function actionDoDownload()
	{
		$id = empty($this->post['id']) ? 0 : $this->post['id'];
		if (empty($id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>[]]);exit;
		}
		$ret = $this->addNums($id,'download');
		if ($ret) {
			echo json_encode(['status'=>200,'message'=>'success','code'=>[]]);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'error','code'=>[]]);exit;
	}

	/**
	 * 点赞行为
	 * @Author   tml
	 * @DateTime 2018-11-01
	 * @return   [type]     [description]
	 */
	public function actionDoLike()
	{
		$id = empty($this->post['id']) ? 0 : $this->post['id'];
		$user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
		$type = empty($this->post['type']) ? 1 : $this->post['type']; //1：点赞；2：取消点赞
		if (empty($id) || empty($user_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>[]]);exit;
		}
		$ret = 0;
		if ($type == 1) { //点赞
			$learn_like = LearnLike::find()->where(['learn_id'=>$id,'user_id'=>$user_id])->one();
			if (empty($learn_like)) {
				$model = new LearnLike();
				$model->learn_id = $id;
				$model->user_id = $user_id;
				$model->add_time = time();
				$ret = $model->save();
			}			
		} else if ($type == 2) {
			$ret = LearnLike::deleteAll(['learn_id'=>$id,'user_id'=>$user_id]);
		}		
		if ($ret) {
			$this->addNums($id,'like',$type);
			echo json_encode(['status'=>200,'message'=>'success','code'=>[]]);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'error','code'=>[]]);exit;
	}

	/**
	 * 评论行为
	 * @Author   tml
	 * @DateTime 2018-11-01
	 * @return   [type]     [description]
	 */
	public function actionDoComment()
	{
		$id = empty($this->post['id']) ? 0 : $this->post['id'];
		$user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
		$comment = empty($this->post['comment']) ? 0 : $this->post['comment'];
		if (empty($id) || empty($user_id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>[]]);exit;
		}
		if (strlen($comment) == 0) {
			echo json_encode(['status'=>-200,'message'=>'请输入评论内容','code'=>[]]);exit;
		}
		if (strlen($comment) > 255) {
			echo json_encode(['status'=>-200,'message'=>'评论内容不可超过255字符','code'=>[]]);exit;
		}
		$model = new LearnComment();
		$model->learn_id = $id;
		$model->user_id = $user_id;
		$model->comment = $comment;
		$model->add_time = time();
		$ret = $model->save();
		if ($ret) {
			$this->addNums($id,'comment');
			echo json_encode(['status'=>200,'message'=>'评论成功','code'=>[]]);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'评论失败','code'=>[]]);exit;
	}

	public function actionCommentList()
	{
		$id = empty($this->post['id']) ? 0 : $this->post['id'];
		if (empty($id)) {
			echo json_encode(['status'=>-200,'message'=>'参数错误','code'=>[]]);exit;
		}
		$list = (new \yii\db\Query())
			->select(new Expression('c.comment,from_unixtime(c.add_time,"%Y.%m.%d %H:%i") as add_time,u.HeaderImg as header_img,u.NickName as nick_name'))
			->from('learn_comment c')
			->leftjoin('user u','c.user_id=u.id')
			->orderBy('c.add_time desc')
			->all();
		if ($list) {
			echo json_encode(['status'=>200,'message'=>'success','code'=>$list]);exit;
		}
		echo json_encode(['status'=>-200,'message'=>'暂无评论数据','code'=>$list]);exit;
	}

	/**
	 * 增加次数
	 * @Author   tml
	 * @DateTime 2018-11-01
	 * @param    [type]     $learn_id [description]
	 * @param    [type]     $tag      [description]
	 */
	function addNums($learn_id,$tag,$type=1)
	{
		$data = [];
		if ($tag == 'read') { // 阅读量
			$data['read_num'] = new Expression('read_num+1');
		} else if ($tag == 'download') { // 下载量
			$data['download_num'] = new Expression('download_num+1');
		} else if ($tag == 'like') { // 点赞量
			if ($type == 1) {
				$data['like_num'] = new Expression('like_num+1');
			} else if ($type == 2) {
				$data['like_num'] = new Expression('like_num-1');
			}			
		} else if ($tag == 'comment') { // 评论量
			$data['comment_num'] = new Expression('comment_num+1');
		}
		return Learn::updateAll($data,['id'=>$learn_id]);
	}
}
