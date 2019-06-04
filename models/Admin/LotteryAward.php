<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "lottery_award".
 *
 * @property string $id
 * @property integer $lottery_id
 * @property integer $user_id
 * @property integer $house_id
 * @property string $award
 * @property string $award_name
 * @property integer $add_time
 */
class LotteryAward extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lottery_award';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lottery_id', 'user_id', 'house_id', 'add_time'], 'integer'],
            [['award', 'award_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lottery_id' => 'Lottery ID',
            'user_id' => 'User ID',
            'house_id' => 'House ID',
            'award' => 'Award',
            'award_name' => 'Award Name',
            'add_time' => 'Add Time',
        ];
    }
}
