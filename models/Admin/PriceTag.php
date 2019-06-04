<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "price_tag".
 *
 * @property string $id
 * @property integer $house_id
 * @property integer $seat_id
 * @property string $tag
 * @property integer $add_time
 * @property integer $add_user
 * @property integer $edit_time
 * @property integer $edit_user
 */
class PriceTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'price_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id', 'seat_id', 'add_time', 'add_user', 'edit_time', 'edit_user'], 'integer'],
            [['tag'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'house_id' => 'House ID',
            'seat_id' => 'Seat ID',
            'tag' => 'Tag',
            'add_time' => 'Add Time',
            'add_user' => 'Add User',
            'edit_time' => 'Edit Time',
            'edit_user' => 'Edit User',
        ];
    }
}
