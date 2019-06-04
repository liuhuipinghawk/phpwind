<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "commont".
 *
 * @property integer $commontId
 * @property integer $articleId
 * @property integer $userId
 * @property string $content
 * @property string $userName
 * @property string $headImg
 * @property integer $status
 * @property string $createTime
 */
class Commont extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'commont';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['articleId', 'userId', 'status'], 'integer'],
            [['userName', 'headImg'], 'string', 'max' => 255],
            [['createTime'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'commontId' => 'Commont ID',
            'articleId' => 'Article ID',
            'userId' => 'User ID',
            'content' => 'Content',
            'userName' => 'User Name',
            'headImg' => 'Head Img',
            'status' => 'Status',
            'createTime' => 'Commont Time',
        ];
    }
}
