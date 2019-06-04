<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 9:07
 */

namespace app\modules\admin\controllers;


use app\models\Admin\ParkingPayment;
use yii\data\Pagination;
use yii\web\Controller;
use Yii;

class ParkingController extends CommonController {

    public function actionIndex(){
        $this->layout = "layout1";
        $parking_name = empty(Yii::$app->request->get()['parking_name']) ? '' : Yii::$app->request->get()['parking_name'];
        $car_no = empty(Yii::$app->request->get()['car_no']) ? '' : Yii::$app->request->get()['car_no'];
        $status     = empty(Yii::$app->request->get()['status']) ? 0 : Yii::$app->request->get()['status'];
        $pay_type     = empty(Yii::$app->request->get()['pay_type']) ? 0 : Yii::$app->request->get()['pay_type'];
        $jquery = ParkingPayment::find()->where(array("status"=>1));
        if(!empty($parking_name)){
            $jquery = $jquery->andWhere(['like','parking_name',$parking_name]);
        }
        if(!empty($car_no)){
            $jquery = $jquery->andWhere(['like','car_no',$car_no]);
        }
        if(!empty($status)){
            $jquery = $jquery->andWhere(['status'=>$status]);
        }
        if(!empty($status)){
            $jquery = $jquery->andWhere(['pay_type'=>$pay_type]);
        }
        $count = $jquery->count();
        $pagination = new Pagination(['totalCount'=>$count],10);

        $list = $jquery->offset($pagination->offset)->limit($pagination->limit)->asArray()->all();
        return $this->render('index', [
            'pagination'=>$pagination,
            'list'=>$list,
            ]);
    }

}