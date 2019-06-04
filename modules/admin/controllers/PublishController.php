<?php

namespace app\modules\admin\controllers;

use app\models\Admin\Admin;
use app\models\Admin\Decoration;
use app\models\Admin\House;
use app\models\Admin\HouseImg;
use app\models\Admin\Orientation;
use app\models\Admin\Region;
use app\models\Admin\Subway;
use Yii;
use app\models\Admin\Publish;
use app\models\Admin\PublishSearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PublishController implements the CRUD actions for Publish model.
 */
class PublishController extends CommonController
{

    /**
     * Lists all Publish models.
     * @return mixed
     */
    public function actionIndex1()
    {
        $this->layout = "layout1";
        $jquery = Publish::find()->where(['is_del'=>0]);
        $count = $jquery->count();
        $pagination = new Pagination(['totalCount'=>$count,'pageSize'=>4]);
        $list = $jquery
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();
        return $this->render('index', [
            'list'=>$list,
            'pagination'=>$pagination
        ]);
    }

    /**
     * Displays a single Publish model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = "layout1";
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Publish model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new Publish();
        $house = House::find()->where(['parentId'=>0])->asArray()->all();
        $region = new Region();
        $region_id = $region->getOptions();
        $subway = new Subway();
        $subway_id = $subway->getOptions();
        $decoration = Decoration::find()->asArray()->all();
        $orientation = Orientation::find()->asArray()->all();
        $house_type = array(
            array('id'=>1,'house_type'=>'写字楼'),
            array('id'=>2,'house_type'=>'公寓'),
            array('id'=>3,'house_type'=>'商铺')
        );
        $session = \Yii::$app->session;
        $user = Admin::find()->where(['adminuser'=>$session['admin']['adminuser']])->asArray()->one();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model->house_type = $post['Publish']['house_type'];
            $model->unit = $post['Publish']['unit'];
            $model->house_id = $post['Publish']['house_id'];
            $model->region_id = $post['Publish']['region_id'];
            $model->subway_id = $post['Publish']['subway_id'];
            $model->price = $post['Publish']['price'];
            $model->space = $post['Publish']['space'];
            $model->age = $post['Publish']['age'];
            $model->floor = $post['Publish']['floor'];
            $model->deco_id = $post['Publish']['deco_id'];
            $model->orien_id = $post['Publish']['orien_id'];
            $model->house_desc = $post['Publish']['house_desc'];
            $model->address = $post['Publish']['address'];
            $model->person = $post['Publish']['person'];
            $model->person_tel = $post['Publish']['person_tel'];
            $model->publish_time = time();
            $model->publish_user = $user['adminid'];
            $model->status = 1;
            if($model->load($model) || $model->save()){
                return $this->redirect(['view', 'id' => $model->publish_id]);
            }else{
                var_dump($model->getErrors());
                exit;
            }
        }
        return $this->render('create', [
            'model' => $model,
            'house'=>$house,
            'region_id'=>$region_id,
            'subway_id'=>$subway_id,
            'decoration'=>$decoration,
            'orientation'=>$orientation,
            'house_type'=>$house_type,
        ]);
    }

    /**
     * Updates an existing Publish model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);
        $house = House::find()->where(['parentId'=>0])->asArray()->all();
        $region = new Region();
        $region_id = $region->getOptions();
        $subway = new Subway();
        $subway_id = $subway->getOptions();
        $decoration = Decoration::find()->asArray()->all();
        $orientation = Orientation::find()->asArray()->all();
        $house_type = array(
            array('id'=>1,'house_type'=>'写字楼'),
            array('id'=>2,'house_type'=>'公寓'),
            array('id'=>3,'house_type'=>'商铺')
        );
        $session = \Yii::$app->session;
        $user = Admin::find()->where(['adminuser'=>$session['admin']['adminuser']])->asArray()->one();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model->house_type = $post['Publish']['house_type'];
            $model->unit = $post['Publish']['unit'];
            $model->house_id = $post['Publish']['house_id'];
            $model->region_id = $post['Publish']['region_id'];
            $model->subway_id = $post['Publish']['subway_id'];
            $model->price = $post['Publish']['price'];
            $model->space = $post['Publish']['space'];
            $model->age = $post['Publish']['age'];
            $model->floor = $post['Publish']['floor'];
            $model->deco_id = $post['Publish']['deco_id'];
            $model->orien_id = $post['Publish']['orien_id'];
            $model->house_desc = $post['Publish']['house_desc'];
            $model->address = $post['Publish']['address'];
            $model->person = $post['Publish']['person'];
            $model->person_tel = $post['Publish']['person_tel'];
            $model->publish_time = time();
            $model->publish_user = $user['adminid'];
            $model->status = 1;
            if($model->load($model) || $model->save()){
                return $this->redirect(['view', 'id' => $model->publish_id]);
            }else{
                var_dump($model->getErrors());
                exit;
            }
        }
        return $this->render('update', [
            'model' => $model,
            'house'=>$house,
            'region_id'=>$region_id,
            'subway_id'=>$subway_id,
            'decoration'=>$decoration,
            'orientation'=>$orientation,
            'house_type'=>$house_type
        ]);
    }

    /**
     * Deletes an existing Publish model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAjaxDelete(){
        $id = Yii::$app->request->get('cid');
        $del = Publish::updateAll(['is_del'=>1],['publish_id'=>$id]);
        if($del){
            echo json_encode(array('status'=>200,'message'=>'删除成功！'));
            exit;
        }else{
            echo json_encode(array('status'=>-200,'message'=>'删除失败！'));
            exit;
        }
    }
    // 1.下架成功!
    public function actionAjaxStatus(){
        $id = Yii::$app->request->get('cid');
        $del = Publish::updateAll(['status'=>2],['publish_id'=>$id]);
        if($del){
            echo json_encode(array('status'=>200,'message'=>'下架成功！'));
            exit;
        }else{
            echo json_encode(array('status'=>-200,'message'=>'下架失败！'));
            exit;
        }
    }

    /**
     * Finds the Publish model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Publish the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Publish::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    /**
     * 房屋租赁列表
     * @Author   tml
     * @DateTime 2018-03-26
     * @return   [type]     [description]
     */
    public function actionIndex()
    {
        $this->layout = 'layout1';
        $get = Yii::$app->request->get();
        $house_id = empty($get['house_id']) ? 0 : $get['house_id'];
        $house_type = empty($get['house_type']) ? 0 : $get['house_type'];
        $con['is_del'] = 0;
        if (!empty($house_id)) {
            $con['house_id'] = $house_id;
        }
        if (!empty($house_type)) {
            $con['house_type'] = $house_type;
        }
        $query = (new \yii\db\Query())
            ->select('p.*,h.housename as house_name,r1.region_name,r2.region_name as region_pname,s1.subway_name,s2.subway_name as subway_pname')
            ->from('house_publish p')
            ->leftJoin('house h','p.house_id=h.id')
            ->leftJoin('app_region r1','r1.region_id=p.region_id')
            ->leftJoin('app_region r2','r2.region_id=r1.parent_id')
            ->leftJoin('app_subway s1','s1.subway_id=p.subway_id')
            ->leftJoin('app_subway s2','s2.subway_id=s1.parent_id')
            ->where($con);
        $count      = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $list       = $query
            ->orderBy('p.publish_time desc')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $house  = House::find()->where(['parentId'=>0])->asArray()->all();
        return $this->render('publish_list',array(
            'list'=>$list,
            'pagination'=>$pagination,
            'house'=>$house
        ));
    }

