<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "count_electrattr".
 *
 * @property integer $id
 * @property integer $electr_id
 * @property integer $time
 * @property integer $create_time
 * @property integer $total
 * @property integer $public
 * @property integer $office
 * @property integer $hold
 * @property integer $meter_time
 * @property integer $user_id
 * @property integer $self
 * @property integer $shop_pre
 * @property integer $hold_pre
 * @property integer $shop
 */
class CountElectrattr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'count_electrattr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['electr_id', 'time', 'create_time', 'total', 'public', 'office', 'hold', 'meter_time', 'user_id', 'self', 'shop_pre', 'hold_pre', 'shop'], 'required'],
            [['electr_id', 'time', 'create_time', 'total', 'public', 'office', 'hold', 'meter_time', 'user_id', 'self', 'shop_pre', 'hold_pre', 'shop'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'electr_id' => 'Electr ID',
            'time' => 'Time',
            'create_time' => 'Create Time',
            'total' => 'Total',
            'public' => 'Public',
            'office' => 'Office',
            'hold' => 'Hold',
            'meter_time' => 'Meter Time',
            'user_id' => 'User ID',
            'self' => 'Self',
            'shop_pre' => 'Shop Pre',
            'hold_pre' => 'Hold Pre',
            'shop' => 'Shop',
        ];
    }
}
