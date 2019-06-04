<?php

namespace app\modules\API\controllers;


class InitController extends CommonController {
    /**
     * get方式提交数据
     * 上次的本版号，小于数据库中的版本号提示更新
     * http://192.168.100.110/index.php?r=API%2Finit%2Findex
     *
     */
    public function actionIndex(){
        $this->check();
        $app_id = \Yii::$app->request->get('app_id');
        $version_code = \Yii::$app->request->get('version_code');
        $type = \Yii::$app->request->get('type');
        $versionUpgrade = $this->getversionUpgrade($app_id);
        if($versionUpgrade){  
            // foreach ($versionUpgrade as $all){
            //     //当前版本号与数据库中的版本号做对比，如果当前版本号小于数据库中的版本号,
            //     if($all['type'] > 0 && $this->params['version_code'] < $all['version_code']){
            //         echo json_encode([
            //             'code'=>$all,
            //             'status'=>200,
            //             'message'=>$all['upgrade_point'],
            //         ]);
            //         exit;
            //     }elseif ($all['type'] ==0 || $this->params['version_code'] == $all['version_code']){
            //         echo json_encode([
            //             'code'=>array('app_id'=>$app_id,'version_code'=>$version_code,'type'=>0),
            //             'status'=>200,
            //             'message'=>'不升级',
            //         ]);
            //         exit;
            //     }
            // }
            
            $info = $versionUpgrade[0];
            if ($info['type'] > 0 && $version_code < $info['version_code']) {
                echo json_encode(['status'=>200,'message'=>$info['upgrade_point'],'code'=>$info]);exit;
            } else {
                echo json_encode([
                    'code'=>array('app_id'=>$app_id,'version_code'=>$version_code,'type'=>0),
                    'status'=>200,
                    'message'=>'不升级',
                ]);
                exit;
            }
        }else{
            echo json_encode([      
                'code'=>(object)[],
                'status'=>400,
                'message'=>'版本升级信息获取失败',
            ]);
            exit();
        }
    }
    public function actionAdd(){
        return $this->render('Init');
    }
}
