/**
 * Created by 554665488 on 2018-5-27.
 */

//查询
function searchData() {
    LoadingInfo(1);
}

/**
 * 隐藏商品分组
 */
function hideEditGroup() {
    $("#editGroup").popover("hide");
}

function hideSetRecommend() {
    $("#setRecommend").popover("hide");
}

//查询用户列表
function LoadingInfo(page_index) {
    var start_date = $("#startDate").val();
    var end_date = $("#endDate").val();
    var state = $("#state").val();
    var goods_name = $("#goods_name").val();
    var category_id_1 = $("#category_id_1").val();
    var category_id_2 = $("#category_id_2").val();
    var category_id_3 = $("#category_id_3").val();
    $.ajax({
        type: "post",
        url: "/admin/goodslist",
        data: {
            "page_index": page_index,
            "page_size": $("#showNumber").val(),
            "start_date": start_date,
            "end_date": end_date,
            "state": state,
            "goods_name": goods_name,
            "category_id_1": category_id_1,
            "category_id_2": category_id_2,
            "category_id_3": category_id_3
        },
        success: function (data) {
            //alert(JSON.stringify(data));
            var html = '';
            if (data["data"].length > 0) {
                for (var i = 0; i < data["data"].length; i++) {
                    html += '<tr class="tr-title" style=" width: 1502px;"><td class="td-' + data["data"][i]["goods_id"] + '"><label><input value="'
                        + data["data"][i]["goods_id"]
                        + '" tj="" name="sub" data-state="' + data["data"][i]["state"] + '" type="checkbox"></label></td>';
                    html += '<td colspan="7" style="width: 97%;"><div style="display: inline-block; width: 100%;" class="pro-code"><span>商家编码' + '：'
                        + data["data"][i]["code"] + '</span>';
                    /* if(data["data"][i]["state"] == 1){
                     html += '<span class="pro-code" style="color: #f35252; float: right;"> <i class="fa fa-long-arrow-up" style="margin-right: 4px;"></i>已上架';
                     }else{
                     html += '<span class="pro-code" style="color: #27A9E3; float: right;"> <i class="fa fa-long-arrow-up" style="margin-right: 4px;"></i>已下架';
                     } */
                    html += '<span class="pro-code" style="margin-left:10px;">创建时间：' + data["data"][i]["create_time"];

                    html += '<span  class="div-flag-style" style="display: inline-block;margin:0 20px 0 40px;position:relative"> <i class="icon-qrcode"style="background: none; color: #555; font-size: 20px; margin-right: 0;"></i>';
                    html += '<div class="QRcode" style="display: none; position: absolute;width:110px;top:28px;left:15px"id="qrcode"><p><img src="../../static/picture/4c8cd98331444ab991bcbef3735b7e2d.gif' + data["data"][i]["QRcode"] + '" style="width:110px;"></p></div></span>';
                    html += '</span></div></td></tr>';
                    html += '<tr><td colspan="2" style="background: white;"><div><a class="a-pro-view-img" href="http://tp.23673.com/goods/goodsinfo?goodsid=' + data["data"][i]["goods_id"] + '" target="_blank"><img class="thumbnail-img"src="../../static/picture/4c8cd98331444ab991bcbef3735b7e2d.gif' + data["data"][i]["pic_cover_micro"] + '">';
                    html += '<div class="div-pro-view-name"><span style="color: #13A5D5;" class="thumbnail-name title=' + data["data"][i]["goods_name"] + '"><a target="_blank" style="word-break:break-all;" href="http://tp.23673.com/goods/goodsinfo?goodsid=' + data["data"][i]["goods_id"] + '">'
                        + data["data"][i]["goods_name"]
                        + '</a></span><br/>';
                    //html += '<div class="div-flag-style"><span class="" title=""><i class="icon-tablet"style="background: none; color: #555; font-size: 20px; margin-right: 0;"></i></span><span onmouseover="mouseover(this)" onmouseout="mouseout(this)"style="display: inline-block;"> <i class="icon-qrcode"style="background: none; color: #555; font-size: 20px; margin-right: 0;"></i></span>';
                    //html += '<div class="QRcode" style="display: none; position: absolute;"id="qrcode"><p><img src=""></p></div></div>';
                    // html += '<div class="introduction_box">'+data["data"][i]["introduction"]+'</div><br>';
                    // html += '<span class="recommendBox">';
                    // html += data["data"][i]["is_hot"] == 1 ? '<i class="hot">热</i>' : '';
                    // html += data["data"][i]["is_recommend"] == 1 ? '<i class="recommend">荐</i>' : '';
                    // html += data["data"][i]["is_new"] == 1 ? '<i class="new">新</i>' : '';
                    // html += '</span></div>';
                    //	html += '<div style="margin-top:10px;">';
                    //	html += data["data"][i]["is_hot"] == 1 ? '<i class="hot">热</i>' : '';
                    //	html += data["data"][i]["is_recommend"] == 1 ? '<i class="recommend">荐</i>' : '';
                    //	html += data["data"][i]["is_new"] == 1 ? '<i class="new">新</i>' : '';
                    //	html += '<span  class="div-flag-style" style="display: inline-block;"> <i class="icon-qrcode"style="background: none; color: #555; font-size: 20px; margin-right: 0;"></i></span>';
                    //	html += '<div class="QRcode" style="display: none; position: absolute;"id="qrcode"><p><img src="../../static/picture/4c8cd98331444ab991bcbef3735b7e2d.gif'+ data["data"][i]["QRcode"]+'" style="width:110px;"></p></div>';
                    //    html += '</div>';
                    html += '</div></td>';
                    html += '<td style="background: white;"><div class="priceaddactive"><span class="price-lable">原&nbsp;&nbsp;&nbsp;价：</span><span class="price-numble" style="color: #666;"id="moreChangePrice' + data["data"][i]["goods_id"] + '"  >'
                        + data["data"][i]["price"]
                        + '</span></div>';
                    html += '<div><span class="price-lable" >销售价：</span><span class="price-numble"id="moreChangePrice' + data["data"][i]["goods_id"] + '" style="color:red;">'
                        + data["data"][i]["promotion_price"]
                        + '</span>';
                    html += '</td>';
                    html += '<td style="background: white;"><div class="cell"><span class="pro-stock" style="color: #666;"id="moreChangeStock' + data["data"][i]["goods_id"] + '">'
                        + data["data"][i]["stock"]
                        + '</span></div></td>';
                    html += '<td style="background: white;"><div class="cell"><span class="pro-stock" style="color: #666;"id="moreChangeStock' + data["data"][i]["goods_id"] + '">'
                        + data["data"][i]["real_sales"]
                        + '</span></div></td>';
                    if (data["data"][i]["state"] == 1) {
                        html += '<td style="background: white;"><a href="javascript:void(0)" onclick="modifyGoodsOnline(' + data["data"][i]["goods_id"] + ',\'offline\')">已上架</a></td>';
                    } else {
                        html += '<td style="background: white;"><a href="javascript:void(0)" onclick="modifyGoodsOnline(' + data["data"][i]["goods_id"] + ',\'online\')" style="color:#999;">已下架</a></td>';
                    }
                    html += '<td style="background: white;"><div class="cell"><input class="input-mini" goods_id="'
                        + data["data"][i]["goods_id"]
                        + '" style="width:30px;text-align:center;" value="'
                        + data["data"][i]["sort"]
                        + '" onchange="changeSort(this)"'
                        + 'type="number"></div></td>';
                    html += '<td style="background: white;"><div ><div class="bs-docs-example tooltip-demo"style="text-align: center;">';
                    html += '<a href="javascript:;" data-placement="bottom" data-original-title="编辑"><span class="edit" style="display: inline-block; width: 19%;" onclick="updateGoodsDetail('
                        + data["data"][i]["goods_id"]
                        + ')"><i class="icon-edit" style="width: initial;"></i>编辑</span></a>';
                    html += '<a href="javascript:;" data-placement="bottom" data-original-title="复制"><span class="edit" style="display: inline-block; width: 19%;" onclick="copyGoodsDetail('
                        + data["data"][i]["goods_id"]
                        + ')"><i class="icon-edit" style="width: initial;"></i>复制</span></a>';
                    // html += '<a href="javascript:;" data-placement="bottom" ><span class="edit" style="display: inline-block; " onclick="updateGoodsQrcode('
                    // 		+ data["data"][i]["goods_id"]
                    // 		+ ')"><i class="icon-edit" style="width: initial;"></i>更新二维码</span></a>';
                    html += '<a href="javascript:void(0)" data-placement="bottom"onclick="deleteGoods('
                        + data["data"][i]["goods_id"]
                        + ')" data-original-title="删除"><span class="del" style="display: inline-block; width: 19%;"><i class="icon-trash" style="width: initial;"></i>删除</span></a></div></div></td></tr>';
                }
            } else {
                html += '<tr align="center"><th colspan="8" style="text-align: center;font-weight: normal;color: #999;">暂无符合条件的数据记录</th></tr>';
            }
            $("#productTbody").html(html);
            initPageData(data["page_count"], data['data'].length, data['total_count']);
            $("#pageNumber").html(pagenumShow(jumpNumber, $("#page_count").val(), 5));
            code();
        }
    });
}
//二维码.
function code() {
    $(".div-flag-style").mouseover(function () {
        $(this).children('.QRcode').show();
    });
    $(".div-flag-style").mouseout(function () {
        $(this).children('.QRcode').hide();
    });
}


