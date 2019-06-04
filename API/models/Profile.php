<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property integer $profileId
 * @property integer $userId
 * @property string $nickName
 * @property string $profileTime
 * @property string $email
 * @property string $trueName
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId'], 'integer'],
            [['nickName'], 'string', 'max' => 30],
            [['profileTime'], 'string', 'max' => 110],
            [['email'], 'string', 'max' => 255],
            [['trueName'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'profileId' => 'Profile ID',
            'userId' => 'User ID',
            'nickName' => 'Nick Name',
            'profileTime' => 'Profile Time',
            'email' => 'Email',
            'trueName' => 'True Name',
        ];
    }
}
