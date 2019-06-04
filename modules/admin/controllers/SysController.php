<?php
namespace app\modules\admin\controllers;

use app\API\models\Propertynotice;
use app\models\Admin\Certification;
use app\models\Admin\House;
use app\models\Admin\User;
use app\models\Admin\Admin;
use app\models\Admin\UserPosition;
use app\models\Admin\UserPost;
use Yii;
use yii\data\Pagination;
use app\models\Admin\UserBase;
use app\vendor\JPush\JPush;
use app\models\Admin\AccountBase;
use app\models\Admin\PriceTag;


class SysController extends CommonController {

    protected $post;
	protected $get;
    public $enableCsrfValidation = false;
	public function init(){
        $this->post = Yii::$app->request->post();
		$this->get = Yii::$app->request->get();
	}

    /**
     * Displays a single UserPost model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = 'layout1';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     *
     * @param $pid
     * @param int $typeid
     */
    public function actionSite(){
        $model = new UserBase();
        if(Yii::$app->request->isAjax){
            $pid = Yii::$app->request->get('house_id');
            $model = $model->getHouseList($pid);
            if($model){
                echo json_encode(array('code'=>$model,'status'=>200,'message'=>'加载成功!'));
            }else{
                echo json_encode(array('code'=>[],'status'=>-200,'message'=>'加载失败!'));
            }
        }
    }

