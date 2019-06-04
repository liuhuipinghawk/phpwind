<?php

namespace app\modules\admin\controllers;

use app\vendor\JPush\JPush;
use Yii;
use app\models\Admin\User;
use app\models\Admin\UserSearch;
use app\models\Admin\Certification;
use app\models\Admin\Order;
use app\util\OrderUtils;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\util\Fushi;
//use app\vendor\JPush\JPush;
use app\models\Admin\Propertynotice;
use app\models\Admin\UserPosition;
use app\models\Admin\UserPost;

/**
 * CertificationController implements the CRUD actions for User model.
 */
class CertificationController extends CommonController
{

    /**
     * Lists all User models.
     * @return mixed
     */
    protected $params;
    // public function actionIndex1()
    // {
    //     $this->layout="layout1";
    //     $Tell = empty(Yii::$app->request->get()['Tell']) ? '' : Yii::$app->request->get()['Tell'];
    //     $TrueName = empty(Yii::$app->request->get()['TrueName']) ? '' : Yii::$app->request->get()['TrueName'];
    //     $Company = empty(Yii::$app->request->get()['Company']) ? '' : Yii::$app->request->get()['Company'];
    //     $Status      = empty(Yii::$app->request->get()['Status']) ? '' : Yii::$app->request->get()['Status'];
    //     $session = \Yii::$app->session;
    //     $list = explode(',',$session['admin']['house_ids']);
    //     $jquery = (new \yii\db\Query())->select('u.*,pt.post_name,pn.position_name')->
    //         from('user u')->
    //     leftJoin('app_user_post pt','pt.post_id = u.PostId')->
    //     leftJoin('app_user_position pn','pn.position_id = u.Position')->
    //     leftJoin('certification c','c.UserId = u.id')->
    //     where(['in','c.HouseId',$list])->
    //     andWhere(['in','u.Status',[2,3]])->orderBy('u.CreateTime desc,c.Status desc')->
    //     groupBy(['u.id']);
    //     if(!empty($Tell)){
    //         $jquery->andWhere(['like','u.Tell',$Tell]);
    //     }
    //     if(!empty($TrueName)){
    //         $jquery->andWhere(['like','u.TrueName',$TrueName]);
    //     }
    //     if(!empty($Company)){
    //         $jquery->andWhere(['like','u.Company',$Company]);
    //     }
    //     if(!empty($Status)){
    //         $jquery->andWhere(['c.Status'=>$Status]);
    //     }
    //     $count      = $jquery->count();
    //     $pagination = new Pagination(['totalCount' => $count]);
    //     $pagination->setPageSize(15);
    //     $model =$jquery->offset($pagination->offset)
    //         ->limit($pagination->limit)->all();
    //     return $this->render('index', [
    //         //'searchModel' => $searchModel,
    //         'model' => $model,
    //         'pagination'=>$pagination,
    //     ]);
    // }

