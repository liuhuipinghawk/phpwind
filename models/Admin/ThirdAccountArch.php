<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "third_account_arch".
 *
 * @property string $id
 * @property integer $area_id
 * @property integer $house_id
 * @property integer $arch_id
 * @property string $arch_name
 * @property integer $seat_id
 * @property integer $arch_storys
 * @property integer $arch_begin
 * @property string $arch_unit
 */
class ThirdAccountArch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'third_account_arch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id', 'house_id', 'arch_id', 'seat_id', 'arch_storys', 'arch_begin'], 'integer'],
            [['arch_name', 'arch_unit'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'area_id' => 'Area ID',
            'house_id' => 'House ID',
            'arch_id' => 'Arch ID',
            'arch_name' => 'Arch Name',
            'seat_id' => 'Seat ID',
            'arch_storys' => 'Arch Storys',
            'arch_begin' => 'Arch Begin',
            'arch_unit' => 'Arch Unit',
        ];
    }
}