    /**
     * Creates a new UserPost model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'layout1';
        $model = new UserBase();    
        //用户类型
        $user_type = array(array('id'=>1,'type_name'=>'内部员工'),array('id'=>2,'type_name'=>'普通用户'));
        $house = House::find()->where(array('parentId'=>0))->asArray()->all();
        //职位
        $position = UserPosition::find()->asArray()->all();
        //岗位
        $posts = UserPost::find()->asArray()->all();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model->user_type = $post['UserBase']['user_type'];
            $model->true_name = $post['UserBase']['true_name'];
            $model->mobile = $post['UserBase']['mobile'];
            $model->company = $post['UserBase']['company'];
            $model->house_id = $post['UserBase']['house_id'];
            $house_name = House::find()->where(array('id'=>$post['UserBase']['house_id']))->asArray()->one();
            $model->house_name =$house_name['housename'];
            $model->seat_id = $post['UserBase']['seat_id'];
            $seat_name = House::find()->where(array('id'=>$post['UserBase']['seat_id']))->asArray()->one();
            $model->seat_name = $seat_name['housename'];
            $model->room_num = $post['UserBase']['room_num'];
            $model->address = $post['UserBase']['address'];
            if($model->load($model) || $model->validate()){
                if($model->save(false)){
                    $user = UserBase::find()->orderBy('id desc')->asArray()->one();
                    $where['TrueName'] = $user['true_name'];
                    $where['Tell'] = $user['mobile'];
                    $list = User::find()->where($where)->asArray()->one();
                    if(!empty($list)){
                        User::updateAll(array('Status'=>3,'Position'=>$post['UserBase']['position'],'PostId'=>$post['UserBase']['posts']),array('TrueName'=>$user['true_name'],'Tell'=>$user['mobile']));
                        $cerfication = new Certification();
                        $cerfication->UserId = $list['id'];
                        $cerfication->HouseId =$post['UserBase']['house_id'];
                        $cerfication->SeatId = $post['UserBase']['seat_id'];
                        $cerfication->Address =$post['UserBase']['room_num'];
                        $cerfication->Company =$post['UserBase']['company'];
                        $cerfication->CreateTime = date("Y-m-d H:i:s", time());
                        $cerfication->Status = 3;
                        $cerfication->CateId = $post['UserBase']['user_type'];
                        $cerfication->save();
                        //极光推送，向维修师傅推送新订单信息
                        $client = new JPush();
                        $client->push()
                            ->setPlatform(array('ios', 'android'))
                            ->addAlias('xy'.$list['id'])
                            ->setNotificationAlert('实名认证信息成功!')
                            ->addAndroidNotification('实名认证信息成功', '实名认证信息通知', 1, array('msg_type'=>2,'title'=>'实名认证信息通知','content'=>'实名认证信息成功','time'=>time()))
                            ->addIosNotification('实名认证信息成功', '实名认证信息通知', JPush::DISABLE_BADGE,true, 'iOS category', array('msg_type'=>2,'title'=>'实名认证信息通知','content'=>'实名认证信息成功','time'=>time()))
                            ->setMessage('实名认证信息成功', '实名认证信息通知', 'type', array('msg_type'=>2,'title'=>'实名认证信息通知','content'=>'实名认证信息成功','time'=>time()))
                            ->setOptions(null, null, null, true)
                            ->send();
                        $art = Propertynotice::find()->orderBy('createTime desc')->asArray()->one();
                        $artId = $art['pNoticeId'] + 1;
                        $models = new Propertynotice();
                        $models->title = '实名认证信息成功';
                        $models->content = '实名认证信息成功！！！';
                        $models->cateId = 3; //系统通知
                        $models->url = "/index.php?r=mobile/default/proery-notice&id=".$artId."&cateid=".$models->cateId;
                        $models->createTime = date('Y-m-d H:i:s',time()); //系统通知
                        $models->save();
                        echo json_encode([
                            'code'=>[],
                            'status'=>200,
                            'message'=>'实名认证信息成功！'
                        ]);
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }else{
                var_dump($model->getErrors());
                exit;
            }
        }
        return $this->render('create', [
            'model' => $model,
            'user_type'=>$user_type,
            'house'=>$house,
            'position'=>$position,
            'post'=>$posts
        ]);
    }

    /**
     * Updates an existing UserPost model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = 'layout1';
        $model = $this->findModel($id);
        //用户类型
        $user_type = array(array('id'=>1,'type_name'=>'内部员工'),array('id'=>2,'type_name'=>'普通用户'));
        $house = House::find()->where(array('parentId'=>0))->asArray()->all();
        //职位
        $position = UserPosition::find()->asArray()->all();
        //岗位
        $posts = UserPost::find()->asArray()->all();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model->user_type = $post['UserBase']['user_type'];
            $model->true_name = $post['UserBase']['true_name'];
            $model->mobile = $post['UserBase']['mobile'];
            $model->house_id = $post['UserBase']['house_id'];
            $house_name = House::find()->where(array('id'=>$post['UserBase']['house_id']))->asArray()->one();
            $model->house_name =$house_name['housename'];
            $model->seat_id = $post['UserBase']['seat_id'];
            $seat_name = House::find()->where(array('id'=>$post['UserBase']['seat_id']))->asArray()->one();
            $model->seat_name = $seat_name['housename'];
            $model->room_num = $post['UserBase']['room_num'];
            $model->address = $post['UserBase']['address'];
            if($model->load($model) || $model->validate()){
                if($model->save(false)){
                    $user = UserBase::find()->orderBy('id desc')->asArray()->one();
                    $where['TrueName'] = $user['true_name'];
                    $where['Tell'] = $user['mobile'];
                    $list = User::find()->where($where)->asArray()->one();       
                    if(!empty($list)){
                        User::updateAll(array('Status'=>3,'Position'=>$post['UserBase']['position'],'PostId'=>$post['UserBase']['posts']),array('TrueName'=>$user['true_name'],'Tell'=>$user['mobile']));
                        $cerfication = new Certification();
                        $cerfication->UserId = $list['id'];
                        $cerfication->HouseId =$post['UserBase']['house_id'];
                        $cerfication->SeatId = $post['UserBase']['seat_id'];
                        $cerfication->Address =$post['UserBase']['room_num'];
                        $cerfication->Company =$post['UserBase']['company'];
                        $cerfication->CreateTime = date("Y-m-d H:i:s", time());
                        $cerfication->Status = 3;
                        $cerfication->CateId = $post['UserBase']['user_type'];
                        $cerfication->save();
                        //极光推送，向维修师傅推送新订单信息
                        $client = new JPush();
                        $client->push()
                            ->setPlatform(array('ios', 'android'))
                            ->addAlias('xy'.$list['id'])
                            ->setNotificationAlert('实名认证信息成功!')
                            ->addAndroidNotification('实名认证信息成功', '实名认证信息通知', 1, array('msg_type'=>2,'title'=>'实名认证信息通知','content'=>'实名认证信息成功','time'=>time()))
                            ->addIosNotification('实名认证信息成功', '实名认证信息通知', JPush::DISABLE_BADGE,true, 'iOS category', array('msg_type'=>2,'title'=>'实名认证信息通知','content'=>'实名认证信息成功','time'=>time()))
                            ->setMessage('实名认证信息成功', '实名认证信息通知', 'type', array('msg_type'=>2,'title'=>'实名认证信息通知','content'=>'实名认证信息成功','time'=>time()))
                            ->setOptions(null, null, null, true)
                            ->send();
                        $art = Propertynotice::find()->orderBy('createTime desc')->asArray()->one();
                        $artId = $art['pNoticeId'] + 1;
                        $models = new Propertynotice();
                        $models->title = '实名认证信息成功';
                        $models->content = '实名认证信息成功！！！';
                        $models->cateId = 3; //系统通知
                        $models->url = "/index.php?r=mobile/default/proery-notice&id=".$artId."&cateid=".$models->cateId;
                        $models->createTime = date('Y-m-d H:i:s',time()); //系统通知
                        $models->save();
                        echo json_encode([
                            'code'=>[],
                            'status'=>200,
                            'message'=>'实名认证信息成功！'
                        ]);
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'user_type'=>$user_type,
            'house'=>$house,
            'position'=>$position,
            'post'=>$posts
        ]);
    }
    /**
     * Deletes an existing UserPost model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['sys/user-base']);
    }

    /**
     * Finds the UserPost model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserPost the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserBase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	/**
	 * 用户基础信息
	 * @Author   tml
	 * @DateTime 2017-12-09
	 * @return   [type]     [description]
	 */
	public function actionUserBase(){
		$this->layout = 'layout1';
        $company = empty(Yii::$app->request->get()['company']) ? '' : Yii::$app->request->get()['company'];
        $mobile = empty(Yii::$app->request->get()['mobile']) ? '' : Yii::$app->request->get()['mobile'];
        $true_name = empty(Yii::$app->request->get()['true_name']) ? '' : Yii::$app->request->get()['true_name'];
        $session = \Yii::$app->session;
        $lists = explode(',',$session['admin']['house_ids']);
        $user_type    = empty(Yii::$app->request->get()['user_type']) ? 0 : Yii::$app->request->get()['user_type'];
        $jquery = UserBase::find()->where(array('in','user_type',array('1','2')))->andWhere(['in','house_id',$lists]);
        if(!empty($company)){
            $jquery = $jquery->andWhere(['like','company',$company]);
        }
        if(!empty($mobile)){
            $jquery = $jquery->andWhere(['like','mobile',$mobile]);
        }
        if(!empty($true_name)){
            $jquery = $jquery->andWhere(['like','true_name',$true_name]);
        }
        if(!empty($user_type)){
            $jquery = $jquery->andWhere(['user_type',$user_type]);
        }
		$count = $jquery->count();
		$pagination = new Pagination(['totalCount'=>$count]);
		$list = $jquery
			->offset($pagination->offset)
			->limit($pagination->limit)
			->orderBy('id desc')
			->asArray()
			->all();

		// var_dump($list);exit;

		return $this->render('user_base',[
			'list'=>$list,
			'pagination'=>$pagination
		]);    
	}

