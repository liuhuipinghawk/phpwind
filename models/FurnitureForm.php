<?php
namespace app\models;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/19
 * Time: 8:54
 */

class FurnitureForm extends BaseForm{
    public function upload(){
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/furniture/'.$this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}