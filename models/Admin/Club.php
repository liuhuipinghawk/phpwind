<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "club".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $company
 * @property string $name
 * @property string $mobile
 * @property string $address
 * @property string $create_time
 * @property string $image
 * @property integer $status
 */
class Club extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'club';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'company', 'name', 'mobile', 'address', 'image'], 'required'],
            [['id', 'user_id', 'status'], 'integer'],
            [['create_time'], 'safe'],
            [['company', 'name', 'address', 'image'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'company' => 'Company',
            'name' => 'Name',
            'mobile' => 'Mobile',
            'address' => 'Address',
            'create_time' => 'Create Time',
            'image' => 'Image',
            'status' => 'Status',
        ];
    }
}
