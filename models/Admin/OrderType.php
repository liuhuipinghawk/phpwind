<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "order_type".
 *
 * @property string $id
 * @property string $type_name
 * @property integer $parent_id
 * @property string $remark
 * @property integer $is_del
 * @property integer $add_time
 * @property integer $add_user
 * @property integer $edit_time
 * @property integer $edit_user
 * @property integer $del_time
 * @property integer $del_user
 */
class OrderType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'is_del', 'add_time', 'add_user', 'edit_time', 'edit_user', 'del_time', 'del_user'], 'integer'],
            [['type_name'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_name' => 'Type Name',
            'parent_id' => 'Parent ID',
            'remark' => 'Remark',
            'is_del' => 'Is Del',
            'add_time' => 'Add Time',
            'add_user' => 'Add User',
            'edit_time' => 'Edit Time',
            'edit_user' => 'Edit User',
            'del_time' => 'Del Time',
            'del_user' => 'Del User',
        ];
    }
}
