<?php
namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;

class UploadController extends CommonController {

	public $enableCsrfValidation=false;

	/**
	 * 上传图片
	 * @Author   tml
	 * @DateTime 2017-12-09
	 * @return   [type]     [description]
	 */
	public function actionUploadImg(){
		$img = $_FILES['file'];

		if ($img['error'] > 0) {
			echo json_encode(['code'=>-200,'msg'=>'文件错误']);exit;
		}

		$dir = Yii::$app->request->post('dir','default');
		$path = 'uploads/'.$dir.'/'.date('Ymd',time()).'/';

		$suffix = strrchr($img['name'], '.');
		if (strtolower($suffix) != '.jpg' && strtolower($suffix) != '.jpeg' && strtolower($suffix) != '.png' && strtolower($suffix) != '.gif') {
			echo json_encode(['code'=>-200,'msg'=>'图片格式错误']);exit;
		}
		if ($img['size'] > 1024*1024*1) {
			echo json_encode(['code'=>-200,'msg'=>'图片大小不可超过2M']);exit;
		}
		
		if (!is_dir($path)) {
			mkdir($path,0777,true);
		}
		
		$tmp = $img['tmp_name'];

		$filename = date('His',time()).rand(1000,9999).$suffix;
        $url = $path.$filename;

		$res = move_uploaded_file($tmp, $url);//将图片文件移到该目录下

		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'上传成功','url'=>'/'.$url]);exit;
		}
		echo json_encode(['code'=>200,'msg'=>'上传失败']);exit;
	}

	function scal_pic($file_name,$file_new){  
        //验证参数  
        if(!is_string($file_name) || !is_string($file_new)){  
            return false;  
        }  
        //获取图片信息  
        $pic_scal_arr = @getimagesize($file_name);  
        if(!$pic_scal_arr){  
            return false;  
        }  
        //获取图象标识符  
        $pic_creat = '';  
        switch($pic_scal_arr['mime']){  
            case 'image/jpeg':  
                $pic_creat = @imagecreatefromjpeg($file_name);  
                break;  
            case 'image/gif':  
                $pic_creat = @imagecreatefromgif($file_name);  
                break;  
            case 'image/png':  
                $pic_creat = @imagecreatefrompng($file_name);  
                break;  
            case 'image/wbmp':  
                $pic_creat = @imagecreatefromwbmp($file_name);  
                break;  
            default:  
                return false;  
                break;  
        }  
        if(!$pic_creat){  
            return false;  
        }  
        //判断/计算压缩大小  
        $max_width = 100;//最大宽度,象素，高度不限制  
        $min_width = 15;  
        $min_heigth = 20;  
        if($pic_scal_arr[0]<$min_width || $pic_scal_arr[1]<$min_heigth){  
            return false;  
        }  
        $re_scal = 0;  
        if($pic_scal_arr[0]>$max_width){  
            $re_scal = ($max_width / $pic_scal_arr[0]);  
        }  
        $re_width = round($pic_scal_arr[0] * $re_scal);
        $re_height = round($pic_scal_arr[1] * $re_scal);  
        //创建空图象  
        $new_pic = @imagecreatetruecolor($re_width,$re_height);  
        if(!$new_pic){  
            return false;  
        }  
        //复制图象  
        if(!@imagecopyresampled($new_pic,$pic_creat,0,0,0,0,$re_width,$re_height,$pic_scal_arr[0],$pic_scal_arr[1])){  
            return false;  
        }  
        //输出文件  
        $out_file = '';  
        switch($pic_scal_arr['mime']){  
            case 'image/jpeg':  
                $out_file = @imagejpeg($new_pic,$file_new);  
                break;  
            case 'image/jpg':  
                $out_file = @imagejpeg($new_pic,$file_new);  
                break;  
            case 'image/gif':  
                $out_file = @imagegif($new_pic,$file_new);  
                break;  
            case 'image/bmp':  
                $out_file = @imagebmp($new_pic,$file_new);  
                break;  
            default:  
                return false;  
                break;  
        }  
        if($out_file){  
            return true;  
        }else{  
            return false;  
        }  
	}
	
	/**
	 * 上传excel
	 * @Author   tml
	 * @DateTime 2017-12-09
	 * @return   [type]     [description]
	 */
	public function actionUploadExcel(){
		$file = $_FILES['file'];

		if ($file['error'] > 0) {
			echo json_encode(['code'=>-200,'msg'=>'文件错误']);exit;
		}

		$dir = Yii::$app->request->post('dir','default');
		$path = 'upload/'.$dir.'/'.date('Ymd',time()).'/';

		$suffix = strrchr($file['name'], '.');
		if (strtolower($suffix) != '.xls' && strtolower($suffix) != '.xlsx') {
			echo json_encode(['code'=>-200,'msg'=>'文件格式错误']);exit;
		}
		if ($file['size'] > 1024*1024*20) {
			echo json_encode(['code'=>-200,'msg'=>'文件大小不可超过20M']);exit;
		}
		
		if (!is_dir($path)) {
			mkdir($path,0777,true);
		}
		
		$tmp = $file['tmp_name'];

		$filename = date('His',time()).rand(1000,9999).$suffix;
        $url = $path.$filename;

		$res = move_uploaded_file($tmp, $url);//将图片文件移到该目录下
		if ($res) {
			echo json_encode(['code'=>200,'msg'=>'上传成功','url'=>$url]);exit;
		}
		echo json_encode(['code'=>200,'msg'=>'上传失败']);exit;
	}
}