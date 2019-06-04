<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "learn_like".
 *
 * @property string $like_id
 * @property integer $learn_id
 * @property integer $user_id
 * @property integer $add_time
 */
class LearnLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'learn_like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['learn_id', 'user_id', 'add_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'like_id' => 'Like ID',
            'learn_id' => 'Learn ID',
            'user_id' => 'User ID',
            'add_time' => 'Add Time',
        ];
    }
}
