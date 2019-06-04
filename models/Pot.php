<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "o2o_pot".
 *
 * @property integer $pot_id
 * @property string $pot_name
 * @property integer $create_time
 * @property integer $update_time
 */
class Pot extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o2o_pot';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'integer'],
            [['pot_name'], 'string', 'max' => 35],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pot_id' => 'Pot ID',
            'pot_name' => 'Pot Name',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
