<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "o2o_baspeak".
 *
 * @property integer $baspeak_id
 * @property string $project_name
 * @property integer $baspeak_time
 * @property integer $end_time
 * @property string $tell
 * @property string $persion
 * @property string $price
 * @property integer $state
 */
class Baspeak extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o2o_baspeak';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['baspeak_time', 'end_time', 'state'], 'integer'],
            [['price'], 'number'],
            [['project_name'], 'string', 'max' => 35],
            [['tell'], 'string', 'max' => 11],
            [['persion'], 'string', 'max' => 10],
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
            'baspeak_time' => 'Baspeak Time',
            'end_time' => 'End Time',
            'tell' => 'Tell',
            'persion' => 'Persion',
            'price' => 'Price',
            'state' => 'State',
        ];
    }
}
