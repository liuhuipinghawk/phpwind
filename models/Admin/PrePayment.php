<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "pre_payment".
 *
 * @property string $pre_id
 * @property string $prepay_id
 * @property string $order_sn
 * @property string $pay_fee
 * @property integer $create_time
 * @property integer $pay_type
 * @property integer $status
 * @property integer $pay_time
 */
class PrePayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pay_fee'], 'number'],
            [['create_time', 'pay_type', 'status', 'pay_time'], 'integer'],
            [['prepay_id'], 'string', 'max' => 100],
            [['order_sn'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pre_id' => 'Pre ID',
            'prepay_id' => 'Prepay ID',
            'order_sn' => 'Order Sn',
            'pay_fee' => 'Pay Fee',
            'create_time' => 'Create Time',
            'pay_type' => 'Pay Type',
            'status' => 'Status',
            'pay_time' => 'Pay Time',
        ];
    }
}
