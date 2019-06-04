<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "lottery_user".
 *
 * @property string $id
 * @property integer $user_id
 * @property integer $house_id
 * @property integer $lottery_id
 * @property string $nums
 * @property integer $add_time
 */
class LotteryUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lottery_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'house_id', 'lottery_id', 'nums', 'add_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'house_id' => 'House ID',
            'lottery_id' => 'Lottery ID',
            'nums' => 'Nums',
            'add_time' => 'Add Time',
        ];
    }
}