    /**
     * 用户基础信息导入
     * @Author   tml
     * @DateTime 2018-01-15
     * @return   [type]     [description]
     */
	public function actionAjaxImportExcel(){
		$path = empty($this->post['path']) ? '' : $this->post['path'];
		if (empty($path)) {
			echo json_encode(['code'=>-200,'msg'=>'请先上传excel文件']);exit;
		}
		require_once(dirname(__FILE__).'/'.'../../../vendor/PHPExcel-1.8/PHPExcel/IOFactory.php');
		//读数据 
		$objReader   = \PHPExcel_IOFactory :: createReaderForFile($path);; //准备打开文件  
		$objPHPExcel =  $objReader->load($path);   //载入文件  
		$sheet = $objPHPExcel->getSheet(0);
		$rows  = $sheet->getHighestRow();

		$data = [];
		$data_error = [];
		$success = 0;
		$fail = 0;
		if ($rows >= 2) {
			for ($i=2; $i <= $rows ; $i++) { 
				$cellA = $sheet->getCell('A'.$i)->getCalculatedValue();
				$cellB = $sheet->getCell('B'.$i)->getCalculatedValue();
				$cellC = $sheet->getCell('C'.$i)->getCalculatedValue();
				$cellD = $sheet->getCell('D'.$i)->getCalculatedValue();
				$cellE = $sheet->getCell('E'.$i)->getCalculatedValue();
				$cellF = $sheet->getCell('F'.$i)->getCalculatedValue();
				$cellG = $sheet->getCell('G'.$i)->getCalculatedValue();
				$cellH = $sheet->getCell('H'.$i)->getCalculatedValue();
				$cellI = $sheet->getCell('I'.$i)->getCalculatedValue();
				if (!(empty($cellA) || empty($cellB) || empty($cellC) || empty($cellD) || empty($cellE) || empty($cellF) || empty($cellG) || empty($cellH) || empty($cellH))) {
					$item = [];
					$item['true_name']  = $cellA;
					$item['mobile']     = (string)$cellB;
					$item['company']    = $cellC;
					$item['house_id']   = $cellD;
					$item['house_name'] = $cellE;
					$item['seat_id']    = $cellF;
					$item['seat_name']  = $cellG;
					$item['room_num']   = (string)$cellH;
					$item['address']    = $cellE . '-' . $cellG . '-' . $cellH;
					$item['user_type']  = $cellI;
					$data[] = $item;
				} else {
					$fail++;
					$item = [];
					$item['true_name']  = $cellA;
					$item['mobile']     = (string)$cellB;
					$item['company']    = $cellC;
					$item['house_id']   = $cellD;
					$item['house_name'] = $cellE;
					$item['seat_id']    = $cellF;
					$item['seat_name']  = $cellG;
					$item['room_num']   = (string)$cellH;
					$item['address']    = $cellE . '-' . $cellG . '-' . $cellH;
					$item['user_type']  = $cellI;
					$item['error']      = '信息缺失';
					$data_error[] = $item;
				}
			}
		}
		if (count($data) > 0) {
			foreach ($data as $k => $v) {
				$mobile = $v['mobile'];
				if (!preg_match('/^1[3|4|5|6|7|8][0-9]{9}$/', $mobile)) {
					$fail++;
					$v['error'] = '手机号格式错误';
					$data_error[] = $v;
				} else {
					$res = UserBase::find()->where(['mobile'=>$mobile])->count();
					if ($res) {
						$fail++;
						$v['error'] = '手机号已存在';
						$data_error[] = $v;
					} else {
						$model = new UserBase();
						$model->true_name = $v['true_name'];
						$model->mobile    = $v['mobile'];
						$model->company   = $v['company'];
						$model->house_id  = $v['house_id'];
						$model->house_name = $v['house_name'];
						$model->seat_id   = $v['seat_id'];
						$model->seat_name = $v['seat_name'];
						$model->room_num  = $v['room_num'];
						$model->address   = $v['address'];
						$model->user_type = $v['user_type'];
						$r = $model->save();
						if ($r) {
							$success++;
						} else {
							$fail++;
							$v['error'] = '插入失败';
							$data_error[] = $v;
						}
					}
				}
				
			}
			echo json_encode(['code'=>200,'success'=>$success,'fail'=>$fail,'data'=>$data_error]);exit;
		}
		echo json_encode(['code'=>-200,'msg'=>'没有可以批量插入的数据']);
	}

