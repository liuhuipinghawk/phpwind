<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "property_pay".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $account_id
 * @property string $order_sn
 * @property integer $create_time
 * @property string $money
 * @property integer $status
 * @property integer $pay_type
 * @property integer $pay_time
 * @property string $trade_no
 * @property integer $invoice_id
 */
class PropertyPay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'property_pay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time', 'money'], 'required'],
            [['user_id', 'account_id', 'create_time', 'status', 'pay_type', 'pay_time', 'invoice_id'], 'integer'],
            [['money'], 'number'],
            [['order_sn'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'account_id' => 'Account ID',
            'order_sn' => 'Order Sn',
            'create_time' => 'Create Time',
            'money' => 'Money',
            'status' => 'Status',
            'pay_type' => 'Pay Type',
            'pay_time' => 'Pay Time',
            'trade_no' => 'Trade No',
            'invoice_id' => 'Invoice ID',
        ];
    }
}
