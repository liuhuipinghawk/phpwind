<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "o2o_plants".
 *
 * @property integer $plants_id
 * @property string $plants_name
 * @property integer $create_time
 * @property integer $update_time
 */
class Plants extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o2o_plants';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'integer'],
            [['plants_name'], 'string', 'max' => 35],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'plants_id' => 'Plants ID',
            'plants_name' => 'Plants Name',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
