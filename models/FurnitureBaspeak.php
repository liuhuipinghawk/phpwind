<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "o2o_furniture_baspeak".
 *
 * @property integer $baspeak_id
 * @property string $project_name
 * @property integer $paspeak_time
 * @property integer $end_time
 * @property string $tell
 * @property string $persion
 */
class FurnitureBaspeak extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o2o_furniture_baspeak';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['baspeak_id', 'paspeak_time', 'end_time'], 'integer'],
            [['project_name', 'persion'], 'string', 'max' => 35],
            [['tell'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'baspeak_id' => 'Baspeak ID',
            'project_name' => 'Project Name',
            'paspeak_time' => 'Paspeak Time',
            'end_time' => 'End Time',
            'tell' => 'Tell',
            'persion' => 'Persion',
        ];
    }
}
