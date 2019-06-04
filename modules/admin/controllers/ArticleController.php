<?php

namespace app\modules\admin\controllers;

use app\models\Admin\Admin;
use app\models\Admin\Category;
use app\models\Admin\House;
use app\models\Admin\ThumbForm;
use Codeception\Module\Yii1;
use Yii;
use app\models\Admin\Article;
use app\models\Admin\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends CommonController
{

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = "layout1";
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $this->layout = "layout1";
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "layout1";
        $session = \Yii::$app->session;
        $headerImg = Admin::find()->select('headerImg')->where(array('adminuser'=>$session['admin']['adminuser']))->asArray()->one();
        $house = House::find()->select('id,housename,parentId')->where(array('parentId'=>0))->asArray()->all();
        array_unshift($house,['id'=>0,'housename'=>'请选择楼盘','parentId'=>0]);
        // var_dump($house);exit;
        $model = new Article();
        $data = new Category();
        $cate = $data->getOptions();
        $thumb = new ThumbForm();

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $thumb->imageFile = UploadedFile::getInstance($model,'thumb');
            if($thumb->upload()){
                $model->thumb =  "/uploads/article/".time().'.'.$thumb->imageFile->extension;
                $model->title = $post['Article']['title'];
                $model->cateId = $post['Article']['cateId'];
                $model->houseId = $post['Article']['houseId'];
                $model->company = $post['Article']['company'];
                $model->content = $post['Article']['content'];
                $model->createTime = date("Y-m-d H:i:s", time());
                $model->adminName = $session['admin']['adminuser'];
                $model->introduction = $post['Article']['introduction'];
                $model->headImg = $headerImg['headerImg'];
//                $model->url = "/index.php?r=mobile/default/index&id=".$artId."&cateid=".$model->cateId;
                $model->point_state = "flase";
                $model->comment_count = 0;
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        $art = Article::find()->orderBy('articleId desc')->asArray()->one();
                        $artId = $art['articleId'];
                        Article::updateAll(['url'=>"/index.php?r=mobile/default/index&id=".$artId."&cateid=".$model->cateId],['articleId'=>$art['articleId']]);
                        return $this->redirect(['view', 'id' => $model->articleId]);
                    }
                    return false;
                }
                return false;
            }
        }
        return $this->render('create', [
            'model' => $model,
            'data'=>$cate,
            'house'=>$house,
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $this->layout = "layout1";
        $model = $this->findModel($id);
        $session = \Yii::$app->session;
        $house = House::find()->select('id,housename,parentId')->where(array('parentId'=>0))->asArray()->all();
        array_unshift($house,['id'=>0,'housename'=>'请选择楼盘','parentId'=>0]);
        $data = new Category();
        $cate = $data->getOptions();
        $thumb = new ThumbForm();
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $thumb->imageFile = UploadedFile::getInstance($model,'thumb');
            if($thumb->imageFile == null){
               // $model->thumb =  "uploads/article/".$thumb->imageFile->name;
                $model->title = $post['Article']['title'];
                $model->cateId = $post['Article']['cateId'];
                $model->houseId = $post['Article']['houseId'];
                $model->company = $post['Article']['company'];
                $model->content = $post['Article']['content'];
                $model->updateTime = date("Y-m-d H:i:s", time());
                $model->adminName = $session['admin']['adminuser'];
                $model->introduction = $post['Article']['introduction'];
//                $model->url = "/index.php?r=mobile/default/index&id=".$id."&cateid=".$model->cateId;
                $model->point_state = "flase";
                $model->comment_count = 0;
                if($model->load($model) || $model->validate()){
                    if($model->save(false)){
                        $art = Article::find()->orderBy('articleId desc')->asArray()->one();
                        $artId = $art['articleId'];
                        Article::updateAll(['url'=>"/index.php?r=mobile/default/index&id=".$artId."&cateid=".$model->cateId],['articleId'=>$art['articleId']]);
                        return $this->redirect(['view', 'id' => $model->articleId]);
                    }
                    return false;
                }else{
                    var_dump($model->getErrors());
                    exit;  
                }
                return false;
            }else{
                if($thumb->upload()){
                    $model->thumb =  "/uploads/article/".time().'.'.$thumb->imageFile->extension;
                    $model->title = $post['Article']['title'];
                    $model->cateId = $post['Article']['cateId'];
                    $model->houseId = $post['Article']['houseId'];
                    $model->content = $post['Article']['content'];
                    $model->updateTime = date("Y-m-d H:i:s", time());
                    $model->adminName = $session['admin']['adminuser'];
                    $model->introduction = $post['Article']['introduction'];
//                    $model->url = "/index.php?r=mobile/default/index&id=".$id."&cateid=".$model->cateId;
                    $model->point_state = "flase";
                    if($model->load($model) || $model->validate()){
                        if($model->save(false)){
                            $art = Article::find()->orderBy('articleId desc')->asArray()->one();
                            $artId = $art['articleId'];
                            Article::updateAll(['url'=>"/index.php?r=mobile/default/index&id=".$artId."&cateid=".$model->cateId],['articleId'=>$art['articleId']]);
                            return $this->redirect(['view', 'id' => $model->articleId]);
                        }
                        return false;
                    }
                    return false;
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'data'=>$cate,
            'house'=>$house,
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
