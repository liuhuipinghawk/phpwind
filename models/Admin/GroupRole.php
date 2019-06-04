<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "user_group_role".
 *
 * @property integer $id
 * @property integer $group_id
 * @property integer $role_id
 * @property integer $create_time
 */
class GroupRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_group_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'role_id', 'create_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group ID',
            'role_id' => 'Role ID',
            'create_time' => 'Create Time',
        ];
    }
}
