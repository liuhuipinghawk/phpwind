<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "headavatar".
 *
 * @property integer $headAvaterId
 * @property integer $userId
 * @property string $headImg
 * @property string $createTime
 */
class Headavatar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'headavatar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId'], 'integer'],
            [['headImg'], 'string', 'max' => 500],
            [['createTime'], 'string', 'max' => 110],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'headAvaterId' => 'Head Avater ID',
            'userId' => 'User ID',
            'headImg' => 'Head Img',
            'createTime' => 'Create Time',
        ];
    }
}
