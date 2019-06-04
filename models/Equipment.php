<?php

namespace app\models;

use app\models\Admin\House;
use Yii;

/**
 * This is the model class for table "o2o_office_equipment".
 *
 * @property integer $equipment_id
 * @property string $equipment_name
 * @property integer $pid
 * @property integer $house_id
 * @property double $price
 * @property string $thumb
 * @property string $equipment_desc
 * @property string $content
 * @property integer $create_time
 * @property integer $update_time
 * @property string $business_telephone
 */
class Equipment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o2o_office_equipment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['equipment_name','content','equipment_desc','thumb','house_id','business_telephone'],'required','message'=>'{attribute}不能为空'],
            [['pid', 'create_time', 'update_time'], 'integer'],
            [['price'], 'number'],
            [['content'], 'string'],
            [['equipment_name'], 'string', 'max' => 35],
            [['thumb'], 'string', 'max' => 255],
            [['equipment_desc'], 'string', 'max' => 50],
            [['business_telephone'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'equipment_id' => '办公设备Id',
            'equipment_name' => '办公设备名称',
            'pid' => '分类名称id',
            'price' => '价格',
            'thumb' => '办公设备租赁logo',
            'equipment_desc' => '办公设备租赁描述',
            'content' => '参数',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'business_telephone' => '商家电话',
            'house_id' => '项目名称id'
        ];
    }
    public function getHouse(){
        return $this->hasOne(House::className(),['id'=>'house_id']);
    }
    public function getCategory(){
        return $this->hasOne(EquipmentCategory::className(),['category_id'=>'pid']);
    }
}
