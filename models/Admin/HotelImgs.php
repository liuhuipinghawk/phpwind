<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "hotel_imgs".
 *
 * @property string $img_id
 * @property integer $hotel_id
 * @property integer $room_id
 * @property integer $type
 * @property string $path
 */
class HotelImgs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hotel_imgs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hotel_id', 'path'], 'required'],
            [['hotel_id', 'room_id', 'type'], 'integer'],
            [['path'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'img_id' => 'Img ID',
            'hotel_id' => 'Hotel ID',
            'room_id' => 'Room ID',
            'type' => 'Type',
            'path' => 'Path',
        ];
    }
}
