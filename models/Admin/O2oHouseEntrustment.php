<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "o2o_house_entrustment".
 *
 * @property string $id
 * @property integer $user_id
 * @property integer $house_id
 * @property integer $house_type
 * @property string $house_area
 * @property string $address
 * @property string $person_name
 * @property string $person_tel
 * @property integer $add_time
 * @property integer $status
 * @property integer $is_del
 * @property integer $deal_time
 * @property integer $deal_user
 */
class O2oHouseEntrustment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o2o_house_entrustment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'house_id', 'house_type', 'add_time', 'status', 'is_del', 'deal_time', 'deal_user'], 'integer'],
            [['house_area'], 'number'],
            [['address'], 'string', 'max' => 200],
            [['person_name', 'person_tel'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'house_id' => 'House ID',
            'house_type' => 'House Type',
            'house_area' => 'House Area',
            'address' => 'Address',
            'person_name' => 'Person Name',
            'person_tel' => 'Person Tel',
            'add_time' => 'Add Time',
            'status' => 'Status',
            'is_del' => 'Is Del',
            'deal_time' => 'Deal Time',
            'deal_user' => 'Deal User',
        ];
    }
}