    /**
     * 添加修改房屋租赁
     * @Author   tml
     * @DateTime 2018-03-26
     * @param    [type]     $id [description]
     * @return   [type]         [description]
     */
    public function actionPublish()
    {
        $this->layout = 'layout1';

        $id = empty(Yii::$app->request->get()['id']) ? 0 : Yii::$app->request->get()['id'];

        $model = null;
        $house_imgs = null;
        if (!empty($id)) {
            $model = Publish::find()->where(['publish_id'=>$id])->one();
            $house_imgs = HouseImg::find()->where(['publish_id'=>$id])->asArray()->all();
        }

        $house  = House::find()->where(['parentId'=>0])->asArray()->all();
        $region = (new Region())->getTreeList();
        $subway = (new Subway())->getTreeList();
        $deco   = Decoration::find()->asArray()->all();
        $orien  = Orientation::find()->asArray()->all();

        return $this->render('publish',array(
            'model'=>$model,
            'house'=>$house,
            'region'=>$region,
            'subway'=>$subway,
            'deco'=>$deco,
            'orien'=>$orien,
            'house_imgs'=>$house_imgs
        ));
    }

    /**
     * 发布房屋租赁信息
     * @Author   tml
     * @DateTime 2018-03-26
     * @return   [type]     [description]
     */
    public function actionDoPublish()
    {
        $post = Yii::$app->request->post();
        $data = empty($post['data']) ? [] : $post['data'];
        $data['house_desc'] = htmlspecialchars($data['house_desc']);
        $house_imgs = empty($post['house_imgs']) ? [] : $post['house_imgs'];
        if ($data) {
            $publish_id = empty($data['publish_id']) ? 0 : $data['publish_id'];
            $model = new Publish();
            $model->setAttributes($data);
            if ($model->validate()) {
                if (!empty($publish_id)) {
                    $data['edit_time'] = time();
                    $data['edit_user'] = Yii::$app->session['admin']['adminid'];
                    $res = Publish::updateAll($data,['publish_id'=>$publish_id]);
                    if ($res) {
                        $this->addHouseImgs($publish_id,$house_imgs);
                        echo json_encode(['code'=>200,'msg'=>'房屋租赁信息编辑成功']);exit;
                    }
                    echo json_encode(['code'=>-200,'msg'=>'房屋租赁信息编辑失败']);exit;
                } else {
                    $model->publish_time = time();
                    $model->publish_user = Yii::$app->session['admin']['adminid'];
                    $res = $model->save();
                    if ($res) {
                        $this->addHouseImgs($model['publish_id'],$house_imgs);
                        echo json_encode(['code'=>200,'msg'=>'房屋租赁信息添加成功']);exit;
                    }
                    echo json_encode(['code'=>-200,'msg'=>'房屋租赁信息添加失败']);exit;
                }
            }
            echo json_encode(['code'=>-200,'msg'=>'验证未通过,请检验提交信息的正确性','data'=>$model->getErrors()]);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
    }

    /**
     * 添加房屋图片
     * @Author   tml
     * @DateTime 2018-03-27
     * @param    [type]     $imgs [description]
     */
    public function addHouseImgs($publish_id,$imgs)
    {
        HouseImg::deleteAll(['publish_id'=>$publish_id]);
        $data = [];
        if($imgs) {
            foreach ($imgs as $v) {
                $data[] = [$publish_id,$v];
            }
            $res = Yii::$app->db->createCommand()->batchInsert(HouseImg::tableName(), ['publish_id','img_path'], $data)->execute();
            return $res;
        }
        return 0;
        
    }

    /**
     * 房屋租赁删除操作
     * @Author   tml
     * @DateTime 2018-03-27
     * @return   [type]     [description]
     */
    public function actionDoDelPublish()
    {
        $publish_id = empty(Yii::$app->request->post()['id']) ? 0 : Yii::$app->request->post()['id'];
        if (empty($publish_id)) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $res = Publish::updateAll(['is_del'=>1],['publish_id'=>$publish_id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'删除成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'删除失败']);exit;
    }

    /**
     * 房屋租赁更新上下架状态操作
     * @Author   tml
     * @DateTime 2018-03-27
     * @return   [type]     [description]
     */
    public function actionDoUpstatusPublish()
    {
        $post = Yii::$app->request->post();
        $publish_id = empty($post['id']) ? 0 : $post['id'];
        $status = empty($post['status']) ? 0 : $post['status'];
        if (empty($publish_id) || empty($status) || !in_array($status,[1,2])) {
            echo json_encode(['code'=>-200,'msg'=>'参数错误']);exit;
        }
        $res = Publish::updateAll(['status'=>$status],['publish_id'=>$publish_id]);
        if ($res) {
            echo json_encode(['code'=>200,'msg'=>'操作成功']);exit;
        }
        echo json_encode(['code'=>-200,'msg'=>'操作失败']);exit;
    }
}
