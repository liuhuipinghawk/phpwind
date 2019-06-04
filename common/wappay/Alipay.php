<?php
namespace app\common\wappay;

use yii;

require_once Yii::$app->basePath.'/vendor/wappay/alipay/aop/AopClient.php';
require_once Yii::$app->basePath.'/vendor/wappay/alipay/aop/request/AlipayTradeAppPayRequest.php';
require_once Yii::$app->basePath.'/vendor/wappay/alipay/aop/request/AlipayTradeQueryRequest.php';

class Alipay{
	protected $gatewayUrl = 'https://openapi.alipay.com/gateway.do';
	protected $appId = '2017121300668897';
	protected $rsaPrivateKey = 'MIIEpAIBAAKCAQEAw3Foc/qzk91/FjwhTQEjwKl2dCBSRIWWPi10p+P6iK0VXttkXkVHF5sDttGsQ9hcaHPaokM/rq9jhlmEjlU/WovtImhVs/8CoyZV0/5oDUZJcfeGM3SFLGwtg00Eyjt8VuEDXshdxsZee1khZJz1t8Lefb/TzP/xzdWRh2ccYw+8FNpSJZIsSSatShL6qhCHBD1YOKWkeldZ+WaonHuTUwHHByOmQGLuEnIylmUJLVO37J0AzZrQ6eOzdOpYewBffrgqj2Mjr/W4eC0YprzPZFA8XNXBPR95FCd5/hBL4/9dLm940zeZPzE90/ERlxBx1RmtEZGaR/63JUevQtZhBQIDAQABAoIBACtYkKkAVimaO2BsD5qrgQluzDWvIW/PDOZXYIMH3f3IHXA/SkBaLw0+NRGr6P/XEY+c+kV4krwka/dVDUAgCgAD/qDd8PwNt8EFdI2i4+Llzs427o2k7xBOIb34K/LKRKZkG0I/QAUg472JpA1Tfm+2CXBsRgY2UaOsFS2pobMaXAHpz3GC1a9qed7Sofdnnc2CAGf7x6vv3umham77I7dLAt8e9JbC1x4T9aj0Eezdq067Gpd0PRHJ07CJ1jP+kDt8nSxfm8Fhqooi2ItJtU4jrWz+HGYg632CiQfU/QGgBkEeDN4HhV81Lqm1LWCSJ++zIYM/3UgscvdT+tUwNuECgYEA5nzYl/J3HcsWT8sBqAO9zWacnwL/3TmHwVb91OgUNKDdkyYOe6WQckTPbBTA1Rk1IUcDOVHVpDINUrhUmPN5Die13dPaEtAkQzMH8whod2Uhdz4v6mjNiwJsJSZCuUsjUg9KnNYfsZ1Nc9CntZTARTPkHjXG+pPFCScKRUr70A0CgYEA2ROHDIP6Zjd4NFSPOMstGcvYzb8F5Y1LC8bzMN5h3Mt9p4oLQW+O1eS5hJnznv0SWDh3JaYGpjo1SLljRlt3QEE1DDw3o+wsw3TH0rac5b8FJC5ZTiai0GJltO5h0j0LUWTHcSqdgeOKP6ZUay2Pe6ACp1nftuYyeT9ETDMnntkCgYEAxtl9EBJ6m/SjijHNewPHU5cslq9Cybyhl7cShQW4sPL8VsBljF15smwVO9znxLHbuZsHeANXOzKHdg9bxR2BGio+aGQm50Y1kthLCmz9m8xfQ/4d3rGOa1iqrp5EwJHHpjtVFtxROa5JrRqeJjVwcAPl0f55baPhQRUycjfP6l0CgYBIOjUfNvKj/CTk1JXrAb9569exbbPak067FnFoezX4r0SZ8FaaaTIPfVE1C7yB1Ba8f901C67+tDNyhSzBBkIBgTDTZ13kDvs99adfNx+xWgOt7DYOyNA3oeXRc9fcii8v3+Z0gwdxZnJjh0Zjev9Y1P7NDBxh0OpOaXyiFgtC0QKBgQCKEeBDRA8QZ7XASyUsJjAYSu/JD6kne555daKaHHf/xRFIsyjiAS0kxIZ4BaGjQhS8Sx6b1mEkHyM3HnzKI5TzB3BKHL+ZW/VkffxrYgxaUC0+QZw1Mq2wEqU9M7gb++9M18QIhL2BXtlZxyx+5a6e+cR0Y0By6hnT1YK5DFIY8w==';
	protected $alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAu+erWpQad3+0tCTeTnlzvN5B7AiN+2BCdKpvqe8BygB4yv3GQUqBXvhw5EXS9DyNgGE+aJkIO0P+Arrr6Rqa05zPGMZYeFwiazvOJpYW/EZw/vqQcXUIXhLE3jpOaev3uhPgnHccR6u4Ma30yCRMYrcLxi7rYnu01vAM58yFUf2mAHyti6FnCdgvjAus2KwdYFR8STX90VIMxaj2jvglCC5oK5uZQWg0HWZ9UJUVEFfX8M9SK75hhzyjtSMK7WHrtIrB3XeI1GAsYUeE+nQiQYsBDK7WVbaZrb9TvN6sPMbwlmo/52+cFZPjI14t4oFigo/tTeZ8S9qfwZJzqZ804QIDAQAB';