    /**
     * 缴费账户基础信息列表
     * @Author   tml
     * @DateTime 2018-01-15
     * @return   [type]     [description]
     */
    public function actionAccountBase(){
        $this->layout = 'layout1';

        $house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
        $seat_id  = empty($this->get['seat_id']) ? 0 : $this->get['seat_id'];
        $room_num = empty($this->get['room_num']) ? 0 : $this->get['room_num'];

        $con = [];
        if (!empty($house_id)) {
            $con['a.house_id'] = $house_id;
        }
        if (!empty($seat_id)) {
            $con['a.seat_id']  = $seat_id;
        }
        if (!empty($room_num)) {
            $con['a.room_num'] = $room_num;
        }
        $session = \Yii::$app->session;
        $lists = explode(',',$session['admin']['house_ids']);
        $query = (new \yii\db\Query())
            ->select('a.*,h1.housename as house_name,h2.housename as seat_name,ad.adminemail')
            ->from('account_base a')
            ->leftJoin('house h1','a.house_id=h1.id')
            ->leftJoin('house h2','a.seat_id=h2.id')
            ->leftJoin('admin ad','ad.adminid = a.user_id')
            ->where($con)->andWhere(['in','a.house_id',$lists]);

        $count = $query->count();

        $pagination = new Pagination(['totalCount'=>$count]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('a.id desc')
            ->all();

        $house = House::find()->where(['parentId'=>0])->asArray()->all();

        return $this->render('account_base',[
            'pagination' => $pagination,
            'list' => $list,
            'house' => $house
        ]);
    }

    /**
     * 文件下载
     * @Author   tml
     * @DateTime 2018-01-15
     * @return   [type]     [description]
     */
    public function actionDownloadFile()
    {
        $app_path = dirname(dirname(dirname(__DIR__)));
        $wrstr=htmlspecialchars_decode(file_get_contents($app_path.'/web/template/account_base_tmp.xlsx'));
        $outfile=time().'.'.'xlsx';
        header('Content-type: application/octet-stream; charset=utf8');
        Header("Accept-Ranges: bytes");
        header('Content-Disposition: attachment; filename='.$outfile);
        echo $wrstr;
        exit();
    }

    /**
     * ajax导入缴费账户基础信息
     * @Author   tml
     * @DateTime 2018-01-15
     * @return   [type]     [description]
     */
    public function actionAjaxImportAccountBase(){
        $path = empty($this->post['path']) ? '' : $this->post['path'];
        if (empty($path)) {
            echo json_encode(['code'=>-200,'msg'=>'请先上传excel文件']);exit;
        }
        require_once(dirname(__FILE__).'/'.'../../../vendor/PHPExcel-1.8/PHPExcel/IOFactory.php');
        //读数据 
        $objReader   = \PHPExcel_IOFactory :: createReaderForFile($path);; //准备打开文件  
        $objPHPExcel =  $objReader->load($path);   //载入文件  
        $sheet = $objPHPExcel->getSheet(0);
        $rows  = $sheet->getHighestRow();

        $data = [];
        $data_error = [];
        $success = 0;
        $fail = 0;
        if ($rows >= 2) {
            for ($i=2; $i <= $rows ; $i++) { 
                $cellA = $sheet->getCell('A'.$i)->getCalculatedValue();
                $cellB = $sheet->getCell('B'.$i)->getCalculatedValue();
                $cellC = $sheet->getCell('C'.$i)->getCalculatedValue();
                $cellD = $sheet->getCell('D'.$i)->getCalculatedValue();
                $cellE = $sheet->getCell('E'.$i)->getCalculatedValue();
                $cellF = $sheet->getCell('F'.$i)->getCalculatedValue();
                $cellG = $sheet->getCell('G'.$i)->getCalculatedValue();
                $cellH = $sheet->getCell('H'.$i)->getCalculatedValue();
                $cellI = $sheet->getCell('I'.$i)->getCalculatedValue();
                if (!(empty($cellA) || empty($cellB) || empty($cellC) || empty($cellD) || empty($cellE) || empty($cellF) || empty($cellG))) {
                    $item = [];
                    $item['house_name'] = $cellA;
                    $item['house_id']   = $cellB;
                    $item['seat_name']  = $cellC;
                    $item['seat_id']    = $cellD;
                    $item['room_num']   = $cellE;
                    $item['owner']      = $cellF;
                    $item['rate']       = $cellG;
                    $item['property_fee']=$cellH;
                    $item['area']       = $cellI;
                    $data[] = $item;
                } else {
                    $fail++;
                    $item = [];
                    $item['house_name'] = $cellA;
                    $item['house_id']   = $cellB;
                    $item['seat_name']  = $cellC;
                    $item['seat_id']    = $cellD;
                    $item['room_num']   = $cellE;
                    $item['owner']      = $cellF;
                    $item['rate']       = $cellG;
                    $item['property_fee']=$cellH;
                    $item['area']       = $cellI;
                    $item['error']      = '信息缺失';
                    $data_error[] = $item;
                }
            }
        }
        if (count($data) > 0) {
            foreach ($data as $k => $v) {                
                $res = AccountBase::find()->where(['house_id'=>$v['house_id'],'seat_id'=>$v['seat_id'],'room_num'=>$v['room_num']])->count();
                if ($res) {
                    $fail++;
                    $v['error'] = '房间号已存在';
                    $data_error[] = $v;
                } else {
                    $model = new AccountBase();
                    $model->house_id = $v['house_id'];
                    $model->seat_id  = $v['seat_id'];
                    $model->room_num = (string)$v['room_num'];
                    $model->owner    = $v['owner'];
                    $model->rate     = $v['rate'];
                    $model->property_fee = $v['property_fee'];
                    $model->area     = $v['area'];
                    $model->create_time = time();
                    $r = $model->save();
                    if ($r) {
                        $success++;
                    } else {
                        $fail++;
                        $v['error'] = '插入失败';
                        $data_error[] = $v;
                    }
                }

            }
            echo json_encode(['code'=>200,'success'=>$success,'fail'=>$fail,'data'=>$data_error]);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'没有可以批量插入的数据']);
    }

