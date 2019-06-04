<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "3d_showings_imgs".
 *
 * @property integer $img_id
 * @property integer $show_id
 * @property string $img_name
 * @property string $img_path
 * @property string $img_thumb
 * @property string $img_desc
 * @property integer $add_time
 * @property integer $add_user
 */
class ShowingsImgs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '3d_showings_imgs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img_id', 'show_id', 'img_name', 'img_path', 'img_desc'], 'required'],
            [['img_id', 'show_id', 'add_time', 'add_user'], 'integer'],
            [['img_name'], 'string', 'max' => 50],
            [['img_path', 'img_thumb'], 'string', 'max' => 100],
            [['img_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'img_id' => 'Img ID',
            'show_id' => 'Show ID',
            'img_name' => 'Img Name',
            'img_path' => 'Img Path',
            'img_thumb' => 'Img Thumb',
            'img_desc' => 'Img Desc',
            'add_time' => 'Add Time',
            'add_user' => 'Add User',
        ];
    }
}