    /**
     * 实名认证列表
     * @Author   tml
     * @DateTime 2018-08-14
     * @return   [type]     [description]
     */
    public function actionIndex()
    {
        $this->layout = 'layout1';
        $get = Yii::$app->request->get();
        $mobile = empty($get['Tell']) ? '' : $get['Tell'];
        $true_name = empty($get['TrueName']) ? '' : $get['TrueName'];
        $company = empty($get['Company']) ? '' : $get['Company'];
        $status = empty($get['Status']) ? 0 : $get['Status'];
        $session = \Yii::$app->session;
        $house_ids = explode(',',$session['admin']['house_ids']);
        $sub_query = (new \yii\db\Query())
            ->select(['u.id as user_id','u.Tell as mobile','u.CreateTime as add_time','u.TrueName as true_name','u.Company as company','u.CateId as user_type','u.`Status` as user_status','p1.position_name','p2.post_name','c.`Status` as cert_status','c.CreateTime as cert_add_time'])
            ->from('user u')
            ->leftJoin('certification c','u.id=c.UserId')
            ->leftJoin('app_user_position p1','u.Position=p1.position_id')
            ->leftJoin('app_user_post p2','u.PostId=p2.post_id')
            ->where(['>','u.Status',1])
            ->andWhere(['in','c.HouseId',$house_ids]);
        if ($mobile) {
            $sub_query = $sub_query->andWhere(['like','u.Tell',$mobile]);
        }
        if ($true_name) {
            $sub_query = $sub_query->andWhere(['like','u.TrueName',$true_name]);
        }
        if ($company) {
            $sub_query = $sub_query->andWhere(['like','u.Company',$company]);
        }
        if ($status) {
            $sub_query = $sub_query->andWhere(['=','c.Status',$status]);
        }
        $sub_query = $sub_query->orderBy('c.Status asc');
        $query = (new \yii\db\Query())->select('z.*')->from(['z'=>$sub_query])->groupBy('z.mobile')->orderBy('z.cert_status asc,z.add_time desc');
        $query = $query;
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $pagination->setPageSize(15);
        $list = $query->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('index', [
            'list' => $list,
            'pagination'=>$pagination,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout="layout1";
        $userId = Yii::$app->request->get('id');
        //$searchModel = new UserSearch();
        $data = array('in','certification.Status',array('1','2','3'));
        $data = array('certification.UserId'=>$userId);
        $list = Certification::find()->select('certification.UpdateTime,certification.CertificationId,certification.UserId,certification.Address,certification.Status,certification.floor,user.TrueName,user.Tell,house.housename,seat.housename as SeatName,house.id as house_id')->join('LEFT JOIN','user','user.id = certification.UserId')->join('LEFT JOIN','house','house.id = certification.HouseId')->join('LEFT JOIN','house as seat','seat.id = certification.SeatId')->where($data);
        $pages = new Pagination(['totalCount'=>$list->count(),'pageSize' => '10']);
        $model =$list->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return $this->render('view', [
            'model' => $model,
            'pages'=>$pages,
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = User::find()->select('seat.name,house.housename,user.id,user.HouseId,user.NickName,user.TrueName,user.Address,user.IdCard,user.IdCardOver,user.WorkCard,user.Company,user.HeaderImg')->join('LEFT JOIN','house','house.id = user.HouseId')->join('LEFT JOIN','seat','seat.id = user.Seat')->where(array('user.id'=>$id))->asArray()->one();
        if ($model  !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     *实名认证ajax
     */
    public function actionConfirm(){
            $id = Yii::$app->request->get('CertificationId');
            $house_id = Yii::$app->request->get('house_id');
            $userid = Yii::$app->request->get('UserId');
            $ids = explode(',',$id);$house_ids = explode(',',$house_id);
            $userall = User::find()->where(array('id'=>$userid))->asArray()->one();
        $seat = Yii::$app->request->get('seat');
        $list = Certification::find()->alias('c')->select('h.housename')->leftJoin('house h','h.id = c.SeatId')->
        where(['c.UserId'=>$userid,'c.HouseId'=>3,'c.Status'=>3])->asArray()->all();
        $seatlist = [];$r = [];
        $seats = explode(',',$seat);
        foreach($list as $k=>$v){
            $r[]=$v['housename'];
        }
        $seatlist = $r;
        $seatname = array_merge($seatlist,$seats);
            if(!empty($userall)){
                $user = User::updateAll(['Status'=>3],['id'=>$userid]);
                foreach($house_ids as $v){
                    if($v == 3 || $v == 7){
                        $res = $this->OwnerImport($v,$userall['TrueName'],$userall['Tell'],$seatname);
                    }
                    if($v == 1 || $v ==2 || $v == 6 || $v == 3 || $v == 4){
                        $res = $this->ShiWei($userall['Tell']);
                    }
                }
                for($index=0;$index<count($ids);$index++){
                    $return = Yii::$app->db->createCommand()->update('certification',['Status'=>3,'UpdateTime'=>date('Y-m-d H:i:s',time())],"CertificationId=".$ids[$index])->execute();
                }
                //极光推送，向维修师傅推送新订单信息
                $client = new JPush();
                $client->push()
                    ->setPlatform(array('ios', 'android'))
                    ->addAlias('xy'.$userall['id'])
                    ->setNotificationAlert('通行区域审核通过!')
                    ->addAndroidNotification('通行区域审核通过!', '通行区域通知', 1, array('msg_type'=>3,'title'=>'通行区域通知','content'=>'通行区域审核通过!','time'=>time()))
                    ->addIosNotification('通行区域审核通过!', '通行区域通知', JPush::DISABLE_BADGE,true, 'iOS category', array('msg_type'=>3,'title'=>'通行区域通知','content'=>'通行区域审核通过!','time'=>time()))
                    ->setMessage('通行区域审核通过!', '通行区域通知', 'type', array('msg_type'=>3,'title'=>'通行区域通知','content'=>'通行区域审核通过!','time'=>time()))
                    ->setOptions(null, null, null, true)
                    ->send();
                // $art = Propertynotice::find()->orderBy('createTime desc')->asArray()->one();
                // $artId = $art['pNoticeId'] + 1;
                // $model = new Propertynotice();
                // $model->title = '通行区域审核通过!';
                // $model->content = '通行区域审核通过!！！！';
                // $model->cateId = 3; //系统通知
                // $model->url = "/index.php?r=mobile/default/proery-notice&id=".$artId."&cateid=".$model->cateId;
                // $model->createTime = date('Y-m-d H:i:s',time()); //系统通知
                // $model->save();
                
                //系统通知
                $noticeM = new Propertynotice();
                $noticeM->addNotice($userall['id'],'通行区域通知','通行区域审核通过',1);
                echo json_encode([
                    'code'=>[],
                    'status'=>200,
                    'message'=>'通行区域审核通过'
                ]);
                exit;
            }else{
                echo json_encode([
                    'code'=>[],
                    'status'=>-200,
                    'message'=>'用户不存在'
                ]);
                exit;
            }
    }
    /**
     * 导入业主信息
     * @Author   tml
     * @DateTime 2018-04-03
     * @return   [type]     [description]
     */
    public function OwnerImport($house_id,$username,$mobile,$role)
    {
        $this->params = Yii::$app->params['house_config'];
        $url = '/public/OwnerImportList';
        $timestamp = time();
        $owner['Name'] = $username;
        $owner['Phone'] = $mobile;
        $owner['IdCard'] = '';
        $owner['HeadPhoto'] = '';
        $owner['BuildingNum'] = $role;

        $data['SmallCode']   = $this->params[$house_id]['SmallCode'];
        $data['SmallCodeId'] = $this->params[$house_id]['SmallCodeId'];
        $data['OwnerPhone'] = '18898709497';
        $data['OwnerList'][] = $owner;
        $fushi = new Fushi();
        $res = $fushi->doSomthing($url,json_encode($data),$timestamp);
        if($res !==false){
            return $res;
        }
        return false;
    }
    function ShiWei($phone){
        $url ="http://test.haoxiangkaimen.cn/api/ZSUserInfoServer?phone=".$phone;

        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        return $output;
    }

    /**
     * 删除通行区域
     * @Author   tml
     * @DateTime 2018-08-01
     * @return   [type]     [description]
     */
    public function actionDoDel()
    {
        $cert_id = Yii::$app->request->post('cert_id');
        if (empty($cert_id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $model = Certification::findOne($cert_id);
        $user = User::find()->where(['id'=>$model['UserId']])->asArray()->one();
        if($model['HouseId'] == 1 || $model['HouseId'] ==2 || $model['HouseId'] == 6 || $model['HouseId'] == 3 || $model['HouseId'] == 4){
            $this->ShiWei($user['Tell']);
        }
        $ret = $model->delete();
        if ($ret) {
            echo json_encode(['code'=>200,'msg'=>'删除成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'删除失败']);exit;
    }

    /**
     * 获取岗位职位select框中option信息
     * @Author   tml
     * @DateTime 2018-08-15
     * @return   [type]     [description]
     */
    public function actionGetOption()
    {
        $type = Yii::$app->request->post('type');
        $user_id = Yii::$app->request->post('user_id');
        $user = User::find()->where(['id'=>$user_id])->asArray()->one();
        $option = '';
        $list = null;
        if ($type == 'position') {
            $list = UserPosition::find()->asArray()->all();
            if ($list) {
                foreach ($list as $k => $v) {
                    if ($v['position_id'] == $user['Position']) {
                        $option .= '<option value="'.$v['position_id'].'" selected>'.$v['position_name'].'</option>';
                    } else {
                        $option .= '<option value="'.$v['position_id'].'">'.$v['position_name'].'</option>';
                    }
                }
            }
        } else if ($type == 'post') {
            $list = UserPost::find()->asArray()->all();
            if ($list) {
                foreach ($list as $k => $v) {
                    if ($v['post_id'] == $user['PostId']) {
                        $option .= '<option value="'.$v['post_id'].'" selected>'.$v['post_name'].'</option>';
                    } else {
                        $option .= '<option value="'.$v['post_id'].'">'.$v['post_name'].'</option>';
                    }
                }
            }
        }
        echo json_encode(['code'=>200,'data'=>$option]);exit;
    }

    /**
     * 编辑用户信息操作
     * @Author   tml
     * @DateTime 2018-08-15
     * @return   [type]     [description]
     */
    public function actionDoEditUser()
    {
        $post = Yii::$app->request->post();
        $user_id = empty($post['id']) ? 0 : $post['id'];
        $true_name = empty($post['true_name']) ? '' : $post['true_name'];
        $user_type = empty($post['user_type']) ? 1 : $post['user_type'];
        $company = empty($post['company']) ? '' : $post['company'];
        $user_post = empty($post['post']) ? 0 : $post['post'];
        $user_position = empty($post['position']) ? 0 : $post['position'];
        if (empty($user_id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $data['TrueName'] = $true_name;
        $data['Company'] = $company;
        $data['CateId'] = $user_type;
        $data['PostId'] = $user_post;
        $data['Position'] = $user_position;
        $data['UpdateTime'] = date('Y-m-d H:i:s',time());
        $ret = User::updateAll($data,['id'=>$user_id]);
        if ($ret) {
            echo json_encode(['code'=>200,'msg'=>'编辑信息成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'编辑信息失败']);exit;
    }
    /**
     * 编辑用户楼层权限
     * @Author   jql
     * @DateTime 2019-03-05
     * @return   [type]     [description]
     */
    public function actionDoEditFloor()
    {
        $post = Yii::$app->request->post();
        $id = empty($post['id']) ? 0 : $post['id'];
        $floor = empty($post['floor']) ? '' : $post['floor'];
        if (empty($id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $data['floor'] = $floor;
        $data['UpdateTime'] = date('Y-m-d H:i:s',time());
        $ret = Certification::updateAll($data,['CertificationId'=>$id]);
        if ($ret) {
            echo json_encode(['code'=>200,'msg'=>'编辑信息成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'编辑信息失败']);exit;
    }

    public function actionTest(){
        $where = ['like','Address','20%',false];
        $res = Certification::find()->select('HouseId,SeatId,Address')->where(['HouseId'=>2])->andWhere(['SeatId'=>21])->andWhere($where)->all();
        foreach($res as $v){
            $user = User::find()->where(['id'=>$v['UserId']])->asArray()->one();
//            $this->ShiWei($user['Tell']);
        }
    }
}
