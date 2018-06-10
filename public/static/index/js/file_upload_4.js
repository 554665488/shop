
/**
 * 上传文件
 * 2017年6月9日 11:53:25 Pack老师
 * @param fileid 当前input file类型
 * @param data 传输的数据 file_path属性必传
 */
function uploadFile(fileid,data,callBack){
	var dom = document.getElementById(fileid);
	var file =  dom.files[0];//File对象;
	if(validationFile(file)){
		$.ajaxFileUpload({
			url : ADMINMAIN + '/upload/uploadfile', //用于文件上传的服务器端请求地址
			secureuri : false, //一般设置为false
			fileElementId : fileid, //文件上传空间的id属性  <input type="file" id="file" name="file" />
			dataType : 'json', //返回值类型 一般设置为json
			data : data,
			async : false,
			contentType : "text/json;charset=utf-8",
			success : function(res){ //服务器成功响应处理函数
				callBack.call(this,res);
			}
		});
	}
}

/**
 * 验证文件是否可以上传
 * 2017年6月9日 19:39:19 Pack老师
 * @param file JS DOM文件对象
 */
function validationFile(file) {
	var fileTypeArr = ['video/mp4','application/msword','application/x-msdownload'];
	if(null == file){
		return false;
	}
	if(!file.type){
		showTip("文件类型不合法","warning");
		return false;
	}
	var flag = false;
	for(var i=0;i<fileTypeArr.length;i++){
		if(file.type == fileTypeArr[i]){
			flag = true;
			break;
		}
	}
	
	if(flag){
		showTip("文件类型不合法","warning");
		return false;
	}
	
	if(file.size > 5000000){
		showTip("文件大小不能超过5MB","warning");
		return false;
	}
		
	return true;
}

/**
 * 删除文件，支付批量删除，逗号隔开
 * 
 * 2017年6月9日 21:25:18 Pack老师
 * @param filename
 */
function removeFile(filename){
	$.ajax({
		url : ADMINMAIN + "/upload/removefile",
		type : "post",
		data : { "filename" : filename },
		success : function(res){
			showTip("本次操作共删除"+res.success_count+"个文件,"+res.error_count+"个文件失败","success");
		}
	})
}