<?php 
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '新增酒店信息';
if ($model) {
	$this->title = '修改酒店信息';
};
$this->params['breadcrumbs'][] = ['label' => '酒店列表管理', 'url' => ['hotel']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?=Html::cssFile('/css/webuploader.css')?>  
<?=Html::jsFile('/js/jquery-1.12.4.js')?>
<?=Html::jsFile('/js/webuploader/webuploader.js')?>
<?=Html::jsFile('/js/upload.js')?>

<style>
	#fileList .thumbnail > img, .thumbnail a > img{margin-left: 0;}
    #fileList .file-item{border: 0; width: 110px; display: block; float: left;}
    #fileList .file-item img{width:100px; height: 100px;}
    #fileList .file-item span.del-img,.file-item span.del-img1{
        display: block;
        width: 100%;
        height: 25px;
        background: rgba(0, 0, 0, .5);
        top: -25px;
        line-height: 25px;
        text-align: right;
        padding-right: 6px;
        color: #fff;
        cursor: pointer;
    }
    #filePicker{display: block; clear: both;}
    #map{height: 380px;}
</style>

<div style="width:70%; margin-left: 10%; display: block; float: left;">
    <h3><?php echo $this->title; ?></h3>
    <form class="form-horizontal">
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;酒店名称</label>
            <div class="col-sm-8">
                <input type="input" class="form-control" name="hotel_name" id="hotel_name" value="<?=$model['hotel_name']?>" placeholder="请输入酒店名称">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;酒店类型</label>
            <div class="col-sm-8">
                <select name="hotel_type" id="hotel_type" class="form-control">
                	<option value="1" <?php if($model['hotel_type'] == 1) echo 'selected';?>>默认</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;所属区域</label>
            <div class="col-sm-8">
                <select name="city_id" id="city_id" class="form-control">
                	<?php if($city): foreach($city as $k => $v): ?>
                		<option value="<?=$v['id']?>" <?php if($model['city_id'] == $v['id']) echo 'selected';?>><?=$v['city']?></option>
                	<?php endforeach; endif; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;所属楼盘</label>
            <div class="col-sm-8">
                <select name="house_id" id="house_id" class="form-control">
                	<?php if($house): foreach($house as $k => $v): ?>
                		<option value="<?=$v['id']?>" <?php if($model['house_id'] == $v['id']) echo 'selected';?>><?=$v['housename']?></option>
                	<?php endforeach;endif; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;酒店品牌</label>
            <div class="col-sm-8">
                <select name="brand_id" id="brand_id" class="form-control">
                	<?php if($brand): foreach($brand as $k => $v): ?>
                		<option value="1" <?php if($model['brand_id'] == $v['brand_id']) echo 'selected';?>><?=$v['brand_name']?></option>
            		<?php endforeach; endif; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;酒店星级</label>
            <div class="col-sm-8">
                <select name="hotel_star" id="hotel_star" class="form-control">
                	<option value="1" <?php if($model['hotel_star'] == 1) echo 'selected';?>>经济型</option>
                	<option value="2" <?php if($model['hotel_star'] == 2) echo 'selected';?>>舒适/三星</option>
                	<option value="3" <?php if($model['hotel_star'] == 3) echo 'selected';?>>高档/四星</option>
                	<option value="4" <?php if($model['hotel_star'] == 4) echo 'selected';?>>豪华/五星</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;酒店简介</label>
            <div class="col-sm-8">
                <input type="input" class="form-control" name="hotel_intro" id="hotel_intro" value="<?=$model['hotel_intro']?>" placeholder="请输入酒店简介">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;酒店图片</label>
            <div class="col-sm-10">	
                <div id="fileList">
                	<?php if($hotel_imgs): foreach($hotel_imgs as $k => $v): ?>
                	<div class="file-item thumbnail" data-url="<?php echo $v['path']; ?>">
                        <img src="<?php echo $v['path']; ?>">
                        <span class="glyphicon glyphicon-trash del-img1"></span>
                    </div>
            		<?php endforeach; endif; ?>
                </div>
                <div id="filePicker"></div>
				<input type="hidden" id="hotel" value="icon">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;价格</label>
            <div class="col-sm-8">
                <input type="input" class="form-control" name="price" id="price" value="<?=$model['price']?>" placeholder="请输入价格">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;酒店电话</label>
            <div class="col-sm-8">
                <input type="input" class="form-control" name="hotel_tel" id="hotel_tel" value="<?=$model['hotel_tel']?>" placeholder="请输入酒店电话">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;开业年份</label>
            <div class="col-sm-8">
                <input type="input" class="form-control" name="open_year" id="open_year" value="<?=$model['open_year']?>" placeholder="请输入开业年份">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;装修年份</label>
            <div class="col-sm-8">
                <input type="input" class="form-control" name="update_year" id="update_year" value="<?=$model['update_year']?>" placeholder="请输入装修年份">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;入住时间</label>
            <div class="col-sm-8">
                <input type="time" class="form-control" name="in_time" id="in_time" value="<?php if($model) echo $model['in_time']; else echo '14:00'; ?>" placeholder="请选择入住时间">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;离店时间</label>
            <div class="col-sm-8">
                <input type="time" class="form-control" name="leave_time" id="leave_time" value="<?php if($model) echo $model['leave_time']; else echo '12:00'; ?>" placeholder="请选择离店时间">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;客房总数</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="total_rooms" id="total_rooms" value="<?=$model['total_rooms'] ?>" placeholder="请输入客房总数">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">押金信息</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" name="deposit" id="deposit" value="<?=$model['deposit'] ?>" placeholder="入住需要押金，金额以前台为准">
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label">基础设施</label>
            <div class="col-sm-8">
				<?php if($facilities): foreach($facilities as $k => $v): ?>
					<input type="checkbox" name="faci" value="<?=$v['faci_id']?>" <?php if($model && in_array($v['faci_id'],explode(',', $model['facilities']))) echo 'checked'; ?>>
					<img src="<?=$v['faci_icon']?>" style="width: 20px; height: 20px;"/>
					<label><?=$v['faci_name']?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php endforeach; endif; ?>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;详细地址</label>
            <div class="col-sm-8">
				<input type="text" class="form-control" id="address" name="address" placeholder="请输入酒店详细地址" value="<?=$model['address']?>">
				<input type="text" class="form-control" id="lng" name="lng" value="<?=$model['longitude']?>" placeholder="经度">
				<input type="text" class="form-control" id="lat" name="lat" value="<?=$model['latitude']?>" placeholder="纬度">
			</div>
        </div>
        <div class="form-group">
            <label for="" class="col-sm-2 control-label"><span style="color: red;">*</span>&nbsp;详细地址</label>
            <div class="col-sm-10">
				<div id="map"></div>
				<script src="https://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js" type="text/javascript" charset="utf-8"></script>
			    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=CVwbPK6LKRV9ibfTZIY8T4DvIYhFxfm4 "></script>
			    <script type="text/javascript">
					// 百度地图API功能
					var map = new BMap.Map("map");    // 创建Map实例
					var point =new BMap.Point(113.7057070132,34.7261604714) 
					map.centerAndZoom(point, 11);  // 初始化地图,设置中心点坐标和地图级别
					map.addControl(new BMap.MapTypeControl());   //添加地图类型控件
					map.setCurrentCity("郑州");          // 设置地图显示的城市 此项是必须设置的
					map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
					var marker = new BMap.Marker(point);  // 创建标注
					map.addOverlay(marker);               // 将标注添加到地图中
					marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
					
					var top_left_control = new BMap.ScaleControl({anchor: BMAP_ANCHOR_TOP_LEFT});// 左上角，添加比例尺
					var top_left_navigation = new BMap.NavigationControl();  //左上角，添加默认缩放平移控件
					var top_right_navigation = new BMap.NavigationControl({anchor: BMAP_ANCHOR_TOP_RIGHT, type: BMAP_NAVIGATION_CONTROL_SMALL}); //右上角，仅包含平移和缩放按钮
					/*缩放控件type有四种类型:
					BMAP_NAVIGATION_CONTROL_SMALL：仅包含平移和缩放按钮；
					BMAP_NAVIGATION_CONTROL_PAN:仅包含平移按钮；
					BMAP_NAVIGATION_CONTROL_ZOOM：仅包含缩放按钮*/
						
					//添加控件和比例尺
					
					map.addControl(top_left_control);        
					map.addControl(top_left_navigation);     
					//map.addControl(top_right_navigation);    
					
					//移除控件和比例尺
					// 	map.removeControl(top_left_control);     
					// 	map.removeControl(top_left_navigation);  
					// 	map.removeControl(top_right_navigation); 
					
					var address=$("#address"),lng=$("#lng"),lat=$("#lat")
					var myGeo = new BMap.Geocoder();
					address.change(function(){
						myGeo.getPoint(address[0].value,function(point){
							if (point) {      
						        map.centerAndZoom(point, 16);      
						        map.addOverlay(new BMap.Marker(point)); 
						        lng[0].value=point.lng;
						        lat[0].value=point.lat;
						    }else{
						    	alert('无效地址')
						    }
						})
					});
					
					var geoc = new BMap.Geocoder();
					map.addEventListener("click", function(e){        
						var pt = e.point;
						lng[0].value=pt.lng;
						lat[0].value=pt.lat;
						geoc.getLocation(pt, function(rs){
							var addComp = rs.addressComponents;
							address[0].value=addComp.province  + addComp.city  + addComp.district + addComp.street  + addComp.streetNumber
						// alert(addComp.province + ", " + addComp.city + ", " + addComp.district + ", " + addComp.street + ", " + addComp.streetNumber);
						});        
					});
				</script>
			</div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
                <input type="hidden" id="hotel_id" value="<?=$model['hotel_id']?>">
                <button type="button" class="btn btn-default btn_submit">提交</button>
            </div>
        </div>
    </form>
