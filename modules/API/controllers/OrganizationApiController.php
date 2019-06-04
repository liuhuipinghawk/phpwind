<?php
namespace app\modules\API\controllers;

use app\models\Baspeak;
use app\models\Equipment;
use app\models\EquipmentCategory;
use yii\web\Controller;

/**
 * 办公租赁设备API
 */

class OrganizationApiController extends Controller{

    /**
     * 办公租赁设备列表
     */
    public function actionIndex(){
        $pageNum = \Yii::$app->request->get('pagenum') ? \Yii::$app->request->get('pagenum') : 1;
        $pid = \Yii::$app->request->get('pid') ? \Yii::$app->request->get('pid') : 0;
        $house_id = \Yii::$app->request->get('house_id') ? \Yii::$app->request->get('house_id') : 0;
        $pageSize = 10;
        $PageRow = ($pageNum - 1)* $pageSize;
        //是否为空,如果为空，加载所有数据
        if(empty($pid)){
            //加载所有数据!
            $cleansservice = Equipment::find()->select('equipment_id,equipment_name,thumb,equipment_desc,price,pid,house_id')->offset($PageRow)->limit($pageSize)->asArray()->all();
            echo json_encode([
                'code' => $cleansservice,
                'status' => 200,
                'message' => '加载所有数据!'
            ]);
            exit;
        }else{
                $where['pid'] = $pid;
                //加载所有数据!
                $cleansservice = Equipment::find()->select('equipment_id,equipment_name,thumb,equipment_desc,price,pid,house_id')->where($where)->offset($PageRow)->limit($pageSize)->asArray()->all();
                echo json_encode([
                    'code' => $cleansservice,
                    'status' => 200,
                    'message' => '按分类Id来加载数据!'
                ]);
                exit;
        }
    }

    /**
     * 获取办公设备子父级分类
     * 1.台式机 2.笔记本 3.打印机
     *
     */
    public function actionCategory($pid=1){   
        $cate = new EquipmentCategory();
        $all = $cate->getSubParent($pid);
        echo json_encode([
            'code' => $all,
            'status' => 200,
            'message' => '分类数据加载成功!'
        ]);
        exit;     

    }

    /**
     * 办公设备详情页
     */
    public function actionList(){
        $id = \Yii::$app->request->get('equipment_id');
        if(empty($id)){
            echo json_encode([
                'code' => '',
                'status' => 200,
                'message' => '参数不为空!'
            ]);
            exit;
        }else{
            $clean = Equipment::find()->select('equipment_id,equipment_name,price,thumb,equipment_desc,content,business_telephone')->where(array('equipment_id'=>$id))->asArray()->one();
            echo json_encode([
                'code' => $clean,
                'status' => 200,
                'message' => '详情数据加载成功!'
            ]);
            exit;
        }
    }
    //信息预约
    public function actionBaspeak(){
        $project_name = \Yii::$app->request->get('project_name');
        $project_persion = \Yii::$app->request->get('persion');
        $price = \Yii::$app->request->get('price');
        $project_tell = \Yii::$app->request->get('tell');
        if(empty($project_name) || empty($project_persion) || empty($project_tell)){
                echo json_encode([
                    'code' => '',
                    'status' => 404,
                    'message' => '参数不能为空!'
                ]);
                exit;
        }else{
                $model = new Baspeak();
                $model->project_name = $project_name;
                $model->tell = $project_tell;
                $model->persion = $project_persion;
                $model->price = $price;
                $model->baspeak_time = time();
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
        //}
    }
}