<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property string $id
 * @property string $log_title
 * @property integer $log_id
 * @property integer $log_status
 * @property integer $log_time
 * @property string $log_method
 * @property string $remark
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['log_id', 'log_status', 'log_time'], 'integer'],
            [['log_title', 'log_method', 'remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'log_title' => 'Log Title',
            'log_id' => 'Log ID',
            'log_status' => 'Log Status',
            'log_time' => 'Log Time',
            'log_method' => 'Log Method',
            'remark' => 'Remark',
        ];
    }
}
