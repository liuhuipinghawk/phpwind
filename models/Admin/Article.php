<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property integer $articleId
 * @property integer $cateId
 * @property integer $houseId
 * @property string $company
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
class Article extends \yii\db\ActiveRecord
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
            [['company', 'createTime', 'updateTime'], 'string', 'max' => 100],
            [['adminName'], 'string', 'max' => 30],
            [['headImg'], 'string', 'max' => 1000],
            [['thumb', 'introduction', 'url'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 60],
            [['point_state'], 'string', 'max' => 225],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'articleId' => '文章Id',
            'cateId' => '文章分类Id',
            'houseId' => '楼盘Id',
            'company' => '公司名称',
            'adminName' => '后台管理员',
            'headImg' => '头像',
            'thumb' => 'logo',
            'content' => '文章内容',
            'title' => '标题',
            'status' => '状态',
            'stars' => '星级',
            'createTime' => '添加时间',
            'updateTime' => '更新时间',
            'introduction' => '描述',
            'url' => 'Url',
            'point_state' => '点赞数',
            'comment_count' => '评论数',
        ];
    }
}
