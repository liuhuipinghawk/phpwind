<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "ad".
 *
 * @property integer $adId
 * @property string $adName
 * @property integer $pid
 * @property string $thumb
 * @property string $url
 * @property string $createTime
 * @property string $updateTime
 */
class Ad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid'], 'integer'],
            [['adName'], 'string', 'max' => 30],
            [['thumb'], 'string', 'max' => 260],
            [['url'], 'string', 'max' => 200],
            [['createTime', 'updateTime'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adId' => 'Ad ID',
            'adName' => 'Ad Name',
            'pid' => 'Pid',
            'thumb' => 'Thumb',
            'url' => 'Url',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
        ];
    }
}
