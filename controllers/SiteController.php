<?php

namespace app\controllers;

use Imagine\Image\ManipulatorInterface;
use Yii;
use app\models\Admin\Certification;
use yii\filters\AccessControl;
use yii\imagine\Image;
use yii\web\Controller;
use app\util\OrderUtils;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        //裁剪
        //Image::crop('E:/www/1.png',1000,1000,[700,700])->save('E:/www/1_crop.jpg');
        //Image::frame('E:/www/1.png')->save('E:/www/2.png');
        //旋转
        //Image::frame('E:/www/1.png',5,'666',0)->rotate(-8)->save('E:/www/1_rotate.png',['quality'=>50]);
        //缩略图（压缩）
         //Image::thumbnail('E:/www/1.png',100,100,ManipulatorInterface::THUMBNAIL_OUTBOUND)->save('E:/www/1_thumb.png');
        //图片水印
        //Image::watermark('', ‘11_thumb.jpg‘, [10,10])->save(‘11_water.jpg‘);
        //文字水印
        //Image::text(‘11.jpg‘, ‘hello world‘, 'glyphicons-halflings-regular.ttf',[10,10],[])->save('11_text.jpg');
        return $this->redirect(['/admin']);
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    /**public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }**/

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
