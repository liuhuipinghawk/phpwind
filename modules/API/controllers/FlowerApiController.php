<?php
namespace app\modules\API\controllers;


use app\models\Area;
use app\models\Flower;
use app\models\FlowerCategory;
use app\models\Implication;
use app\models\Plants;
use app\models\Position;
use app\models\Pot;
use yii\web\Controller;
/**
 * 花卉租赁.
 */
class FlowerApiController extends Controller{

    /**
     * 花卉租赁信息
     * is_price ,pagenum,pid,effect_plants,Pot_type,green_implication,covering_area,position
     * 价格排序,分页数,分类Id,绿植功效   ,盆栽类型,绿植寓意,          实用面积,     摆放位置
     */
    public function actionIndex()
    {
        $pageNum = \Yii::$app->request->get('pagenum') ? \Yii::$app->request->get('pagenum') : 1;
        $effect_plants = \Yii::$app->request->get('plants_id') ? \Yii::$app->request->get('plants_id') : 0;
        $pot_type = \Yii::$app->request->get('pot_id') ? \Yii::$app->request->get('pot_id') : 0;
        $green_implication = \Yii::$app->request->get('implication_id') ? \Yii::$app->request->get('implication_id') : 0;
        $covering_area = \Yii::$app->request->get('area_id') ? \Yii::$app->request->get('area_id') : 0;
        $position = \Yii::$app->request->get('opsition_id') ? \Yii::$app->request->get('opsition_id') : 0;
        $house_id = \Yii::$app->request->get('house_id') ? \Yii::$app->request->get('house_id') : 0;
        $pageSize = 10;
        $PageRow = ($pageNum - 1)* $pageSize;
        if( empty($_GET['plants_id']) && empty($_GET['pot_id']) && empty($_GET['implication_id']) && empty($_GET['area_id']) && empty($_GET['opsition_id'])){
            $cleansservice = Flower::find()->offset($PageRow)->limit($pageSize)->asArray()->all();
            echo json_encode([
                'code' => $cleansservice,
                'status' => 200,
                'message' => '加载所有数据!'
            ]);
            exit;
        }else{
            if(!empty($effect_plants)){
                //判断不为空,如果不为空
                $where[] = "FIND_IN_SET(".$effect_plants.", effect_plants)";
                $str = implode(' AND ',$where);
                $flower = Flower::find()->where($str)->offset($PageRow)->limit($pageSize)->asArray()->all();
                echo json_encode([
                    'code' => $flower,
                    'status' => 200,
                    'message' => '加载所有数据!'
                ]);
                exit;
            }else if (!empty($pot_type)){
                $where[] = "FIND_IN_SET(".$pot_type.", Pot_type)";
                $str = implode(' AND ',$where);
                $flower = Flower::find()->where($str)->offset($PageRow)->limit($pageSize)->asArray()->all();
                echo json_encode([
                    'code' => $flower,
                    'status' => 200,
                    'message' => '加载所有数据!'
                ]);
                exit;
            }else if(!empty($green_implication)){
                $where[] = "FIND_IN_SET(".$green_implication.", green_implication)";
                $str = implode(' AND ',$where);
                $flower = Flower::find()->where($str)->offset($PageRow)->limit($pageSize)->asArray()->all();
                echo json_encode([
                    'code' => $flower,
                    'status' => 200,
                    'message' => '加载所有数据!'
                ]);
                exit;
            }else if(!empty($covering_area)){
                $where[] = "FIND_IN_SET(".$covering_area.", covering_area)";
                $str = implode(' AND ',$where);
                $flower = Flower::find()->where($str)->offset($PageRow)->limit($pageSize)->asArray()->all();
                echo json_encode([
                    'code' => $flower,
                    'status' => 200,
                    'message' => '加载所有数据!'
                ]);
                exit;
            }else if(!empty($position)){
                $where[] = "FIND_IN_SET(".$position.", position)";
                $str = implode(' AND ',$where);
                $flower = Flower::find()->where($str)->offset($PageRow)->limit($pageSize)->asArray()->all();
                echo json_encode([
                    'code' => $flower,
                    'status' => 200,
                    'message' => '加载所有数据!'
                ]);
                exit;
            }else{
                $where[] = "FIND_IN_SET(".$effect_plants.", effect_plants)";
                $where[] = "FIND_IN_SET(".$pot_type.", Pot_type)";
                $where[] = "FIND_IN_SET(".$green_implication.", green_implication)";
                $where[] = "FIND_IN_SET(".$covering_area.", covering_area)";
                $where[] = "FIND_IN_SET(".$position.", position)";
                $str = implode(' AND ',$where);
                $flower = Flower::find()->where($str)->offset($PageRow)->limit($pageSize)->asArray()->all();
                echo json_encode([
                    'code' => $flower,
                    'status' => 200,
                    'message' => '加载所有数据!'
                ]);
                exit;
            }
        }
    }
    /**
     * 花卉详情页
     */
    public function actionList(){
        $id = \Yii::$app->request->get('flower_id');
        if(empty($id)){
            echo json_encode([
                'code' => '',
                'status' => 200,
                'message' => '参数不为空!'
            ]);
            exit;
        }else{
            $tree = array();
            $clean= Flower::find()->where(array('flower_id'=>$id))->asArray()->one();
            //绿植功效
            $plants = explode(',',$clean['effect_plants']);
            $clean['plants'] =  Plants::find()->where(['plants_id'=>$plants])->asArray()->all();
            //绿植寓意
            $green_implication = explode(',',$clean['green_implication']);
            $clean['implication'] = Implication::find()->where(['implication_id'=>$green_implication])->asArray()->all();
            //实用面积
            $covering_area = explode(',',$clean['covering_area']);
            $clean['covering_area'] = Area::find()->where(['area_id'=>$covering_area])->asArray()->all();
            //摆放位置
            $position = explode(',',$clean['position']);
            $clean['position'] = Position::find()->where(['opsition_id'=>$position])->asArray()->all();
            $tree[] = $clean;
            echo json_encode([
                'code' => $tree,
                'status' => 200,
                'message' => '加载花卉详情页成功!'
            ]);
            exit;
        }
    }
    //信息预约
    public function actionCleanBaspeak(){
        $project_name = \Yii::$app->request->get('project_name');
        $price = \Yii::$app->request->get('price');
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
            $model = new CleanBaspeak();
            $model->project_name = $project_name;
            $model->tell = $project_tell;
            $model->persion = $project_persion;
            $model->price = $price;
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
    /**
     * 加载花卉租赁服务分类
     */
    public function actionCategory(){
        $cate = FlowerCategory::find()->select('category_id,category_name')->where(array('parent_id'=>0))->asArray()->all();
        echo json_encode([  
            'code' => $cate,
            'status' => 200,
            'message' => '加载保洁服务分类!'
        ]);
        exit;
    }

    /**
     * 绿植功效
     */
    public function actionPlants(){
        $cate = Plants::find()->select('plants_id,plants_name')->asArray()->all();
        echo json_encode([
            'code' => $cate,
            'status' => 200,
            'message' => '加载绿植功效!'
        ]);
        exit;
    }

    /**
     *适用面积
     */
    public function actionArea(){
        $cate = Area::find()->select('area_id,area_name')->asArray()->all();
        echo json_encode([
            'code' => $cate,
            'status' => 200,
            'message' => '加载适用面积!'
        ]);
        exit;
    }

    /**
     * 盆栽类型
     */
    public function actionPot(){
        $cate = Pot::find()->select('pot_id,pot_name')->asArray()->all();
        echo json_encode([
            'code' => $cate,
            'status' => 200,
            'message' => '加载盆栽类型!'
        ]);
        exit;
    }

    /**
     * 绿植寓意
     */
    public function actionImplication(){
        $cate = Implication::find()->select('implication_id,implication_name')->asArray()->all();
        echo json_encode([
            'code' => $cate,
            'status' => 200,
            'message' => '加载绿植寓意!'
        ]);
        exit;
    }

    /**
     * 摆放位置
     */
    public function actionPosition(){
        $cate = Position::find()->select('opsition_id,opsition_name')->asArray()->all();
        echo json_encode([
            'code' => $cate,
            'status' => 200,
            'message' => '加载摆放位置!'
        ]);
        exit;
    }
}