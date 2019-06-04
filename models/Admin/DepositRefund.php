<?php
/**
 * User: qilin
 * Date: 2018/5/7
 * Time: 17:52
 */
namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "ad".
 *
 * @property integer $adId
 * @property string $adName
 * @property integer $pid
 * @property string $thumb
 * @property string $url
 * @property string $createTime
 * @property string $updateTime
 */
class DepositRefund extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deposit_refund';
    }
}