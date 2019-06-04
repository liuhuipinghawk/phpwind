<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "work_weibao".
 *
 * @property integer $id
 * @property string $content
 * @property string $need
 * @property integer $type
 * @property integer $cast
 * @property string $create_time
 */
class WorkWeibao extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'work_weibao';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'need', 'type', 'cast', 'create_time'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'need' => 'Need',
            'type' => 'Type',
            'cast' => 'Cast',
            'create_time' => 'Create Time',
        ];
    }
}
