<?php
namespace app\modules\wappay\controllers;

use app\util\CURLUtils;
use yii\web\Controller;

/**
 * ArchitectureID
 * User: mumu
 * Date: 2018/1/19
 * Time: 9:31
 */
class PurchaseController extends Controller{

    //定义链接
    protected $host;
    public function init()
    {
        // $this->host = 'http://59.175.180.234:8051';
        $this->host = 'http://218.28.131.242:8088/WebService_res';
    }
    /**
     *获取所有区域信息（包括区域名、区域ID）
     *http://192.168.10.16/index.php?r=wappay/purchase/get-area-info
     */
    public function actionGetAreaInfo(){
        var_dump($this->md5());exit;
        $GetAreaInfo = $this->host."/PurchaseWebService.asmx/getAreaInfo";
        $curlRet = CURLUtils::_request($GetAreaInfo,false,'POST');
        $xml = simplexml_load_string($curlRet);
        // var_dump($xml);exit;
        $resultInfo = $xml->resultInfo;
        if ($resultInfo->result == 1) { //成功
            $areaInfoList = $xml->areaInfoList;
            foreach ($areaInfoList->areaInfo as $k => $v) {
                var_dump('AreaID：' . $v->AreaID . '<br>');
                var_dump('AreaName：' . $v->AreaName .'<br>');
            }
        }
        exit;

        // $jsonStr = json_encode($xml->areaInfoList);
        // $jsonArray = json_decode($jsonStr,true);
        // foreach ($jsonArray['areaInfo'] as $val){
        //     var_dump($val['AreaID']."<br/>".$val['AreaName']);
        // }
        // exit;
    } 
    //获取指定区域ID的所有建筑信息（包括建筑名称、建筑ID，建筑总楼层，建筑起始楼层号）
    //POST
    //http://192.168.10.16/index.php?r=wappay/purchase/get-area-info
    public function actionGetArchitectureInfo(){
        //header("Content-type: text/xml");
        $GetArchitectureInfo = $this->host."/PurchaseWebService.asmx/getArchitectureInfo";
        $data = "Area_ID=1";
        $curlRet = CURLUtils::_request($GetArchitectureInfo,false,'POST',$data);
        $xml = simplexml_load_string($curlRet);
        // var_dump($xml);exit;
        $resultInfo = $xml->resultInfo;
        if ($resultInfo->result == 1) { //成功
            $architectureInfoList = $xml->architectureInfoList;
            foreach ($architectureInfoList->architectureInfo as $k => $v) {
                var_dump('ArchitectureID：' . $v->ArchitectureID . '<br>');
                var_dump('ArchitectureName：' . $v->ArchitectureName .'<br>');
                var_dump('ArchitectureStorys：' . $v->ArchitectureStorys .'<br>');
                var_dump('ArchitectureBegin：' . $v->ArchitectureBegin .'<br>');
                var_dump('ArchitectureUnit：' . $v->ArchitectureUnit .'<br>');
            }
        }
        exit;
    }

    /**
     * 获取指定建筑ID的指定楼层的所有房间信息（包括房间名称、房间电表ID）
     * Architecture_ID:186
     * Floor:1
     * http://192.168.10.16/index.php?r=wappay/purchase/get-room-info
     */
    public function actionGetRoomInfo(){
        $GetRoomInfo = $this->host."/PurchaseWebService.asmx/getRoomInfo";
        $data = "Architecture_ID=12&Floor=27";
        $curlRet = CURLUtils::_request($GetRoomInfo,false,'POST',$data);
        $xml = simplexml_load_string($curlRet);
        // var_dump($xml);exit;
        $resultInfo = $xml->resultInfo;
        if ($resultInfo->result == 1) { //成功
            $roomInfoList = $xml->roomInfoList;
            foreach ($roomInfoList->roomInfo as $k => $v) {
                var_dump('AmMeter_ID：' . $v->AmMeter_ID . '<br>');
                var_dump('RoomName：' . $v->RoomName .'<br>');
            }
        }
        exit;
    }
    /**
     * 获取指定房间电表ID的剩余电量（金额）、透支电量（金额）
     * http://192.168.10.16/index.php?r=wappay/purchase/get-reserve-am
     */
    public function actionGetReserveAm(){
        $GetReserveAm = $this->host."/PurchaseWebService.asmx/getReserveAM";
        $data= "AmMeter_ID=18985";
        $curl = CURLUtils::_request($GetReserveAm,false,'POST',$data);
        var_dump($curl);
    }
    public function md5(){
        $str = "studentID=0&AmMeter_ID=1296&money=5000&orderNo=201801231417";
        return md5($str);
    }

}