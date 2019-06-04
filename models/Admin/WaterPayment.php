<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "water_payment".
 *
 * @property integer $order_id
 * @property integer $user_id
 * @property integer $account_id
 * @property string $order_sn
 * @property integer $water_consumption
 * @property integer $create_time
 * @property string $water_fee
 * @property integer $status
 * @property integer $pay_type
 * @property integer $water_time
 * @property string $trade_no
 * @property integer $invoice_type
 * @property string $invoice_name
 * @property string $invoice_num
 */
class WaterPayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'water_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'account_id', 'create_time', 'status', 'pay_type', 'water_time', 'invoice_type'], 'integer'],
            [['order_sn'], 'string', 'max' => 32],
            [['trade_no'], 'string', 'max' => 64],
            [['invoice_name'], 'string', 'max' => 50],
            [['invoice_num'], 'string', 'max' => 20],
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
            'account_id' => 'Account ID',
            'order_sn' => 'Order Sn',
            'water_consumption' => 'Water Consumption',
            'create_time' => 'Create Time',
            'water_fee' => 'Water Fee',
            'status' => 'Status',
            'pay_type' => 'Pay Type',
            'water_time' => 'Water Time',
            'trade_no' => 'Trade No',
            'invoice_type' => 'Invoice Type',
            'invoice_name' => 'Invoice Name',
            'invoice_num' => 'Invoice Num',
        ];
    }
}