	/**
	 * 支付宝支付
	 * @Author   tml
	 * @DateTime 2017-12-23
	 * @param    [type]     $body        [description]
	 * @param    [type]     $order_sn    [description]
	 * @param    [type]     $parking_fee [description]
	 * @return   [type]                  [description]
	 */
	public function alipay($body,$order_sn,$total_fee,$type){
		$aop = new \AopClient;
		$aop->gatewayUrl = $this->gatewayUrl;
		$aop->appId      = $this->appId;
		$aop->rsaPrivateKey = $this->rsaPrivateKey;
		$aop->format = "json";
		$aop->charset = "UTF-8";
		$aop->signType = "RSA2";
		$aop->alipayrsaPublicKey = $this->alipayrsaPublicKey;
		//实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
		$request = new \AlipayTradeAppPayRequest();
		// 异步通知地址
		$notify_url = 'http://106.15.127.161/API/notify/alipay-notify';
		//SDK已经封装掉了公共参数，这里只需要传入业务参数
		$bizcontent = "{\"body\":\"".$body."\","
		                . "\"subject\": \"".$body."\","
		                . "\"out_trade_no\": \"".$order_sn."\","
		                . "\"timeout_express\": \"30m\","
		                . "\"total_amount\": \"".$total_fee."\","
		                . "\"passback_params\": \"".$type."\","
		                . "\"product_code\":\"QUICK_MSECURITY_PAY\""
		                . "}";
		$request->setNotifyUrl($notify_url);
		$request->setBizContent($bizcontent);
		//这里和普通的接口调用不同，使用的是sdkExecute
		$response = $aop->sdkExecute($request);
		// 注意：这里不需要使用htmlspecialchars进行转义，直接返回即可
		return $response;
	}

	/**
	 * 支付宝支付订单状态查询
	 * @Author   tml
	 * @DateTime 2018-01-09
	 * @param    [type]     $out_trade_no [description]
	 * @param    [type]     $trade_no     [description]
	 * @return   [type]                   [description]
	 */
	public function alipayOrderQuery($out_trade_no,$trade_no){
    	$aop = new \AopClient ();
		$aop->gatewayUrl = $this->gatewayUrl;
		$aop->appId      = $this->appId;
		$aop->rsaPrivateKey = $this->rsaPrivateKey;
		$aop->alipayrsaPublicKey = $this->alipayrsaPublicKey;
		$aop->apiVersion = '1.0';
		$aop->signType = 'RSA2';
		$aop->postCharset='UTF-8';
		$aop->format='json';
		$request = new \AlipayTradeQueryRequest();
		$request->setBizContent("{" 
			. "\"out_trade_no\":\"" . $out_trade_no . "\"," 
			. "\"trade_no\":\"" . $trade_no . "\"" 
			. "}");
		$result = $aop->execute($request); 

		$responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
		$resultCode = $result->$responseNode->code;
		if(!empty($resultCode) && $resultCode == 10000){
			return true;
		}
		return false;
	}
}