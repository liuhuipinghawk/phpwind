<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "house_publish".
 *
 * @property string $publish_id
 * @property integer $house_type
 * @property integer $house_id
 * @property integer $region_id
 * @property integer $subway_id
 * @property string $price
 * @property string $space
 * @property string $unit
 * @property string $img_3d
 * @property integer $age
 * @property string $floor
 * @property integer $deco_id
 * @property integer $orien_id
 * @property string $house_desc
 * @property string $address
 * @property string $person
 * @property string $person_tel
 * @property integer $status
 * @property integer $is_del
 * @property integer $publish_time
 * @property integer $publish_user
 * @property integer $edit_time
 * @property integer $edit_user
 */
class Publish extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_publish';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_type', 'house_id', 'region_id', 'subway_id', 'age', 'deco_id', 'orien_id', 'status', 'is_del', 'publish_time', 'publish_user', 'edit_time', 'edit_user'], 'integer'],
            [['price', 'space'], 'number'],
            [['house_desc'], 'required'],
            [['house_desc'], 'string'],
            [['unit', 'person', 'person_tel'], 'string', 'max' => 20],
            [['img_3d'], 'string', 'max' => 255],
            [['floor'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'publish_id' => 'Publish ID',
            'house_type' => 'House Type',
            'house_id' => 'House ID',
            'region_id' => 'Region ID',
            'subway_id' => 'Subway ID',
            'price' => 'Price',
            'space' => 'Space',
            'unit' => 'Unit',
            'img_3d' => 'Img 3d',
            'age' => 'Age',
            'floor' => 'Floor',
            'deco_id' => 'Deco ID',
            'orien_id' => 'Orien ID',
            'house_desc' => 'House Desc',
            'address' => 'Address',
            'person' => 'Person',
            'person_tel' => 'Person Tel',
            'status' => 'Status',
            'is_del' => 'Is Del',
            'publish_time' => 'Publish Time',
            'publish_user' => 'Publish User',
            'edit_time' => 'Edit Time',
            'edit_user' => 'Edit User',
        ];
    }
}
