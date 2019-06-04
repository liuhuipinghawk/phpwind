<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "idcard".
 *
 * @property integer $id
 * @property string $thumb
 * @property string $createTime
 */
class Idcard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'idcard';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thumb'], 'string', 'max' => 255],
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
