// 调取默认用户信息
function userInfo() {  
	var u = navigator.userAgent;
	var userInfo;
	if(u.indexOf('Android') > -1 || u.indexOf('Adr') > -1) {
		// 安卓端调取默认信息
		userInfo = window.android.userInfo();
		userJson = eval("(" + userInfo + ")");// 字符串(string)转json
		userInfo = JSON.parse(userInfo);
		$('#person_name').val(userJson['true_name']);
		$('#person_tel').val(userJson['tell']);
	} else if(!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)) {
		//iOS端调取默认信息	        		
		userInfo = CustomJS.userInfo();
		$('#person_name').val(userInfo['true_name']);
		$('#person_tel').val(userInfo['tell']);
	}
	return userInfo;
}


// 获取楼盘id
function addressID() {
    var u = navigator.userAgent;
    var addrID;
    if(u.indexOf('Android') > -1 || u.indexOf('Adr') > -1) {
        // 安卓端调取默认信息
        addrID = window.android.addressID();
    } else if(!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)) {
        //iOS端调取默认信息
        addrID = CustomJS.addressID();
    }
    return addrID;
}

// 登录信息丢失，重新调取登录接口
function missLogin() {
	var u = navigator.userAgent;
	if(u.indexOf('Android') > -1 || u.indexOf('Adr') > -1) {
		window.android.showViewController();
	} else if(!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)) {
		CustomJS.showViewController('XYWebLoginViewController');
	}
}

// 抽奖活动分享
function getShare() {
    var u = navigator.userAgent;
    var luckShare;
    if(u.indexOf('Android') > -1 || u.indexOf('Adr') > -1) {
        // 安卓端调取默认信息
        luckShare = window.android.luckShare();
    } else if(!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)) {
        //iOS端调取默认信息
        luckShare = CustomJS.luckShare();
    }
    return luckShare;
}