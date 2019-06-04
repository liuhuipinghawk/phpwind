<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "house_data".
 *
 * @property string $id
 * @property integer $house_id
 * @property integer $seat_id
 * @property integer $house_type
 * @property integer $total_nums
 * @property integer $sale_nums
 * @property integer $unsale_nums
 * @property integer $match_nums
 * @property integer $unmatch_nums
 * @property integer $already_nums
 * @property integer $unalready_nums
 * @property string $total_money
 * @property string $real_money
 * @property integer $rent_live
 * @property integer $rent_office
 * @property integer $hotel
 * @property integer $dormitory
 * @property integer $self_office
 * @property integer $self_live
 * @property integer $vacant
 * @property integer $year
 * @property integer $month
 * @property integer $day
 * @property integer $is_del
 * @property integer $add_time
 * @property integer $add_user
 * @property integer $edit_time
 * @property integer $edit_user
 * @property integer $del_time
 * @property integer $del_user
 */
class HouseData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id', 'seat_id', 'house_type', 'total_nums', 'sale_nums', 'unsale_nums', 'match_nums', 'unmatch_nums', 'already_nums', 'unalready_nums', 'rent_live', 'rent_office', 'hotel', 'dormitory', 'self_office', 'self_live', 'vacant', 'year', 'month', 'day', 'is_del', 'add_time', 'add_user', 'edit_time', 'edit_user', 'del_time', 'del_user'], 'integer'],
            [['total_money', 'real_money'], 'number'],
            [['year', 'month'], 'required'],
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
            'sale_nums' => 'Sale Nums',
            'unsale_nums' => 'Unsale Nums',
            'match_nums' => 'Match Nums',
            'unmatch_nums' => 'Unmatch Nums',
            'already_nums' => 'Already Nums',
            'unalready_nums' => 'Unalready Nums',
            'total_money' => 'Total Money',
            'real_money' => 'Real Money',
            'rent_live' => 'Rent Live',
            'rent_office' => 'Rent Office',
            'hotel' => 'Hotel',
            'dormitory' => 'Dormitory',
            'self_office' => 'Self Office',
            'self_live' => 'Self Live',
            'vacant' => 'Vacant',
            'year' => 'Year',
            'month' => 'Month',
            'day' => 'Day',
            'is_del' => 'Is Del',
            'add_time' => 'Add Time',
            'add_user' => 'Add User',
            'edit_time' => 'Edit Time',
            'edit_user' => 'Edit User',
            'del_time' => 'Del Time',
            'del_user' => 'Del User',
        ];
    }
}