    /**
     * 添加缴费账户基础信息
     * @Author   tml
     * @DateTime 2018-01-16
     * @return   [type]     [description]
     */
    public function actionAddAccountBase(){
        $this->layout=false;
        $op_id = empty($this->get['op_id']) ? 0 : $this->get['op_id'];
        $model = AccountBase::find()->where(['id'=>$op_id])->asArray()->one();
        $house = House::find()->where(['parentId'=>0])->asArray()->all();
        $seat  = [];
        $house_id = 0;
        $seat_id  = 0;
        if (!empty($model)) {
            $house_id = $model['house_id'];
            $seat_id  = $model['seat_id'];
            $seat  = House::find()->where(['parentId'=>$house_id])->asArray()->all();
        }
        return $this->render('add_account_base',[
            'op_id' => $op_id,
            'model' => $model,
            'house' => $house,
            'seat'  => $seat
        ]);
    }

    /**
     * ajax进行缴费账户新增/修改操作
     * @Author   tml
     * @DateTime 2018-01-17
     * @return   [type]     [description]
     */
    public function actionAjaxDoAddAccountBase(){
        $op_id    = empty($this->post['op_id']) ? 0 : $this->post['op_id'];
        $house_id = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
        $seat_id  = empty($this->post['seat_id']) ? 0 : $this->post['seat_id'];
        $room_num = empty($this->post['room_num']) ? 0 : $this->post['room_num'];
        $owner    = empty($this->post['owner']) ? 0 : $this->post['owner'];
        $rate     = empty($this->post['rate']) ? 0 : $this->post['rate'];
        $property_fee = empty($this->post['property_fee']) ? 0 : $this->post['property_fee'];
        $area     = empty($this->post['area']) ? 0 : $this->post['area'];
        $res = 0;
        $session = \Yii::$app->session;
        $user_id = $session['admin']['adminid'];
        $create_time = time();
        if (empty($op_id)) { //添加
            $count = AccountBase::find()->where(['house_id'=>$house_id,'seat_id'=>$seat_id,'room_num'=>$room_num])->count();
            if ($count) {
                echo json_encode(['code'=>-200,'msg'=>'账户信息已存在，不可重复添加']);exit;
            }
            $model = new AccountBase();
            $model->house_id = $house_id;
            $model->seat_id  = $seat_id;
            $model->room_num = $room_num;
            $model->owner    = $owner;
            $model->rate     = $rate;
            $model->user_id = $user_id;
            $model->create_time = $create_time;
            $model->property_fee = $property_fee;
            $model->area = $area;
            $res = $model->save();
        } else {
            $count = AccountBase::find()->where(['house_id'=>$house_id,'seat_id'=>$seat_id,'room_num'=>$room_num])->andWhere(['!=','id',$op_id])->count();
            if ($count) {
                echo json_encode(['code'=>-200,'msg'=>'账户信息已存在，不可重复添加']);exit;
            }
            $udata['house_id'] = $house_id;
            $udata['seat_id']  = $seat_id;
            $udata['room_num'] = $room_num;
            $udata['owner']    = $owner;
            $udata['rate']     = $rate;
            $udata['user_id'] = $user_id;
            $udata['update_time'] = $create_time;
            $udata['property_fee'] = $property_fee;
            $udata['area'] = $area;
            $udata['update_time'] = time();
            $res = AccountBase::updateAll(['user_id'=>$user_id,'update_time'=>$create_time,'house_id'=>$house_id,'seat_id'=>$seat_id,'room_num'=>$room_num,'owner'=>$owner,'rate'=>$rate,'area'=>$area,'property_fee'=>$property_fee],['id'=>$op_id]);
        }
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }

