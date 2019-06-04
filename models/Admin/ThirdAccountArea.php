<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "third_account_area".
 *
 * @property string $id
 * @property integer $area_id
 * @property string $area_name
 * @property integer $house_id
 */
class ThirdAccountArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'third_account_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area_id', 'house_id'], 'integer'],
            [['area_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'area_id' => 'Area ID',
            'area_name' => 'Area Name',
            'house_id' => 'House ID',
        ];
    }
}
