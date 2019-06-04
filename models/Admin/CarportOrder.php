<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "carport_order".
 *
 * @property string $order_id
 * @property integer $house_id
 * @property integer $seat_id
 * @property string $floor
 * @property string $person_name
 * @property string $person_tel
 * @property string $order_type
 * @property integer $user_id
 * @property integer $add_time
 * @property integer $is_del
 * @property integer $state
 * @property integer $deal_user
 * @property integer $deal_time
 */
class CarportOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'carport_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id', 'seat_id', 'user_id', 'add_time', 'is_del', 'state', 'deal_user', 'deal_time'], 'integer'],
            [['floor', 'person_tel', 'order_type'], 'string', 'max' => 20],
            [['person_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'house_id' => 'House ID',
            'seat_id' => 'Seat ID',
            'floor' => 'Floor',
            'person_name' => 'Person Name',
            'person_tel' => 'Person Tel',
            'order_type' => 'Order Type',
            'user_id' => 'User ID',
            'add_time' => 'Add Time',
            'is_del' => 'Is Del',
            'state' => 'State',
            'deal_user' => 'Deal User',
            'deal_time' => 'Deal Time',
        ];
    }
}
