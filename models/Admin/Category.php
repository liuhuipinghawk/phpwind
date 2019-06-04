<?php

namespace app\models\Admin;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property integer $categoryId
 * @property string $categoryName
 * @property integer $parentId
 * @property string $createTime
 * @property string $updateTime
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['parentId','required','message'=>'上级分类不能为空'],
            ['categoryName','required','message'=>'标题名称不能为空'],
            ['createtime', 'safe'],
            [['parentId'], 'integer'],
            [['categoryName'], 'string', 'max' => 20],
            [['createTime', 'updateTime'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categoryId' => '分类ID',
            'categoryName' => '分类名称',
            'parentId' => '上级分类',
            'createTime' => '添加时间',
            'updateTime' => '更新时间',
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
            if($cate['parentId'] ==$pid){
                $tree[] = $cate;
                $tree = array_merge($tree,$this->getTree($cates,$cate['categoryId']));
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
                if($data[$key - 1]['parentId'] !=$val['parentId']){
                    $num ++;
                }
            }
            if(array_key_exists($val['parentId'], $prefix)){
                $num = $prefix[$val['parentId']];
            }
            $val['categoryName'] = str_repeat($p, $num).$val['categoryName'];
            $prefix[$val['parentId']] = $num;
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
            $options[$cate['categoryId']] = $cate['categoryName'];
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
