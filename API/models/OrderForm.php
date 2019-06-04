<?php
namespace app\API\models;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/27
 * Time: 9:09
 */
/**
 * 保修添加的图片显示！
 * Class OrderForm
 * @package app\API\models
 */
class OrderForm extends BaseForm{

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/Order/'.$this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}