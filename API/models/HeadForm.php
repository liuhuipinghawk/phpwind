<?php
namespace app\API\models;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * 头像上传！
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/24
 * Time: 10:28
 */

class HeadForm extends BaseForm
{
    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/head/'.$this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}