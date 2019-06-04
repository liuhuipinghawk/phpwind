<?php

namespace app\models\Admin;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "app_area".
 *
 * @property integer $area_id
 * @property string $area_name
 * @property integer $parent_id
 */
class InspectionArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_name','parent_id'],'required','message'=>'{attribute}不能为空'],
            [['parent_id'], 'integer'],
            [['area_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'area_id' => '报检报修区域Id',
            'area_name' => '报检报修区域名称',
            'parent_id' => 'Parent ID',
        ];
    }

    public function getData(){
        $cates = self::find()->all();
        $cates = ArrayHelper::toArray($cates);
        return $cates;
    }

    public function getTree($cates,$pid = 0){
        $tree = [];
        foreach ($cates as $cate){
            if($cate['parent_id'] ==$pid){
                $tree[] = $cate;
                $tree = array_merge($tree,$this->getTree($cates,$cate['area_id']));
            }
        }
        return $tree;
    }
    public function setPrefix($data,$p="|-----"){
        $tree = [];
        $num = 1;
        $prefix = [0=>1];
        while ($val = current($data)){
            $key = key($data);
            if($key >0){
                if($data[$key - 1]['parent_id'] !=$val['parent_id']){
                    $num ++;
                }
            }
            if(array_key_exists($val['parent_id'], $prefix)){
                $num = $prefix[$val['parent_id']];
            }
            $val['area_name'] = str_repeat($p, $num).$val['area_name'];
            $prefix[$val['parent_id']] = $num;
            $tree[] = $val;
            next($data);
        }
        return $tree;
    }

    public function getTreeList(){
        $data = $this->getData();
        $tree = $this->getTree($data);
        return $tree = $this->setPrefix($tree);
    }
    public function getOptions(){
        $data = $this->getData();
        $tree = $this->getTree($data);
        $tree = $this->setPrefix($tree);
        $options = ['添加顶级分类'];
        foreach ($tree as $cate){
            $options[$cate['area_id']] = $cate['area_name'];
        }
        return $options;
    }
    public function addItem($data){

        if($this->load($data) && $this->validate()){
            $this->createTime = time();
            $this->updateTime = time();
            if($this->save(false)){
                return true;
            }
            return false;
        }
        return false;
    }
}
