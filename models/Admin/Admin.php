<?php

namespace app\models\Admin;
use app\models\Admin\GroupRole;

use Yii;

/**
 * This is the model class for table "admin".
 *
 * @property integer $adminid
 * @property string $adminuser
 * @property string $adminpass
 * @property string $adminemail
 * @property string $logintime
 * @property string $loginip
 * @property string $headerImg
 * @property string $createtime
 */
class Admin extends \yii\db\ActiveRecord
{
    public $rememberMe = true;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['adminuser', 'required', 'message' => '管理员账号不能为空', 'on' => ['login',  'create']],
            ['adminpass', 'required', 'message' => '管理员密码不能为空', 'on' => ['login', 'create']],
            ['adminemail', 'required', 'message' => '邮箱不能为空', 'on' => [ 'create']],
            // [['adminuser','adminpass','adminemail','headerImg'],'required','message'=>'{attribute}不能为空'],
            ['rememberMe', 'boolean', 'on' => 'login'],
            ['adminpass', 'validatePass', 'on' => ['login']],
            ['createtime', 'string', 'max' => 100],
            [['headerImg'], 'string', 'max' => 255,'on'=>['create']],
            [['house_ids'], 'string', 'max' => 255],
            [['group_id','uppass_time'], 'integer'],
            [['password'], 'string', 'max' => 50],
        ];
    }
    public function validatePass(){
        if(!$this->hasErrors()){
            $data = self::find()->where('adminuser = :user and adminpass = :pass',[":user"=>$this->adminuser,":pass"=>md5($this->adminpass)])->one();
            if(is_null($data)){
                $this->addError("adminpass","用户名或者密码错误");
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adminid' => '管理员ID',
            'adminuser' => '账号',
            'adminpass' => '密码',
            'adminemail' => '邮箱',
            'logintime' => '登录时间',
            'headerImg' => '头像',
            'loginip' => 'Loginip',
            'createtime' => 'Createtime',
            'house_ids' => '绑定项目',
            'group_id' => '用户角色',
            'password' => '密码'
        ];
    }
    public function addItem($data){
        $this->scenario = "create";
        if($this->load($data) && $this->validate()){
            $this->createtime = time();
            $this->adminpass = md5($this->adminpass);
            if($this->save(false)){
                return true;
            }
            return false;
        }
        return false;  
    }
    public function login($data){
        $this->scenario = "login";
        if($this->load($data) && $this->validate()){
            //做点有意义的事
            $lifetime = $this->rememberMe ? 24*3600:0;
            $admin = Admin::find()->where(['adminuser'=>$this->adminuser,'adminpass'=>md5($this->adminpass)])->one();
            // var_dump($admin);exit;
            $session = Yii::$app->session;
            session_set_cookie_params($lifetime);
            if ($admin) {
                $group_id = $admin->group_id;
                $gr_list = GroupRole::find()->select('role_id')->where(['group_id'=>$group_id])->column();
                $session['admin'] =[
                    'adminuser'=>$this->adminuser,
                    'adminid'=>$admin->adminid,
                    'isLogin'=>1,
                    'house_ids'=>$admin->house_ids,
                    'group_id' => $group_id,
                    'group_role' => implode(',',$gr_list),
                    'pass'=>$admin['adminpass']
                ];
            }
            $this->updateAll(['logintime' => time(), 'loginip' => ip2long(Yii::$app->request->userIP)], 'adminuser = :user', [':user' => $this->adminuser]);
            return (bool)$session['admin']['isLogin'];
        }
        // var_dump($this->getFirstErrors());exit;
        return false;
    }
}
