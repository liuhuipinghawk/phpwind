<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $articleId
 * @property integer $cateId
 * @property integer $houseId
 * @property string $adminName
 * @property string $headImg
 * @property string $thumb
 * @property string $content
 * @property string $title
 * @property integer $status
 * @property integer $stars
 * @property string $createTime
 * @property string $updateTime
 * @property string $introduction
 * @property string $url
 * @property string $point_state
 * @property integer $comment_count
 */
class article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cateId', 'houseId', 'status', 'stars', 'comment_count'], 'integer'],
            [['content'], 'string'],
            [['comment_count'], 'required'],
            [['adminName'], 'string', 'max' => 30],
            [['headImg'], 'string', 'max' => 1000],
            [['thumb', 'introduction', 'url'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 60],
            [['createTime', 'updateTime'], 'string', 'max' => 100],
            [['point_state'], 'string', 'max' => 225],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'articleId' => 'Article ID',
            'cateId' => 'Cate ID',
            'houseId' => 'House ID',
            'adminName' => 'Admin Name',
            'headImg' => 'Head Img',
            'thumb' => 'Thumb',
            'content' => 'Content',
            'title' => 'Title',
            'status' => 'Status',
            'stars' => 'Stars',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
            'introduction' => 'Introduction',
            'url' => 'Url',
            'point_state' => 'Point State',
            'comment_count' => 'Comment Count',
        ];
    }
}
