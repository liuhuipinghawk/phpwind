<?php

namespace app\models\Admin;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "app_subway".
 *
 * @property string $subway_id
 * @property string $subway_name
 * @property integer $parent_id
 */
class Subway extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_subway';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['subway_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'subway_id' => 'Subway ID',
            'subway_name' => 'Subway Name',
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
                $tree = array_merge($tree,$this->getTree($cates,$cate['subway_id']));
            }
        }
        return $tree;
    }
    public function setPrefix($data,$p="|------"){
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
            if(array_key_exists($val['parent_id'],$prefix)){
                $num = $prefix[$val['parent_id']];
            }
            $val['subway_name'] = str_repeat($p,$num).$val['subway_name'];
            $prefix[$val['parent_id']] = $num;
            $tree[] = $val;
            next($data);
        }
        return $tree;
    }
    public function getTreeList(){
        $data = $this->getData();
        $tree = $this->getTree($data);
        return $tree= $this->setPrefix($tree);
    }
    public function getOptions(){
        $data = $this->getData();
        $tree = $this->getTree($data);
        $tree = $this->setPrefix($tree);
        $options = ['添加顶级分类'];
        foreach ($tree as $cate){
            $options[$cate['subway_id']] = $cate['subway_name'];
        }
        return $options; 
    }
}
