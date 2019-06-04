<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "parking_payment".
 *
 * @property string $order_id
 * @property integer $user_id
 * @property string $order_sn
 * @property string $record_code
 * @property string $parking_code
 * @property string $parking_name
 * @property string $car_no
 * @property string $park_card
 * @property integer $begin_time
 * @property integer $create_time
 * @property string $parking_fee
 * @property integer $status
 * @property integer $pay_type
 * @property integer $pay_time
 */
class ParkingPayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'parking_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'begin_time', 'create_time', 'status', 'pay_type', 'pay_time'], 'integer'],
            [['parking_fee'], 'number'],
            [['order_sn', 'record_code', 'park_card'], 'string', 'max' => 32],
            [['parking_code', 'parking_name'], 'string', 'max' => 20],
            [['car_no'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'user_id' => 'User ID',
            'order_sn' => 'Order Sn',
            'record_code' => 'Record Code',
            'parking_code' => 'Parking Code',
            'parking_name' => 'Parking Name',
            'car_no' => 'Car No',
            'park_card' => 'Park Card',
            'begin_time' => 'Begin Time',
            'create_time' => 'Create Time',
            'parking_fee' => 'Parking Fee',
            'status' => 'Status',
            'pay_type' => 'Pay Type',
            'pay_time' => 'Pay Time',
        ];
    }
}
