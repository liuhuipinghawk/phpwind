<?php

namespace app\modules\admin\controllers;

use app\models\Admin\House;
use app\models\Admin\ServiceOrder;
use app\models\Area;
use app\models\Baspeak;
use app\models\Equipment;
use app\models\FlowerCategory;
use app\models\FlowerForm;
use app\models\Furniture;
use app\models\Implication;
use app\models\Plants;
use app\models\Position;
use app\models\Pot;
use Yii;
use app\models\Flower;
use app\models\FlowerSearch;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * FlowerController implements the CRUD actions for Flower model.
 */
class FlowerController extends CommonController
{

    /**
     * Lists all Flower models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new FlowerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Flower model.
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
     * Creates a new Flower model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new Flower();
        $data = new FlowerCategory();
        $cate = $data->getOptions();
        $plants = Plants::find()->asArray()->all();
        $pot = Pot::find()->asArray()->all();
        $implication = Implication::find()->asArray()->all();
        $area = Area::find()->asArray()->all();
        $position = Position::find()->asArray()->all();
        $m = new House();
        $house = $m->find()->where(['parentId'=>0])->all();
        $thumb = new FlowerForm();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $thumb->imageFile = UploadedFile::getInstance($model,'thumb');
            if($thumb->upload()){
                $model->thumb = "/uploads/flower/".$thumb->imageFile->name;
                $model->flower_name = $post['Flower']['flower_name'];
                $model->another_name = $post['Flower']['another_name'];
                $model->pid = $post['Flower']['pid'];
                $model->house_id = $post['Flower']['house_id'];
                if(!empty($post['Flower']['effect_plants'])){
                    $model->effect_plants = implode(',',$post['Flower']['effect_plants']);
                }else{
                    $model->effect_plants = "";
                }
                if(!empty($post['Flower']['Pot_type'])){
                    $model->Pot_type = implode(',',$post['Flower']['Pot_type']);
                }else{
                    $model->Pot_type = "";
                }
                if(!empty($post['Flower']['green_implication'])){
                    $model->green_implication = implode(',',$post['Flower']['green_implication']);
                }else{
                    $model->green_implication = "";
                }
                if(!empty($post['Flower']['covering_area'])){
                    $model->covering_area = implode(',',$post['Flower']['covering_area']);
                }else{
                    $model->covering_area ="";
                }
                if(!empty($post['Flower']['position'])){
                    $model->position = implode(',',$post['Flower']['position']);
                }else{
                    $model->position = "";
                }
                //$model->effect_plants = implode(',',$post['Flower']['effect_plants']);
                //$model->Pot_type = implode(',',$post['Flower']['Pot_type']);
                //$model->green_implication = implode(',',$post['Flower']['green_implication']);
                //$model->covering_area = implode(',',$post['Flower']['covering_area']);
                //$model->position = implode(',',$post['Flower']['position']);

                $model->price = $post['Flower']['price'];
                $model->content = $post['Flower']['content'];
                $model->flower_desc = $post['Flower']['flower_desc'];
                $model->business_telephone = $post['Flower']['business_telephone'];
                $model->create_time = time();
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->flower_id]);
                    }
                    return false;
                }else{
                    var_dump($model->getErrors());
                    exit;
                }
                return false;
            }
        }
        return $this->render('create', [
            'model' => $model,
            'data'=>$cate,
            'plants'=>$plants,
            'pot'=>$pot,
            'implication'=>$implication,
            'area'=>$area,
            'position'=>$position,
            'house'=>$house,
        ]);
    }

    /**
     * Updates an existing Flower model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);
        if(!empty($model->effect_plants)){
            $effect_plants = $model->effect_plants;
            $arr_effect_plants = explode(',',$effect_plants);
            $model->effect_plants = $arr_effect_plants;
        }
        if(!empty($model->Pot_type)){
            $pot_type = $model->Pot_type;
            $arr_pot_type = explode(',',$pot_type);
            $model->Pot_type = $arr_pot_type;
        }
        if(!empty($model->green_implication)){
            $green_implication = $model->green_implication;
            $arr_green_implication = explode(',',$green_implication);
            $model->green_implication = $arr_green_implication;
        }
        if(!empty($model->covering_area)){
            $covering_area = $model->covering_area;
            $arr_overing_area = explode(',',$covering_area);
            $model->covering_area = $arr_overing_area;
        }
        if(!empty($model->position)){
            $position = $model->position;
            $arr_position = explode(',',$position);
            $model->position = $arr_position;
        }
        $data = new FlowerCategory();
        $cate = $data->getOptions();
        $plants = Plants::find()->asArray()->all();
        $pot = Pot::find()->asArray()->all();
        $implication = Implication::find()->asArray()->all();
        $area = Area::find()->asArray()->all();
        $position = Position::find()->asArray()->all();
        $thumb = new FlowerForm();
        $m = new House();
        $house = $m->find()->where(['parentId'=>0])->all();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $thumb->imageFile = UploadedFile::getInstance($model,'thumb');
            if($thumb->imageFile==null){
                //$model->thumb = "uploads/flower/".$thumb->imageFile->name;
                $model->flower_name = $post['Flower']['flower_name'];
                $model->another_name = $post['Flower']['another_name'];
                $model->effect_plants = implode(',',$post['Flower']['effect_plants']);
                $model->Pot_type = implode(',',$post['Flower']['Pot_type']);
                $model->green_implication = implode(',',$post['Flower']['green_implication']);
                $model->covering_area = implode(',',$post['Flower']['covering_area']);
                $model->position = implode(',',$post['Flower']['position']);
                $model->price = $post['Flower']['price'];
                $model->content = $post['Flower']['content'];
                $model->flower_desc = $post['Flower']['flower_desc'];
                $model->create_time = time();
                $model->house_id = $post['Flower']['house_id'];
                $model->business_telephone = $post['Flower']['business_telephone'];
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        return $this->redirect(['view', 'id' => $model->flower_id]);
                    }
                    return false;
                }
                return false;
            }else{
                if($thumb->upload()){
                    $model->thumb = "/uploads/flower/".$thumb->imageFile->name;
                    $model->flower_name = $post['Flower']['flower_name'];
                    $model->another_name = $post['Flower']['another_name'];
                    $model->effect_plants = implode(',',$post['Flower']['effect_plants']);
                    $model->Pot_type = implode(',',$post['Flower']['Pot_type']);
                    $model->green_implication = implode(',',$post['Flower']['green_implication']);
                    $model->covering_area = implode(',',$post['Flower']['covering_area']);
                    $model->position = implode(',',$post['Flower']['position']);
                    $model->price = $post['Flower']['price'];
                    $model->content = $post['Flower']['content'];
                    $model->flower_desc = $post['Flower']['flower_desc'];
                    $model->create_time = time();
                    $model->house_id = $post['Flower']['house_id'];
                    if($model->load($model) || $model->validate()){
                        if($model->save(false)){
                            return $this->redirect(['view', 'id' => $model->flower_id]);
                        }
                        return false;
                    }
                    return false;
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'data'=>$cate,
            'plants'=>$plants,
            'pot'=>$pot,
            'implication'=>$implication,
            'area'=>$area,
            'position'=>$position,
            'house'=>$house,
        ]);
    }

    /**
     * Deletes an existing Flower model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Flower model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Flower the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Flower::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     *室内保洁预约
     */
    public function actionFlowerPaspeak(){
        $this->layout="layout1";

        $service_order = ServiceOrder::find();
        $list = $service_order->asArray()->all();
        foreach ($list as $val){
            //预约服务类型，1：洗衣服务；2：公司注册；3：直饮水；4：石材养护；5：室内清洁；6：甲醛治理；7：洗车服务 8: 办公设备 9: 办公家具 10: 花卉租赁
            if($val['order_type'] == 8){
                $vals = Equipment::find()->where(array('equipment_id'=>$val['type_id']))->asArray()->all();
            }elseif ($val['order_type'] == 9){
                $list_office = Furniture::find()->where(array('furniture_id'=>$val['type_id']))->asArray()->all();
            }elseif ($val['order_type'] == 10){
                $flower = Flower::find()->where(array('flower_id'=>$val['type_id']))->asArray()->all();
            }
            var_dump($flower);
        }
        exit;

        /**$project_name = empty(Yii::$app->request->get()['project_name']) ? '' : Yii::$app->request->get()['project_name'];
        $tell = empty(Yii::$app->request->get()['tell']) ? '' : Yii::$app->request->get()['tell'];
        $persion = empty(Yii::$app->request->get()['persion']) ? '' : Yii::$app->request->get()['persion'];
        $price = empty(Yii::$app->request->get()['price']) ? '' : Yii::$app->request->get()['price'];
        $state      = empty(Yii::$app->request->get()['state']) ? 0 : Yii::$app->request->get()['state'];
        $conn['state'] = 1;
        $list = Baspeak::find()->where($conn);
        if(!empty($project_name)){
            $list = $list->andWhere(['like','project_name',$project_name]);
        }
        if(!empty($tell)){
            $list = $list->andWhere(['like','tell',$tell]);
        }
        if(!empty($persion)){
            $list = $list->andWhere(['like','persion',$persion]);
        }
        if(!empty($price)){
            $list = $list->andWhere(['like','price',$price]);
        }
        if(!empty($state)){
            $conn['state'] = $state;
        }
        $pages = new Pagination(['totalCount'=>$list->count(),'pageSize' => '9']);
        $model =$list->offset($pages->offset)->limit($pages->limit)->orderBy('baspeak_time desc')->asArray()->all();
        return $this->render('paspeak',[
            'model' => $model,
            'pages'=>$pages,
        ]);**/
    }
    /**
     *同行区域认证
     */
    public function actionAjaxConfirm(){
        if(Yii::$app->request->isAjax){
            $id = Yii::$app->request->get('id');
            $cerfication = Baspeak::updateAll(['state'=>2,'end_time'=>time()],['baspeak_id'=>$id]);
            if($cerfication){
                echo json_encode(['code'=>[],'status'=>200,'message'=>'预约信息回访成功!!']);exit;
            }else{
                echo json_encode([
                    'code'=>[],
                    'status'=>404,
                    'message'=>'预约信息已回访！'
                ]);
                exit;
            }
        }
    }

}