    /**
     * ajax进行缴费账户基础信息删除操作
     * @Author   tml
     * @DateTime 2018-01-17
     * @return   [type]     [description]
     */
    public function actionAjaxDelAccountBase(){
        $op_id = empty($this->post['op_id']) ? 0 : $this->post['op_id'];
        $res = AccountBase::deleteAll(['id'=>$op_id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }

    /**
     * 修改密码
     * @Author   tml
     * @DateTime 2018-03-08
     * @return   [type]     [description]
     */
    public function actionUpdatePassword()
    {
        $this->layout = 'layout1';
        return $this->render('update_password');
    }

    /**
     * ajax修改密码
     * @Author   tml
     * @DateTime 2018-03-08
     * @return   [type]     [description]
     */
    public function actionAjaxUpdatePassword()
    {
        $newpass = empty($this->post['newpass']) ? '' : $this->post['newpass'];
        if (empty($newpass)) {
            echo json_encode(['code'=>-200,'msg'=>'请输入新密码']);exit;
        }
        $admin_id = Yii::$app->session['admin']['adminid'];
        $res = Admin::updateAll(['password'=>$newpass,'adminpass'=>md5($newpass),'uppass_time'=>time()],['adminid'=>$admin_id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'新密码设置成功']);exit;
        }
        echo json_encode(['code'=>200,'msg'=>'新密码设置失败']);exit;
    }

    /**
     * 电费充值金额标签管理
     * @Author   tml
     * @DateTime 2018-08-22
     * @return   [type]     [description]
     */
    public function actionPriceTag()
    {
        $this->layout = 'layout1';
        $house_id = empty($this->get['house_id']) ? 0 : $this->get['house_id'];
        $con = [];
        if ($house_id) {
            $con['house_id'] = $house_id;
        }
        $house_ids = explode(',',Yii::$app->session['admin']['house_ids']);
        $list = (new \yii\db\Query())
            ->select('h1.housename as house_name,h2.housename as seat_name,a.adminuser,p.*')
            ->from('price_tag p')
            ->leftJoin('house h1','p.house_id=h1.id')
            ->leftJoin('house h2','p.seat_id=h2.id')
            ->leftJoin('admin a','p.edit_user=a.adminid')
            ->where($con)
            ->andWhere(['in','p.house_id',$house_ids])
            ->orderBy('p.house_id,p.seat_id')
            ->all();
        $house = House::find()->select('id,housename')->where(['parentId'=>0])->andWhere(['in','id',$house_ids])->asArray()->all();
        return $this->render('price_tag',[
            'list' => $list,
            'house' => $house
        ]);
    }

    /**
     * 设置电费充值金额标签
     * @Author   tml
     * @DateTime 2018-08-22
     * @return   [type]     [description]
     */
    public function actionSetPriceTag()
    {
        $this->layout = 'layout1';
        $id = empty($this->get['id']) ? 0 : $this->get['id'];
        $model = null;
        if ($id) {
            $model = PriceTag::find()->where(['id'=>$id])->one();
        }
        $house_ids = explode(',',Yii::$app->session['admin']['house_ids']);
        $house = House::find()->select('id,housename')->where(['parentId'=>0])->andWhere(['in','id',$house_ids])->asArray()->all();
        // var_dump($house);exit;
        return $this->render('set_price_tag',[
            'model' => $model,
            'house' => $house
        ]);
    }

    /**
     * ajax获取楼座信息
     * @Author   tml
     * @DateTime 2018-08-23
     * @return   [type]     [description]
     */
    public function actionAjaxGetSeat()
    {
        $id = empty($this->post['id']) ? 0 : $this->post['id'];
        $list = null;
        if ($id) {
            $list = House::find()->select('id,housename')->where(['parentId'=>$id])->asArray()->all();
        }
        if ($list) {
            echo json_encode(['code'=>200,'data'=>$list]);exit;
        } else {
            echo json_encode(['code'=>-200,'data'=>$list]);exit;
        }
    }

    /**
     * 设置价格标签操作
     * @Author   tml
     * @DateTime 2018-08-24
     * @return   [type]     [description]
     */
    public function actionDoSetPriceTag()
    {
        $id = empty($this->post['id']) ? 0 : $this->post['id'];
        $house_id = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
        $seat_id = empty($this->post['seat_id']) ? 0 : $this->post['seat_id'];
        $tag1 = empty($this->post['tag1']) ? 0 : $this->post['tag1'];
        $tag2 = empty($this->post['tag2']) ? 0 : $this->post['tag2'];
        $tag3 = empty($this->post['tag3']) ? 0 : $this->post['tag3'];
        $tag4 = empty($this->post['tag4']) ? 0 : $this->post['tag4'];
        $tag5 = empty($this->post['tag5']) ? 0 : $this->post['tag5'];
        $tag6 = empty($this->post['tag6']) ? 0 : $this->post['tag6'];
        if (empty($house_id) || empty($seat_id)) {
            echo json_encode(['code'=>-200,'msg'=>'请选择楼盘楼座']);exit;
        }
        $tags = [];
        if (empty($tag1) || $tag1 < 50) {
            echo json_encode(['code'=>-200,'msg'=>'价格标签不可小于50']);exit;
        }
        array_push($tags,$tag1); 
        if (empty($tag2) || $tag2 < 50) {
            echo json_encode(['code'=>-200,'msg'=>'价格标签不可小于50']);exit;
        }
        if (in_array($tag2,$tags)) {
            echo json_encode(['code'=>-200,'msg'=>'价格标签不可重复']);exit;
        }
        array_push($tags, $tag2);
        if (empty($tag3) || $tag3 < 50) {
            echo json_encode(['code'=>-200,'msg'=>'价格标签不可小于50']);exit;
        }
        if (in_array($tag3,$tags)) {
            echo json_encode(['code'=>-200,'msg'=>'价格标签不可重复']);exit;
        }
        array_push($tags, $tag3);
        if (empty($tag4) || $tag4 < 50) {
            echo json_encode(['code'=>-200,'msg'=>'价格标签不可小于50']);exit;
        }
        if (in_array($tag4,$tags)) {
            echo json_encode(['code'=>-200,'msg'=>'价格标签不可重复']);exit;
        }
        array_push($tags, $tag4);
        if (empty($tag5) || $tag5 < 50) {
            echo json_encode(['code'=>-200,'msg'=>'价格标签不可小于50']);exit;
        }
        if (in_array($tag5,$tags)) {
            echo json_encode(['code'=>-200,'msg'=>'价格标签不可重复']);exit;
        }
        array_push($tags, $tag5);
        if (empty($tag6) || $tag6 < 50) {
            echo json_encode(['code'=>-200,'msg'=>'价格标签不可小于50']);exit;
        }
        if (in_array($tag6,$tags)) {
            echo json_encode(['code'=>-200,'msg'=>'价格标签不可重复']);exit;
        }
        array_push($tags, $tag6);
        //对价格标签进行升序排序
        sort($tags);
        $model = PriceTag::find()->where(['house_id'=>$house_id,'seat_id'=>$seat_id])->andWhere(['<>','id',$id])->one();
        if ($model) {
            echo json_encode(['code'=>-200,'msg'=>'此楼座价格标签信息已存在，不可重复添加']);exit;
        }
        $ret = 0;
        if ($id) {
            $data['house_id'] = $house_id;
            $data['seat_id'] = $seat_id;
            $data['tag'] = implode(',', $tags);
            $data['edit_time'] = time();
            $data['edit_user'] = Yii::$app->session['admin']['adminid'];
            $ret = PriceTag::updateAll($data,['id'=>$id]);
        } else {
            $model = new PriceTag();
            $model->house_id = $house_id;
            $model->seat_id = $seat_id;
            $model->tag = implode(',', $tags);
            $model->add_time = time();
            $model->add_user = Yii::$app->session['admin']['adminid'];
            $model->edit_time = time();
            $model->edit_user = Yii::$app->session['admin']['adminid'];
            $ret = $model->save();
        }
        if ($ret) {
            echo json_encode(['code'=>200,'msg'=>'提交成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'提交失败']);exit;
    }
}