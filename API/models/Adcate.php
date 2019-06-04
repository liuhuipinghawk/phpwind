<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "adcate".
 *
 * @property integer $adCateId
 * @property string $adCateName
 * @property integer $parentId
 * @property string $createTime
 * @property string $updateTime
 */
class Adcate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'adcate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentId'], 'integer'],
            [['adCateName'], 'string', 'max' => 30],
            [['createTime', 'updateTime'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adCateId' => 'Ad Cate ID',
            'adCateName' => 'Ad Cate Name',
            'parentId' => 'Parent ID',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
        ];
    }
}