//把值传过去即可
function updateGoodsDetail(goods_id) {
    window.location = "http://tp.23673.com/admin/goods/addgoods?step=2&goodsId=" + goods_id;
}



//商品上架id合计
function goodsIdCount(line) {
    var goods_ids = "";
    $("#productTbody input[type='checkbox']:checked").each(function () {
        if (!isNaN($(this).val())) {
            var state = $(this).data("state");
//				if(line == "online"){
//					if(state == 1){
//						$( "#dialog" ).dialog({
//							buttons: {
//								"确定": function() {
//									$(this).dialog('close');
//								}
//							},
//							contentText:"记录中包含已上架记录",
//							title:"消息提醒",
//						});
//						return false;
//					}
//				}else{
//					if(state == 0){
//						$( "#dialog" ).dialog({
//							buttons: {
//								"确定": function() {
//									$(this).dialog('close');
//								}
//							},
//							contentText:"记录中包含已下架记录",
//							title:"消息提醒",
//						});
//					return false;
//					}
//				}
            goods_ids = $(this).val() + "," + goods_ids;
        }
    });
    goods_ids = goods_ids.substring(0, goods_ids.length - 1);
    if (goods_ids == "") {
        $("#dialog").dialog({
            buttons: {
                "确定": function () {
                    $(this).dialog('close');
                }
            },
            contentText: "请选择需要操作的记录",
            title: "消息提醒",
        });
        return false;
    }
    modifyGoodsOnline(goods_ids, line);
}




