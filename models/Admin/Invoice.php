<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property integer $id
 * @property string $title
 * @property integer $user_id
 * @property string $mobile
 * @property string $number
 * @property string $tell
 * @property string $address
 * @property string $bank
 * @property string $account_nub
 * @property integer $type
 */
class Invoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'user_id'], 'required'],
            [['user_id', 'type'], 'integer'],
            [['title', 'address', 'bank', 'account_nub'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 11],
            [['number'], 'string', 'max' => 20],
            [['tell'], 'string', 'max' => 30],
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
            'user_id' => 'User ID',
            'mobile' => 'Mobile',
            'number' => 'Number',
            'tell' => 'Tell',
            'address' => 'Address',
            'bank' => 'Bank',
            'account_nub' => 'Account Nub',
            'type' => 'Type',
        ];
    }
}
