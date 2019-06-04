<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "house_lease".
 *
 * @property string $id
 * @property integer $house_id
 * @property integer $seat_id
 * @property integer $house_type
 * @property integer $total_nums
 * @property integer $rent_nums
 * @property integer $unrent_nums
 * @property string $total_space
 * @property string $rent_space
 * @property string $unrent_space
 * @property integer $year
 * @property integer $month
 * @property integer $day
 * @property integer $add_time
 * @property integer $add_user
 * @property integer $edit_time
 * @property integer $edit_user
 * @property integer $is_del
 * @property integer $del_user
 * @property integer $del_time
 */
class HouseLease extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_lease';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id', 'seat_id', 'house_type', 'total_nums', 'rent_nums', 'unrent_nums', 'year', 'month', 'day', 'add_time', 'add_user', 'edit_time', 'edit_user', 'is_del', 'del_user', 'del_time'], 'integer'],
            [['total_space', 'rent_space', 'unrent_space'], 'number'],
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
            'house_type' => 'House Type',
            'total_nums' => 'Total Nums',
            'rent_nums' => 'Rent Nums',
            'unrent_nums' => 'Unrent Nums',
            'total_space' => 'Total Space',
            'rent_space' => 'Rent Space',
            'unrent_space' => 'Unrent Space',
            'year' => 'Year',
            'month' => 'Month',
            'day' => 'Day',
            'add_time' => 'Add Time',
            'add_user' => 'Add User',
            'edit_time' => 'Edit Time',
            'edit_user' => 'Edit User',
            'is_del' => 'Is Del',
            'del_user' => 'Del User',
            'del_time' => 'Del Time',
        ];
    }
}
