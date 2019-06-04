<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "loss_register".
 *
 * @property string $reg_id
 * @property string $content
 * @property integer $reg_time
 * @property integer $reg_user
 * @property integer $name
 * @property integer $mobile
 * @property integer $house_id
 */
class LossRegister extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'loss_register';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reg_time', 'reg_user'], 'integer'],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reg_id' => 'Reg ID',
            'content' => 'Content',
            'reg_time' => 'Reg Time',
            'reg_user' => 'Reg User',
        ];
    }
}