</div>

<script>	
	$(function(){
		$('.btn_submit').click(function(){
			var hotel_id   = $('#hotel_id').val();
			var hotel_name = $('#hotel_name').val();
			var hotel_type = $('#hotel_type').val();
			var city_id    = $('#city_id').val();	
			var house_id   = $('#house_id').val();	
			var brand_id   = $('#brand_id').val();	
			var hotel_star = $('#hotel_star').val();
			var hotel_intro = $('#hotel_intro').val();
			var price      = $('#price').val();
			var hotel_tel  = $('#hotel_tel').val();
			var open_year  = $('#open_year').val();
			var update_year = $('#update_year').val();
			var in_time    = $('#in_time').val();
			var leave_time = $('#leave_time').val();
			var total_rooms = $('#total_rooms').val();
			var deposit    = $('#deposit').val();
			var facilities = '';
			$('input[name=faci]:checked').each(function(){
				facilities += $(this).val() + ',';
			});
			var address   = $('#address').val();
			var longitude = $('#lng').val();
			var latitude  = $('#lat').val();			
			var hotel_img  = '';
			$('.file-item').each(function(){
				hotel_img += $(this).data('url') + ',';
			});

			if (hotel_name == undefined || hotel_name.length == 0) {
				alert("请输入酒店名称");return false;
			}
			if (hotel_type == undefined || hotel_type.length == 0) {
				alert("请选择酒店类型");return false;
			}
			if (city_id == undefined || city_id.length == 0) {
				alert("请选择所属区域");return false;
			}
			if (house_id == undefined || house_id.length == 0) {
				alert("请选择所属楼盘");return false;
			}
			if (brand_id == undefined || brand_id.length == 0) {
				alert("请选择酒店品牌");return false;
			}
			if (hotel_star == undefined || hotel_star.length == 0) {
				alert("请选择酒店星级");return false;
			}
			if (hotel_img == undefined || hotel_img.length == 0) {
				alert("请上传酒店主图");return false;
			}
			if (price == undefined || price.length == 0) {
				alert("请输入酒店价格");return false;
			}
			if (hotel_tel == undefined || hotel_tel.length == 0) {
				alert("请输入酒店电话");return false;
			}
			if (open_year == undefined || open_year.length == 0) {
				alert("请输入酒店开业年份");return false;
			}
			if (update_year == undefined || update_year.length == 0) {
				alert("请输入酒店装修年份");return false;
			}
			if (in_time == undefined || in_time.length == 0) {
				alert("请输入酒店入住时间");return false;
			}
			if (leave_time == undefined || leave_time.length == 0) {
				alert("请输入酒店离店时间");return false;
			}
			if (total_rooms == undefined || total_rooms.length == 0) {
				alert("请输入酒店客房总数");return false;
			}
			if (address == undefined || address.length == 0) {
				alert("请输入酒店详细地址");return false;
			}
			if (longitude == undefined || longitude.length == 0 || latitude == undefined || latitude.length == 0) {
				alert("请选择酒店坐标");return false;
			}

			var data = {};
			data.hotel_id   = hotel_id;
			data.hotel_name = hotel_name;
			data.hotel_type = hotel_type;
			data.city_id = city_id;
			data.house_id = house_id;
			data.brand_id = brand_id;
			data.hotel_star = hotel_star;
			data.hotel_intro = hotel_intro;
			data.hotel_img = hotel_img;
			data.price = price;
			data.hotel_tel = hotel_tel;
			data.open_year = open_year;
			data.update_year = update_year;
			data.in_time = in_time;
			data.leave_time = leave_time;
			data.total_rooms = total_rooms;
			data.deposit = deposit;
			data.facilities = facilities;
			data.address = address;
			data.longitude = longitude;
			data.latitude = latitude;

			// console.log(data);

			$.post("<?=Url::to(['hotel/ajax-add-hotel'])?>",{data},function(res){
				if (res.code == 200) {
					alert('提交成功');
					location.href = "<?=Url::to(['hotel/hotel'])?>";
				} else {
					alert(res.msg);return false;
				}
			},"JSON");
		});
	});
</script>