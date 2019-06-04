<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "house_charge".
 *
 * @property string $id
 * @property integer $house_id
 * @property integer $seat_id
 * @property integer $house_type
 * @property string $total_money
 * @property string $get_money
 * @property string $current_money
 * @property string $unget_money
 * @property integer $total_nums
 * @property integer $get_nums
 * @property integer $current_nums
 * @property integer $unget_nums
 * @property integer $is_del
 * @property integer $add_time
 * @property integer $add_user
 * @property integer $edit_time
 * @property integer $edit_user
 * @property integer $del_time
 * @property integer $del_user
 * @property integer $year
 * @property integer $month
 * @property integer $day
 */
class HouseCharge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_charge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id', 'seat_id', 'house_type', 'total_nums', 'get_nums', 'current_nums', 'unget_nums', 'is_del', 'add_time', 'add_user', 'edit_time', 'edit_user', 'del_time', 'del_user', 'year', 'month', 'day'], 'integer'],
            [['total_money', 'get_money', 'current_money', 'unget_money'], 'number'],
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
            'total_money' => 'Total Money',
            'get_money' => 'Get Money',
            'current_money' => 'Current Money',
            'unget_money' => 'Unget Money',
            'total_nums' => 'Total Nums',
            'get_nums' => 'Get Nums',
            'current_nums' => 'Current Nums',
            'unget_nums' => 'Unget Nums',
            'is_del' => 'Is Del',
            'add_time' => 'Add Time',
            'add_user' => 'Add User',
            'edit_time' => 'Edit Time',
            'edit_user' => 'Edit User',
            'del_time' => 'Del Time',
            'del_user' => 'Del User',
            'year' => 'Year',
            'month' => 'Month',
            'day' => 'Day',
        ];
    }
}
