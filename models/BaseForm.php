<?php
namespace app\models;

use yii\base\Model;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/18
 * Time: 12:08
 */

class BaseForm extends Model{

    /**
     * @var
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpeg,png, jpg, gif, bmp','maxSize'=>5024000,'checkExtensionByMimeType'=>false],
        ];
    }
}