<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "comter".
 *
 * @property integer $comterId
 */
class Comter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ,
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comterId' => 'Comter ID',
        ];
    }
}