function batchDelete() {
    var goods_ids = new Array();
    $("#productTbody input[type='checkbox']:checked").each(function () {
        if (!isNaN($(this).val())) {
            goods_ids.push($(this).val());
        }
    });
    if (goods_ids.length == 0) {
        $("#dialog").dialog({
            buttons: {
                "确定,#e57373": function () {
                    $(this).dialog('close');
                }
            },
            contentText: "请选择需要操作的记录",
            title: "消息提醒",
        });
        return false;
    }
    deleteGoods(goods_ids);
}
function deleteGoods(goods_ids) {
    $("#dialog").dialog({
        buttons: {
            "确定": function () {
                $.ajax({
                    type: "post",
                    url: "http://tp.23673.com/admin/goods/deletegoods",
                    data: {
                        "goods_ids": goods_ids.toString()
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data["code"] > 0) {
                            LoadingInfo(getCurrentIndex(goods_ids, '#productTbody', 'tr[class="tr-title"]'));

                            $("#dialog").dialog({
                                buttons: {
                                    "确定": function () {
                                        $(this).dialog('close');
                                    }
                                },
                                modal: true,
                                contentText: data["message"],
                                title: "消息提醒",
                                time: 1
                            });
                            $("#chek_all").prop("checked", false);
                        }
                    }
                });
                $(this).dialog('close');
            },
            "取消,#e57373": function () {
                $(this).dialog('close');
            },
        },
        contentText: "确定要删除吗？",
    });
}

