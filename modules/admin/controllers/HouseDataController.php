<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Admin\HouseData;
use app\models\Admin\HouseCharge;
use app\models\Admin\Renovation;
use yii\data\Pagination;

/**
 * HouseDataController implements the CRUD actions for HouseLease model.
 */
class HouseDataController extends CommonController
{
    public $enableCsrfValidation = false;
    protected $post;
    protected $get;
    protected $session;
    protected $house_ids;
    /**
     * 初始化
     **/
    public function init(){
        $this->post = Yii::$app->request->post();
        $this->get  = Yii::$app->request->get();
        $this->session = Yii::$app->session;
        $this->house_ids = empty($this->session['admin']['house_ids']) ? '' : $this->session['admin']['house_ids'];
    }

    /**
     * 房屋动态列表
     * @Author   tml
     * @DateTime 2018-04-21
     * @return   [type]     [description]
     */
    public function actionHouseDataList()
    {
        $this->layout = 'layout1';
        $query = (new \yii\db\Query())
            ->select('d.*,h1.housename as house_name,h2.housename as seat_name,a.adminuser as true_name')
            ->from('house_data d')
            ->leftJoin('house h1','d.house_id=h1.id')
            ->leftJoin('house h2','d.seat_id=h2.id')
            ->leftJoin('admin a','d.add_user=a.adminid')
            ->where(['d.is_del'=>0]);
        if (!empty($this->house_ids)) {
            $query = $query->andWhere(['in','d.house_id',explode(',',$this->house_ids)]);
        }
        $pagination = new Pagination(['totalCount'=>$query->count()]);
        $list = $query
            ->orderBy('d.add_time desc')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('house_data_list',[
            'list'=>$list,
            'pagination'=>$pagination
        ]);
    }

    /**
     * 新增房屋动态数据
     * @Author   tml
     * @DateTime 2018-04-21
     * @return   [type]     [description]
     */
    public function actionAddHouseData()
    {
        $this->layout = 'layout1';

        $id = empty($this->get['id']) ? 0 : $this->get['id'];

        $model = null;
        if ($id) {
            $model = HouseData::find()->where(['id'=>$id,'is_del'=>0])->asArray()->one();
        }

        $house = $this->getHouseInfo(0);
        if (!empty($this->house_ids)) {
            $house_arr = explode(',',$this->house_ids);
            foreach ($house as $k => $v) {
                if (!in_array($v['id'],$house_arr)) {
                    unset($house[$k]);
                }
            }
        }

        return $this->render('add_house_data',[
            'model'=>$model,
            'house'=>$house
        ]);
    }

