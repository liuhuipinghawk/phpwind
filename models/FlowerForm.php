<?php
namespace app\models;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/19
 * Time: 8:56
 */

class FlowerForm extends BaseForm{
    public function upload(){
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/flower/'.$this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}