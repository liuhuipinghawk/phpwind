<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "o2o_furniture".
 *
 * @property integer $furniture_id
 * @property string $furniture_name
 * @property double $price
 * @property integer $pid
 * @property string $thumb
 * @property string $content
 * @property integer $create_time
 * @property integer $update_time
 */
class Furniture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o2o_furniture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['furniture_name','content','price','thumb'],'required','message'=>'{attribute}不能为空'],
            [['price'], 'number'],
            [['pid', 'create_time', 'update_time'], 'integer'],
            [['content'], 'string'],
            [['furniture_name'], 'string', 'max' => 25],
            [['thumb'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'furniture_id' => 'Furniture ID',
            'furniture_name' => '办公家具名称',
            'price' => '价格',
            'pid' => '分类名称',
            'thumb' => '办公家具logo',
            'content' => '服务内容',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
