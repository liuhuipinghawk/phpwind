<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "renovation".
 *
 * @property string $id
 * @property integer $house_id
 * @property integer $seat_id
 * @property integer $house_type
 * @property integer $renovation_nums
 * @property integer $check_nums
 * @property integer $return_nums
 * @property integer $nowing_nums
 * @property integer $current_nums
 * @property integer $year
 * @property integer $month
 * @property integer $day
 * @property integer $is_del
 * @property integer $add_user
 * @property integer $add_time
 * @property integer $edit_user
 * @property integer $edit_time
 * @property integer $del_user
 * @property integer $del_time
 */
class Renovation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'renovation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id', 'seat_id', 'house_type', 'renovation_nums', 'check_nums', 'return_nums', 'nowing_nums', 'current_nums', 'year', 'month', 'day', 'is_del', 'add_user', 'add_time', 'edit_user', 'edit_time', 'del_user', 'del_time'], 'integer'],
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
            'renovation_nums' => 'Renovation Nums',
            'check_nums' => 'Check Nums',
            'return_nums' => 'Return Nums',
            'nowing_nums' => 'Nowing Nums',
            'current_nums' => 'Current Nums',
            'year' => 'Year',
            'month' => 'Month',
            'day' => 'Day',
            'is_del' => 'Is Del',
            'add_user' => 'Add User',
            'add_time' => 'Add Time',
            'edit_user' => 'Edit User',
            'edit_time' => 'Edit Time',
            'del_user' => 'Del User',
            'del_time' => 'Del Time',
        ];
    }
}
