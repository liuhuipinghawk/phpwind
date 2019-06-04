<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "user_account".
 *
 * @property string $account_id
 * @property integer $house_id
 * @property integer $seat_id
 * @property string $room_num
 * @property integer $rate
 * @property string $owner
 * @property integer $user_id
 * @property integer $add_time
 * @property integer $is_del
 * @property integer $is_open
 * @property integer $ammeter_id
 */
class UserAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id', 'seat_id', 'rate', 'user_id', 'add_time', 'is_del', 'is_open', 'ammeter_id'], 'integer'],
            [['room_num', 'owner'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'account_id' => 'Account ID',
            'house_id' => 'House ID',
            'seat_id' => 'Seat ID',
            'room_num' => 'Room Num',
            'rate' => 'Rate',
            'owner' => 'Owner',
            'user_id' => 'User ID',
            'add_time' => 'Add Time',
            'is_del' => 'Is Del',
            'is_open' => 'Is Open',
            'ammeter_id' => 'Ammeter ID',
        ];
    }
}
