<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property string $item_id
 * @property integer $order_id
 * @property string $order_sn
 * @property integer $repair_id
 * @property integer $add_time
 * @property integer $complate_time
 * @property string $complate_img
 * @property string $complate_remark
 * @property integer $audit_status
 * @property integer $audit_time
 * @property integer $audit_user
 * @property string $audit_remark
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'repair_id', 'add_time', 'complate_time', 'audit_status', 'audit_time', 'audit_user'], 'integer'],
            [['order_sn'], 'string', 'max' => 50],
            [['complate_img', 'complate_remark', 'audit_remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_id' => 'Item ID',
            'order_id' => 'Order ID',
            'order_sn' => 'Order Sn',
            'repair_id' => 'Repair ID',
            'add_time' => 'Add Time',
            'complate_time' => 'Complate Time',
            'complate_img' => 'Complate Img',
            'complate_remark' => 'Complate Remark',
            'audit_status' => 'Audit Status',
            'audit_time' => 'Audit Time',
            'audit_user' => 'Audit User',
            'audit_remark' => 'Audit Remark',
        ];
    }
}
