<?php

namespace app\models\Admin;

use Yii;

use app\models\Admin\Certification;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $Tell
 * @property string $PassWord
 * @property string $CreateTime
 * @property string $UpdateTime
 * @property string $LoginTime
 * @property string $HeaderImg
 * @property string $NickName
 * @property string $Email
 * @property string $TrueName
 * @property integer $HouseId
 * @property integer $Seat
 * @property string $Address
 * @property string $IdCard
 * @property string $IdCardOver
 * @property string $WorkCard
 * @property string $Company
 * @property integer $Status
 * @property integer $Cases
 * @property string $Department
 * @property integer $Position
 * @property integer $PostId
 * @property integer $Maintenancetype
 * @property integer $CateId
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['HouseId', 'Seat', 'Status', 'Cases', 'Position', 'PostId', 'Maintenancetype', 'CateId'], 'integer'],
            [['Tell'], 'string', 'max' => 15],
            [['PassWord'], 'string', 'max' => 100],
            [['CreateTime', 'UpdateTime', 'LoginTime'], 'string', 'max' => 50],
            [['HeaderImg'], 'string', 'max' => 225],
            [['NickName', 'TrueName', 'Address'], 'string', 'max' => 30],
            [['Email'], 'string', 'max' => 60],
            [['IdCard', 'IdCardOver', 'WorkCard', 'Company', 'Department'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Tell' => 'Tell',
            'PassWord' => 'Pass Word',
            'CreateTime' => 'Create Time',
            'UpdateTime' => 'Update Time',
            'LoginTime' => 'Login Time',
            'HeaderImg' => 'Header Img',
            'NickName' => 'Nick Name',
            'Email' => 'Email',
            'TrueName' => 'True Name',
            'HouseId' => 'House ID',
            'Seat' => 'Seat',
            'Address' => 'Address',
            'IdCard' => 'Id Card',
            'IdCardOver' => 'Id Card Over',
            'WorkCard' => 'Work Card',
            'Company' => 'Company',
            'Status' => 'Status',
            'Cases' => 'Cases',
            'Department' => 'Department',
            'Position' => 'Position',
            'PostId' => 'Post ID',
            'Maintenancetype' => 'Maintenancetype',
            'CateId' => 'Cate ID',
        ];
    }

    /**
     * 获取用户通行区域权限
     * @Author   tml
     * @DateTime 2019-03-05
     * @param    [type]     $phone [description]
     * @return   [type]            [description]
     */
    public function getUserPermission($phone){
        $user = User::find()->where(['Tell'=>$phone])->asArray()->one();
        $res = [];
        $res['exist'] = false;
        if (empty($user) || $user['Status'] != 3) {
            return $res;
        }
        // $certlist = Certification::find()->where(['UserId'=>$user['id'],'Status'=>3])->asArray()->all();
        $certlist = Certification::find()->alias('c')->select('c.*,h.housename')->leftJoin('house h','h.id = c.SeatId')->where(['c.UserId'=>$user['id'],'c.Status'=>3])->asArray()->all();
        if (!$certlist) {
            return $res;
        }
        // var_dump($certlist);exit;
        $params = Yii::$app->params['haoxiangkaimen'];    
        $num = 0; 
        $permissionlist = [];       
        foreach ($certlist as $k => $v) {
            if (in_array($v['HouseId'],$params['houseids'])) {
                $item = [];
                $item['item'] = $params[$v['HouseId']]['item'];
                $item['room'] = $v['housename'] . '-' . $v['Address'];
                if (isset($params[$v['HouseId']][$v['SeatId']]['accesslist'])) {
                    $item['accesslist'] = $params[$v['HouseId']][$v['SeatId']]['accesslist'];
                }
                if (isset($params[$v['HouseId']][$v['SeatId']]['ladderlist'])) {
                    $item['ladderlist'] = $params[$v['HouseId']][$v['SeatId']]['ladderlist'];
                    $item['floor'] = empty($v['floor']) ? '97' : explode(',',$v['floor']);
                }
                array_push($permissionlist,$item);
                $num++;
            }
        }
        if ($num) {
            $res['exist'] = true;
            $res['num'] = $num;
            $res['name'] = $user['TrueName'];
            $res['permissionlist'] = $permissionlist;
            $res['user_id'] = $user['id'];
        }
        return $res;
    }
}
