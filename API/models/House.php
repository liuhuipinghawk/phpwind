<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "house".
 *
 * @property integer $id
 * @property string $housename
 * @property integer $cityid
 */
class House extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cityid'], 'integer'],
            [['housename'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'housename' => 'Housename',
            'cityid' => 'Cityid',
        ];
    }
}
