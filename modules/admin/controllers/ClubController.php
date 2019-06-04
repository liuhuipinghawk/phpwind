<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Admin\Club;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

/**
 * AdController implements the CRUD actions for Ad model.
 */
class ClubController extends CommonController
{
    /**
     * Lists all Ad models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout="layout1";
        $Tell = empty(Yii::$app->request->get()['mobile']) ? '' : Yii::$app->request->get()['mobile'];
        $TrueName = empty(Yii::$app->request->get()['name']) ? '' : Yii::$app->request->get()['name'];
        $Company = empty(Yii::$app->request->get()['company']) ? '' : Yii::$app->request->get()['company'];
        $Status      = empty(Yii::$app->request->get()['status']) ? 0 : Yii::$app->request->get()['status'];
        $data = array('in','status',array('1','2'));
        $jquery = Club::find()->select('*')->where($data);
        if(!empty($Tell)){
            $jquery->andWhere(['like','mobile',$Tell]);
        }
        if(!empty($TrueName)){
            $jquery->andWhere(['like','name',$TrueName]);
        }
        if(!empty($Company)){
            $jquery->andWhere(['like','company',$Company]);
        }
        if(!empty($Status)){
            $jquery->andWhere(['status'=>$Status]);
        }
        $pages = new Pagination(['totalCount'=>$jquery->count(),'pageSize' => '10']);
        $model =$jquery->offset($pages->offset)->limit($pages->limit)->orderBy('id desc')->asArray()->all();
        return $this->render('index', [
            'model' => $model,
            'pages'=>$pages,
        ]);
    }

    public function actionStatus($id)
    {
        $this->layout="layout1";
        $Id = Yii::$app->request->get('id');
        $res = Club::findOne($id);
        if($res['status'] == 1){
            Club::updateAll(['status'=>2],['id'=>$Id]);
        }elseif($res['status'] == 2){
            Club::updateAll(['status'=>1],['id'=>$Id]);
        }
        return $this->redirect('index');
    }

    public function actionEdit($id){
        $this->layout = "layout1";
        $data = Club::findOne($id);
        return $this->render('edit', [
            'data' => $data,
        ]);
    }

    public function actionUpdate(){
        $data = Yii::$app->request->post();
        $res = Club::updateAll(['content'=>$data['data']['content']],['id'=>$data['data']['id']]);
        if ($res) {
            return json_encode(['code'=>200,'msg'=>'编辑成功']);
        }
        return json_encode(['code'=>200,'msg'=>'编辑失败']);
    }
}
