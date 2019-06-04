window.id = 0; 
function add_id(id)
{
	window.id = id;
}
$(function(){
	var thumbnailWidth = 100;
	var thumbnailHeight = 100;
	var uploader;
	
	// 初始化Web Uploader
	uploader = WebUploader.create({
		// swf文件路径
		swf: '/web/js/webuploader/Uploader.swf',
		// 文件接收服务端。
		server: "/index.php?r=admin/upload/upload-img",
		// 选择文件的按钮。可选。
		// 内部根据当前运行是创建，可能是input元素，也可能是flash.
		pick: {
			id: '.filePicker',
			// innerHTML: $(this).data('title'),
			multiple: false
		},
		// 只允许选择图片文件。
		accept: {
			title: 'Images',
			extensions: 'gif,jpg,jpeg,bmp,png',
			mimeTypes: 'image/*'
		},
		// 选完文件后，是否自动上传。
		auto: true,
		// fileNumLimit: 6,
		fileSingleSizeLimit: 1024*1024*2,
		duplicate: false,
		formData: {
			dir:$('#dir').val()
		},
		compress:{
			quality: 80,
			allowMagnify: false,
			crop: false,
			preserveHeaders: true,
			noCompressIfLarger: false,
			compressSize:0
		}
	});

	uploader.on('error', function(e){
		if (e == 'Q_EXCEED_NUM_LIMIT') {
			alert('已达到最大上传数量');return false;
		} else if(e == 'F_DUPLICATE') {
			alert('不可上传重复图片');return false;
		}
		alert(e);
		return false;
	});

	// 当有文件添加进来的时候
	uploader.on('fileQueued', function( file ) {
		var $li = $(
			'<div id="' + file.id + '" class="file-item thumbnail">' +
				'<img><span class="glyphicon glyphicon-trash del-img"></span>' +
			'</div>'
		),
		$img = $li.find('img');
		// $list为容器jQuery实例
		if (window.id != 'house_img') {
			$('#fileList_'+window.id).html('');
		}
		$('#fileList_'+window.id).append( $li );
		// 创建缩略图
		// 如果为非图片文件，可以不用调用此方法。
		// thumbnailWidth x thumbnailHeight 为 100 x 100
		uploader.makeThumb( file, function( error, src ) {
			if ( error ) {
				$img.replaceWith('<span>不能预览</span>');
				return;
			}
			$img.attr( 'src', src );
		}, thumbnailWidth, thumbnailHeight );
	});

	// 文件上传成功，给item添加成功class, 用样式标记上传成功。
	uploader.on('uploadSuccess', function( file, res ) {
		if (res.code == 200) {
			$( '#'+file.id ).attr('data-url',res.url);
			if (window.id == 'house_img') {
				var len = $('#fileList_'+window.id).find('.file-item:last').index();
				if (len >= 5) {
					$('#fileList_'+window.id).prev('.filePicker').hide();
				}
			} else {
				$('#fileList_'+window.id).prev('.filePicker').hide();
			}
		}
	});

	// 文件上传失败，显示上传出错。
	uploader.on('uploadError', function( file ) {
		var $li = $( '#'+file.id ),
		$error = $li.find('div.error');
		// 避免重复创建
		if ( !$error.length ) {
			$error = $('<div class="error"></div>').appendTo( $li );
		}
		$error.text('上传失败');
	});
	// 完成上传完了，成功或者失败，先删除进度条。
	uploader.on('uploadComplete', function( file ) {
		$( '#'+file.id ).find('.progress').remove();
	});

	$('#fileList_a0,#fileList_a1,#fileList_house_img,#fileList_qj').on('click','.del-img',function(){
		if (confirm('确定要删除该图片吗？')) {
			$(this).parent().parent().prev('.filePicker').show();
			$(this).parent('.thumbnail').remove();
			uploader.removeFile($(this).parent().attr('id'),true);
		}
	});
});
