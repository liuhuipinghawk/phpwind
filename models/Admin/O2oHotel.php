<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "o2o_hotel".
 *
 * @property string $hotel_id
 * @property string $hotel_name
 * @property string $hotel_intro
 * @property integer $hotel_type
 * @property integer $house_id
 * @property integer $brand_id
 * @property integer $hotel_star
 * @property string $hotel_img
 * @property string $price
 * @property integer $city_id
 * @property string $longitude
 * @property string $latitude
 * @property string $address
 * @property string $hotel_tel
 * @property string $facilities
 * @property integer $open_year
 * @property integer $update_year
 * @property string $in_time
 * @property string $leave_time
 * @property integer $total_rooms
 * @property string $deposit
 * @property integer $likes
 * @property integer $audit_state
 * @property integer $audit_user
 * @property integer $audit_time
 * @property integer $state
 * @property integer $is_del
 * @property integer $add_time
 * @property integer $add_user
 * @property integer $update_time
 * @property integer $update_user
 */
class O2oHotel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o2o_hotel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_type', 'house_id', 'brand_id', 'hotel_star', 'city_id', 'open_year', 'update_year', 'total_rooms', 'likes', 'audit_state', 'audit_user', 'audit_time', 'state', 'is_del', 'add_time', 'add_user', 'update_time', 'update_user'], 'integer'],
            [['price', 'longitude', 'latitude'], 'number'],
            [['hotel_tel', 'open_year', 'update_year', 'add_time', 'add_user'], 'required'],
            [['hotel_name'], 'string', 'max' => 50],
            [['hotel_intro'], 'string', 'max' => 200],
            [['hotel_img', 'address', 'facilities', 'deposit'], 'string', 'max' => 100],
            [['hotel_tel'], 'string', 'max' => 20],
            [['in_time', 'leave_time'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hotel_id' => 'Hotel ID',
            'hotel_name' => 'Hotel Name',
            'hotel_intro' => 'Hotel Intro',
            'hotel_type' => 'Hotel Type',
            'house_id' => 'House ID',
            'brand_id' => 'Brand ID',
            'hotel_star' => 'Hotel Star',
            'hotel_img' => 'Hotel Img',
            'price' => 'Price',
            'city_id' => 'City ID',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'address' => 'Address',
            'hotel_tel' => 'Hotel Tel',
            'facilities' => 'Facilities',
            'open_year' => 'Open Year',
            'update_year' => 'Update Year',
            'in_time' => 'In Time',
            'leave_time' => 'Leave Time',
            'total_rooms' => 'Total Rooms',
            'deposit' => 'Deposit',
            'likes' => 'Likes',
            'audit_state' => 'Audit State',
            'audit_user' => 'Audit User',
            'audit_time' => 'Audit Time',
            'state' => 'State',
            'is_del' => 'Is Del',
            'add_time' => 'Add Time',
            'add_user' => 'Add User',
            'update_time' => 'Update Time',
            'update_user' => 'Update User',
        ];
    }
}
