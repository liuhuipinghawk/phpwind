<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "suggestion".
 *
 * @property integer $suggestionId
 * @property integer $userId
 * @property integer $type
 * @property string $suggestionContent
 */
class Suggestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'suggestion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'type'], 'integer'],
            [['suggestionContent'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'suggestionId' => 'Suggestion ID',
            'userId' => 'User ID',
            'type' => 'Type',
            'suggestionContent' => 'Suggestion Content',
        ];
    }
}
