<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "app_user_position".
 *
 * @property string $position_id
 * @property string $position_name
 */
class UserPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_user_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['position_name','required','message'=>'{attribute}不能为空'],
            [['position_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'position_id' => '用户职位ID',
            'position_name' => '用户职位名称',
        ];
    }
}
