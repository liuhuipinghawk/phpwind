<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "o2o_brand".
 *
 * @property string $brand_id
 * @property string $brand_name
 * @property integer $type
 */
class O2oBrand extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o2o_brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand_name'], 'required'],
            [['type'], 'integer'],
            [['brand_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'brand_id' => 'Brand ID',
            'brand_name' => 'Brand Name',
            'type' => 'Type',
        ];
    }
}
