<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "o2o_clean_service".
 *
 * @property integer $clean_id
 * @property string $clean_name
 * @property integer $pid
 * @property double $price
 * @property string $content
 * @property resource $thumb
 * @property integer $create_time
 * @property integer $update_time
 */
class CleanService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'o2o_clean_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['clean_name','thumb','price','content'],'required','message'=>'{attribute}不能为空'],
            [['pid', 'create_time', 'update_time'], 'integer'],
            [['price'], 'number'],
            [['content', 'thumb'], 'string'],
            [['clean_name'], 'string', 'max' => 35],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'clean_id' => 'Clean ID',
            'clean_name' => '室内保洁服务名称',
            'pid' => '父级分类Id',
            'price' => '价格',
            'content' => '服务内容',
            'thumb' => '产品logo',
            'create_time' => '添加时间',
            'update_time' => '修改时间',
        ];
    }
}
