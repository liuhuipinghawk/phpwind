<?php

namespace app\API\models;

use Yii;

/**
 * This is the model class for table "version_upgrade".
 *
 * @property integer $id
 * @property integer $app_id
 * @property integer $version_id
 * @property integer $version_mini
 * @property string $version_code
 * @property integer $type
 * @property string $apk_url
 * @property string $upgrade_point
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */
class VersionUpgrade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'version_upgrade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['app_id', 'version_id', 'version_mini', 'type', 'status', 'create_time', 'update_time'], 'integer'],
            [['version_code'], 'string', 'max' => 11],
            [['apk_url', 'upgrade_point'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'app_id' => 'App ID',
            'version_id' => 'Version ID',
            'version_mini' => 'Version Mini',
            'version_code' => 'Version Code',
            'type' => 'Type',
            'apk_url' => 'Apk Url',
            'upgrade_point' => 'Upgrade Point',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
