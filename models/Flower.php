<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "o2o_flower".
 *
 * @property integer $flower_id
 * @property string $flower_name
 * @property integer $pid
 * @property integer $shopping_method
 * @property string $effect_plants
 * @property string $Pot_type
 * @property string $green_implication
 * @property string $covering_area
 * @property string $content
 * @property string $position
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $house_id
 * @property string $thumb
 * @property double $price
 * @property string $flower_desc
 * @property string $another_name
 * @property string $business_telephone
 */
class Flower extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o2o_flower';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flower_name','content','flower_desc','thumb','house_id','business_telephone','pid','price','effect_plants','Pot_type','green_implication','covering_area','position'],'required','message'=>'{attribute}不能为空'],
            [['pid', 'shopping_method', 'create_time', 'update_time'], 'integer'],
            [['content'], 'string'],
            [['price'], 'number'],
            [['flower_name', 'another_name'], 'string', 'max' => 35],
            [['effect_plants', 'Pot_type', 'green_implication', 'covering_area', 'position', 'flower_desc'], 'string', 'max' => 255],
            [['thumb'], 'string', 'max' => 355],
            [['business_telephone'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'flower_id' => '花卉Id',
            'flower_name' => '花卉名称',
            'pid' => '花卉分类Id',
            'shopping_method' => '选购方式',
            'effect_plants' => '绿植功效',
            'Pot_type' => '盆栽类型',
            'green_implication' => '绿植寓意',
            'covering_area' => '实用面积',
            'content' => '服务内容',
            'position' => '摆放位置',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'thumb' => 'Thumb',
            'price' => '价格',
            'flower_desc' => '花卉描述',
            'another_name' => '别名',
            'business_telephone' => '商家电话',
            'house_id' => '项目名称'
        ];
    }
}
