<?php

namespace app\models\Admin;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_base".
 *
 * @property string $id
 * @property integer $user_type
 * @property string $true_name
 * @property string $mobile
 * @property string $company
 * @property integer $house_id
 * @property string $house_name
 * @property integer $seat_id
 * @property string $seat_name
 * @property string $room_num
 * @property string $address
 */
class UserBase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_base';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['true_name','mobile','company','house_id','seat_id','room_num','address'],'required','message'=>'{attribute}不能为空'],
            [['user_type', 'house_id', 'seat_id'], 'integer'],
            [['mobile', 'company'], 'required'],
            [['true_name', 'mobile', 'house_name', 'seat_name', 'room_num'], 'string', 'max' => 20],
            [['company'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 100],           
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户信息Id',
            'user_type' => '用户信息类型',
            'true_name' => '真实姓名',
            'mobile' => '手机号',
            'company' => '公司名称',
            'house_id' => '楼盘Id',
            'house_name' => '楼盘名称',
            'seat_id' => '座号Id',
            'seat_name' => '座号名称',
            'room_num' => '房间号',
            'address' => '详细地址',
        ];
    }

    //获取楼盘/座号
    public function getHouseList($pid){
        $model = House::find()->where(array('parentId'=>$pid))->asArray()->all();
        return $model;
    }
}
