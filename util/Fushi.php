<?php
namespace app\util;

/**
 * 富士接口封装
 */
class Fushi 
{
	private $privkey = 'MIICXQIBAAKBgQCz4j9uO/WZZHru5hz/xA4zeT7L9Uck/gWD+1uG2+A4+KvQOrsQ
		sSLOOSl9NPpxfz1uZ2f0KTLgRFyUFOGr7V4OoGewmM3T9f7pTcxhMlfkCuQDpaQv
		TWR1MtAdMrzQSSMNJD9HG+jqbgTFSWZjprGI127JrPPwPTf1XQKXVb9mbQIDAQAB
		AoGAc+Dpj6+cdSYfc0pVoAXCSDJw2560KAZjszP3MBbwiILY25kZ7JTPoR19tqSs
		OPUIs9h1RPpNRd+D6/jPr5uHnLpwAdajR9hW16Gm3ToZmYgT6sQoAdhWZs3lkkZU
		2q012aOBsiSUn5K75FuDGvU6lfyXarLUTJOLIAzSNlVabAECQQDu8yUdizhmQtx+
		i5jApSe2rMMuHM3U+HQQ1pUFuiuEDomTfSGrRdsnoDs0Gfj22IvcEucHzAUETd31
		u+jmRQntAkEAwLgndjuL6DmYKfz8Gf+/aUv8GoSj0WmGAyHUpxEqko28TUwGuCLe
		6g6VwOTnyt7ZvofmgygLMQJTHqSKnQY+gQJBAJqYYz3/EelPftq8tIKHF++fTNQr
		vJv6dxVhz56Z+YeB5E6xGbR3CLhVeZhW6XXDWpFzBVhNDj3fpyhSf/djWW0CQAZR
		w5F/8F2EDfZKgmXD2h30zOZ9tPV39VoC8Pstd+zoUuVh+dJt6ktYgRabKvKfDhrO
		UAO6+2r2/YzCrnzpqIECQQDcOQqxoR82vABxndILBwxh1mtfvLWan1E7TiXJajCU
		/nqgZMlP4HPDhEfmotSgmK91z6IgJhpcnbW29jDiBPe/';

	private $secret = "a8c9a1ef6c434db5aaa5223755a0b765";

	private $appid = 'fujica_a1bee074f5be7869';

	private $url = 'http://api.mops.fujica.com.cn/VisitorApi/api';
	// private $url = 'http://mops-test.fujica.com.cn:8061/VisitorAPI/api';

	public function __construct()
	{
		$this->privkey = str_replace("\n","",$this->privkey);//此行可免去手动清除回车符
		$this->privkey = chunk_split($this->privkey, 64, "\n");
		$this->privkey = "-----BEGIN RSA PRIVATE KEY-----\n$this->privkey-----END RSA PRIVATE KEY-----\n";
	}

	public function doSomthing($url,$request,$timestamp)
	{
		$param ='param='.$request.'&secret='.$this->secret."&timestamp=".$timestamp;
		if (openssl_sign($param, $sign, $this->privkey,OPENSSL_ALGO_SHA1)) {
			return $this->PostData($this->url.$url,$request,base64_encode($sign),$timestamp);
		}
	}

	public function PostData($url,$param,$sign,$timestamp) 
	{
		$header = array();
		$header[] = 'Content-Type:application/json;charset=utf-8';
		$header[] = 'appid:'.$this->appid;
		$header[] = 'sign:'.$sign;
		$header[] = 'timestamp:'.$timestamp;

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_HEADER,true);
		curl_setopt($ch,CURLOPT_HTTPHEADER,$header);

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);//用post方法传送参数
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		curl_close($ch);
		$ret = substr($response, $headerSize);
		return json_decode($ret,true);
	}
}