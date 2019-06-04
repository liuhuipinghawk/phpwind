<?php
namespace app\models\Admin;


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/5
 * Time: 8:48
 */

class LearnFrom extends BaseForm{

    public function upload(){
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/learn/'.time(). '.' . $this->imageFile->extension);
            return true; 
        } else {
            return false; 
        }  
    }
}
