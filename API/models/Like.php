<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "like".
 *
 * @property integer $likeId
 * @property integer $status
 * @property string $voteTime
 * @property integer $articleId
 * @property integer $userId
 */
class Like extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'articleId', 'userId'], 'integer'],
            [['voteTime'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'likeId' => 'Like ID',
            'status' => 'Status',
            'voteTime' => 'Vote Time',
            'articleId' => 'Article ID',
            'userId' => 'User ID',
        ];
    }
}
