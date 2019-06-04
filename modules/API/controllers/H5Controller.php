<?php

namespace app\modules\API\controllers;

use yii\web\Controller;
use Yii;
use app\models\Admin\VersionUpgrade;

class H5Controller extends Controller{
    public function actionHotelList(){
        $this->layout = false;
        return $this->render('hotel-list');
    }
    public function actionHotelAbout(){
        $this->layout = false;
        return $this->render('hotel-about');
    }
    public function actionHotelDetail(){
        $this->layout = false;
        return $this->render('hotel-detail');
    }
    public function actionHotelAlbum(){
        $this->layout = false;
        return $this->render('hotel-album');
    }
    public function actionHotelBook(){
        $this->layout = false;
        return $this->render('hotel-book');
    }
    public function actionHotelEvaluation(){
        $this->layout = false;
        return $this->render('hotel-evaluation');
    }
    public function actionOfficeLease(){
        $this->layout = false;
        return $this->render('office-lease');
    }
    public function actionOfficeDetail(){
        $this->layout = false;
        return $this->render('office-detail');
    }
    public function actionPlantsList(){
        $this->layout = false;
        return $this->render('plants-list');
    }
    public function actionPlantDetail(){
        $this->layout = false;
        return $this->render('plant-detail');
    }
    public function actionNrealEstate(){
        $this->layout = false;
        return $this->render('nreal-estate');
    }
    public function actionDFang(){
        $this->layout = false;
        return $this->render('d-fang');
    }
    public function actionZdFang(){
        $this->layout = false;
        return $this->render('zd-fang');
    }
    public function actionHouseList(){
        $this->layout = false;
        return $this->render('house-list');
    }
    public function actionHouseDetail(){
        $this->layout = false;
        return $this->render('house-detail');
    }
    public function actionFoodList(){
        $this->layout = false;
        return $this->render('food-list');
    }
    public function actionFoodDetail(){
        $this->layout = false;
        return $this->render('food-detail');
    }
    /**
     * 酒店/美食
     * @Author   tml
     * @DateTime 2018-4-23
     * @return   [type]     [description]
     */
    public function actionHotel(){
        $this->layout = false;
        return $this->render('hotel');
    }
    public function actionFood()
    {
        $this->layout = false;
        return $this->render('food');
    }
    /**
     * 礼品定制
     * @Author   tml
     * @DateTime 2018-5-8
     * @return   [type]     [description]
     */
    public function actionGift(){
        $this->layout = false;
        return $this->render('gift');
    }
    /**
     * 办公家具
     * @Author   tml
     * @DateTime 2018-5-9
     * @return   [type]     [description]
     */
    public function actionOfficeFurniture(){
        $this->layout = false;
        return $this->render('office-furniture');
    }
    /**
     * 装饰设计
     * @Author   tml
     * @DateTime 2018-5-11
     * @return   [type]     [description]
     */
    public function actionRenovation(){
        $this->layout = false;
        return $this->render('renovation');
    }
    /**
     * 停车缴费启动页
     * @Author   tml
     * @DateTime 2018-6-8
     * @return   [type]     [description]
     */
    public function actionParkingPayment(){
        $this->layout = false;
        return $this->render('parking-payment');
    }

    /**
     * 代理记账
     * @Author   tml
     * @DateTime 2018-6-11
     * @return   [type]     [description]
     */
    public function actionBookkeeping(){
        $this->layout = false;
        return $this->render('bookkeeping');
    }

    /**
     * 宣传服务
     * @Author   tml
     * @DateTime 2018-6-11
     * @return   [type]     [description]
     */
    public function actionPropagate(){
        $this->layout = false;
        return $this->render('propagate');
    }
    /**
     * 公司注册
     * @Author   tml
     * @DateTime 2017-12-01
     * @return   [type]     [description]
     */
    public function actionBusiness(){
        $this->layout = false;
        return $this->render('business');
    }
    /**
     * 洗衣服务
     * @Author   tml
     * @DateTime 2017-12-01
     * @return   [type]     [description]
     */
    public function actionLaundry(){
        $this->layout = false;
        return $this->render('laundry');
    }
    /**
     * 直饮水
     * @Author   tml
     * @DateTime 2017-12-01
     * @return   [type]     [description]
     */
    public function actionWater(){
        $this->layout = false;
        return $this->render('water');
    }
    /**
     * 车位租赁
     * @Author   tml
     * @DateTime 2017-12-01
     * @return   [type]     [description]
     */
    public function actionParking(){
        $this->layout = false;
        return $this->render('parking');
    }
    /**
     * 室内清洁
     * @Author   tml
     * @DateTime 2017-12-01
     * @return   [type]     [description]
     */
    public function actionIndoorClean(){
        $this->layout = false;
        return $this->render('indoor-clean');
    }
    public function actionCarWashing(){
        $this->layout = false;
        return $this->render('car-washing');
    }

