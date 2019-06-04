<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "electric_order".
 *
 * @property string $order_id
 * @property string $order_sn
 * @property integer $account_id
 * @property integer $ammeter_id
 * @property integer $house_id
 * @property integer $seat_id
 * @property string $room_num
 * @property integer $user_id
 * @property integer $rate
 * @property string $money
 * @property integer $add_time
 * @property integer $pay_type
 * @property integer $pay_status
 * @property integer $pay_time
 * @property integer $order_status
 * @property integer $send_time
 * @property integer $op_user
 * @property string $trade_no
 * @property integer $is_del
 * @property integer $invoice_type
 * @property string $invoice_name
 * @property string $invoice_num
 */
class ElectricOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'electric_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'ammeter_id', 'house_id', 'seat_id', 'user_id', 'rate', 'add_time', 'pay_type', 'pay_status', 'pay_time', 'order_status', 'send_time', 'op_user', 'is_del', 'invoice_type'], 'integer'],
            [['money'], 'number'],
            [['order_sn', 'invoice_name'], 'string', 'max' => 50],
            [['room_num', 'invoice_num'], 'string', 'max' => 20],
            [['trade_no'], 'string', 'max' => 64],
            [['remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_sn' => 'Order Sn',
            'account_id' => 'Account ID',
            'ammeter_id' => 'Ammeter ID',
            'house_id' => 'House ID',
            'seat_id' => 'Seat ID',
            'room_num' => 'Room Num',
            'user_id' => 'User ID',
            'rate' => 'Rate',
            'money' => 'Money',
            'add_time' => 'Add Time',
            'pay_type' => 'Pay Type',
            'pay_status' => 'Pay Status',
            'pay_time' => 'Pay Time',
            'order_status' => 'Order Status',
            'send_time' => 'Send Time',
            'op_user' => 'Op User',
            'trade_no' => 'Trade No',
            'is_del' => 'Is Del',
            'invoice_type' => 'Invoice Type',
            'invoice_name' => 'Invoice Name',
            'invoice_num' => 'Invoice Num',
            'remark' => 'Remark',
        ];
    }
}
