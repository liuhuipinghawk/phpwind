<?php
namespace app\models\Admin;


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/5
 * Time: 8:48
 */

class ThumbForm extends BaseForm{

    public function upload(){
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/article/'.time(). '.' . $this->imageFile->extension);
            return true; 
        } else {
            return false; 
        }  
    }
}
