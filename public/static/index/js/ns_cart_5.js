/**
 * AJAX后台、卖家中心公共组件
 * 
 */

(function($) {
	$.topbar = {
		init: function() {
			if ($(".NS-USER-NAME").size() > 0) {
				$.get('/site/user', {}, function(result) {
					if (result.code == 0 && result.data != null) {
						$.sidebar.renderLogin(result.data);
						$.sidebar.initLogin = true;

						var data = result.data;

						// 判断是否存在站点
						if (data.site_id != undefined) {

							if (data.site_id == 0) {
								// 弹出选择站点的界面
								$.get('/subsite/selector', {}, function(result) {
									if (result.code == 0 && result.data != null) {
										var element = $($.parseHTML(result.data, true));
										$("body").append(element);
									}
								}, "json");
							}

							if (data.site_change != undefined || data.site_change != null) {
								if ($(".NS-SUBSITE").size() > 0) {
									$(".NS-SUBSITE").html(data.site_change);
								}
							}

						}
					}
				}, "json");
			}
		}
	};

	// 侧边栏
	$.sidebar = {
		// 初始化登录信息
		initLogin: false,
		// 初始化
		init: function() {
			// 侧边栏浏览记录
			$(".sidebar-historybox-trigger").click(function() {
				var target = this;
				if ($(target).data("load")) {
					return;
				}
				$.get("/history/box-goods-list", {}, function(result) {
					if (result.code == 0) {
						$(".sidebar-historybox").find(".sidebar-historybox-goods-list").html(result.data);
					}
					$(target).data("load", true);
				}, "json");
			});

			// 初始化侧边栏登录信息
			$(".sidebar-user-trigger").mouseover(function() {

				if ($.sidebar.initLogin) {
					return;
				}

				$.get('/site/user', {}, function(result) {
					if (result.code == 0 && result.data != null) {
						$.sidebar.renderLogin(result.data);
					}
				});

				$.sidebar.initLogin = true;
			});
		},
		renderLogin: function(user) {

			if (user && user.cart) {
				var count = user.cart.goods_count;
				if (count > 99) {
					count = "99+";
				}
				// 购物车中商品数量
				$(".NS-CART-COUNT").html(count);
			}

			// 用户信息
			if (user && user.user_name) {

				var target = $(".NS-USER-ALREADY-LOGIN");

				$(target).find(".NS-USER-NAME").html(user.user_name);

				$(target).find(".NS-USER-PIC").attr("src", user.headimg);

				if (user.user_rank) {

					$(target).find(".NS-USER-RANK-IMG").attr("src", user.user_rank.rank_img);

					$(target).find(".NS-USER-RANK-NAME").html(user.user_rank.rank_name);

				}

				$(target).find(".NS-USER-LAST-LOGIN").html(user.last_time_format);

				$(".NS-USER-NOT-LOGIN").hide();
				$(".NS-USER-ALREADY-LOGIN").show();
			} else {
				$(".NS-USER-NOT-LOGIN").show();
				$(".NS-USER-ALREADY-LOGIN").hide();
			}
		},
		// 飞入购物车效果
		fly: function(image_url, event, target) {
			if (image_url && event && $(target).size() > 0) {
				// 结束的地方的元素
				var offset = $(target).offset();
				var flyer = $('<img class="fly-img" src="' + image_url + '">');
				if ($.isFunction(flyer.fly)) {
					flyer.fly({
						start: {
							left: event.pageX - 20,
							top: event.pageY - $(window).scrollTop()
						},
						end: {
							left: offset.left + 20,
							top: offset.top - $(window).scrollTop() + 50,
							width: 0,
							height: 0
						},
						onEnd: function() {
							this.destory();
						}
					});
				}
			}
		}
	};

	// 购物车盒子
	$.cartbox = {
		// 上次访问的时间戳
		lasttime: 0,
		// 当前购物车盒子中商品的数量
		count: 0,
		// 初始化
		init: function() {

			$(".cartbox").mouseenter(function() {
				var time = new Date().getTime();
				if ($.cartbox.lasttime == 0 || time - $.cartbox.lasttime > 5 * 1000) {
					$.cartbox.load();
				}
				$(this).find(".cartbox-goods-list").show();
			}).mouseleave(function() {
				$(this).find(".cartbox-goods-list").hide();
			});

			$(".sidebar-cartbox-trigger").click(function() {
				var time = new Date().getTime();
				if ($.cartbox.lasttime == 0 || time - $.cartbox.lasttime > 5 * 1000) {
					$.cartbox.load();
				}
			});
		},
		// 设置新增了几件商品
		add: function(number) {
			// 计数累计
			this.count = parseInt(this.count) + parseInt(number);
			// 移入刷新
			this.lasttime = 0;
			// 渲染数量
			this.renderCount();
		},
		// 渲染数量
		renderCount: function(count) {
			if (!count) {
				count = this.count;
			}
			if (count > 99) {
				count = "99+";
			}
			$(".cartbox").find(".NS-CART-COUNT").html(count);

			$(".sidebar-cartbox-trigger").find(".NS-CART-COUNT").html(count);
		}
	};

	// 购物车
	$.cart = {
		loading: false,
		request: null,
		// 立即购买
		quickBuy: function(id, number, options) {
			$.loading.start();

			var data = {
				sku_id: id,
				number: number
			};

			// 拼团
			if (options && options.group_sn) {
				data.group_sn = options.group_sn;
			}

			$.post('/cart/quick-buy.html', data, function(result) {
				if (result.code == 0) {
					$.go(result.data);
				} else {
					$.msg(result.message, {
						time: 5000
					});
				}
			}, "json").always(function() {
				$.loading.stop()
			});
		},
		// 添加购物车
		// @param sku_id 商品SKU编号
		// @param number 数量
		// @param options 其他参数 {is_sku-是否为SKU, image_url-图片路径, event-点击事件,
		// shop_id-店铺编号
		// callback-回调函数}
		add: function(id, number, options) {

			var defaults = {
				// 是否为SKU商品
				is_sku: true,
				// 图片路径
				image_url: undefined,
				// 点击事件
				event: undefined,
				// 回调函数
				callback: undefined
			};

			options = $.extend(true, defaults, options);
			var data = {
				sku_id: id,
				number: number
			};

			if (options.shop_id != undefined && options.shop_id != 0) {
				data.shop_id = options.shop_id;
			}
			if (options.is_sku) {
				if(validationInfo(id))//shopping_cart.js中的函数
				{
//					if($("#hidden_uid").val() == undefined || $("#hidden_uid").val() == ""){
//						$("#verify_img").attr("src",'{:captcha_src()}');
//						$('#mask-layer-login').attr("data-tag",options.tag).show();
//						$('#layui-layer').show();
//					}else{
					
						
							//立即购买
						if(options.tag == "buy_now"){
							
								if($("#hidden_uid").val() == undefined || $("#hidden_uid").val() == ""){
									$("#verify_img").attr("src",'{:captcha_src()}');
									$('#mask-layer-login').attr("data-tag",options.tag).show();
									$('#layui-layer').show();
								}else{
										//防止用户恶意操作
										if($(".add-cart").hasClass("js-disabled"))
										{
											return;
										}
										if($(".js-buy-now").hasClass("js-disabled"))
										{
											return;
										}
										$(".js-buy-now").addClass("js-disabled");
										$(".add-cart").addClass("js-disabled");
										
										var sku_id = $("#hidden_skuid").val();
										//没有SKU商品，获取第一个
										if(sku_id==null||sku_id=="")
										{
											sku_id=$("#goods_sku0").attr("skuid");
										}
										$.ajax({
											url : shop_main + "/member/ordercreatesession",
											type : "post",
											data : { "tag" : "buy_now", "sku_id" : sku_id , "num" : $("#num").val() },
											success : function(res){
												if(res > 0){
													location.href= shop_main + "/member/paymentorder";													
												}else{
													$.msg("购买失败");
													$(".js-buy-now").removeClass("js-disabled");
													$(".add-cart").removeClass("js-disabled");
												}
											}
										});
								}
						}else{
							// 加入购物车，飞入购物车动画特效
							$.sidebar.fly(options.image_url, options.event, $(".sidebar-cartbox-trigger"));
							var cart_detail = new Object();
							cart_detail.goods_id = $("#hidden_goodsid").val();
							cart_detail.count = $("#num").val();
							cart_detail.goods_name = $(".js-goods-name").text();
							cart_detail.sku_id = $("#hidden_skuid").val();
							//没有SKU商品，获取第一个
							if(cart_detail.sku_id==null||cart_detail.sku_id=="")
							{
								cart_detail.sku_id=$("#goods_sku0").attr("skuid");
							}
							cart_detail.sku_name = $("#hidden_skuname").val();
							cart_detail.price = $("#hidden_sku_price").val();
							cart_detail.picture_id = $("#hidden_default_img_id").val();
							cart_detail.cost_price = $("#hidden_sku_price").val();//成本价
							$.ajax({
								url : shop_main+"/goods/addcart",
								type : "post",
								data : { "cart_detail" : cart_detail },
								success : function(res){
									//alert(JSON.stringify(res));
									if(res == -1)
									{
										$.msg("添加购物车失败");
										//只有会员登录之后才能购买，请进入会员中心注册或登录。
										//window.location.href = shop_main+ "/login/index";
									}else{
										$(".add-cart").removeClass("js-disabled");
										$(".js-buy-now").removeClass("js-disabled");
										//加入购物车
										refreshShopCart();//里边会加载购物车中的数量
										$.msg("添加购物车成功");
									}
								}
							});
						}
//					}
				}
//				$.post(app_main+'/Goods/addCart', data, function(result) {
//					alert(result);
//					if (result.code == 0) {
//						$.msg(result.message);
//						// 刷新购物车数量
//						$.cartbox.add(number);
//						// 飞入购物车
//						$.sidebar.fly(options.image_url, options.event, $(".sidebar-cartbox-trigger"));
//					} else {
//						$.msg(result.message, {
//							time: 5000
//						});
//					}
//
//					// 回调函数
//					if ($.isFunction(options.callback)) {
//						options.callback.call($.cart, result);
//					}
//				}, "json");
			} else {
				// 添加商品
				$.post('/cart/add', {
					goods_id: id,
					number: number
				}, function(result) {

					if (result.code == 0) {
						$.msg(result.message);
						// 刷新购物车数量
						$.cartbox.add(number);
						// 飞入购物车
						$.sidebar.fly(options.image_url, options.event, $(".sidebar-cartbox-trigger"));
					} else if (result.code == 98) {
						$("body").append(result.data);
					} else {
						$.msg(result.message, {
							time: 5000
						});
					}

					// 回调函数
					if ($.isFunction(options.callback)) {
						options.callback.call($.cart, result);
					}

				}, "json");
			}

		},
		// 从购物车中删除
		remove: function(cart_ids, callback) {

			if (this.request != null && $.isFunction(this.request.abort)) {
				// 终止请求
				this.request.abort();
			}

			this.request = $.post('/cart/remove', {
				cart_ids: cart_ids
			}, function(result) {

				if (result.code == 0) {
					if (result.message != null && result.message.length > 0) {
						$.msg(result.message);
					}
					// 刷新购物车
					$.cartbox.load();
				} else {
					$.msg(result.message, {
						time: 5000
					});
				}

				// 回调函数
				if ($.isFunction(callback)) {
					callback.call($.cart, result);
				}

			}, "json");

			return this.request;
		},
		// 从购物车中删除
		del: function(cart_ids, callback) {

			if (this.request != null && $.isFunction(this.request.abort)) {
				// 终止请求
				this.request.abort();
			}

			this.request = $.post('/cart/delete', {
				cart_ids: cart_ids
			}, function(result) {

				if (result.code == 0) {
					if (result.message.length > 0) {
						$.msg(result.message);
					}
					// 刷新购物车
					$.cartbox.load();
				} else {
					$.msg(result.message, {
						time: 5000
					});
				}

				// 回调函数
				if ($.isFunction(callback)) {
					callback.call($.cart, result);
				}

			}, "json");

			return this.request;
		},
		/**
		 * 根据规格串的数组获取SKU编号
		 * 
		 * @params array spec_ids 规格串的数组
		 * @params array sku_ids 以SKU规格串为Key，包含“sku_id”属性的数组
		 */
		getSkuId: function(spec_ids, sku_ids) {

			var temp_spec_ids = spec_ids.join("|");
			if (sku_ids[temp_spec_ids]) {
				return sku_ids[temp_spec_ids]['sku_id'];
			} else {
				// 求数组的全排序
				var spec_ids_list = $.toPermute(spec_ids);

				for (var i = 0; i < spec_ids_list.length; i++) {
					spec_ids = spec_ids_list[i];

					spec_ids = spec_ids.join("|");

					if (sku_ids[spec_ids]) {
						return sku_ids[spec_ids]['sku_id'];
					}

				}

				return null;
			}
		},
		// 改变购物车中商品数量
		// @param sku_id SKU商品编号
		// @param number 变更后的数量
		// @param callback 变更后的回调函数
		changeNumber: function(sku_id, number, callback) {

			if (this.request != null && $.isFunction(this.request.abort)) {
				// 终止请求
				this.request.abort();
			}

			this.request = $.post('/cart/change-number', {
				sku_id: sku_id,
				number: number
			}, function(result) {

				if (result.code == 0) {

				} else {
					$.msg(result.message, {
						time: 5000
					});
				}

				if ($.isFunction(callback)) {
					callback.call($.cart, result);
				}

			}, "json");

			return this.request;
		},
		// 选择商品
		select: function(cart_ids, callback) {

			if (this.request != null && $.isFunction(this.request.abort)) {
				// 终止请求
				this.request.abort();
			}

			this.request = $.post('/cart/select', {
				cart_ids: cart_ids.join(",")
			}, function(result) {

				if (result.code == 0) {

				} else {
					$.msg(result.message, {
						time: 5000
					});
				}

				if ($.isFunction(callback)) {
					callback.call($.cart, result);
				}

			}, "json");

			return this.request;
		}
	};
	// 在线客服
	$.openim = function(options) {

		var name = 'webcall'; // 网页名称，可为空;
		var iWidth = 700; // 弹出窗口的宽度;
		var iHeight = 580; // 弹出窗口的高度;
		// 获得窗口的垂直位置
		var iTop = (window.screen.availHeight - 30 - iHeight) / 2;
		// 获得窗口的水平位置
		var iLeft = (window.screen.availWidth - 10 - iWidth) / 2;

		var win_object = window.open('', name, 'height=' + iHeight + ',,innerHeight=' + iHeight + ',width=' + iWidth + ',innerWidth=' + iWidth + ',top=' + iTop + ',left=' + iLeft + ',status=no,toolbar=no,menubar=no,location=no,resizable=no,scrollbars=0,titlebar=no');

		win_object.document.write('<html><head><title>正在连接客服，请稍后...</title><meta charset="utf-8" /><meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" /><link type="text/css" rel="stylesheet" href="/css/common.css" /></head><body><div class="loading"><div class="loading-img"><img src="/images/aliim-loading.gif"></div></div></body></html>');

		var defaults = {
			goods_id: null,
			order_id: null,
			shop_id: null
		};

		options = $.extend(defaults, options);

		var goods_id = options.goods_id;
		var order_id = options.order_id;
		var shop_id = options.shop_id;

		$.get('/user/im/check.html', {}, function(result) {

			// 转向网页的地址;
			var url = '/user/im/open.html';
			if (goods_id) {
				url += '?goods_id=' + goods_id;
			} else if (order_id) {
				url += '?order_id=' + order_id;
			} else if (shop_id) {
				url += '?shop_id=' + shop_id;
			}

			win_object.location = url;

		}, "json");
	}

	$.sidebar.comparebox = {
		// 上次访问的时间戳
		lasttime: 0,
		// 当前购物车盒子中商品的数量
		count: 0,
		// 初始化
		init: function() {
			if ($(".sidebar-comparebox").size() == 0) {
				return;
			}
			$(".sidebar-comparebox-trigger").click(function() {
				var time = new Date().getTime();
				if ($.sidebar.comparebox.lasttime == 0 || time - $.sidebar.comparebox.lasttime > 5 * 1000) {
					$.sidebar.comparebox.load();
				}
			});
		},
		// 加载
		load: function() {
			if ($(".sidebar-comparebox").size() == 0) {
				return;
			}
			$.sidebar.comparebox.lasttime = new Date().getTime();
			$.get("/compare/box-goods-list", {}, function(result) {
				if (result.code == 0) {
					$(".sidebar-comparebox").find(".sidebar-comparebox-goods-list").html(result.data);
				}
			}, "json");
		},
		reset: function() {
			$.sidebar.comparebox.lasttime = 0;
		}
	};

	// 对比
	$.compare = {
		// 添加/移除对比商品
		// @param goods_id 商品编号
		// @param image_url 图片路径
		// @param event 点击事件
		// @param callback 回调函数 result.data=0 已经移除 result.data=1已经加入
		toggle: function(goods_id, image_url, event, callback) {
			$.post('/compare/toggle', {
				goods_id: goods_id
			}, function(result) {
				if (result.code == 0) {
					// 重置
					$.sidebar.comparebox.reset();
					if (result.data == 1) {
						// 飞入
						$.sidebar.fly(image_url, event, $(".sidebar-comparebox-trigger"));
					}
				} else {
					$.msg(result.message);
				}
				// 回调函数
				if ($.isFunction(callback)) {
					callback.call($.compare, result);
				}
			}, "json");
		},
		// 添加对比商品
		// @param goods_id 商品编号
		// @param image_url 图片路径
		// @param event 点击事件
		// @param callback 回调函数
		add: function(goods_id, image_url, event, callback) {
			$.post('/compare/add', {
				goods_id: goods_id
			}, function(result) {
				if (result.code == 0) {
					// 重置
					$.sidebar.comparebox.reset();
					// 飞入
					$.sidebar.fly(image_url, event, $(".sidebar-comparebox-trigger"));

				} else {
					$.msg(result.message);
				}
				// 回调函数
				if ($.isFunction(callback)) {
					callback.call($.compare, result);
				}
			}, "json");
		},
		// 移除对比商品
		remove: function(goods_id, callback) {
			$.post('/compare/remove', {
				goods_id: goods_id
			}, function(result) {
				if (result.code == 0) {
					// 重置
					$.sidebar.comparebox.load();
				} else {
					$.msg(result.message, {
						time: 5000
					});
				}
				// 回调函数
				if ($.isFunction(callback)) {
					callback.call($.compare, result);
				}

				// 回调函数
				if ($.isFunction($.compare.removeCallback)) {
					$.compare.removeCallback.call($.compare, goods_id, result);
				}
			}, "json");
		},
		// 清空对比商品
		clear: function() {
			$.post('/compare/clear', {}, function(result) {
				if (result.code == 0) {
					// 重置
					$.sidebar.comparebox.load();
				} else {
					$.msg(result.message, {
						time: 5000
					});
				}

				if ($.isFunction($.compare.clearCallback)) {
					$.compare.clearCallback.call($.compare, result);
				}
			}, "json");
		},
		// 获取对比商品
		getGoodsList: function(goods_ids, callback) {

			var data = {
				goods_ids: goods_ids
			};

			$.get('/compare/goods-list.html', data, function(result) {

				if ($.isFunction(callback)) {
					callback.call(this, result);
				}
			}, "json");
		},

		// 清空的回调函数
		clearCallback: null,
		// 移除回调函数
		// @param goods_id
		// @param result
		removeCallback: null
	};

	// 收藏接口
	$.collect = {
		// 收藏、取消收藏商品
		// @params goods_id
		// @params goods_id
		// @params sku_id
		// @params callback
		// @params show_count true-返回收藏数量 false-不返回收藏数量
		toggleGoods: function(goods_id, sku_id, callback, show_count) {
			if (!sku_id) {
				sku_id = 0;
			}

			var data = {
				goods_id: goods_id,
				sku_id: sku_id
			};

			if (show_count) {
				data.show_count = 1;
			}

			$.post('/user/collect/toggle.html', data, function(result) {

				if (result.code == 0) {

					if (result.data == 1) {
						// 收藏成功
					} else {
						// 取消收藏
					}

					$.msg(result.message);
				} else {
					$.msg(result.message, {
						time: 5000
					});
				}

				if ($.isFunction(callback)) {
					callback.call(this, result);
				}

			}, "json");
		},
		// 收藏、取消收藏店铺
		toggleShop: function(shop_id, callback, show_count) {

			var data = {
				shop_id: shop_id
			};

			if (show_count) {
				data.show_count = 1;
			}

			$.post('/user/collect/toggle.html', data, function(result) {

				if (result.code == 0) {

					if (result.bonus_info && result.bonus_info.html) {
						$("body").append(result.bonus_info.html);
					} else {
						$.msg(result.message);
					}

				} else {
					$.msg(result.message, {
						time: 5000
					});
				}

				if ($.isFunction(callback)) {
					callback.call(this, result);
				}

			}, "json");
		},

		// 添加收藏
		addGoods: function(goods_id, sku_id, callback) {
			if (!sku_id) {
				sku_id = 0;
			}
			$.post('/user/collect/add.html', {
				goods_id: goods_id,
				sku_id: sku_id
			}, function(result) {

				$.msg(result.message);

				if ($.isFunction(callback)) {
					callback.call(this, result);
				}

			}, "json");
		},
		// 添加收藏
		addShop: function(shop_id, callback) {
			$.post('/user/collect/add.html', {
				shop_id: shop_id
			}, function(result) {

				if (result.bonus_info && result.bonus_info.html) {
					$("body").append(result.bonus_info.html);
				} else {
					$.msg(result.message);
				}

				if ($.isFunction(callback)) {
					callback.call(this, result);
				}

			}, "json");
		},
		removeGoods: function(goods_id, sku_id, callback) {
			$.post('/user/collect/remove.html', {
				goods_id: goods_id,
				sku_id: sku_id
			}, function(result) {
				$.msg(result.message);

				if ($.isFunction(callback)) {
					callback.call(this, result);
				}

			}, "json");
		},
		removeShop: function(shop_id, callback) {
			$.post('/user/collect/remove.html', {
				shop_id: shop_id
			}, function(result) {
				$.msg(result.message);

				if ($.isFunction(callback)) {
					callback.call(this, result);
				}

			}, "json");
		},
		getGoodsList: function(goods_ids, sku_ids, callback) {

			if (!sku_ids) {
				sku_ids = 0;
			}

			var data = {
				goods_ids: goods_ids,
				sku_ids: sku_ids
			};

			$.get('/user/collect/goods-list.html', data, function(result) {

				if ($.isFunction(callback)) {
					callback.call(this, result);
				}
			}, "json");
		}
	};

	// 红包
	$.bonus = {
		/**
		 * 领取红包
		 */
		receive: function(bonus_id, callback) {
			return $.post("/user/bonus/receive.html", {
				bonus_id: bonus_id
			}, function(result) {
				if ($.isFunction(callback)) {
					callback.call(this, result);
				}
			}, "JSON");
		}
	};

	if (!$("body").data("cart-js-init")) {
		// 顶部栏初始化
		$.topbar.init();
		// 初始化侧边栏
		$.sidebar.init();
		// 初始化购物车盒子
		$.cartbox.init();
		// 初始化
		$.sidebar.comparebox.init();
		// 标记
		$("body").data("cart-js-init", true);
	}

})(jQuery);