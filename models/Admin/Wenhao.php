<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "wenhao".
 *
 * @property integer $id
 * @property string $name
 * @property string $cases
 * @property string $department
 * @property string $position
 * @property string $title
 * @property integer $user_id
 * @property string $time
 */
class Wenhao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wenhao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'cases' => 'Cases',
            'department' => 'Department',
            'position' => 'Position',
            'title' => 'Title',
            'user_id' => 'User ID',
            'time' => 'Time',
        ];
    }
}
