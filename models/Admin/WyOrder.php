<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "wy_order".
 *
 * @property integer $wyorderId
 * @property integer $houseId
 * @property integer $userId
 * @property string $userName
 * @property string $Address
 * @property string $content
 * @property string $thumb
 * @property string $orderTime
 * @property string $ContactPersion
 * @property string $ContactNumber
 * @property integer $status
 */
class WyOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wy_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['houseId', 'userId', 'status'], 'integer'],
            [['userName', 'ContactNumber'], 'string', 'max' => 50],
            [['Address', 'thumb'], 'string', 'max' => 255],
            [['content'], 'string', 'max' => 130],
            [['orderTime'], 'string', 'max' => 150],
            [['ContactPersion'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wyorderId' => 'Wyorder ID',
            'houseId' => 'House ID',
            'userId' => 'User ID',
            'userName' => 'User Name',
            'Address' => 'Address',
            'content' => 'Content',
            'thumb' => 'Thumb',
            'orderTime' => 'Order Time',
            'ContactPersion' => 'Contact Persion',
            'ContactNumber' => 'Contact Number',
            'status' => 'Status',
        ];
    }
}
