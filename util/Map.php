<?php
namespace app\util;

class Map{
	/**
	 * 计算两点地理坐标之间的距离
	 * @param  Decimal $longitude1 起点经度
	 * @param  Decimal $latitude1  起点纬度
	 * @param  Decimal $longitude2 终点经度 
	 * @param  Decimal $latitude2  终点纬度
	 * @param  Int     $unit       单位 1:米 2:公里
	 * @param  Int     $decimal    精度 保留小数位数
	 * @return Decimal
	 */
	public static function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=1, $decimal=2){
		if (empty($longitude1) || empty($latitude1)) {
			return 0;
		}

		// $EARTH_RADIUS = 6370.996; // 地球半径系数
		$EARTH_RADIUS = 6372.797; // 地球半径系数
		$PI = 3.1415926;

		$radLat1 = $latitude1 * $PI / 180.0;
		$radLat2 = $latitude2 * $PI / 180.0;

		$radLng1 = $longitude1 * $PI / 180.0;
		$radLng2 = $longitude2 * $PI / 180.0;

		$a = $radLat1 - $radLat2;
		$b = $radLng1 - $radLng2;

		$distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
		$distance = $distance * $EARTH_RADIUS * 1000;

		// if($unit==2){
		// 	$distance = $distance / 1000;
		// }
		$dw = 'm';
		if ($distance > 1000) {
			$distance = $distance / 1000;
			$dw = 'km';
		}

		return round($distance, $decimal).$dw;

	}

	/**
	 * 计算已知坐标和特定距离，计算经纬度范围
	 * @param  Decimal $Lng 经度
	 * @param  Decimal $Lat 纬度
	 * @param  Double $Len 距离长度，1代表1km之内，单位km
	 * @return Array
	 */
	public static function getRange($Lng,$Lat,$Len){
		$range = 180 / pi() * $Len / 6372.797;  
		$lngR = $range / cos($Lat * pi() / 180);    
  
		$maxLat = $Lat + $range;//最大纬度    
		$minLat = $Lat - $range;//最小纬度    
		$maxLng = $Lng + $lngR;//最大经度    
		$minLng = $Lng - $lngR;//最小经度   
  
		return array('maxLat'=>$maxLat,'minLat'=>$minLat,'maxLng'=>$maxLng,'minLng'=>$minLng);
	}
}	
