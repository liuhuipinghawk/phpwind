<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "o2o_implication".
 *
 * @property integer $implication_id
 * @property string $implication_name
 * @property integer $create_time
 * @property integer $update_time
 */
class Implication extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o2o_implication';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'integer'],
            [['implication_name'], 'string', 'max' => 35],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'implication_id' => 'Implication ID',
            'implication_name' => 'Implication Name',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
