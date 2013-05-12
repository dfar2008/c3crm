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
<script type="text/javascript" src="swfupload/js/handlers2.js"></script>
<script type="text/javascript">

{literal}
var upload1, upload2;

window.onload = function() {
	upload1 = new SWFUpload({
		// Backend Settings
		upload_url: "modules/Import/upload1.php",	// Relative to the SWF file (or you can use absolute paths)
		post_params: {"PHPSESSID" : ""},

		
		// File Upload Settings
		file_size_limit : "2048",	// 2MB
		file_types : "*.csv",
		file_types_description : "All Files",
		file_upload_limit : "1",
		file_queue_limit : "0",

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

	upload2 = new SWFUpload({
		// Backend Settings
		upload_url: "modules/Import/upload2.php",	// Relative to the SWF file (or you can use absolute paths)
		post_params: {"PHPSESSID" : ""},

		// File Upload Settings
		file_size_limit : "2048",	// 30MB
		file_types : "*.csv",
		file_types_description : "All Files",
		file_upload_limit : "1",
		file_queue_limit : "0",

		// Event Handler Settings (all my handlers are in the Handler.js file)
		file_dialog_start_handler : fileDialogStart,
		file_queued_handler : fileQueued2,
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete2,
		upload_start_handler : uploadStart,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess2,
		upload_complete_handler : uploadComplete,

		// Button Settings
		button_image_url : "swfupload/images/XPButtonUploadText_61x21.png",
		button_placeholder_id : "spanButtonPlaceholder2",
		button_width: 61,
		button_height: 22,
		
		// Flash Settings
		flash_url : "swfupload/swf/swfupload.swf",

		swfupload_element_id : "flashUI2",		// Setting from graceful degradation plugin
		degraded_element_id : "degradedUI2",	// Setting from graceful degradation plugin

		custom_settings : {
			progressTarget : "fsUploadProgress2",
			cancelButtonId : "btnCancel2"
		},

		// Debug Settings
		debug: false
	});

}

 {/literal}
</script>


<!-- header - level 2 tabs -->
{include file='Buttons_List.tpl'}	

<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%" class="small">
   <tr>
	<td class="showPanelBg" valign="top" width="100%">

		<table  cellpadding="0" cellspacing="0" width="100%" border=0>
		   <tr>
			<td width="75%" valign=top>
				<form enctype="multipart/form-data" name="Import" method="POST" action="index.php">
				<input type="hidden" name="module" value="{$MODULE}">
				<input type="hidden" name="step" value="1">
				<input type="hidden" name="source" value="{$SOURCE}">
				<input type="hidden" name="source_id" value="{$SOURCE_ID}">
				<input type="hidden" name="action" value="Import">
				<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
				<input type="hidden" name="return_id" value="{$RETURN_ID}">
				<input type="hidden" name="return_action" value="{$RETURN_ACTION}">
				<input type="hidden" name="parenttab" value="{$CATEGORY}">
				<input type="hidden" name="filename1" id="filename1" value="">
                <input type="hidden" name="filename2" id="filename2" value="">
                
				<!-- IMPORT LEADS STARTS HERE  -->
				<br />
				<table align="center" cellpadding="5" cellspacing="0" width="95%" class="mailClient importLeadUI small" border="0">
                
				   <tr>
					<td colspan="2" height="50" valign="middle" align="left" class="mailClientBg  genHeaderSmall">{$MOD.LBL_MODULE_NAME}{$APP.$MODULE}</td>
				   </tr>
				  
				  
				   <tr ><td align="left" valign="top" colspan="2">&nbsp;</td></tr>
				   <tr >
					
					<td align="center" valign="top" >
						<!--<input type="file" name="userfile1"  size="40"   class=small/>&nbsp;-->
                       <div>
						<div class="fieldset flash" >
							<span class="legend">{$MOD.LBL_FILE_ORDERLIST_CSV}(Max:2MB)</span>
                             <input type="text" id="txtFileName1" disabled="true" style="border: solid 1px; background-color: #FFFFFF; vertical-align:top;width:250px;margin-left:-30px;"/>
							<span id="spanButtonPlaceholder1"></span>
                            <div id="fsUploadProgress1"></div>
                            <div align="left" style="padding-left:10px;padding-top:10px;">
                            <input type="button" value="开始上传" id="btnSubmit1" onclick="doSubmit(upload1);" disabled="disabled" style="margin-left: 5px; height: 22px; font-size: 10pt;" />
							<input id="btnCancel1" type="button" value="取消上传" onclick="cancelQueue(upload1);" disabled="disabled" style="margin-left: 2px; height: 22px; font-size: 10pt;" />
						</div>
					</div>
					
					<td align="center" valign="top" >
						<!--<input type="file" name="userfile2"  size="40"   class=small/>&nbsp;-->
                		<div>
						<div class="fieldset flash" >
							<span class="legend">{$MOD.LBL_FILE_ORDERDETAILLIST_CSV}(Max:2MB)</span>
                             <input type="text" id="txtFileName2" disabled="true" style="border: solid 1px; background-color: #FFFFFF; vertical-align:top;width:250px;margin-left:-30px;"/>
							<span id="spanButtonPlaceholder2"></span>
                            <div id="fsUploadProgress2"></div>
                            <div align="left" style="padding-left:10px;padding-top:10px;">
                            <input type="button" value="开始上传" id="btnSubmit2" onclick="doSubmit(upload2);" disabled="disabled" style="margin-left: 5px; height: 22px; font-size: 10pt;" />
							<input id="btnCancel2" type="button" value="取消上传" onclick="cancelQueue(upload2);" disabled="disabled" style="margin-left: 2px; height: 22px; font-size: 10pt;" />
						</div>
					</div>
					</td>
				   </tr>
				  
				   <tr ><td colspan="2" height="50"  style="padding-left: 90px; color:#F00" >备注:1.若不能上传文件，请刷新本页面即可。2.文件请尽量保持淘宝下载原样(文件名及内容)，不宜改动，造成编码错误。)</td></tr>
				    <tr >
						<td colspan="2" align="right" style="padding-right:40px;" class="reportCreateBottom">
							<input title="{$MOD.LBL_NEXT}" accessKey="" class="crmButton small save" type="button" name="button" value="  {$MOD.LBL_NEXT} &rsaquo; "  onclick="this.form.action.value='Import2';this.form.step.value='2'; checkFileName();">
						</td>
				   </tr>				</form>
				 </table>
				<br>
				<!-- IMPORT LEADS ENDS HERE -->
			</td>
		   </tr>
		</table>

	</td>
   </tr>
</table>
<br>
<script>
{literal}
function checkFileName(){
	var filename1 = document.getElementById("filename1").value;	
	if(filename1 == '' || filename1 == 'error'){
		alert("订单列表文件未上传或上传失败，请重新上传");
		return false;
	}
	var filename2 = document.getElementById("filename2").value;	
	if(filename2 == '' || filename2 == 'error'){
		alert("宝贝列表文件未上传或上传失败，请重新上传");
		return false;
	}else{
		document.Import.submit();
	}
	
}
{/literal}
</script>
