<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "count_electr".
 *
 * @property integer $id
 * @property integer $house_id
 * @property integer $create_time
 * @property integer $user_id
 * @property string $area
 */
class CountElectr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'count_electr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id', 'create_time', 'user_id', 'area'], 'required'],
            [['house_id', 'create_time', 'user_id'], 'integer'],
            [['area'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'house_id' => '项目ID',
            'create_time' => '添加时间',
            'user_id' => '添加人ID',
            'area' => '公区面积',
        ];
    }
    public function getHouse(){
        return $this->hasOne(House::className(),['id'=>'house_id']);
    }
    public function getAdmin(){
        return $this->hasOne(Admin::className(),['adminid'=>'user_id']);
    }
}
