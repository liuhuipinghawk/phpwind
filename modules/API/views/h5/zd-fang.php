<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>3D看房详情</title>
    <meta name="viewport" content="initial-scale=1">
    <link rel="stylesheet" href="../../dist/css/jquery-weui.css">
    <link rel="stylesheet" href="../../dist/css/d-fang.css">
    <script>
        /*设定html字体大小*/
        var deviceWidth = document.documentElement.clientWidth;
        if(deviceWidth > 640) deviceWidth = 640;
        document.documentElement.style.fontSize = deviceWidth / 6.4 + 'px';

    </script>
</head>
<body ontouchstart>
<div id="container"></div>


<script src="../../dist/js/three.min.js"></script>
<script src="../../dist/js/photo-sphere-viewer.min.js"></script>
<script src="../../dist/js/jquery-2.1.4.js"></script>
<script src="../../dist/js/fastclick.js"></script>
<?=Html::jsFile('/js/common.js')?>

<script>
    $(function () {
        //初始加载3D图片路径
        var div = document.getElementById('container');
        function getCookie(cookieName) {
            var strCookie = document.cookie;
            var arrCookie = strCookie.split("; ");
            for(var i = 0; i < arrCookie.length; i++){
                var arr = arrCookie[i].split("=");
                if(cookieName == arr[0]){
                    return arr[1];
                }
            }
            return "";
        }
        var imgsrc = getCookie("imgsrc");
        // console.log(imgsrc);

        var PSV = new PhotoSphereViewer({
            panorama: imgsrc,
            container: div,
            time_anim: 3000,
            loading_msg: '加载中……'
        });


    });
</script>
</body>
</html>