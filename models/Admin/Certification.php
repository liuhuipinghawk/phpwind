<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "certification".
 *
 * @property integer $CertificationId
 * @property integer $UserId
 * @property integer $HouseId
 * @property integer $SeatId
 * @property string $Address
 * @property string $Company
 * @property string $Department
 * @property string $Position
 * @property integer $Maintenancetype
 * @property string $CreateTime
 * @property string $UpdateTime
 * @property integer $Status
 * @property integer $CateId
 */
class Certification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'certification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['UserId', 'HouseId', 'SeatId', 'Maintenancetype', 'Status', 'CateId'], 'integer'],
            [['Address', 'Company', 'Department', 'Position', 'CreateTime', 'UpdateTime'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CertificationId' => 'Certification ID',
            'UserId' => 'User ID',
            'HouseId' => 'House ID',
            'SeatId' => 'Seat ID',
            'Address' => 'Address',
            'Company' => 'Company',
            'Department' => 'Department',
            'Position' => 'Position',
            'Maintenancetype' => 'Maintenancetype',
            'CreateTime' => 'Create Time',
            'UpdateTime' => 'Update Time',
            'Status' => 'Status',
            'CateId' => 'Cate ID',
        ];
    }
}
