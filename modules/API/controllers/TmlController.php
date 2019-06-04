<?php

namespace app\modules\API\controllers;

use Yii;
use yii\web\Controller;

/**
 * 我的BaseController
 */
class TmlController extends Controller{
	public $enableCsrfValidation = false;
	public $get;
	public $post;

	public function init(){
		$this->get = Yii::$app->request->get();
		$this->post = Yii::$app->request->post();
	}

	/**
	 * 验证手机号
	 * @Author   tml
	 * @DateTime 2018-01-13
	 * @param    [type]     $mobile [description]
	 * @return   [type]             [description]
	 */
	public function checkMobile($mobile){
		return preg_match('/^1[3456789]\d{9}$/', $mobile);
	}
}
