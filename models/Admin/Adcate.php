<?php

namespace app\models\Admin;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "adcate".
 *
 * @property integer $adCateId
 * @property string $adCateName
 * @property integer $parentId
 * @property string $createTime
 * @property string $updateTime
 */
class Adcate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adcate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adCateName'],'required','message'=>'{attribute}不能为空'],
            [['parentId'], 'integer'],
            [['adCateName'], 'string', 'max' => 30],
            [['createTime', 'updateTime'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adCateId' => '广告分类ID',
            'adCateName' => '广告分类名称',
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
                $tree = array_merge($tree,$this->getTree($cates,$cate['adCateId']));
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
            $val['adCateName'] = str_repeat($p, $num).$val['adCateName'];
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
            $options[$cate['adCateId']] = $cate['adCateName'];
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
