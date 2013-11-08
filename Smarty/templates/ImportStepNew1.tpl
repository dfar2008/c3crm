{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
-->*}

<link href="swfupload/css/default2.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="swfupload/js/swfupload.js"></script>
<script type="text/javascript" src="swfupload/js/swfupload.queue.js"></script>
<script type="text/javascript" src="swfupload/js/fileprogress.js"></script>
<script type="text/javascript" src="swfupload/js/handlers.js"></script>
<script type="text/javascript">

{literal}
var swfu;

window.onload = function() {
	swfu = new SWFUpload({
		// Backend Settings
		upload_url: "modules/Import/upload.php",	// Relative to the SWF file (or you can use absolute paths)
		post_params: {"PHPSESSID" : ""},

		
		// File Upload Settings
		file_size_limit : "2048",	// 2MB
		file_types : "*.csv",
		file_types_description : "All Files",
		file_upload_limit : 2,
		file_queue_limit : 0,

		// Event Handler Settings (all my handlers are in the Handler.js file)
		file_dialog_start_handler : fileDialogStart,
		file_queued_handler : fileQueued,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,

		// Button Settings
		button_image_url : "swfupload/images/XPButtonUploadText_61x21.png",
		button_placeholder_id : "spanButtonPlaceholder1",
		button_width: 61,
		button_height: 22,
		
		// Flash Settings
		flash_url : "swfupload/swf/swfupload.swf",
		

		custom_settings : {
			progressTarget : "fsUploadProgress1",
			cancelButtonId : "btnCancel1"
		},
		
		// Debug Settings
		debug: false
	});

	

}

 {/literal}
</script>


<!-- header - level 2 tabs -->
<link rel="stylesheet" type="text/css" href="themes/bootcss/css/Setting.css">
<div class="container-fluid" style="height:590px;margin-right:10px">
	<div class="row-fluid box" style="height:500px">
		<div class="tab-header">导入{$APP.$MODULE}</div>
		<div class="padded" style="overflow:auto;height:500px;">
			<form enctype="multipart/form-data" name="Import" method="POST" action="index.php">
			<div class="row-fluid" style="margin-top:30px">
				<!--tip-->
				<div class="span4">
					<div class="well" style="width:400px;height:200px;background-color:#fff">
						<span class="label label-info">说明:</span>
						<p>
							1.若不能上传文件，请刷新本页面即可。<br><br>
							2.请保持文件默认编码ANSI，以免造成编码错误。<br><br>
							3.导入文件的第一行"标题"请不要删除，添加或更改，以免不能导入。<br><br>
							4.重复的记录跳过不更新<br><br>
						</p>
						{if $MODULE=='Accounts'}
						<a href="c3crm.csv" target="_blank"><font color=red size="+1"><b>>>下载样例</b></font></a>
						{else}
						<a href="contacts.csv" target="_blank"><font color=red size="+1"><b>>>下载样例</b></font></a>
						{/if}
					</div>
				</div>
				<!--tip end-->
				<!--form-->
				<div class="span8 ">
					<input type="hidden" name="module" value="{$MODULE}">
					<input type="hidden" name="step" value="1">
					<input type="hidden" name="source" value="{$SOURCE}">
					<input type="hidden" name="source_id" value="{$SOURCE_ID}">
					<input type="hidden" name="action" value="Import">
					<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
					<input type="hidden" name="return_id" value="{$RETURN_ID}">
					<input type="hidden" name="return_action" value="{$RETURN_ACTION}">
					<input type="hidden" name="parenttab" value="{$CATEGORY}">
					<input type="hidden" name="filename" id="filename" value="">
					<div class="fieldset flash" style="margin-left:200px;"  >
						<span class="legend">上传要导入的{$APP.$MODULE}CSV文件(Max:2MB)</span>
						<input type="text" id="txtFileName"  disabled="true" style="width:250px;margin-left:5px;"/>
						<!--<input type="file" name="userfile" id="txtFileName"/>-->
						<span id="spanButtonPlaceholder1"></span>
						<div id="fsUploadProgress1"></div>
						<div align="left" style="padding-left:10px;padding-top:10px;">
							<button type="button"  id="btnSubmit" onclick="doSubmit(swfu);" disabled="disabled"  class="btn btn-small " >
							<i class="icon-circle-arrow-up"></i> 开始上传 
							</button>
							<button id="btnCancel1" type="button"  onclick="cancelQueue(swfu);" disabled="disabled" class="btn btn-small " >
								<i class="icon-remove-sign"></i> 取消上传
							</button>
							<br />
						</div>
					</div>
				</div>
			</div>
			<div style="margin-top:100px" class="breadcrumb text-center">
				<button type="button" class="btn btn-small btn-primary"  onclick="window.location.reload();"style="margin-right:240px">
					<i class="icon-refresh icon-white"></i> 刷 新
				</button>
				<button title="{$MOD.LBL_NEXT}" accessKey="" class="btn btn-small btn-primary" type="button" name="button" onclick="this.form.action.value='Import';this.form.step.value='2'; checkFilename();">
					<i class="icon-circle-arrow-right icon-white"></i> 开始导入
				</button>
			</div>
			</form>
			<!--form end-->
		</div>
	</div>
</div>

<script>
{literal}
	function checkFilename(){
		var filename = document.getElementById("filename").value;
		if(filename == ''){
			alert("文件还未上传...");
			return false;
		}else{
			document.Import.submit();
		}
	}
{/literal}
</script>