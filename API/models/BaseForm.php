<?php
namespace app\API\models;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * 上传图片的父类
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/24
 * Time: 14:35
 */

class BaseForm extends Model{

    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif, bmp','maxSize'=>1024000,'checkExtensionByMimeType'=>false],
        ];
    }
}
