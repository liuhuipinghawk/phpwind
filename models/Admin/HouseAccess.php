<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "house_access".
 *
 * @property integer $id
 * @property integer $house_id
 * @property string $access
 * @property string $home
 */
class HouseAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id','access','home'], 'required'],
            [['house_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'house_id' => '楼盘名称序号',
            'access' => '增值服务权限',
            'home' => '首页图标权限',
        ];
    }
}
