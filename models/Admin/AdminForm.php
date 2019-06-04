<?php
namespace app\models\Admin;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/2
 * Time: 14:17
 */
class AdminForm extends BaseForm{

    public function upload(){
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/admin/'.$this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}