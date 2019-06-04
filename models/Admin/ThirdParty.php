<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "third_party".
 *
 * @property integer $id
 * @property string $name
 * @property string $mobile
 * @property string $house
 * @property string $seat
 * @property string $floor
 * @property string $room
 * @property integer $type
 */
class ThirdParty extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'third_party';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'mobile', 'house', 'seat', 'floor', 'room', 'type'], 'required'],
            [['type'], 'integer'],
            [['name', 'house', 'room'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 15],
            [['seat', 'floor'], 'string', 'max' => 100],
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
            'mobile' => 'Mobile',
            'house' => 'House',
            'seat' => 'Seat',
            'floor' => 'Floor',
            'room' => 'Room',
            'type' => 'Type',
        ];
    }
}
