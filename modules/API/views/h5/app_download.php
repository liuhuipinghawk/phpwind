<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>二维码</title>
</head>
<body>

<script>
    /**
     出来的链接大概是长这样的
     http://xxxx.cn/243423.html?c=Q23DR32
     */

    // c=Q23DR32是注册时扫描获取的邀请码。
    // 这样加参数，后面的参数会被自动忽略，不会影响加载此网页
    goDownload();

    // 去下载
    function goDownload() {
        var u = navigator.userAgent, app = navigator.appVersion;
        var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1;
        var isIOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/);
        // 这里是安卓浏览器
        if (isAndroid) {
            window.location.href = "<?=$url?>"; // 跳安卓端下载地址
        }
        // 这里是iOS浏览器
        if (isIOS) {
            window.location.href = 'https://itunes.apple.com/cn/app/ai-ban/id1330924526?mt=8'; // 跳AppStore下载地址
        }

        // 是微信内部webView
        if (is_weixn()) {
            alert("请点击右上角按钮, 点击使用浏览器打开");
        }

        // 是PC端
        if (IsPC()) {
            window.location.href = 'http://www.xingyewulian.com/';  // 公司主页
        }
    }

    // 是微信浏览器
    function is_weixn(){
        var ua = navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i)=="micromessenger") {
            return true;
        } else {
            return false;
        }
    }


    function IsPC() {
        var userAgentInfo = navigator.userAgent;
        var Agents = ["Android", "iPhone",
            "SymbianOS", "Windows Phone",
            "iPad", "iPod"];
        var flag = true;
        for (var v = 0; v < Agents.length; v++) {
            if (userAgentInfo.indexOf(Agents[v]) > 0) {
                flag = false;
                break;
            }
        }
        return flag;
    }

</script>
</body>
</html>