<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "app".
 *
 * @property integer $id
 * @property string $name
 * @property integer $is_encryption
 * @property string $key
 * @property string $image_size
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 */
class App extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required','message'=>'{attribute}不能为空'],
            [['is_encryption', 'status'], 'integer'],
            [['name'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'app名称',
            'is_encryption' => 'Is Encryption',
            'key' => 'Key',
            'image_size' => 'Image Size',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
