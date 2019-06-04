<?php
namespace app\models;
use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/18
 * Time: 14:11
 */

class CleanForm extends BaseForm {
    public function upload(){
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/clean/'.$this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}