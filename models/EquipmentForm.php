<?php

namespace  app\models;


/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 18:42
 */

class EquipmentForm extends BaseForm{
    public function upload(){
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/equipment/'.$this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}