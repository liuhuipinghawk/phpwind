<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "workcard".
 *
 * @property integer $id
 * @property string $thumb
 * @property string $createTime
 */
class WorkCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'workcard';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thumb'], 'string', 'max' => 225],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thumb' => 'Thumb',
            'createTime' => 'Create Time',
        ];
    }
}
