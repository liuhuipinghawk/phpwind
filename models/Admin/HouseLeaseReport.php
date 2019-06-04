<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "house_lease_report".
 *
 * @property string $report_id
 * @property integer $house_id
 * @property integer $seat_id
 * @property integer $house_type
 * @property string $room_num
 * @property string $space
 * @property string $get_money
 * @property integer $year
 * @property integer $month
 * @property integer $day
 * @property integer $add_time
 * @property integer $add_user
 * @property integer $edit_time
 * @property integer $edit_user
 * @property integer $is_del
 * @property integer $del_time
 * @property integer $del_user
 */
class HouseLeaseReport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_lease_report';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id', 'seat_id', 'house_type', 'year', 'month', 'day', 'add_time', 'add_user', 'edit_time', 'edit_user', 'is_del', 'del_time', 'del_user'], 'integer'],
            [['space', 'get_money'], 'number'],
            [['room_num'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'report_id' => 'Report ID',
            'house_id' => 'House ID',
            'seat_id' => 'Seat ID',
            'house_type' => 'House Type',
            'room_num' => 'Room Num',
            'space' => 'Space',
            'get_money' => 'Get Money',
            'year' => 'Year',
            'month' => 'Month',
            'day' => 'Day',
            'add_time' => 'Add Time',
            'add_user' => 'Add User',
            'edit_time' => 'Edit Time',
            'edit_user' => 'Edit User',
            'is_del' => 'Is Del',
            'del_time' => 'Del Time',
            'del_user' => 'Del User',
        ];
    }
}