//商品修改分组id合计
function goodsGroupIdCount() {
    var goods_ids = "";
    $("#productTbody input[type='checkbox']:checked").each(function () {
        if (!isNaN($(this).val())) {
            goods_ids = $(this).val() + "," + goods_ids;
        }
    });
    goods_ids = goods_ids.substring(0, goods_ids.length - 1);
    if (goods_ids == "") {
        $("#dialog").dialog({
            buttons: {
                "确定": function () {
                    $(this).dialog('close');
                }
            },
            contentText: "请选择需要操作的记录",
            title: "消息提醒",
        });
        return false;
    }
    $("#goods_type_ids").val(goods_ids);
    $("#editGroup").popover("show");
    $(".popover").css("max-width", '1000px');
}

//商品修改分组
function goodsGroupUpdate() {
    var goods_type = "";
    var goods_ids = $("#goods_type_ids").val();
    $("#goodsChecked input[type='checkbox']:checked").each(function () {
        if (!isNaN($(this).val())) {
            goods_type = $(this).val() + "," + goods_type;
        }
    })
    if (goods_type == "") {
        $("#dialog").dialog({
            buttons: {
                "确定": function () {
                    $(this).dialog('close');
                }
            },
            contentText: "请选择需要操作的记录",
            title: "消息提醒",
        });
        return false;
    }
    goods_type = goods_type.substring(0, goods_type.length - 1);
    $.ajax({
        type: "post",
        url: "http://tp.23673.com/admin/goods/modifygoodsgroup",
        data: {
            "goods_id": goods_ids,
            "goods_type": goods_type
        },
        success: function (data) {
            if (data["code"] > 0) {
                $("#editGroup").popover("hide");
                LoadingInfo(getCurrentIndex(goods_ids, '#productTbody', 'tr[class="tr-title"]'));
                $("#dialog").dialog({
                    buttons: {
                        "确定": function () {
                            $(this).dialog('close');
                        }
                    },
                    contentText: data["message"],
                    title: "消息提醒",
                });
            }
        }
    })
}

//显示 推荐选项
function ShowRecommend() {
    var goods_ids = "";
    $("#productTbody input[type='checkbox']:checked").each(function () {
        if (!isNaN($(this).val())) {
            goods_ids = $(this).val() + "," + goods_ids;
        }
    });
    goods_ids = goods_ids.substring(0, goods_ids.length - 1);
    if (goods_ids == "") {
        $("#dialog").dialog({
            buttons: {
                "确定": function () {
                    $(this).dialog('close');
                }
            },
            contentText: "请选择需要操作的记录",
            title: "消息提醒",
        });
        return false;
    }
    $("#goods_type_ids").val(goods_ids);
    $("#setRecommend").popover("show");
}

