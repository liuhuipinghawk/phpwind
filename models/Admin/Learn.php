<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "learn".
 *
 * @property integer $id
 * @property string $title
 * @property integer $create_time
 * @property string $content
 * @property string $image
 * @property string $upload
 * @property integer $type
 * @property integer $comment_num
 * @property integer $read_num
 * @property integer $like_num
 * @property integer $download_num
 * @property integer $adminuser
 */
class Learn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'learn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'create_time', 'content', 'type', 'adminuser'], 'required'],
            [['create_time', 'type', 'comment_num', 'read_num', 'like_num', 'download_num'], 'integer'],
            [['content'], 'string'],
            [['title', 'image', 'upload'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '文章Id',
            'title' => '标题',
            'create_time' => '添加时间',
            'content' => '描述',
            'image' => '图片',
            'upload' => '文件',
            'type' => '类型',
            'comment_num' => '评论量',
            'read_num' => '阅读量',
            'like_num' => '点赞量',
            'download_num' => '下载量',
            'adminuser' => '发布人',
            'status' =>'置顶'
        ];
    }
}
