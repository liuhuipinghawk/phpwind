<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "propertynotice".
 *
 * @property integer $pNoticeId
 * @property string $title
 * @property string $author
 * @property string $content
 * @property string $createTime
 * @property string $thumb
 * @property integer $cateId
 * @property string $url
 * @property integer $house_id
 */
class Propertynotice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'propertynotice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['cateId', 'house_id'], 'integer'],
            [['title'], 'string', 'max' => 30],
            [['createTime'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pNoticeId' => '物业通知Id',
            'title' => '物业通知标题',
            'author' => '作者',
            'content' => '内容',
            'createTime' => '添加时间',
            'thumb' => 'logo',
            'cateId' => '分类Id',
            'url' => 'Url',
            'house_id' => '楼盘Id',
        ];
    }

    /**
     * 添加系统通知
     * @Author   tml
     * @DateTime 2018-06-30
     * @param    [type]     $user_id [用户ID]
     * @param    [type]     $title   [标题]
     * @param    [type]     $content [内容]
     * @param    [type]     $type    [1：通行区域；2：派单；3：审核通过；4：审核失败；]
     */
    public function addNotice($user_id,$title,$content,$type,$order_id=0)
    {
        $model = new Propertynotice();
        $model->author = $user_id;
        $model->title = $title;
        $model->content = $content;
        $model->createTime = date('Y-m-d H:i:s',time());
        $model->cateId = 3;
        $model->house_id = $type;
        $model->url = $order_id;
        $ret = $model->save();
        return $ret;
    }
}
