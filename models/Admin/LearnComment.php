<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "learn_comment".
 *
 * @property string $comment_id
 * @property integer $learn_id
 * @property integer $user_id
 * @property string $comment
 * @property integer $add_time
 * @property string $reply
 * @property integer $reply_user
 * @property integer $reply_time
 */
class LearnComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'learn_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['learn_id', 'user_id', 'add_time', 'reply_user', 'reply_time'], 'integer'],
            [['comment', 'reply'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => 'Comment ID',
            'learn_id' => 'Learn ID',
            'user_id' => 'User ID',
            'comment' => 'Comment',
            'add_time' => 'Add Time',
            'reply' => 'Reply',
            'reply_user' => 'Reply User',
            'reply_time' => 'Reply Time',
        ];
    }
}
