$(function(){
	var $list = $('#fileList');
	var uploader;
	// 初始化Web Uploader
	uploader = WebUploader.create({
		// swf文件路径
		swf: '/web/js/webuploader/Uploader.swf',
		// 文件接收服务端。
		server: "/index.php?r=admin/upload/upload-excel",
		// 选择文件的按钮。可选。
		// 内部根据当前运行是创建，可能是input元素，也可能是flash.
		pick: {
			id: '#filePicker',
			innerHTML: '选择excel文件',
			multiple: false
		},
		// 只允许选择Excel文件。
		accept: {
			title: 'Excel',
			extensions: 'xls,xlsx'
		},
		// 选完文件后，是否自动上传。
		auto: true,
		// fileNumLimit: 1,
		fileSingleSizeLimit: 1024*1024*20,
		duplicate: false,
		formData: {
			dir:'excel'
		},
	});

	uploader.on('error', function(e){
		console.log(e);
		return false;
	});

	// 文件上传成功，给item添加成功class, 用样式标记上传成功。
	uploader.on('uploadSuccess', function( file, res ) {
		if (res.code == 200) {
			$list.attr('data-url',res.url);
			$list.append(res.url + '&nbsp;&nbsp;上传成功');
		}
	});
});