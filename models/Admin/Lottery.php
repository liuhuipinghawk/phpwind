<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "lottery".
 *
 * @property string $id
 * @property string $title
 * @property integer $stime
 * @property integer $etime
 * @property integer $add_time
 * @property integer $edit_time
 * @property integer $status
 * @property string $award
 * @property string $award_remain
 * @property integer $is_del
 */
class Lottery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lottery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stime', 'etime', 'add_time', 'edit_time', 'status', 'is_del'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['award', 'award_remain'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'stime' => 'Stime',
            'etime' => 'Etime',
            'add_time' => 'Add Time',
            'edit_time' => 'Edit Time',
            'status' => 'Status',
            'award' => 'Award',
            'award_remain' => 'Award Remain',
            'is_del' => 'Is Del',
        ];
    }
}
