<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "house_decoration".
 *
 * @property string $deco_id
 * @property string $deco_name
 */
class Decoration extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_decoration';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deco_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'deco_id' => 'Deco ID',
            'deco_name' => 'Deco Name',
        ];
    }
}
