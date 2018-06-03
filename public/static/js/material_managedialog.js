//弹出图片管理界面  2016年11月24日 17:58:41
var OpenPricureDialog = function(type, ADMIN_MAIN, number ) {
	if (number  == null || number  == '' || number  == 0) {
		number  = 1;
	}
	if (type == "PopPicure") {
		art.dialog.open(ADMIN_MAIN + '/system/dialogalbumlist?number='+ number , {
			lock : true,
			title : "我的图片",
			width : 860,
			height : 620,
			drag : false,
			background : "#000000"
		}, true);
	}
}
//弹出sku管理界面
var OpenSkuDialog = function(ADMIN_MAIN,attr_id) {
	art.dialog.open(ADMIN_MAIN + '/goods/controldialogsku?attr_id='+attr_id, {
		lock : true,
		title : "商品规格",
		width : 860,
		height : 350,
		drag : false,
		background : "#000000"
	}, true);
	
}

//弹出商品分类选择界面
var OpenCategoryDialog = function(ADMIN_MAIN, category_id, goodsid, flag, box_id, category_extend_id) {
	var dialog_title = "";
	switch(flag){
	case "category":
		dialog_title = "商品类目";
		break;
	case "extend_category":
		dialog_title = "商品扩展类目";
		break;
	
	}
	art.dialog.open(ADMIN_MAIN + '/goods/dialogselectcategory?category_id='+category_id+'&goodsid='+goodsid+"&flag="+flag+"&box_id="+box_id+"&category_extend_id="+category_extend_id, {
		lock : true,
		title : dialog_title,
		width : 974,
		height : 550,
		drag : false,
		background : "#000000"
	}, true);
	
}