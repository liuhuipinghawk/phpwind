<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "app_user_post".
 *
 * @property string $post_id
 * @property string $post_name
 */
class UserPost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_user_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['post_name','required','message'=>'{attribute}不能为空'],
            [['post_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => '用户岗位ID',
            'post_name' => '用户岗位名称',
        ];
    }
}
