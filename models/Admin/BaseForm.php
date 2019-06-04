<?php
namespace app\models\Admin;
use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/5
 * Time: 8:46
 */

class BaseForm extends Model{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $File;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpeg,png, jpg, gif, docx,excel,pdf,ppt','maxSize'=>5024000,'checkExtensionByMimeType'=>false],
        ];
    }
}
