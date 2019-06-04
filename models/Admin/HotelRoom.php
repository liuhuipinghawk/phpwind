<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "hotel_room".
 *
 * @property string $room_id
 * @property integer $hotel_id
 * @property string $room_name
 * @property integer $room_type
 * @property string $price
 * @property string $room_img
 * @property string $bed_type
 * @property string $breakfast
 * @property string $wifi
 * @property string $room_window
 * @property string $to_live
 * @property string $bathroom
 * @property string $room_space
 * @property string $floor
 * @property integer $state
 * @property integer $is_del
 * @property integer $add_time
 * @property integer $add_user
 * @property integer $audit_state
 * @property integer $audit_time
 * @property integer $audit_user
 * @property integer $update_time
 * @property integer $update_user
 * @property integer $likes
 * @property integer $sales
 */
class HotelRoom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'add_time', 'add_user'], 'required'],
            [['hotel_id', 'room_type', 'state', 'is_del', 'add_time', 'add_user', 'audit_state', 'audit_time', 'audit_user', 'update_time', 'update_user', 'likes', 'sales'], 'integer'],
            [['price'], 'number'],
            [['room_name', 'bed_type'], 'string', 'max' => 50],
            [['room_img'], 'string', 'max' => 100],
            [['breakfast', 'wifi', 'room_window', 'to_live', 'bathroom', 'room_space', 'floor'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'room_id' => 'Room ID',
            'hotel_id' => 'Hotel ID',
            'room_name' => 'Room Name',
            'room_type' => 'Room Type',
            'price' => 'Price',
            'room_img' => 'Room Img',
            'bed_type' => 'Bed Type',
            'breakfast' => 'Breakfast',
            'wifi' => 'Wifi',
            'room_window' => 'Room Window',
            'to_live' => 'To Live',
            'bathroom' => 'Bathroom',
            'room_space' => 'Room Space',
            'floor' => 'Floor',
            'state' => 'State',
            'is_del' => 'Is Del',
            'add_time' => 'Add Time',
            'add_user' => 'Add User',
            'audit_state' => 'Audit State',
            'audit_time' => 'Audit Time',
            'audit_user' => 'Audit User',
            'update_time' => 'Update Time',
            'update_user' => 'Update User',
            'likes' => 'Likes',
            'sales' => 'Sales',
        ];
    }
}