//修改为  推荐 商品
function setRecommend() {
    var recommend_type = '';
    var goods_ids = $("#goods_type_ids").val();
    $("#recommendType input[type='checkbox']").each(function () {
        if ($(this).attr("checked") == 'checked') {
            var recommend_type_new = 1;
        } else {
            var recommend_type_new = 0;
        }
        recommend_type = recommend_type_new + "," + recommend_type;
    })
    if (recommend_type == "") {
        $("#dialog").dialog({
            buttons: {
                "确定": function () {
                    $(this).dialog('close');
                }
            },
            contentText: "请选择需要操作的记录",
            title: "消息提醒",
        });
        return false;
    }
    recommend_type = recommend_type.substring(0, recommend_type.length - 1);
    $.ajax({
        type: "post",
        url: "http://tp.23673.com/admin/goods/modifygoodsrecommend",
        data: {
            "goods_id": goods_ids,
            "recommend_type": recommend_type
        },
        success: function (data) {
            if (data["code"] > 0) {
                $("#setRecommend").popover("hide");
                LoadingInfo(getCurrentIndex(goods_ids, '#productTbody', 'tr[class="tr-title"]'));
                $("#dialog").dialog({
                    buttons: {
                        "确定": function () {
                            $(this).dialog('close');
                        }
                    },
                    contentText: data["message"],
                    title: "消息提醒",
                });
            }
        }
    })
}
$("#goodsCategoryOne").click(function () {
    var isShow = $("#goodsCategoryOne").attr('is_show');
    if (isShow == "false") {
        $(".one").show();
        $(".selectGoodsCategory").css("width", '216px');
        $(".selectGoodsCategory").show();
        $("#goodsCategoryOne").attr('is_show', 'true');
        $(".js-mask-category").show();
    } else {
        $(".one").hide();
        $(".two").hide();
        $(".three").hide();
        $(".selectGoodsCategory").css("width", '216px');
        $(".selectGoodsCategory").hide();
        $("#goodsCategoryOne").attr('is_show', 'false');
    }
})

$(".js-mask-category").click(function () {
    $(".one").hide();
    $(".selectGoodsCategory").hide();
    $(".two").hide();
    $(".three").hide();
    $("#goodsCategoryOne").attr('is_show', 'false');
    $(this).hide();
})
$(".js-category-one").click(function () {
    parentId = $(this).attr("category_id");
    category_name = $(this).text();
    $(".one ul li").not($(this)).removeClass("selected");
    $(this).addClass("selected");
    $("#goodsCategoryOne").val($.trim(category_name) + ">");
    $("#category_id_1").val(parentId);
    $("#category_id_2").val('');
    $("#category_id_3").val('');
    $.ajax({
        type: 'post',
        url: "http://tp.23673.com/admin/goods/getcategorybyparentajax",
        data: {"parentId": parentId},
        success: function (data) {
            if (data.length > 0) {
                var html = '';
                for (var i = 0; i < data.length; i++) {
                    html += '<li class="js-category-two" category_id="' + data[i]['category_id'] + '">' + data[i]['category_name'];
                    if (data[i]['is_parent'] == 1) {
                        html += '<i class="fa fa-angle-right fa-lg"></i>';
                    }
                    html += '</li>';
                }
                $("#goodsCategoryTwo").html(html);
                $(".two").show();
                $(".selectGoodsCategory").css("width", '433px');
            } else {
                $(".one").hide();
                $(".two").hide();
                $(".js-mask-category").hide();
                $(".selectGoodsCategory").hide();
                $("#goodsCategoryOne").attr('is_show', 'false');
            }
            $(".three").hide();
        }
    });
    return false;
});
$(".js-category-two").on("click", function (event) {
    var parentId = $(this).attr("category_id");
    var category_name = $(this).text();
    $(".two ul li").not($(this)).removeClass("selected");
    $(this).addClass("selected");
    var goodsCategoryOne = $("#goodsCategoryOne").val();
    $("#goodsCategoryOne").val(goodsCategoryOne + '' + category_name + '>');
    $("#category_id_2").val(parentId);
    $("#category_id_3").val('');
    $.ajax({
        type: 'post',
        url: "http://tp.23673.com/admin/goods/getcategorybyparentajax",
        data: {"parentId": parentId},
        success: function (data) {
            if (data.length > 0) {
                html = ''
                for (var i = 0; i < data.length; i++) {
                    html += '<li onclick="goodsCategoryThree(this);" category_id="' + data[i]['category_id'] + '">' + data[i]['category_name'] + '<i class="fa fa-angle-right fa-lg"></i></li>';
                }
                $("#goodsCategoryThree").html(html);
                $(".three").show();
                $(".selectGoodsCategory").css("width", '632px');
            } else {
                $(".one").hide();
                $(".two").hide();
                $(".three").hide();
                $(".selectGoodsCategory").hide();
                $(".js-mask-category").hide();
                $("#goodsCategoryOne").attr('is_show', 'false');
            }
        }
    })
    event.stopPropagation();
});
function goodsCategoryThree(obj) {
    var parentId = $(obj).attr("category_id");
    var category_name = $(obj).text();
    $(".three ul li").not($(obj)).removeClass("selected");
    $(obj).addClass("selected");
    var goodsCategoryOne = $("#goodsCategoryOne").val();
    $("#goodsCategoryOne").val(goodsCategoryOne + '' + category_name);
    $("#category_id_3").val(parentId);
    $(".one").hide();
    $(".two").hide();
    $(".three").hide();
    $(".selectGoodsCategory").hide();
    $(".js-mask-category").hide();
    $(".selectGoodsCategory").css("width", '216px');
    $("#goodsCategoryOne").attr('is_show', 'false');
}
$("#confirmSelect").click(function () {
    $(".one").hide();
    $(".two").hide();
    $(".three").hide();
    $(".selectGoodsCategory").hide();
    $(".selectGoodsCategory").css("width", '216px');
})

