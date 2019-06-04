<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "usercate".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parentid
 * @property string $cratetime
 * @property string $updatetime
 */
class usercate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usercate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentid'], 'integer'],
            [['cratetime', 'updatetime'], 'safe'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parentid' => 'Parentid',
            'cratetime' => 'Cratetime',
            'updatetime' => 'Updatetime',
        ];
    }
}
