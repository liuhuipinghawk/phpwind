<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "dispatch".
 *
 * @property integer $dispatchId
 * @property integer $userId
 * @property string $userName
 * @property string $orderInfo
 * @property string $address
 * @property string $dispatchTime
 * @property integer $comterId
 */
class Dispatch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dispatch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'comterId'], 'integer'],
            [['userName'], 'string', 'max' => 255],
            [['orderInfo', 'address'], 'string', 'max' => 150],
            [['dispatchTime'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dispatchId' => 'Dispatch ID',
            'userId' => 'User ID',
            'userName' => 'User Name',
            'orderInfo' => 'Order Info',
            'address' => 'Address',
            'dispatchTime' => 'Dispatch Time',
            'comterId' => 'Comter ID',
        ];
    }
}
