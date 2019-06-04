<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "maintenancetype".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parentid
 * @property string $createtime
 * @property string $updatetime
 */
class Maintenancetype extends BaseCategory  
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'maintenancetype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['housename','parentId'],'required','message'=>'{attribute}不能为空'],
            [['parentId'], 'integer'],
            [['housename'], 'string', 'max' => 500],
            [['createtime', 'updatetime'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '维修类型Id',
            'housename' => '维修类型名称',
            'parentId' => '维修类型分类',
            'createtime' => '添加时间',
            'updatetime' => '更新时间',
        ];
    }
}
