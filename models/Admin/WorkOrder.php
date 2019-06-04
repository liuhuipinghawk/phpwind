<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "work_order".
 *
 * @property integer $id
 * @property integer $life_id
 * @property integer $admin_id
 * @property integer $type
 * @property string $create_time
 * @property integer $status
 * @property integer $user_id
 */
class WorkOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'life_id' => 'Life ID',
            'admin_id' => 'Admin ID',
            'type' => 'Type',
            'create_time' => 'Create Time',
            'status' => 'Status',
            'user_id' => 'User ID',
        ];
    }
}
