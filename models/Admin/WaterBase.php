<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "water_base".
 *
 * @property integer $id
 * @property integer $house_id
 * @property integer $seat_id
 * @property string $meter_number
 * @property string $owner_name
 * @property string $monovalent
 * @property string $this_month
 * @property string $end_month
 * @property string $month_dosage
 * @property string $month_amount
 * @property integer $water_type
 * @property integer $create_time
 * @property integer $status
 * @property string $room_num
 */
class WaterBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'water_base';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_name','meter_number','room_num','monovalent','this_month','end_month','month_amount','month_dosage'],'required','message'=>'{attribute}不能为空'],
            [['house_id', 'seat_id', 'water_type', 'create_time', 'status'], 'integer'],
            [['monovalent', 'month_amount'], 'number'],
            [['meter_number'], 'string', 'max' => 330],
            [['owner_name'], 'string', 'max' => 20],
            [['this_month', 'end_month'], 'string', 'max' => 200],
            [['month_dosage'], 'string', 'max' => 60],
            [['room_num'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '水费Id',
            'house_id' => '楼盘Id',
            'seat_id' => '座号Id',
            'meter_number' => '水表号',
            'owner_name' => '业主名称',
            'monovalent' => '单价',
            'this_month' => '月初度数',
            'end_month' => '月末度数',
            'month_dosage' => '本月用量',
            'month_amount' => '本月金额',
            'water_type' => '水费类型',
            'create_time' => '创建时间',
            'status' => '状态',
            'room_num' => '房间号',
        ];
    }
}
