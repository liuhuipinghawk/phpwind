<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "o2o_position".
 *
 * @property integer $opsition_id
 * @property string $opsition_name
 * @property integer $create_time
 * @property integer $update_time
 */
class Position extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o2o_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'integer'],
            [['opsition_name'], 'string', 'max' => 35],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'opsition_id' => 'Opsition ID',
            'opsition_name' => 'Opsition Name',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
