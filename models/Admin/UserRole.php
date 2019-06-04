<?php

namespace app\models\Admin;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_role".
 *
 * @property integer $id
 * @property string $name
 * @property string $url
 * @property integer $pid
 * @property integer $status
 */
class UserRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'required'],
            [['pid', 'status','column'], 'integer'],
            [['name', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
            'pid' => 'Pid',
            'status' => 'Status',
            'column' => 'Column'
        ];
    }
    public function getData(){
        $cates = self::find()->where(['status'=>1])->all();
        $cates = ArrayHelper::toArray($cates);
        return $cates;
    }

    public function getTree($cates,$pid = 0){
        $tree = [];
        foreach ($cates as $cate){
            if($cate['pid'] ==$pid){
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
                if($data[$key - 1]['pid'] !=$val['pid']){
                    $num ++;
                }
            }
            if(array_key_exists($val['pid'], $prefix)){
                $num = $prefix[$val['pid']];
            }
            $val['name'] = str_repeat($p, $num).$val['name'];
            $prefix[$val['pid']] = $num;
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
            $options[$cate['id']] = $cate['name'];
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