function copyGoodsDetail(goods_id) {
    $("#dialog").dialog({
        buttons: {
            "确定": function () {
                $.ajax({
                    type: "post",
                    url: "http://tp.23673.com/admin/goods/copygoods",
                    data: {"goods_id": goods_id},
                    dataType: "json",
                    success: function (data) {
                        if (data["code"] > 0) {
                            LoadingInfo(getCurrentIndex(goods_id, '#productTbody', 'tr[class="tr-title"]'));

                            $("#dialog").dialog({
                                buttons: {
                                    "确定": function () {
                                        $(this).dialog('close');
                                    }
                                },
                                modal: true,
                                contentText: data["message"],
                                title: "消息提醒",
                                time: 1
                            });
                            $("#chek_all").prop("checked", false);
                        }
                    }
                });
                $(this).dialog('close');
            },
            "取消,#e57373": function () {
                $(this).dialog('close');
            },
        },
        contentText: "确定要复制一条新的商品信息吗？",
    });
}

function changeSort(event) {
    var sort = parseInt($(event).val());
    $(event).val(sort);
    var goods_id = $(event).attr("goods_id");
    $.ajax({
        type: "post",
        url: "http://tp.23673.com/admin/goods/updateGoodsSortAjax",
        data: {
            "sort": sort,
            "goods_id": goods_id
        },
        success: function (data) {
            if (data.code > 0) {
                showTip(data.message, "success");
            } else {
                showTip(data.message, "error");
            }
        }
    })
}

/**
 更新二维码
 */
function batchUpdateGoodsQrcode() {
    var goods_ids = new Array();
    $("#productTbody input[type='checkbox']:checked").each(function () {
        if (!isNaN($(this).val())) {
            goods_ids.push($(this).val());
        }
    });
    if (goods_ids.length == 0) {
        showMessage("error", "请至少选择一件商品");
        return false;
    }
    $.ajax({
        type: "post",
        url: "http://tp.23673.com/admin/goods/updateGoodsQrcode",
        data: {
            "goods_id": goods_ids,
        },
        success: function (data) {
            if (data["code"] > 0) {
                showMessage('success', '二维码更新成功');
                LoadingInfo(1);
            } else {
                showMessage('error', data['message']);
            }
        }
    })
}
