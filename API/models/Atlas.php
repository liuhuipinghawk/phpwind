<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "atlas".
 *
 * @property integer $Id
 * @property string $Thumb
 * @property string $CreateTime
 */
class Atlas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'atlas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Thumb'], 'string', 'max' => 550],
            [['CreateTime'], 'string', 'max' => 225],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Thumb' => 'Thumb',
            'CreateTime' => 'Create Time',
        ];
    }
}
