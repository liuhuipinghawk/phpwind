<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Admin\HouseLease;
use app\models\Admin\HouseLeaseReport;
use yii\data\Pagination;

/**
 * HouseLeaseController implements the CRUD actions for HouseLease model.
 */
class HouseLeaseController extends CommonController
{
    public $enableCsrfValidation = false;
    protected $post;
    protected $get;
    protected $session;
    /**
     * 初始化
     **/
    public function init(){
        $this->post = Yii::$app->request->post();
        $this->get  = Yii::$app->request->get();
        $this->session = Yii::$app->session;
    }

    /**
     * 项目房源管理
     * @Author   tml
     * @DateTime 2018-04-17
     * @return   [type]     [description]
     */
    public function actionHouseLeaseList()
    {
        $this->layout = 'layout1';
        $list = (new \yii\db\Query())
            ->select('l.*,h.housename as house_name,a.adminuser as true_name')
            ->from('house_lease l')
            ->leftJoin('house h','l.house_id=h.id')
            ->leftJoin('admin a','l.add_user=a.adminid')
            ->where(['is_del'=>0])
            ->all();
        return $this->render('house_lease_list',[
            'list'=>$list
        ]);
    }

    /**
     * 新增楼盘房源
     * @Author   tml
     * @DateTime 2018-04-17
     * @return   [type]     [description]
     */
    public function actionAddHouseLease()
    {
        $this->layout = 'layout1';

        $id = empty($this->get['id']) ? 0 : $this->get['id'];

        $model = null;
        if ($id) {
            $model = HouseLease::find()->where(['id'=>$id,'is_del'=>0])->asArray()->one();
        }

        $house = $this->getHouseInfo(0);

        return $this->render('add_house_lease',[
            'model'=>$model,
            'house'=>$house
        ]);
    }

    /**
     * ajax新增楼盘房源
     * @Author   tml
     * @DateTime 2018-04-17
     * @return   [type]     [description]
     */
    public function actionAjaxAddHouseLease()
    {
        $id = empty($this->post['id']) ? 0 : $this->post['id'];
        $house_id = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
        $seat_id = empty($this->post['seat_id']) ? 0 : $this->post['seat_id'];
        $house_type = empty($this->post['house_type']) ? 0 : $this->post['house_type'];
        $total_nums = empty($this->post['total_nums']) ? 0 : $this->post['total_nums'];
        $rent_nums = empty($this->post['rent_nums']) ? 0 : $this->post['rent_nums'];
        $unrent_nums = empty($this->post['unrent_nums']) ? 0 : $this->post['unrent_nums'];
        $total_space = empty($this->post['total_space']) ? 0 : $this->post['total_space'];
        $rent_space = empty($this->post['rent_space']) ? 0 : $this->post['rent_space'];
        $unrent_space = empty($this->post['unrent_space']) ? 0 : $this->post['unrent_space'];

        $year = date('Y');
        $month = date('n');
        $day = date('j');

        $con['is_del'] = 0;
        $con['house_id'] = $house_id;
        $con['seat_id'] = $seat_id;
        $con['house_type'] = $house_type;
        $con['year'] = $year;
        $con['month'] = $month;
        $con['day'] = $day;

        if ($id) {
            $res = HouseLease::find()->where($con)->andWhere(['!=','id',$id])->count();
            if ($res) {
                echo json_encode(['code'=>-200,'msg'=>'该楼盘已添加，不可重复添加']);exit;
            }
            $updata['house_id'] = $house_id;
            $updata['seat_id'] = $seat_id;
            $updata['house_type'] = $house_type;
            $updata['total_nums'] = $total_nums;
            $updata['rent_nums'] = $rent_nums;
            $updata['unrent_nums'] = $unrent_nums;
            $updata['total_space'] = $total_space;
            $updata['rent_space'] = $rent_space;
            $updata['unrent_space'] = $unrent_space;
            $updata['edit_time'] = time();
            $updata['edit_user'] = $this->session['admin']['adminid'];
            $ret = HouseLease::updateAll($updata,['id'=>$id]);
            if ($ret) {
                echo json_encode(['code'=>200,'msg'=>'编辑成功']);exit;
            }
            echo json_encode(['code'=>-200,'msg'=>'编辑失败']);exit;
        } else {
            $res = HouseLease::find()->where($con)->count();
            if ($res) {
                echo json_encode(['code'=>-200,'msg'=>'该楼盘已添加，不可重复添加']);exit;
            }
            $model = new HouseLease();
            $model->house_id = $house_id;
            $model->seat_id = $seat_id;
            $model->house_type = $house_type;
            $model->total_nums = $total_nums;
            $model->rent_nums = $rent_nums;
            $model->unrent_nums = $unrent_nums;
            $model->total_space = $total_space;
            $model->rent_space = $rent_space;
            $model->unrent_space = $unrent_space;
            $model->year = date('Y');
            $model->month = date('n');
            $model->day = date('j');
            $model->add_time = time();
            $model->add_user = $this->session['admin']['adminid'];
            $ret = $model->save();
            if ($ret) {
                echo json_encode(['code'=>200,'msg'=>'新增成功']);exit;
            }
            echo json_encode(['code'=>-200,'msg'=>'新增失败']);exit;
        }
    }

