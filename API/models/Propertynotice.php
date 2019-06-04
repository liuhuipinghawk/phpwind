<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "propertynotice".
 *
 * @property integer $pNoticeId
 * @property string $title
 * @property string $author
 * @property string $content
 * @property string $createTime
 * @property string $thumb
 */
class Propertynotice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'propertynotice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['title'], 'string', 'max' => 30],
            [['author'], 'string', 'max' => 60],
            [['createTime'], 'string', 'max' => 100],
            [['thumb'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pNoticeId' => 'P Notice ID',
            'title' => 'Title',
            'author' => 'Author',
            'content' => 'Content',
            'createTime' => 'Create Time',
            'thumb' => 'Thumb',
        ];
    }
}
