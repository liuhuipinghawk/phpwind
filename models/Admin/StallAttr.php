<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "stall_attr".
 *
 * @property integer $id
 * @property integer $stall_id
 * @property integer $user_id
 * @property integer $create_time
 * @property integer $sold
 * @property integer $rent
 * @property integer $other
 */
class StallAttr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stall_attr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stall_id', 'user_id', 'create_time', 'sold', 'rent', 'other'], 'required'],
            [['stall_id', 'user_id', 'create_time', 'sold', 'rent', 'other'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stall_id' => 'Stall ID',
            'user_id' => 'User ID',
            'create_time' => 'Create Time',
            'sold' => 'Sold',
            'rent' => 'Rent',
            'other' => 'Other',
        ];
    }
}
