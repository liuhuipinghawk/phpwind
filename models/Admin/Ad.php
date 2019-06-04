<?php

namespace app\models\Admin;

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
            [['adName','thumb'],'required','message'=>'{attribute}不能为空'],
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
            'adId' => '广告ID',
            'adName' => '广告名称',
            'pid' => '上级分类',
            'thumb' => '图片路径',
            'url' => '链接',
            'createTime' => '添加时间',
            'updateTime' => '更新时间',
        ];
    }
}
