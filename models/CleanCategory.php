<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "o2o_clean_category".
 *
 * @property integer $category_id
 * @property string $category_name
 * @property integer $parent_id
 * @property integer $create_time
 * @property integer $update_time
 */
class CleanCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o2o_clean_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['parent_id','required','message'=>'上级分类不能为空'],
            ['category_name','required','message'=>'标题名称不能为空'],
            ['create_time', 'safe'],
            [['parent_id'], 'integer'],
            [['category_name'], 'string', 'max' => 20],
            [['create_time', 'update_time'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'category_name' => 'Category Name',
            'parent_id' => 'Parent ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
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
                $tree = array_merge($tree,$this->getTree($cates,$cate['category_id']));
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
            $val['category_name'] = str_repeat($p, $num).$val['category_name'];
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
            $options[$cate['category_id']] = $cate['category_name'];
        }
        return $options;
    }
    public function addItem($data){

        if($this->load($data) && $this->validate()){
            $this->create_time = time();
            $this->update_time = time();
            if($this->save(false)){
                return true;
            }
            return false;
        }
        return false;
    }
}
