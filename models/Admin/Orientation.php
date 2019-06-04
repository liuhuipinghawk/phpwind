<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "house_orientation".
 *
 * @property string $orien_id
 * @property string $orien_name
 */
class Orientation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_orientation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orien_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'orien_id' => 'Orien ID',
            'orien_name' => 'Orien Name',
        ];
    }
}
