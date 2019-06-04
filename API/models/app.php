<?php

namespace app\API\models;

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
class app extends \yii\db\ActiveRecord
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
            [['name', 'is_encryption', 'create_time', 'update_time'], 'required'],
            [['is_encryption', 'create_time', 'update_time', 'status'], 'integer'],
            [['image_size'], 'string'],
            [['name'], 'string', 'max' => 10],
            [['key'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'is_encryption' => 'Is Encryption',
            'key' => 'Key',
            'image_size' => 'Image Size',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'status' => 'Status',
        ];
    }
}
