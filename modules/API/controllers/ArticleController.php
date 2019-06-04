<?php
/**
 * User: qilin
 * Date: 2018/1/18
 * Time: 10:57
 */
namespace app\modules\API\controllers;

use app\models\Admin\ArticleLike;
use Yii;
use app\models\Admin\Article;

/**
 * API代码的编写
 */
class ArticleController extends TmlController
{
    /*
     * 兴业有道生活圈简介
     */
    public function actionIndex(){
        $data = Article::find()->where(['cateId'=>8,'status'=>0])->asArray()->one();
        if(!$data){
            echo json_encode(['status'=>-200,'message'=>'error','code'=>[]]);exit;
        }
        echo json_encode(['status'=>200,'message'=>'success','code'=>$data]);exit;
    }
    /*
     * 有道生活圈资讯
     */
    public function actionList(){
        $pagenum = empty($this->get['pagenum']) ? 1 : $this->get['pagenum'];
        $page_size = \Yii::$app->params['APP_PAGE_SIZE'];
        $data = Article::find()->where(['cateId'=>9,'status'=>0])->asArray()
            ->orderBy('articleId desc')
            ->offset(($pagenum-1)*$page_size)
            ->limit($page_size)->all();
        if(!$data){
            echo json_encode(['status'=>-200,'message'=>'error','code'=>[]]);exit;
        }
        echo json_encode(['status'=>200,'message'=>'success','code'=>$data]);exit;
    }
    /*
     * 有道生活圈首页资讯
     */
    public function actionNews(){
        $data = Article::find()->where(['cateId'=>9,'status'=>0])->asArray()
            ->orderBy('articleId desc')
            ->limit(5)->all();
        if(!$data){
            echo json_encode(['status'=>-200,'message'=>'error','code'=>[]]);exit;
        }
        echo json_encode(['status'=>200,'message'=>'success','code'=>$data]);exit;
    }
    /*
     * 有道生活圈资讯详情
     */
    public function actionDet(){
        $articleId = empty($this->get['articleId']) ? 0 : $this->get['articleId'];
        if (empty($articleId)) {
            echo json_encode(['status'=>-200,'message'=>'请选择用户身份','code'=>[]]);exit;
        }
        $data = Article::find()->where(['articleId'=>$articleId])->asArray()->one();
        if(!$data){
            echo json_encode(['status'=>-200,'message'=>'error','code'=>[]]);exit;
        }
        echo json_encode(['status'=>200,'message'=>'success','code'=>$data]);exit;
    }
    /*
     * 有道资讯banner资讯
     */
    public function actionBanner(){
        $data = Article::find()->where(['cateId'=>10,'status'=>0])->asArray()
            ->orderBy('articleId desc')
            ->limit(3)->all();
        if(!$data){
            echo json_encode(['status'=>-200,'message'=>'error','code'=>[]]);exit;
        }
        echo json_encode(['status'=>200,'message'=>'success','code'=>$data]);exit;
    }

    /*
     * 资讯点赞
     */
    public function actionLike(){
        $articleId = empty($this->post['articleId']) ? 0 : $this->post['articleId'];
        $user_id = empty($this->post['user_id']) ? 0 : $this->post['user_id'];
        $count = ArticleLike::find()->where(['articleId'=>$articleId,'user_id'=>$user_id])->count();
        $article = article::find()->where(['articleid' => $articleId])->asArray()->one();
        if($count == 1){
            $stars = $article['stars'] - 1;
            article::updateAll(['stars'=>$stars], ['articleId' => $articleId]);
            $res = ArticleLike::deleteAll(['articleId'=>$articleId,'user_id'=>$user_id]);
            echo json_encode([
                'code' => ['favour'=>'flase'],
                'status' => 200,
                'message' => '取消点赞！',
            ]);
            exit;
        }else{
            $stars = $article['stars'] + 1;
            article::updateAll(['stars'=>$stars], ['articleId' => $articleId]);
            $model = new ArticleLike();
            $model->articleId = $articleId;
            $model->user_id  = $user_id;
            $res = $model->save();
            echo json_encode([
                'code' => ['favour'=>'true'],
                'status' => 200,
                'message' => '点赞成功！',
            ]);
            exit;
        }

    }
}