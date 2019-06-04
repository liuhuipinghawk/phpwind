<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "maintenancetype".
 *
 * @property integer $id
 * @property string $housename
 * @property integer $parentId
 * @property string $createtime
 * @property string $updatetime
 */
class Maintenancetype extends \yii\db\ActiveRecord
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
            'id' => 'ID',
            'housename' => 'Housename',
            'parentId' => 'Parent ID',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
}
