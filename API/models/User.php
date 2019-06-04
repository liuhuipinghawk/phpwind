<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $UserId
 * @property string $Tell
 * @property string $PassWord
 * @property string $CreateTime
 * @property string $UpdateTime
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%user}}";
    }
}
