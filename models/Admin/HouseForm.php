<?php

namespace app\models\Admin;
/**
 * User: mumu
 * Date: 2018/2/25
 * Time: 9:07
 */
class HouseForm extends BaseForm{

    public function upload(){
        if($this->validate()){
            $this->imageFile->saveAs('uploads/HouseImg/'.time(). '.' . $this->imageFile->extension);
            return true;
        }else{
            return false;
        }
    }
}