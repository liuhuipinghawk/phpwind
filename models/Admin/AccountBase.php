<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "account_base".
 *
 * @property string $id
 * @property integer $house_id
 * @property integer $seat_id
 * @property string $room_num
 * @property string $owner
 * @property integer $rate
 */
class AccountBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account_base';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id', 'seat_id', 'rate'], 'integer'],
            [['room_num', 'owner'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'house_id' => 'House ID',
            'seat_id' => 'Seat ID',
            'room_num' => 'Room Num',
            'owner' => 'Owner',
            'rate' => 'Rate',
        ];
    }
}