    /**
     * ajax新增房屋动态数据
     * @Author   tml
     * @DateTime 2018-04-21
     * @return   [type]     [description]
     */
    public function actionAjaxAddHouseData()
    {
        $id = empty($this->post['id']) ? 0 : $this->post['id'];
        $house_id = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
        $seat_id = empty($this->post['seat_id']) ? 0 : $this->post['seat_id'];
        $house_type = empty($this->post['house_type']) ? 0 : $this->post['house_type'];
        $total_nums = empty($this->post['total_nums']) ? 0 : $this->post['total_nums'];
        $unsale_nums = empty($this->post['unsale_nums']) ? 0 : $this->post['unsale_nums'];
        $sale_nums = empty($this->post['sale_nums']) ? 0 : $this->post['sale_nums'];
        $unmatch_nums = empty($this->post['unmatch_nums']) ? 0 : $this->post['unmatch_nums'];
        $match_nums = empty($this->post['match_nums']) ? 0 : $this->post['match_nums'];
        $unalready_nums = empty($this->post['unalready_nums']) ? 0 : $this->post['unalready_nums'];
        $already_nums = empty($this->post['already_nums']) ? 0 : $this->post['already_nums'];
        $total_money = empty($this->post['total_money']) ? 0 : $this->post['total_money'];
        $real_money = empty($this->post['real_money']) ? 0 : $this->post['real_money'];
        $rent_live = empty($this->post['rent_live']) ? 0 : $this->post['rent_live'];
        $rent_office = empty($this->post['rent_office']) ? 0 : $this->post['rent_office'];
        $hotel = empty($this->post['hotel']) ? 0 : $this->post['hotel'];
        $dormitory = empty($this->post['dormitory']) ? 0 : $this->post['dormitory'];
        $self_office = empty($this->post['self_office']) ? 0 : $this->post['self_office'];
        $self_live = empty($this->post['self_live']) ? 0 : $this->post['self_live'];
        $vacant = empty($this->post['vacant']) ? 0 : $this->post['vacant'];

        $year = date('Y');
        $month = date('n');
        $day = date('j');

        if ($id) {
            $res = HouseData::find()->where(['house_id'=>$house_id,'seat_id'=>$seat_id,'house_type'=>$house_type,'is_del'=>0,'year'=>$year,'month'=>$month,'day'=>$day])->andWhere(['!=','id',$id])->count();
            // var_dump($res);exit;
            if ($res) {
                echo json_encode(['code'=>-200,'msg'=>'该项目数据今日已添加，不可重复提交']);exit;
            }
            $updata['house_id'] = $house_id;
            $updata['seat_id'] = $seat_id;
            $updata['house_type'] = $house_type;
            $updata['total_nums'] = $total_nums;
            $updata['unsale_nums'] = $unsale_nums;
            $updata['sale_nums'] = $sale_nums;
            $updata['unmatch_nums'] = $unmatch_nums;
            $updata['match_nums'] = $match_nums;
            $updata['unalready_nums'] = $unalready_nums;
            $updata['already_nums'] = $already_nums;
            $updata['total_money'] = $total_money;
            $updata['real_money'] = $real_money;
            $updata['rent_live'] = $rent_live;
            $updata['rent_office'] = $rent_office;
            $updata['hotel'] = $hotel;
            $updata['dormitory'] = $dormitory;
            $updata['self_office'] = $self_office;
            $updata['self_live'] = $self_live;
            $updata['vacant'] = $vacant;
            $updata['edit_time'] = time();
            $updata['edit_user'] = $this->session['admin']['adminid'];
            $ret = HouseData::updateAll($updata,['id'=>$id]);
            if ($ret) {
                echo json_encode(['code'=>200,'msg'=>'编辑成功']);exit;
            }
            echo json_encode(['code'=>-200,'msg'=>'编辑失败']);exit;
        } else {
            $res = HouseData::find()->where(['house_id'=>$house_id,'seat_id'=>$seat_id,'house_type'=>$house_type,'is_del'=>0,'year'=>$year,'month'=>$month,'day'=>$day])->count();
            if ($res) {
                echo json_encode(['code'=>-200,'msg'=>'该项目数据今日已添加，不可重复提交']);exit;
            }
            $model = new HouseData();
            $model->house_id = $house_id;
            $model->seat_id = $seat_id;
            $model->house_type = $house_type;
            $model->total_nums = $total_nums;
            $model->unsale_nums = $unsale_nums;
            $model->sale_nums = $sale_nums;
            $model->unmatch_nums = $unmatch_nums;
            $model->match_nums = $match_nums;
            $model->unalready_nums = $unalready_nums;
            $model->already_nums = $already_nums;
            $model->total_money = $total_money;
            $model->real_money = $real_money;
            $model->rent_live = $rent_live;
            $model->rent_office = $rent_office;
            $model->hotel = $hotel;
            $model->dormitory = $dormitory;
            $model->self_office = $self_office;
            $model->self_live = $self_live;
            $model->vacant = $vacant;
            $model->year = $year;
            $model->month = $month;
            $model->day = $day;
            $model->add_time = time();
            $model->add_user = $this->session['admin']['adminid'];
            $ret = $model->save();
            // var_dump($model->getErrors());exit;
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
     * ajax删除房屋动态数据
     * @Author   tml
     * @DateTime 2018-04-23
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
        $ret = HouseData::updateAll($updata,['id'=>$id]);
        if ($ret) {
            echo json_encode(['code'=>200,'msg'=>'删除成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'删除失败']);exit;
    }

    /**
     * 交付收费列表
     * @Author   tml
     * @DateTime 2018-04-25
     * @return   [type]     [description]
     */
    public function actionHouseChargeList()
    {
        $this->layout = 'layout1';
        $query = (new \yii\db\Query())
            ->select('c.*,h1.housename as house_name,h2.housename as seat_name,a.adminuser as true_name')
            ->from('house_charge c')
            ->leftJoin('house h1','c.house_id=h1.id')
            ->leftJoin('house h2','c.seat_id=h2.id')
            ->leftJoin('admin a','c.add_user=a.adminid')
            ->where(['c.is_del'=>0]);
        if (!empty($this->house_ids)) {
            $query = $query->andWhere(['in','c.house_id',explode(',',$this->house_ids)]);
        }
        $pagination = new Pagination(['totalCount'=>$query->count()]);
        $list = $query
            ->orderBy('c.add_time desc')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('house_charge_list',[
            'list'=>$list,
            'pagination'=>$pagination
        ]);
    }

    /**
     * 新增交付收费
     * @Author   tml
     * @DateTime 2018-04-25
     * @return   [type]     [description]
     */
    public function actionAddHouseCharge()
    {
        $this->layout = 'layout1';

        $id = empty($this->get['id']) ? 0 : $this->get['id'];

        $model = null;
        if ($id) {
            $model = HouseCharge::find()->where(['id'=>$id,'is_del'=>0])->asArray()->one();
        }

        $house = $this->getHouseInfo(0);
        if (!empty($this->house_ids)) {
            $house_arr = explode(',',$this->house_ids);
            foreach ($house as $k => $v) {
                if (!in_array($v['id'],$house_arr)) {
                    unset($house[$k]);
                }
            }
        }

        return $this->render('add_house_charge',[
            'model'=>$model,
            'house'=>$house
        ]);
    }

    /**
     * ajax新增交付收费
     * @Author   tml
     * @DateTime 2018-04-25
     * @return   [type]     [description]
     */
    public function actionAjaxAddHouseCharge()
    {
        $id = empty($this->post['id']) ? 0 : $this->post['id'];
        $house_id = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
        $seat_id = empty($this->post['seat_id']) ? 0 : $this->post['seat_id'];
        $house_type = empty($this->post['house_type']) ? 0 : $this->post['house_type'];
        $total_money = empty($this->post['total_money']) ? 0 : $this->post['total_money'];
        $get_money = empty($this->post['get_money']) ? 0 : $this->post['get_money'];
        $current_money = empty($this->post['current_money']) ? 0 : $this->post['current_money'];
        $unget_money = empty($this->post['unget_money']) ? 0 : $this->post['unget_money'];
        $total_nums = empty($this->post['total_nums']) ? 0 : $this->post['total_nums'];
        $get_nums = empty($this->post['get_nums']) ? 0 : $this->post['get_nums'];
        $current_nums = empty($this->post['current_nums']) ? 0 : $this->post['current_nums'];
        $unget_nums = empty($this->post['unget_nums']) ? 0 : $this->post['unget_nums'];

        $year = date('Y');
        $month = date('n');
        $day = date('j');

        if ($id) {
            $res = HouseCharge::find()->where(['house_id'=>$house_id,'seat_id'=>$seat_id,'house_type'=>$house_type,'is_del'=>0,'year'=>$year,'month'=>$month,'day'=>$day])->andWhere(['!=','id',$id])->count();
            if ($res) {
                echo json_encode(['code'=>-200,'msg'=>'该项目今日数据已添加，不可重复提交']);exit;
            }
            $updata['house_id'] = $house_id;
            $updata['seat_id'] = $seat_id;
            $updata['house_type'] = $house_type;
            $updata['total_money'] = $total_money;
            $updata['get_money'] = $get_money;
            $updata['current_money'] = $current_money;
            $updata['unget_money'] = $unget_money;
            $updata['total_nums'] = $total_nums;
            $updata['get_nums'] = $get_nums;
            $updata['current_nums'] = $current_nums;
            $updata['unget_nums'] = $unget_nums;
            $updata['edit_time'] = time();
            $updata['edit_user'] = $this->session['admin']['adminid'];
            $ret = HouseCharge::updateAll($updata,['id'=>$id]);
            if ($ret) {
                echo json_encode(['code'=>200,'msg'=>'编辑成功']);exit;
            }
            echo json_encode(['code'=>-200,'msg'=>'编辑失败']);exit;
        } else {
            $res = HouseCharge::find()->where(['house_id'=>$house_id,'seat_id'=>$seat_id,'house_type'=>$house_type,'is_del'=>0,'year'=>$year,'month'=>$month,'day'=>$day])->count();
            if ($res) {
                echo json_encode(['code'=>-200,'msg'=>'该项目今日数据已添加，不可重复提交']);exit;
            }
            $model = new HouseCharge();
            $model->house_id = $house_id;
            $model->seat_id = $seat_id;
            $model->house_type = $house_type;
            $model->total_money = $total_money;
            $model->get_money = $get_money;
            $model->current_money = $current_money;
            $model->unget_money = $unget_money;
            $model->total_nums = $total_nums;
            $model->get_nums = $get_nums;
            $model->current_nums = $current_nums;
            $model->unget_nums = $unget_nums;
            $model->year = $year;
            $model->month = $month;
            $model->day = $day;
            $model->add_time = time();
            $model->add_user = $this->session['admin']['adminid'];
            $ret = $model->save();
            // var_dump($model->getErrors());exit;
            if ($ret) {
                echo json_encode(['code'=>200,'msg'=>'新增成功']);exit;
            }
            echo json_encode(['code'=>-200,'msg'=>'新增失败']);exit;
        }
    }

    /**
     * ajax删除交付收费数据
     * @Author   tml
     * @DateTime 2018-04-27
     * @return   [type]     [description]
     */
    public function actionAjaxDoDelCharge()
    {
        $id = empty($this->post['id']) ? 0 : $this->post['id'];
        if (empty($id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $updata['is_del'] = 1;
        $updata['del_time'] = time();
        $updata['del_user'] = $this->session['admin']['adminid'];
        $ret = HouseCharge::updateAll($updata,['id'=>$id]);
        if ($ret) {
            echo json_encode(['code'=>200,'msg'=>'删除成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'删除失败']);exit;
    }


    /**
     * 装修办理列表
     * @Author   tml
     * @DateTime 2018-05-03
     * @return   [type]     [description]
     */
    public function actionRenovation()
    {
        $this->layout = 'layout1';
        $query = (new \yii\db\Query())
            ->select('r.*,h1.housename as house_name,h2.housename as seat_name,a.adminuser as true_name')
            ->from('renovation r')
            ->leftJoin('house h1','r.house_id=h1.id')
            ->leftJoin('house h2','r.seat_id=h2.id')
            ->leftJoin('admin a','r.add_user=a.adminid')
            ->where(['r.is_del'=>0]);
        if (!empty($this->house_ids)) {
            $query = $query->andWhere(['in','r.house_id',explode(',',$this->house_ids)]);
        }
        $pagination = new Pagination(['totalCount'=>$query->count()]);
        $list = $query
            ->orderBy('r.add_time desc')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        if ($list) {
            foreach ($list as $k => $v) {
                $total_nums = HouseData::find()->select('total_nums')->where(['is_del'=>0,'house_id'=>$v['house_id'],'seat_id'=>$v['seat_id'],'house_type'=>$v['house_type']])->orderBy('add_time desc')->scalar();
                if ($total_nums) {
                    $list[$k]['zxl'] = round(($v['check_nums']/$total_nums*100),2).'%';
                } else {
                    $list[$k]['zxl'] = '--';
                }
            }
        }
        return $this->render('renovation',[
            'list'=>$list,
            'pagination'=>$pagination
        ]);
    }

    /**
     * 新增交付收费
     * @Author   tml
     * @DateTime 2018-04-25
     * @return   [type]     [description]
     */
    public function actionAddRenovation()
    {
        $this->layout = 'layout1';

        $id = empty($this->get['id']) ? 0 : $this->get['id'];

        $model = null;
        if ($id) {
            $model = Renovation::find()->where(['id'=>$id,'is_del'=>0])->asArray()->one();
        }

        $house = $this->getHouseInfo(0);
        if (!empty($this->house_ids)) {
            $house_arr = explode(',',$this->house_ids);
            foreach ($house as $k => $v) {
                if (!in_array($v['id'],$house_arr)) {
                    unset($house[$k]);
                }
            }
        }

        return $this->render('add_renovation',[
            'model'=>$model,
            'house'=>$house
        ]);
    }

    /**
     * ajax新增交付收费
     * @Author   tml
     * @DateTime 2018-04-25
     * @return   [type]     [description]
     */
    public function actionAjaxAddRenovation()
    {
        $id = empty($this->post['id']) ? 0 : $this->post['id'];
        $house_id = empty($this->post['house_id']) ? 0 : $this->post['house_id'];
        $seat_id = empty($this->post['seat_id']) ? 0 : $this->post['seat_id'];
        $house_type = empty($this->post['house_type']) ? 0 : $this->post['house_type'];
        $renovation_nums = empty($this->post['renovation_nums']) ? 0 : $this->post['renovation_nums'];
        $check_nums = empty($this->post['check_nums']) ? 0 : $this->post['check_nums'];
        $return_nums = empty($this->post['return_nums']) ? 0 : $this->post['return_nums'];
        $nowing_nums = empty($this->post['nowing_nums']) ? 0 : $this->post['nowing_nums'];
        $current_nums = empty($this->post['current_nums']) ? 0 : $this->post['current_nums'];

        $year = date('Y');
        $month = date('n');
        $day = date('j');

        if ($id) {
            $res = Renovation::find()->where(['house_id'=>$house_id,'seat_id'=>$seat_id,'house_type'=>$house_type,'is_del'=>0,'year'=>$year,'month'=>$month,'day'=>$day])->andWhere(['!=','id',$id])->count();
            if ($res) {
                echo json_encode(['code'=>-200,'msg'=>'该项目今日数据已添加，不可重复提交']);exit;
            }
            $updata['house_id'] = $house_id;
            $updata['seat_id'] = $seat_id;
            $updata['house_type'] = $house_type;
            $updata['renovation_nums'] = $renovation_nums;
            $updata['check_nums'] = $check_nums;
            $updata['return_nums'] = $return_nums;
            $updata['nowing_nums'] = $nowing_nums;
            $updata['current_nums'] = $current_nums;
            $updata['edit_time'] = time();
            $updata['edit_user'] = $this->session['admin']['adminid'];
            $ret = Renovation::updateAll($updata,['id'=>$id]);
            if ($ret) {
                echo json_encode(['code'=>200,'msg'=>'编辑成功']);exit;
            }
            echo json_encode(['code'=>-200,'msg'=>'编辑失败']);exit;
        } else {
            $res = Renovation::find()->where(['house_id'=>$house_id,'seat_id'=>$seat_id,'house_type'=>$house_type,'is_del'=>0,'year'=>$year,'month'=>$month,'day'=>$day])->count();
            if ($res) {
                echo json_encode(['code'=>-200,'msg'=>'该项目今日数据已添加，不可重复提交']);exit;
            }
            $model = new Renovation();
            $model->house_id = $house_id;
            $model->seat_id = $seat_id;
            $model->house_type = $house_type;
            $model->renovation_nums = $renovation_nums;
            $model->check_nums = $check_nums;
            $model->return_nums = $return_nums;
            $model->nowing_nums = $nowing_nums;
            $model->current_nums = $current_nums;
            $model->year = $year;
            $model->month = $month;
            $model->day = $day;
            $model->add_time = time();
            $model->add_user = $this->session['admin']['adminid'];
            $ret = $model->save();
            // var_dump($model->getErrors());exit;
            if ($ret) {
                echo json_encode(['code'=>200,'msg'=>'新增成功']);exit;
            }
            echo json_encode(['code'=>-200,'msg'=>'新增失败']);exit;
        }
    }

    /**
     * ajax删除交付收费数据
     * @Author   tml
     * @DateTime 2018-04-27
     * @return   [type]     [description]
     */
    public function actionAjaxDoDelRenovation()
    {
        $id = empty($this->post['id']) ? 0 : $this->post['id'];
        if (empty($id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $updata['is_del'] = 1;
        $updata['del_time'] = time();
        $updata['del_user'] = $this->session['admin']['adminid'];
        $ret = Renovation::updateAll($updata,['id'=>$id]);
        if ($ret) {
            echo json_encode(['code'=>200,'msg'=>'删除成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'删除失败']);exit;
    }
}
