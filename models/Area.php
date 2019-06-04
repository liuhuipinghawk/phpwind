<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "o2o_area".
 *
 * @property integer $area_id
 * @property string $area_name
 * @property integer $create_time
 * @property integer $update_time
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o2o_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'integer'],
            [['area_name'], 'string', 'max' => 35],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'area_id' => 'Area ID',
            'area_name' => 'Area Name',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
