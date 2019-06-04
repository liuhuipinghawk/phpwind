<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $categoryId
 * @property string $categoryName
 * @property integer $parentId
 * @property string $createTime
 * @property string $updateTime
 */
class category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentId'], 'integer'],
            [['categoryName'], 'string', 'max' => 20],
            [['createTime', 'updateTime'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'categoryId' => 'Category ID',
            'categoryName' => 'Category Name',
            'parentId' => 'Parent ID',
            'createTime' => 'Create Time',
            'updateTime' => 'Update Time',
        ];
    }
}
