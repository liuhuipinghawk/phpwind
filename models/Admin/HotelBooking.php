<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "hotel_booking".
 *
 * @property string $book_id
 * @property integer $hotel_id
 * @property integer $room_id
 * @property string $in_date
 * @property string $out_date
 * @property integer $days
 * @property integer $room_nums
 * @property string $price
 * @property string $total_price
 * @property string $person_name
 * @property string $person_tel
 * @property string $in_time
 * @property integer $book_time
 * @property integer $book_user
 * @property integer $is_del
 * @property integer $state
 * @property integer $deal_time
 * @property integer $deal_user
 */
class HotelBooking extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_booking';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'room_id', 'days', 'room_nums', 'book_time', 'book_user', 'is_del', 'state', 'deal_time', 'deal_user'], 'integer'],
            [['price', 'total_price'], 'number'],
            [['in_date', 'out_date'], 'string', 'max' => 10],
            [['person_name', 'person_tel', 'in_time'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'book_id' => 'Book ID',
            'hotel_id' => 'Hotel ID',
            'room_id' => 'Room ID',
            'in_date' => 'In Date',
            'out_date' => 'Out Date',
            'days' => 'Days',
            'room_nums' => 'Room Nums',
            'price' => 'Price',
            'total_price' => 'Total Price',
            'person_name' => 'Person Name',
            'person_tel' => 'Person Tel',
            'in_time' => 'In Time',
            'book_time' => 'Book Time',
            'book_user' => 'Book User',
            'is_del' => 'Is Del',
            'state' => 'State',
            'deal_time' => 'Deal Time',
            'deal_user' => 'Deal User',
        ];
    }
}
