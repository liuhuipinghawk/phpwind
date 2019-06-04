<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "house_img".
 *
 * @property integer $img_id
 * @property integer $publish_id
 * @property string $img_path
 * @property string $tag
 */
class HouseImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img_id', 'publish_id'], 'integer'],
            [['img_path', 'tag'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'img_id' => 'Img ID',
            'publish_id' => 'Publish ID',
            'img_path' => 'Img Path',
            'tag' => 'Tag',
        ];
    }
}
