<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "service_order".
 *
 * @property string $order_id
 * @property integer $order_type
 * @property string $person_name
 * @property string $person_tel
 * @property integer $state
 * @property integer $is_del
 * @property integer $order_user
 * @property integer $add_time
 * @property integer $deal_user
 * @property integer $deal_time
 * @property integer $type_id
 */
class ServiceOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_type', 'state', 'is_del', 'order_user', 'add_time', 'deal_user', 'deal_time', 'type_id'], 'integer'],
            [['person_name'], 'string', 'max' => 20],
            [['person_tel'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_type' => 'Order Type',
            'person_name' => 'Person Name',
            'person_tel' => 'Person Tel',
            'state' => 'State',
            'is_del' => 'Is Del',
            'order_user' => 'Order User',
            'add_time' => 'Add Time',
            'deal_user' => 'Deal User',
            'deal_time' => 'Deal Time',
            'type_id' => 'Type ID',
        ];
    }
}
