/**
 * 组件条用js 2018年6月15日16:45:22
 */

// 组件根据广告位查询广告 ap_id广告位id
function platformAdvLoad(ap_id) {
	var result = '';
	$.ajax({
		type : "post",
		url : shop_main + "/index/Components/platformAdvList",
		async : false,
		data : {
			'ap_id' : ap_id
		},
		dataType : 'json',
		success : function(data) {
			result = data;
			return result;
		}
	});
	return result;
}

// 组件根据广告位查询广告 ap_id广告位id
function platformAdvLoadNew(ap_id) {
	var result = '';
	$.ajax({
		type : "post",
		url : shop_main + "/components/platformadvlistnew",
		async : false,
		data : {
			'ap_id' : ap_id
		},
		dataType : 'json',
		success : function(data) {
			result = data;
			return result;
		}
	});
	return result;
}