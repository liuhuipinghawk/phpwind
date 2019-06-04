<?php

namespace app\models\Admin;

use Yii;

/**
 * This is the model class for table "version_upgrade".
 *
 * @property integer $id
 * @property string $app_id
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
            [['version_code','apk_url','upgrade_point'],'required','message'=>'{attribute}不能为空'],
            [['type', 'status'], 'integer'],
            [['app_id', 'version_code'], 'string', 'max' => 11],
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
            'app_id' => '应用分类',
            'version_code' => '版本号',
            'type' => '类型',
            'apk_url' => 'apk地址',
            'upgrade_point' => '提示语',
            'status' => '状态',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
