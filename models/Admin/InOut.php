<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "in_out".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $house_id
 * @property string $username
 * @property string $room
 * @property string $card
 * @property integer $mobile
 * @property integer $time
 * @property string $content
 * @property integer $status
 */
class InOut extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'in_out';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'user_id', 'house_id', 'username', 'room', 'card', 'mobile', 'time'], 'required'],
            [['id', 'user_id', 'house_id', 'mobile', 'status'], 'integer'],
            [['username', 'card'], 'string', 'max' => 255],
            [['room'], 'string', 'max' => 225],
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
            'house_id' => 'House ID',
            'username' => 'Username',
            'room' => 'Room',
            'card' => 'Card',
            'mobile' => 'Mobile',
            'time' => 'Time',
            'status' => 'Status',
            'create_time' => 'Create Time',
        ];
    }
}
