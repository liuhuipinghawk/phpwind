<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "third_account_base".
 *
 * @property string $base_id
 * @property integer $area_id
 * @property integer $arch_id
 * @property integer $house_id
 * @property integer $seat_id
 * @property integer $floor
 * @property string $room_name
 * @property string $ammeter_id
 */
class ThirdAccountBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'third_account_base';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id', 'arch_id', 'house_id', 'seat_id', 'floor'], 'integer'],
            [['room_name', 'ammeter_id'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'base_id' => 'Base ID',
            'area_id' => 'Area ID',
            'arch_id' => 'Arch ID',
            'house_id' => 'House ID',
            'seat_id' => 'Seat ID',
            'floor' => 'Floor',
            'room_name' => 'Room Name',
            'ammeter_id' => 'Ammeter ID',
        ];
    }
}
