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
		file_upload_limit : 1,
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
				<input type="hidden" name="filename" id="filename" value="">
				<!-- IMPORT LEADS STARTS HERE  -->
				<br />
				<table align="center" cellpadding="5" cellspacing="0" width="95%" class="mailClient importLeadUI small" border="0">
                
				   <tr>
					<td colspan="2" height="50" valign="middle" align="left" class="mailClientBg  genHeaderSmall">{$MOD.LBL_MODULE_NAME}{$APP.$MODULE}</td>
				   </tr>
				  
				  
				   <tr ><td align="left" valign="top" colspan="2">&nbsp;</td></tr>
				   <tr >
					
                    <td align="left" width="50%" valign="middle"  style="padding-left:40px;">
                    说明:<br><br>
                   1.若不能上传文件，请刷新本页面即可。<br><br>
                   2.请保持文件默认编码ANSI，以免造成编码错误。<br><br>
                   3.导入文件的第一行"标题"请不要删除，添加或更改，以免不能导入<br><br>
                   4.重复的记录跳过不更新<br><br>
                    <a href="c3crm.csv"><font color=red size="+1"><b>>>下载样例</b></font></a>
                    </td>
					<td align="left" valign="middle" >
						<!--<input type="file" name="userfile1"  size="40"   class=small/>&nbsp;-->
                       <div align="left" style="padding-left:10px;">
						<div class="fieldset flash"  >
							<span class="legend">{$MOD.LBL_FILE_ORDERLIST}(Max:2MB)</span>
                            <input type="text" id="txtFileName" disabled="true" style="border: solid 1px; background-color: #FFFFFF; vertical-align:top;width:250px;margin-left:5px;"/>
							<span id="spanButtonPlaceholder1"></span>
                            <div id="fsUploadProgress1"></div>
                            <div align="left" style="padding-left:10px;padding-top:10px;">
                            <input type="button" value="开始上传" id="btnSubmit" onclick="doSubmit(swfu);" disabled="disabled" style="margin-left: -5px; height: 22px; font-size: 10pt;" />
							<input id="btnCancel1" type="button" value="取消上传" onclick="cancelQueue(swfu);" disabled="disabled" style="margin-left: 2px; height: 22px; font-size: 10pt;" />
							<br />
						</div>
						</div>
						
					</div>
				   </tr>
				    <tr >
						<td  align="left" style="padding-left:40px;" class="reportCreateBottom">
                        <input type="button" class="crmbutton small edit" value="  刷 新  "  onclick="window.location.reload();"/>
                        </td>
                        <td  align="right" style="padding-right:40px;" class="reportCreateBottom">
							<input title="{$MOD.LBL_NEXT}" accessKey="" class="crmButton small save" type="button" name="button" value="   开始导入 &rsaquo; "  onclick="this.form.action.value='Import';this.form.step.value='2'; checkFilename();">
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