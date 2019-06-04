<?php

namespace app\modules\admin\controllers;

use app\models\Admin\House;
use Yii;
use app\models\Admin\WaterBase;
use app\models\Admin\WaterBaseSearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WaterBaseController implements the CRUD actions for WaterBase model.
 */
class WaterBaseController extends CommonController
{

    /**
     * Lists all WaterBase models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'layout1';
        $owner_name = empty(Yii::$app->request->get()['owner_name']) ? '' : Yii::$app->request->get()['owner_name'];
        $room_num = empty(Yii::$app->request->get()['room_num']) ? '' : Yii::$app->request->get()['room_num'];
        $water_type     = empty(Yii::$app->request->get()['water_type']) ? "" : Yii::$app->request->get()['water_type'];
        $house_id = empty(Yii::$app->request->get()['house_id']) ? 0 : Yii::$app->request->get()['house_id'];
        $session = \Yii::$app->session;
        $list = explode(',',$session['admin']['house_ids']);
        $jquery = WaterBase::find()->select('water_base.id,water_base.*,house.housename as house_name,has.housename as seat_name')->join('LEFT JOIN','house','house.id = water_base.house_id')->join('LEFT JOIN','house as has','has.id = water_base.seat_id');
//        $data = array('in','water_type',array('0','1','2'));
        $data = array('water_base.status'=>1);
        $jquery = $jquery->where($data)->andWhere(['in','house_id',$list]);
        if (!empty($house_id)) {
            $jquery = $jquery->andWhere(['water_base.house_id'=>$house_id]);
        }
        if(!empty($owner_name)){
            $jquery = $jquery->andWhere(['like','owner_name',$owner_name]);
        }
        if(!empty($room_num)){
            $jquery = $jquery->andWhere(['like','room_num',$room_num]);
        }
        if(!empty($water_type)){
            if($water_type == 3){
                $water_type = 0;
            }
            $jquery = $jquery->andWhere(['water_type'=>$water_type]);
        }
        $count = $jquery->count();
        $pagination = new Pagination(['totalCount'=>$count],10);
        $list = $jquery
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->orderBy('water_base.id desc')
            ->asArray()
            ->all();
        $house = House::find()->where(['parentId'=>0])->asArray()->all();
        return $this->render('index',[
            'list'=>$list,
            'pagination'=>$pagination,
            'house'=>$house,
        ]);
    }

    /**
     * Displays a single WaterBase model.
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
     * Creates a new WaterBase model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $model = new WaterBase();
        $house = House::find()->where(array('parentId'=>0))->asArray()->all();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model->house_id = $post['WaterBase']['house_id'];
            $model->seat_id = $post['WaterBase']['seat_id'];
            $model->room_num = $post['WaterBase']['room_num'];
            $model->owner_name = $post['WaterBase']['owner_name'];
            $model->meter_number = $post['WaterBase']['meter_number'];
            $model->monovalent = $post['WaterBase']['monovalent'];
            $model->this_month = $post['WaterBase']['this_month'];
            $model->end_month = $post['WaterBase']['end_month'];
            $model->month_dosage = $post['WaterBase']['month_dosage'];
            $model->month_amount = $post['WaterBase']['month_amount'];
            $model->create_time = time();
            if($model->load($model) || $model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                var_dump($model->getErrors());
                exit;
            }
        }else{
            return $this->render('create', [
                'model' => $model,
                'house'=>$house
            ]);
        }
    }
    /**
     * Updates an existing WaterBase model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);
        $house = House::find()->where(array('parentId'=>0))->asArray()->all();
        $seat  = House::find()->where(['parentId'=>$model['house_id']])->asArray()->all();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $model->house_id = $post['WaterBase']['house_id'];
            $model->seat_id = $post['WaterBase']['seat_id'];
            $model->room_num = $post['WaterBase']['room_num'];
            $model->owner_name = $post['WaterBase']['owner_name'];
            $model->meter_number = $post['WaterBase']['meter_number'];
            $model->monovalent = $post['WaterBase']['monovalent'];
            $model->this_month = $post['WaterBase']['this_month'];
            $model->end_month = $post['WaterBase']['end_month'];
            $model->month_dosage = $post['WaterBase']['month_dosage'];
            $model->month_amount = $post['WaterBase']['month_amount'];
            $model->create_time = time();
            if($model->load($model) || $model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                var_dump($model->getErrors());
                exit;
            }
        }else{
            return $this->render('update', [
                'model' => $model,
                'house'=>$house,
                'seat'=>$seat
            ]);
        }
    }

    public function actionAjaxImportExcel(){
        $post = Yii::$app->request->post();
        $path = empty($post['path']) ? '' : $post['path'];
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
            for ($i=2; $i <= $rows; $i++) { 
                $cellA = $sheet->getCell('A'.$i)->getCalculatedValue();
                $cellB = $sheet->getCell('B'.$i)->getCalculatedValue();
                $cellC = $sheet->getCell('C'.$i)->getCalculatedValue();
                $cellD = $sheet->getCell('D'.$i)->getCalculatedValue();
                $cellE = $sheet->getCell('E'.$i)->getCalculatedValue();
                $cellF = $sheet->getCell('F'.$i)->getCalculatedValue();
                $cellG = $sheet->getCell('G'.$i)->getCalculatedValue();
                $cellH = $sheet->getCell('H'.$i)->getCalculatedValue();
                $cellI = $sheet->getCell('I'.$i)->getCalculatedValue();
                $cellJ = $sheet->getCell('J'.$i)->getCalculatedValue();
                if ($cellA && $cellB && $cellC && $cellD && $cellE && $cellF && count($cellG) && count($cellH) && count($cellI) && count($cellJ)) {
                    $item = [];
                    $item['house_id'] = $cellA;
                    $item['seat_id'] = $cellB;
                    $item['room_num'] = (string)$cellC;
                    $item['meter_number'] = (string)$cellD;
                    $item['owner_name'] = (string)$cellE;
                    $item['monovalent'] = (string)$cellF;
                    $item['this_month'] = (string)$cellG;
                    $item['end_month'] = (string)$cellH;
                    $item['month_dosage'] = (string)$cellI;
                    $item['month_amount'] = (string)$cellJ;
                    $data[] = $item;
                } else if (!$cellA && !$cellB && !$cellC && !$cellD && !$cellE && !$cellF && !$cellG && !$cellH && !$cellI && !$cellJ) {
                    break;
                } else {
                    $fail++;
                    $item = [];
                    $item['house_id'] = $cellA;
                    $item['seat_id']  =$cellB;
                    $item['room_num'] = (string)$cellC;
                    $item['meter_number']   = (string)$cellD;
                    $item['owner_name'] = $cellE;
                    $item['monovalent']    = $cellF;
                    $item['this_month']  = (string)$cellG;
                    $item['end_month']   = (string)$cellH;
                    $item['month_dosage']  = (string)$cellI;
                    $item['month_amount']  = $cellJ;
                    $item['error']      = '信息缺失';
                    $data_error[] = $item;
                }
            }
            if (count($data) > 0) {
                $stime = strtotime(date('Y-m-01',time()));
                $etime = strtotime(date('Y-m-t',time()).'23:59:59');
                foreach ($data as $k => $v) {
                    $res = WaterBase::find()->where(['house_id'=>$v['house_id'],'seat_id'=>$v['seat_id'],'room_num'=>$v['room_num'],'water_type'=>0,'status'=>1])->andWhere(['between','create_time',$stime,$etime])->count();
                    if ($res) {
                        $fail++;
                        $v['error'] = '当月水费订单信息已存在，不可重复导入';
                        $data_error[] = $v;
                    } else {
                        $model = new WaterBase();
                        $model->house_id = $v['house_id'];
                        $model->seat_id = $v['seat_id'];
                        $model->room_num = $v['room_num'];
                        $model->meter_number = $v['meter_number'];
                        $model->owner_name = $v['owner_name'];
                        $model->monovalent = $v['monovalent'];
                        $model->month_amount = $v['month_amount'];
                        $model->this_month = $v['this_month'];
                        $model->end_month = $v['end_month'];
                        $model->month_dosage = $v['month_dosage'];
                        $model->create_time = time();
                        $model->status = 1;
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
            echo json_encode(['code'=>200,'success'=>$success,'fail'=>$fail,'data'=>$data_error]);exit;
        }
        echo json_encode(['code'=>-200,'success'=>$success,'fail'=>$fail,'msg'=>'暂无可导入的数据']);exit;
    }

    /**
     * Deletes an existing WaterBase model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
         WaterBase::updateAll(['status'=>2],['id'=>$id]);
         return $this->redirect(['index']);
    }

    /**
     * Finds the WaterBase model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WaterBase the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WaterBase::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    //1.软删除!
    public function actionAjaxDelete(){
        $id = Yii::$app->request->get('Id');
        $ids = explode(',',$id);
        if(empty($id)){
           echo json_encode(array('code'=>[],'status'=>-200,'message'=>'参数不为空!'));
           exit;
        }else{
            for($index=0;$index<count($ids);$index++){
                $return = Yii::$app->db->createCommand()->update('water_base',['status'=>2],"id=".$ids[$index])->execute();
            }
            echo json_encode(array('code'=>[],'status'=>200,'message'=>'删除成功!'));
            exit;
        }

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
        $wrstr=htmlspecialchars_decode(file_get_contents($app_path.'/web/template/water_base_tmp.xlsx'));
        $outfile=time().'.'.'xlsx';
        header('Content-type: application/octet-stream; charset=utf8');
        Header("Accept-Ranges: bytes");
        header('Content-Disposition: attachment; filename='.$outfile);
        echo $wrstr;
        exit();
    }

    //1.线下结算！
    public function actionAjaxPay(){
        $id = Yii::$app->request->get('Id');
        $ids = explode(',',$id);
        if(empty($id)){
            echo json_encode(array('code'=>[],'status'=>-200,'message'=>'参数不为空!'));
            exit;
        }else{
            $water = array();
            for($index=0;$index<count($ids);$index++){
                $return = Yii::$app->db->createCommand()->update('water_base',['water_type'=>2],"id=".$ids[$index])->execute();
            }
            echo json_encode(array('code'=>[],'status'=>200,'message'=>'线下结算!'));
            exit;
        }
    }
}
