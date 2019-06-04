<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "hotel_facilities".
 *
 * @property string $faci_id
 * @property string $faci_name
 * @property integer $faci_type
 * @property string $faci_icon
 * @property integer $add_time
 * @property integer $add_user
 * @property integer $update_time
 * @property integer $update_user
 * @property integer $state
 */
class HotelFacilities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_facilities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['faci_type', 'add_time', 'add_user', 'update_time', 'update_user', 'state'], 'integer'],
            [['add_time', 'add_user'], 'required'],
            [['faci_name'], 'string', 'max' => 20],
            [['faci_icon'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'faci_id' => 'Faci ID',
            'faci_name' => 'Faci Name',
            'faci_type' => 'Faci Type',
            'faci_icon' => 'Faci Icon',
            'add_time' => 'Add Time',
            'add_user' => 'Add User',
            'update_time' => 'Update Time',
            'update_user' => 'Update User',
            'state' => 'State',
        ];
    }
}
