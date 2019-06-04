<?php

namespace app\models\Admin;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "house".   
 *
 * @property integer $id
 * @property integer $parentId
 * @property string $housename
 * @property integer $cityid
 * @property string $createtime
 * @property string $updatetime
 */
class House extends BaseCategory
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['housename','parentId','cityid'],'required','message'=>'{attribute}不能为空'],
            [['id','parentId', 'cityid'], 'integer'],
            [['housename'], 'string', 'max' => 20],
            [['createtime', 'updatetime'], 'string', 'max' => 200],
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
                $tree = array_merge($tree,$this->getTree($cates,$cate['id']));
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
            $val['housename'] = str_repeat($p, $num).$val['housename'];
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
            $options[$cate['id']] = $cate['housename'];
        }
        return $options;
    }
    public function addItem($data){

        if($this->load($data) && $this->validate()){
            $this->createtime = time();
            $this->updatetime = time();
            if($this->save(false)){
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '楼盘Id',
            'parentId' => '楼盘分类ID',
            'housename' => '楼盘名称',
            'cityid' => '城市Id',
            'createtime' => '添加时间',
            'updatetime' => '更新时间',
        ];
    }
}
