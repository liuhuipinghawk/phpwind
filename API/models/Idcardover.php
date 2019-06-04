<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "idcardover".
 *
 * @property integer $id
 * @property string $thumb
 * @property string $createTime
 */
class Idcardover extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'idcardover';
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
