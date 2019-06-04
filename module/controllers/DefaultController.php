<?php

namespace app\module\controllers;

use app\API\models\Propertynotice;
use yii\web\Controller;
use app\models\Admin\Article;

/**
 * Default controller for the `mobile` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $get = \Yii::$app->request->get();
        $list = Article::find()->where(array('articleId'=>$get['id'],'cateId'=>$get['cateid']))->asArray()->one();
        return $this->renderPartial('index',['list'=>$list]);
    }
    public function actionProeryNotice(){
        $get = \Yii::$app->request->get();
        $list = Propertynotice::find()->where(['pNoticeId'=>$get['id'],'cateId'=>$get['cateid']])->asArray()->one();
        return $this->renderPartial('proery',['list'=>$list]);
    }
}
