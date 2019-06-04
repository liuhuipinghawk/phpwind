<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "smscode".
 *
 * @property string $id
 * @property string $mobile
 * @property string $sms_code
 * @property integer $send_time
 */
class Smscode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'smscode';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['send_time'], 'integer'],
            [['mobile'], 'string', 'max' => 11],
            [['sms_code'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile' => 'Mobile',
            'sms_code' => 'Sms Code',
            'send_time' => 'Send Time',
        ];
    }
}
