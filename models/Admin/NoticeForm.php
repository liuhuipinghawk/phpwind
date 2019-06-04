<?php
namespace app\models\Admin;



/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/5
 * Time: 11:47
 */

class NoticeForm extends BaseForm{

    public function upload(){
        if($this->validate()){
            $this->imageFile->saveAs('uploads/properynotice/'.$this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        }else{
            return false;
        }
    }
}