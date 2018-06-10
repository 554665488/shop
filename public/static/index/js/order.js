/**
 * 订单操作js
 * 作用：订单流程相关操作
 * 2017-01-07
 */
/**
 * 订单操作中转
 * @param no
 * @param order_id
 */
function operation(no,order_id)
{
	switch(no){
	case 'pay'://支付
		pay(order_id);
		break;
	case 'close'://订单关闭
		orderClose(order_id);
		break;
	case 'getdelivery'://订单收货
		getdelivery(order_id);
		break;
	case 'refund'://申请退款
		orderRefund(order_id);
		break;
	default:
		break;
			
	}
}
/**
 * 微信支付
 * @param order_id
 */
function pay(order_id)
{
	//去支付
	window.location.href = shop_main+"/order/orderPay?id="+order_id;
//	$.msg("去支付，没做！！");
	
/*	$.ajax({
		type : "post",
		url : shop_main+"/Order/orderPay",
		async : true,
		data : {
			"id" : order_id
		},
		success : function(data) {
			if(data["code"] > 0 ){
				$.msg(data['message']);
				location.href=shop_main+"/member/orderlist?status=1";
			}
		}
	})*/
}

/**
 * 订单交易关闭
 * @param order_id
 */
function orderClose(order_id)
{	
	$( "#dialog" ).dialog({
		buttons: {
			"确定": function() {
				   $.ajax({
						type : "post",
						url : shop_main+"/order/orderClose",
						async : true,
						data : {
							"order_id" : order_id
						},
						success : function(data) {
							//alert(JSON.stringify(data['message']));
							if(data["code"] > 0 ){
								$.msg("操作成功");
								location.href=shop_main+"/member/orderlist?status=0";
							}
						}
					})
					$(this).dialog('close');
		},
		"取消,#e57373": function() {
			$(this).dialog('close');
		},
	},
	contentText:"确定关闭订单吗？",
});			
}
/**
 * 订单收货
 * @param order_id
 */
function getdelivery(order_id)
{
	$.ajax({
		type : "post",
		url : shop_main+"/order/orderTakeDelivery",
		async : true,
		data : {
			"order_id" : order_id
		},
		success : function(data) {
			if(data["code"] > 0 ){
				 $.msg("收货成功");
				location.href=shop_main+"/member/orderlist?status=3";
			}
		}
	})
}
/*****************************************************************************************************订单退款项目*************************************************************************/

