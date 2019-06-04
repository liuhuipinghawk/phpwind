<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $Id
 * @property string $OrderId
 * @property integer $UserId
 * @property integer $HouseId
 * @property integer $SeatId
 * @property string $RoomNum
 * @property string $Address
 * @property string $Company
 * @property string $Title
 * @property string $Content
 * @property string $OrderTime
 * @property string $PublishTime
 * @property string $EndTime
 * @property string $Persion
 * @property string $Number
 * @property string $Tumb
 * @property integer $Status
 * @property integer $maintenanceType
 * @property integer $repair_id
 * @property string $repair_name
 * @property string $repair_tel
 * @property integer $deal_time
 * @property integer $deal_user
 * @property integer $start_time
 * @property integer $complate_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['UserId', 'HouseId', 'SeatId', 'Status', 'maintenanceType', 'repair_id', 'deal_time', 'deal_user', 'start_time', 'complate_time'], 'integer'],
            [['OrderId', 'Address', 'Company', 'Content', 'OrderTime', 'PublishTime', 'EndTime', 'Persion', 'Number', 'Tumb'], 'string', 'max' => 255],
            [['RoomNum'], 'string', 'max' => 55],
            [['Title'], 'string', 'max' => 50],
            [['repair_name', 'repair_tel'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'OrderId' => 'Order ID',
            'UserId' => 'User ID',
            'HouseId' => 'House ID',
            'SeatId' => 'Seat ID',
            'RoomNum' => 'Room Num',
            'Address' => 'Address',
            'Company' => 'Company',
            'Title' => 'Title',
            'Content' => 'Content',
            'OrderTime' => 'Order Time',
            'PublishTime' => 'Publish Time',
            'EndTime' => 'End Time',
            'Persion' => 'Persion',
            'Number' => 'Number',
            'Tumb' => 'Tumb',
            'Status' => 'Status',
            'maintenanceType' => 'Maintenance Type',
            'repair_id' => 'Repair ID',
            'repair_name' => 'Repair Name',
            'repair_tel' => 'Repair Tel',
            'deal_time' => 'Deal Time',
            'deal_user' => 'Deal User',
            'start_time' => 'Start Time',
            'complate_time' => 'Complate Time',
        ];
    }
}
