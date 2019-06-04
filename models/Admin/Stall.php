<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "stall".
 *
 * @property integer $id
 * @property integer $house_id
 * @property integer $stall_num
 * @property integer $stall_sold
 * @property integer $stall_rent
 * @property integer $stall_other
 * @property integer $user_id
 * @property integer $time
 */
class Stall extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stall';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id', 'stall_num', 'user_id', 'time'], 'required'],
            [['house_id', 'stall_num', 'user_id', 'time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'house_id' => '项目id',
            'stall_num' => '车位总数量',
            'user_id' => '添加人id',
            'time' => '添加修改时间',
            'housename'=>'项目名称'
        ];
    }
    public function getHouse(){
        return $this->hasOne(House::className(),['id'=>'house_id']);
    }
    public function getAdmin(){
        return $this->hasOne(Admin::className(),['adminid'=>'user_id']);
    }
}
