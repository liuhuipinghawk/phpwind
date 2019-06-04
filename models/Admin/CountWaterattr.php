<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "count_waterattr".
 *
 * @property integer $id
 * @property integer $water_id
 * @property integer $time
 * @property integer $create_time
 * @property integer $total
 * @property integer $public
 * @property integer $office
 * @property integer $hold
 * @property integer $meter_time
 */
class CountWaterattr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'count_waterattr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['water_id', 'time', 'create_time', 'total', 'public', 'office', 'hold', 'meter_time'], 'required'],
            [['water_id', 'time', 'create_time', 'total', 'public', 'office', 'hold', 'meter_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'water_id' => 'Water ID',
            'time' => 'Time',
            'create_time' => 'Create Time',
            'total' => 'Total',
            'public' => 'Public',
            'office' => 'Office',
            'hold' => 'Hold',
            'meter_time' => 'Meter Time',
        ];
    }
}