    /**
     * ajax删除楼盘房源信息
     * @Author   tml
     * @DateTime 2018-04-18
     * @return   [type]     [description]
     */
    public function actionAjaxDoDel()
    {
        $id = empty($this->post['id']) ? 0 : $this->post['id'];
        if (empty($id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $updata['is_del'] = 1;
        $updata['del_time'] = time();
        $updata['del_user'] = $this->session['admin']['adminid'];
        $ret = HouseLease::updateAll($updata,['id'=>$id]);
        if ($ret) {
            echo json_encode(['code'=>200,'msg'=>'删除成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'删除失败']);exit;
    }

    /**
     * 租赁日报
     * @Author   tml
     * @DateTime 2018-04-18
     * @return   [type]     [description]
     */
    public function actionHouseLeaseReport()
    {
        $this->layout = 'layout1';

        $adminid = $this->session['admin']['adminid'];

        $page = empty($this->get['page']) ? 1 : $this->get['page'];

        $query = (new \yii\db\Query())
            ->select('r.*,h1.housename as house_name,h2.housename as seat_name,a.adminuser as true_name')
            ->from('house_lease_report r')
            ->leftJoin('house h1','r.house_id=h1.id')
            ->leftJoin('house h2','r.seat_id=h2.id')
            ->leftJoin('admin a','r.add_user=a.adminid')
            ->where(['is_del'=>0]);
        $pagination = new Pagination(['totalCount'=>$query->count()]);
        $list = $query
            ->orderBy('r.add_time desc')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('house_lease_report',[
            'list'=>$list,
            'adminid'=>$adminid,
            'pagination'=>$pagination
        ]);
    }

    /**
     * 新增日报
     * @Author   tml
     * @DateTime 2018-04-18
     * @return   [type]     [description]
     */
    public function actionAddReport()
    {
        $this->layout = 'layout1';

        $id = empty($this->get['id']) ? 0 : $this->get['id'];

        $model = null;
        if ($id) {
            $model = HouseLeaseReport::find()->where(['report_id'=>$id,'is_del'=>0])->asArray()->one();
        }

        $house = $this->getHouseInfo(0);

        return $this->render('add_report',[
            'model'=>$model,
            'house'=>$house
        ]);
    }

    /**
     * ajax新增日报
     * @Author   tml
     * @DateTime 2018-04-18
     * @return   [type]     [description]
     */
    public function actionAjaxAddReport()
    {
        $report_id = empty($this->post['report_id']) ? 0 : $this->post['report_id'];
        $house_id = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
        $seat_id = empty($this->post['seat_id']) ? 0 : $this->post['seat_id'];
        $house_type = empty($this->post['house_type']) ? 0 : $this->post['house_type'];
        $room_num = empty($this->post['room_num']) ? '' : $this->post['room_num'];
        $space = empty($this->post['space']) ? 0 : $this->post['space'];
        $get_money = empty($this->post['get_money']) ? 0 : $this->post['get_money'];
        
        if ($report_id) {
            $updata['house_id'] = $house_id;
            $updata['seat_id'] = $seat_id;
            $updata['house_type'] = $house_type;
            $updata['room_num'] = $room_num;
            $updata['space'] = $space;
            $updata['get_money'] = $get_money;
            $updata['edit_time'] = time();
            $updata['edit_user'] = $this->session['admin']['adminid'];
            $ret = HouseLeaseReport::updateAll($updata,['report_id'=>$report_id]);
            if ($ret) {
                echo json_encode(['code'=>200,'msg'=>'编辑成功']);exit;
            }
            echo json_encode(['code'=>-200,'msg'=>'编辑失败']);exit;
        } else {
            $model = new HouseLeaseReport();
            $model->house_id = $house_id;
            $model->seat_id = $seat_id;
            $model->house_type = $house_type;
            $model->room_num = $room_num;
            $model->space = $space;
            $model->get_money = $get_money;
            $model->add_time = time();
            $model->add_user = $this->session['admin']['adminid'];
            $model->year = date('Y');
            $model->month = date('n');
            $model->day = date('j');
            $ret = $model->save();
            if ($ret) {
                echo json_encode(['code'=>200,'msg'=>'新增成功']);exit;
            }
            echo json_encode(['code'=>-200,'msg'=>'新增失败']);exit;
        }
    }

    /**
     * ajax获取楼座信息
     * @Author   tml
     * @DateTime 2018-04-19
     * @return   [type]     [description]
     */
    public function actionAjaxGetSeat()
    {
        $parent_id = empty($this->post['parent_id']) ? 0 : $this->post['parent_id'];
        $list = $this->getHouseInfo($parent_id);
        echo json_encode(['code'=>200,'data'=>$list]);exit;
    }

    /**
     * ajax删除租赁记录
     * @Author   tml
     * @DateTime 2018-04-19
     * @return   [type]     [description]
     */
    public function actionAjaxDoDelReport()
    {
        $id = empty($this->post['id']) ? 0 : $this->post['id'];
        if (empty($id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $updata['is_del'] = 1;
        $updata['del_time'] = time();
        $updata['del_user'] = $this->session['admin']['adminid'];
        $ret = HouseLeaseReport::updateAll($updata,['report_id'=>$id]);
        if ($ret) {
            echo json_encode(['code'=>200,'msg'=>'删除成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'删除失败']);exit;
    }
}
