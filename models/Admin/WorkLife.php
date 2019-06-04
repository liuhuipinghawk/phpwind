<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "work_life".
 *
 * @property integer $id
 * @property string $name
 * @property integer $house_id
 */
class WorkLife extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_life';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'house_id'], 'required'],
            [['house_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'house_id' => 'House ID',
        ];
    }
}
