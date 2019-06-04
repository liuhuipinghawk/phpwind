<?php

namespace app\models\Admin;

use Yii;
use yii\helpers\ArrayHelper;

class BaseCategory extends \yii\db\ActiveRecord{

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

}
?>
