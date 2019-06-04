<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "3d_showings".
 *
 * @property string $id
 * @property integer $house_id
 * @property integer $seat_id
 * @property integer $type
 * @property string $type_name
 * @property string $img_path
 * @property string $img_thumb
 * @property string $room_num
 * @property string $address
 * @property string $tag
 * @property string $desc
 * @property integer $is_del
 * @property integer $status
 * @property integer $add_time
 * @property integer $add_user
 * @property integer $edit_time
 * @property integer $edit_user
 */
class Showings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '3d_showings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id', 'seat_id', 'type', 'is_del', 'status', 'add_time', 'add_user', 'edit_time', 'edit_user'], 'integer'],
            [['type_name'], 'string', 'max' => 50],
            [['img_path', 'img_thumb', 'room_num', 'tag'], 'string', 'max' => 100],
            [['address', 'desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'house_id' => 'House ID',
            'seat_id' => 'Seat ID',
            'type' => 'Type',
            'type_name' => 'Type Name',
            'img_path' => 'Img Path',
            'img_thumb' => 'Img Thumb',
            'room_num' => 'Room Num',
            'address' => 'Address',
            'tag' => 'Tag',
            'desc' => 'Desc',
            'is_del' => 'Is Del',
            'status' => 'Status',
            'add_time' => 'Add Time',
            'add_user' => 'Add User',
            'edit_time' => 'Edit Time',
            'edit_user' => 'Edit User',
        ];
    }
}
