<?php
namespace app\models\Admin;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/5
 * Time: 16:15
 */

class AdForm extends  BaseForm{

    public function upload(){
        if($this->validate()){
            $this->imageFile->saveAs('uploads/ad/'.$this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        }
        return false;
    }
}