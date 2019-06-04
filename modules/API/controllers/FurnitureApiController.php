<?php

namespace app\modules\API\controllers;

use app\models\Furniture;
use app\models\FurnitureBaspeak;
use app\models\FurnitureCategory;
use yii\web\Controller;


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/21
 * Time: 14:13
 */

class FurnitureApiController extends Controller{

    //默认的是1_1全部数据 1_2.is_price 1.高在前 desc 低在前 asc。1_2.pid分类查询。
    public function actionIndex()
    {
        $pageNum = \Yii::$app->request->get('pagenum') ? \Yii::$app->request->get('pagenum') : 1;
        $is_price = $_GET['is_price'];
        $pid = $_GET['pid'];
        $pageSize = 4;
        $PageRow = ($pageNum - 1)* $pageSize;
        //是否为空,如果为空，加载所有数据
        if(empty($is_price) && empty($pid)){
            //加载所有数据!
            $cleansservice = Furniture::find()->offset($PageRow)->limit($pageSize)->asArray()->all();
            echo json_encode([
                'code' => $cleansservice,
                'status' => 200,
                'message' => '加载所有数据!'
            ]);
            exit;
        }else{
            if($is_price ==1){
                //加载所有数据!
                $cleansservice = Furniture::find()->orderBy('price desc')->offset($PageRow)->limit($pageSize)->asArray()->all();
                echo json_encode([
                    'code' => $cleansservice,
                    'status' => 200,
                    'message' => '按价格最高的排序加载数据!'
                ]);
                exit;
            }else if($is_price ==2){
                //加载所有数据!
                $cleansservice = Furniture::find()->orderBy('price asc')->offset($PageRow)->limit($pageSize)->asArray()->all();
                echo json_encode([
                    'code' => $cleansservice,
                    'status' => 200,
                    'message' => '按价格最低的排序加载数据!'
                ]);
                exit;
            }else{
                $where['pid'] = $pid;
                //加载所有数据!
                $cleansservice = Furniture::find()->where($where)->offset($PageRow)->limit($pageSize)->asArray()->all();
                echo json_encode([
                    'code' => $cleansservice,
                    'status' => 200,
                    'message' => '按分类Id来加载数据!'
                ]);
                exit;
            }
        }
    }

    /**
     * 日常保洁详情页
     */
    public function actionList(){
        $id = \Yii::$app->request->get('clean_id');
        if(empty($id)){
            echo json_encode([
                'code' => '',
                'status' => 200,
                'message' => '参数不为空!'
            ]);
            exit;
        }else{
            $clean = Furniture::find()->where(array('clean_id'=>$id))->asArray()->one();
            echo json_encode([
                'code' => $clean,
                'status' => 200,
                'message' => '详情数据加载成功!'
            ]);
            exit;
        }
    }
    /**
     * 加载保洁服务分类
     */
    public function actionCategory(){
        $cate = FurnitureCategory::find()->where(array('parent_id'=>1))->asArray()->all();
        echo json_encode([
            'code' => $cate,
            'status' => 200,
            'message' => '加载保洁服务分类!'
        ]);
        exit;
    }
    //信息预约
    public function actionFurnitureBaspeak(){
        $project_name = \Yii::$app->request->get('project_name');
        $project_persion = \Yii::$app->request->get('persion');
        $project_tell = \Yii::$app->request->get('tell');
        if(empty($project_name) || empty($project_persion) || empty($project_tell)){
            echo json_encode([
                'code' => '',
                'status' => 404,
                'message' => '参数不能为空!'
            ]);
            exit;
        }else{
            $model = new FurnitureBaspeak();
            $model->project_name = $project_name;
            $model->tell = $project_tell;
            $model->persion = $project_persion;
            if($model->load($model) || $model->validate()){
                if($model->save(false)){
                    echo json_encode([
                        'code' => '',
                        'status' => 200,
                        'message' => '申请提交成功!'
                    ]);
                    return false;
                }
                return false;
            }
        }
    }
}