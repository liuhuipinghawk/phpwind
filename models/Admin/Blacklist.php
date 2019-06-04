<?php

namespace app\models\Admin;

use Yii;


class Blacklist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "blacklist";
    }
}
