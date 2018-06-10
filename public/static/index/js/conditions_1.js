/**
 * 条件筛选查询 2017年2月22日 09:54:58
 */
function searchConditions() {
	var min_price = $("#min_price").val();
	var max_price = $("#max_price").val();
	var url_parameter = $("#hidden_url_parameter").val();
	if (min_price == "" || max_price == "") {
		if(min_price == '' && max_price != ''){
			$.msg("应搜索大于等于此价格的商品");
			return;
		}else if(min_price != '' && max_price == ''){
			$.msg("应搜索小于等于此价格的商品");
			return;
		}
	} else {
		if (parseFloat(min_price) > parseFloat(max_price) || min_price.length > 15
				|| max_price.length > 15) {
			$.msg("价格输入错误");
			return;
		}
		var url = shop_main + "/goods/goodslist?" + url_parameter;
		url += "&min_price=" + min_price + "&max_price=" + max_price;
		if($.trim(attr_item) != "" && $.trim(attr_item) != undefined ){
			url += "&attr=" + attr_item;
		}
		location.href = url;
	}
}
// 是否多选
var isMore = false;
// 同一类，多选条件进行筛选，显示
// ns_category.js会控制“确定”按钮的样式
function showDuoXuan(obj) {
	$(obj).find(".duoxuan-btnbox").css("text-align", "center");
	$(obj).find(".duoxuan-btnbox").show();
	isMore = true;
}
// 同一类，多选条件进行筛选 隐藏
function hiddenDuoXuan(obj) {
	$(obj).find(".duoxuan-btnbox").hide();
	$("#brand-abox").find("li").removeClass("brand-seled");
	$(".select-button-sumbit").addClass("disabled");
	$(".select-button-sumbit").removeClass("select-button-sumbit");
	isMore = false;
}
// 单个品牌查询
function selectBrand(obj, brand_id, brand_name) {
	var url_parameter = $("#hidden_url_parameter").val();
	if ($(obj).parent().hasClass("brand-seled")) {
		$(obj).parent().removeClass("brand-seled");
	} else {
		$(obj).parent().addClass("brand-seled");
	}
	// 单选
	if (!isMore) {
		$("#brand-abox").find("li").removeClass("brand-seled");
		var url = shop_main + "/goods/goodslist?" + url_parameter;
		url += "&brand_id=" + brand_id + "&brand_name=" + brand_name;
		//拼装属性条件
		if($.trim(attr_item) != "" && $.trim(attr_item) != undefined ){
			url += "&attr=" + attr_item;
		}
		location.href = url;
		
	}
}

// 多个品牌查询
function brandMoreSearch(obj) {
	if (!$(obj).hasClass("disabled")) {
		var url_parameter = $("#hidden_url_parameter").val();
		var arr_id = new Array();
		var arr_name = new Array();
		$("#brand-abox").find(".brand-seled").each(function() {
			arr_id.push($(this).attr("data-brand-id"));
			arr_name.push($(this).attr("data-brand-name"));
		})
		var brand_id = arr_id.join(",");
		var brand_name = arr_name.join(",");
		var url = shop_main + "/goods/goodslist?" + url_parameter;
		url += "&brand_id=" + brand_id + "&brand_name=" + brand_name;
		if($.trim(attr_item) != "" && $.trim(attr_item) != undefined ){
			url += "&attr=" + attr_item;
		}
		location.href = url;
	}
}

//属性
function attrSelect(obj){
	var url_parameter = $("#hidden_url_parameter").val();
	if ($(obj).parent().hasClass("brand-seled")) {
		$(obj).parent().removeClass("brand-seled");
	} else {
		$(obj).parent().addClass("brand-seled");
	}

	var attr_value = $(obj).data("attr-value");
	var attr_value_name= $(obj).data("attr-value-name");
	
	judgeAttrIsHaveData(attr_value, attr_value_name, true);
	var url = shop_main + "/goods/goodslist?" + url_parameter;
	if($.trim(attr_item) != "" && $.trim(attr_item) != undefined ){
		url += "&attr=" + attr_item;
	}
	location.href = url;
}
//判断数据是否在数据中  存在就改变  不存在就添加 (is_remove true为添加 false位删除)
function judgeAttrIsHaveData(attr_value, attr_value_name, is_remove){
	if(attr_value !="" && attr_value_name !=""){
			
			var temp_array = new Array();
			var attr_array = new Array()
			temp_array = attr_item.split(";");
			for(var i =0; i < temp_array.length ; i++){
				attr_array.push(temp_array[i].split(","));
			}
			var is_have = true; 
			//如果本属性已存在要改变吃属性值
			$.each(attr_array,function(k,v){
					if(v[0] == attr_value){
						if(is_remove){
							attr_array[k][1] = attr_value_name;
						}else{
							SpliceArrayItem(attr_array, v);
						}
						is_have = false;
						return false;
					}
			});
			
			if(is_have){
				if(attr_item == ""){
					attr_item =attr_value+","+attr_value_name;
				}else{
					attr_item +=";"+attr_value+","+attr_value_name;
				}
			}else{
				arrayChangeString(attr_array);
			}
	}
}
//移除摸个属性条件
function removeAttr(event){
	var url_parameter = $("#hidden_url_parameter").val();
	var attr_value = $(event).data("attr-value");
	var attr_value_name= $(event).data("attr-value-name");
	judgeAttrIsHaveData(attr_value, attr_value_name, false);
	var url = shop_main + "/goods/goodslist?" + url_parameter;
	if($.trim(attr_item) != "" && $.trim(attr_item) != undefined ){
		url += "&attr=" + attr_item;
	}
	location.href = url;
}
//字符串转数组
function arrayChangeString(array){
	var temp_array = new Array();
	$.each(array,function(k,v){
		temp_array.push(v.join(","));
	});
	attr_item = temp_array.join(";");
}

/**
 * 删除数组中的指定元素
 * @param arr
 * @param val
 */
function SpliceArrayItem(arr, val) {
	  for(var i=0; i<arr.length; i++) {
	    if(arr[i] == val) {
	      arr.splice(i, 1);
	      break;
	    }
	  }
}
//显示多余隐藏的属性
function showOverflow(obj){
	$(obj).parent().parent().hide();
	$(obj).parent().parent().parent().find(".brand").show();
	$(obj).parent().parent().parent().find(".hideover").show();
}
//显示多余隐藏的属性
function hideOverflow(obj){
	$(obj).parent().parent().hide();
	$(obj).parent().parent().parent().find(".overli").hide();
	$(obj).parent().parent().parent().find(".showover").show();
}