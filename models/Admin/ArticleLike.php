<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "article_like".
 *
 * @property integer $id
 * @property integer $articleId
 * @property integer $user_id
 */
class ArticleLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['articleId', 'user_id'], 'required'],
            [['articleId', 'user_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'articleId' => 'Article ID',
            'user_id' => 'User ID',
        ];
    }
}
