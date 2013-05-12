<!DOCTYPE html>
<html>
<head>
<title>上传文件</title>
<link href="swfup/css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="swfup/Uploadjs/handlers.js"></script>
<script type="text/javascript" src="swfup/Uploadjs/swfupload.js"></script>
<script type="text/javascript" src="swfup/Uploadjs/fileprogress.js"></script>
<script type="text/javascript">
		var swfu;

		window.onload = function () {
			swfu = new SWFUpload({
				// Backend settings (后端 设置)
				upload_url: "swfupload.php",
				file_post_name: "attachement_file",

				// Flash file settings (Flash 文件 设置)
				file_size_limit : "20480",  // 文件 大小 限制
				file_types : "*.*",			// or you could use something like: "*.doc;*.wpd;*.pdf",(或者你可以使用类似："*.doc;*.wpd;*.pdf")
				file_types_description : "All Files",// 文件 类型 描述
				file_upload_limit : 0, // 文件 上传 限制
				file_queue_limit : 1,  // 文件 队列 限制

				// Event handler settings (事件 处理程序 设置)
				swfupload_loaded_handler : swfUploadLoaded,			// 指定 swfupload 页面加载 处理程序			
				
				file_dialog_start_handler: fileDialogStart,			// 文件 对话框 启动 处理程序
				file_queued_handler : fileQueued,					// 文件队列处理程序
				file_queue_error_handler : fileQueueError,			// 文件队列错误处理程序
				file_dialog_complete_handler : fileDialogComplete,	// 完整的处理文件对话框
				
				// upload_start_handler : uploadStart,	
				// I could do some client/JavaScript validation here, but I don't need to.
				// (可以做一些我的客户机/ JavaScript的验证，但我不需要。)
				swfupload_preload_handler : preLoad,		// swfupload预处理器 (*)
				swfupload_load_failed_handler : loadFailed, // swfupload加载失败处理
				upload_progress_handler : uploadProgress,   // 上传进度处理程序 (*)
				upload_error_handler : uploadError,			// 上传错误处理程序 (* --txtFileName)
				upload_success_handler : uploadSuccess,		// 上传成功的处理程序 (* --hidFileID)
				upload_complete_handler : uploadComplete,	// 上传完成处理程序 (*)

				// Button Settings (按钮 设置)
				button_image_url : "swfup/Uploadjs/XPButtonUploadText_61x22.png",
				button_placeholder_id : "spanButtonPlaceholder",
				button_width: 61,
				button_height: 22,
				
//				swfupload_element_id : "flashUI",		// setting for the graceful degradation plugin
//				degraded_element_id : "degradedUI",
				
				// Flash Settings (Flash 设置)
				flash_url : "swfup/Uploadjs/swfupload.swf",
				flash9_url : "swfup/Uploadjs/swfupload_fp9.swf",

				custom_settings : { //自定义 设置
					progress_target : "fsUploadProgress",	// progress target:发展目标
					upload_successful : false           	//上传成功
				},
				
				// Debug settings (调试 设置)
				debug: false
			});

		};
	</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<body>    
<!--<form id="form1" action="index.php" enctype="multipart/form-data" method="post">-->
<form id="form1" action="index.php" enctype="multipart/form-data" method="post">
<?php
	$ret_action = $_REQUEST['return_action'];
	$ret_module = $_REQUEST['return_module']; 
	$ret_id = $_REQUEST['return_id'];
	//phpinfo();
?>
    <INPUT TYPE="hidden" NAME="return_module" VALUE="<?php echo $ret_module ?>">
    <INPUT TYPE="hidden" NAME="return_action" VALUE="<?php echo $ret_action ?>">
    <INPUT TYPE="hidden" NAME="return_id" VALUE="<?php echo $ret_id ?>">
	<input type="hidden" name="module" value="uploads"/>
	<input type="hidden" name="action" value="add2db_swfbigfile"/>
	<input type="hidden" name="filename"  id="filename" value="">
		<div class="content">
			<fieldset >
				<legend>上传您的文件</legend>
				<table style="vertical-align:top;">
					
					<tr>
						<td>
							文件:
						</td>
						<td>
							<div id="flashUI" style="display:;">
                                <div>
                                    <input type="text" id="txtFileName" disabled="true" style="border: solid 1px; background-color: #FFFFFF; vertical-align:top;"/>
                                    <span id="spanButtonPlaceholder"></span>
                                    (最大20MB)
                                </div>
                                <div class="flash" id="fsUploadProgress">
                                    <!-- 
                                        这是该文件的进展得到显示。 SWFUpload不直接更新UI。
                                            在handlers.js处理程序()事件过程中，上载，使用户界面更新
                                        This is where the file progress gets shown.  SWFUpload doesn't update the UI directly.
                                            The Handlers (in handlers.js) process the upload events and make the UI updates -->
                                </div>
                                <input type="hidden" name="hidFileID" id="hidFileID" value="" />
                                <!-- 
                                这是该文件的ID存储在SWFUpload上传文件并获取返回的ID从上传的
                                This is where the file ID is stored after SWFUpload uploads the file and gets the ID back from upload.php
                                 -->
							</div>
                            <div id="degradedUI">
								<!-- This is the standard UI.  This UI is shown by default but when SWFUpload loads it will be
								hidden and the "flashUI" will be shown -->
								<!--<input type="file" name="filename_degraded" id="filename_degraded" /> (最大 20 MB)<br/>-->
							</div>
						</td>
					</tr>
					<tr>
						<td>
							描述:
						</td>
						<td>
							<textarea name="txtDescription"  id="txtDescription" cols="0" rows="0" style="width: 400px; height: 100px;"></textarea>
						</td>
					</tr>
				</table>
				<br />
				<input type="submit" value="开始上传" id="btnSubmit" />
			</fieldset>
		</div>
	</form>
</div>
</body>
</html>