    /**
     * 企业家俱乐部
     * @Author   zx
     * @DateTime 2017-12-01
     * @return   [type]     [description]
     */
    public function actionClubIndex(){
        $this->layout = false;
        return $this->render('club-index');
    }
    public function actionClubDec(){
        $this->layout = false;
        return $this->render('club-dec');
    }
    public function actionClubJoin(){
        $this->layout = false;
        return $this->render('club-join');
    }
    public function actionClubMember(){
        $this->layout = false;
        return $this->render('club-member');
    }
    public function actionBusinessDetail(){
        $this->layout = false;
        return $this->render('business-detail');
    }
    public function actionClubNews(){
        $this->layout = false;
        return $this->render('club-news');
    }
    /*房屋委托*/
    public function actionHouseEntrust(){
        $this->layout = false;
        return $this->render('house-ebtrust');
    }
    /*招商租赁*/
    public function actionZuList(){
        $this->layout = false;
        return $this->render('zu-list');
    }
    public function actionZuDetail(){
        $this->layout = false;
        return $this->render('zu-detail');
    }

    public function actionAppDownload(){
        $this->layout = false;
        $url = VersionUpgrade::find()->select('apk_url')->where(['status'=>1])->andWhere(['in','type',[1,2]])->orderBy('create_time desc')->limit(1)->scalar();
        if (empty($url)) {
            $url = 'http://106.15.127.161/aiban_1.2.apk';
        }
        return $this->render('app_download',['url'=>$url]);
    }

//    消息详情
    public function actionMessageDetail(){
        $this->layout = false;
        return $this->render('message-detail');
    }
//    新闻详情
    public function actionConsultDetail(){
        $this->layout = false;
        return $this->render('consult-detail');
    }
    //  蓝海-自助开门
    public function actionOpenDoor0(){  // 只有闸机没有电梯
        $this->layout = false;
        return $this->render('open-door0');
    }
    public function actionOpenDoor(){
        $this->layout = false;
        return $this->render('open-door');
    }
    //  蓝海-访客预约
    public function actionVisitorBook(){
        $this->layout = false;
        return $this->render('visitor-book');
    }

    // 蓝海house_id:2        1栋seat_id:21     2栋seat_id:22
    public function actionOpenDoor221(){
        $this->layout = false;
        return $this->render('open-door2-21');
    }
    public function actionOpenDoor222(){
        $this->layout = false;
        return $this->render('open-door2-22');
    }
    public function actionVisitorBook221(){
        $this->layout = false;
        return $this->render('visitor-book2-21');
    }
    public function actionVisitorBook222(){
        $this->layout = false;
        return $this->render('visitor-book2-22');
    }
    // 向阳蓝海house_id:6    A座seat_id:29     B座seat_id:30
    public function actionOpenDoor629(){
        $this->layout = false;
        return $this->render('open-door6-29');
    }
    public function actionOpenDoor630(){
        $this->layout = false;
        return $this->render('open-door6-30');
    }
    public function actionVisitorBook629(){
        $this->layout = false;
        return $this->render('visitor-book6-29');
    }
    public function actionVisitorBook630(){
        $this->layout = false;
        return $this->render('visitor-book6-30');
    }


    //  转盘抽奖
    public function actionLuckDraw(){
        $this->layout = false;
        return $this->render('luck-draw');
    }

    //  转盘纪录
    public function actionLuckList(){
        $this->layout = false;
        return $this->render('luck-list');
    }

    //  学习园地列表
    public function actionLearnList(){
        $this->layout = false;
        return $this->render('learn-list');
    }
    //  学习园地详情
    public function actionLearnDetail(){
        $this->layout = false;
        return $this->render('learn-detail');
    }
}