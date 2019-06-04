<?php
/**
 * User: qilin
 * Date: 2019/5/17
 * Time: 17:10
 */
namespace app\modules\admin\controllers;

use app\models\Admin\Blacklist;
use app\models\Admin\House;
use yii\data\Pagination;
use Yii;


/**
 * AdController implements the CRUD actions for Ad model.
 */
class BlacklistController extends CommonController
{
    /**
     * Lists all Ad models.
     * @return mixed
     */
    protected $post;
    protected $get;
    public $enableCsrfValidation = false;
    public function init(){
        $this->post = Yii::$app->request->post();
        $this->get = Yii::$app->request->get();
    }
    public function actionIndex()
    {
        $this->layout = "layout1";
        $model = new Blacklist();
        $query = $model->find()->select('b.*,h.housename')->alias('b')->leftJoin('house h','h.id = b.house_id');
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $pagination->setPageSize(15);
        $list = $query->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
        $house = House::find()->where(['parentId'=>0])->asArray()->all();
        return $this->render('index', [
            'list' => $list,
            'pagination'=>$pagination,
            'house'=>$house
        ]);
    }

    public function actionAdd(){
        $this->layout=false;
        $house = House::find()->where(['parentId'=>0])->asArray()->all();
        return $this->render('add',[
            'house'=>$house
        ]);
    }

    public function actionDoAdd(){

        $phone    = empty($this->post['phone']) ? '' : $this->post['phone'];
        $remark = empty($this->post['remark']) ? '' : $this->post['remark'];
        $house_id = empty($this->post['house_id']) ? '' : $this->post['house_id'];
        $time = time();
        $model = new Blacklist();
        $model->phone = $phone;
        $model->remark  = $remark;
        $model->add_time = $time;
        $model->house_id    = $house_id;
        $res = $model->save();
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }

    public function actionAjaxDel(){
        $op_id = empty($this->post['op_id']) ? 0 : $this->post['op_id'];
        $res = Blacklist::deleteAll(['id'=>$op_id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }
}