<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "order_remind".
 *
 * @property string $id
 * @property integer $remind_type
 * @property integer $house_id
 * @property integer $seat_id
 * @property string $room_num
 * @property string $money
 * @property integer $user_id
 * @property integer $order_id
 * @property integer $add_time
 */
class OrderRemind extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_remind';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'remind_type' => 'Remind Type',
            'house_id' => 'House ID',
            'seat_id' => 'Seat ID',
            'room_num' => 'Room Num',
            'money' => 'Money',
            'user_id' => 'User ID',
            'order_id' => 'Order ID',
            'add_time' => 'Add Time',
        ];
    }
}
