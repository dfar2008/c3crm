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


<script language="javascript">
{literal}
function verify_data() {
	if(document.Import.userfile.value == ''){
		alert(alert_arr.IMPORTED_FILE_ISNOT_NULL);
		document.Import.userfile.focus();
		return false;
	}
	return true;
}
{/literal}
</script>

<!-- header - level 2 tabs -->
{include file='Buttons_List.tpl'}	

<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%" class="small">
   <tr>
	<td class="showPanelBg" valign="top" width="100%">

		<!-- Import UI Starts -->
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

				<!-- IMPORT LEADS STARTS HERE  -->
				<br />
				<table align="center" cellpadding="5" cellspacing="0" width="80%" class="mailClient importLeadUI small" border="0">
				   <tr>
					<td colspan="2" height="50" valign="middle" align="left" class="mailClientBg  genHeaderSmall">{$MOD.LBL_MODULE_NAME}{$APP.$MODULE}</td>
				   </tr>
				   <tr >
					<td colspan="2" align="left" valign="top" style="padding-left:40px;">
					<br>
						<span class="genHeaderGray">{$MOD.LBL_STEP_1}</span>&nbsp; 
						<span class="genHeaderSmall">{$MOD.LBL_STEP_1_TITLE}</span> 
					</td>
				   </tr>
				   <tr >
					<td colspan="2" align="left" valign="top" style="padding-left:40px;">
						{$MOD.LBL_STEP_1_TEXT}
					</td>
				   </tr>
				   <tr ><td align="left" valign="top" colspan="2">&nbsp;</td></tr>
				   <tr >
					<td align="right" valign="top" width="25%" class=small><b>{$MOD.LBL_FILE_LOCATION} </b></td>
					<td align="left" valign="top" width="75%">
						<input type="file" name="userfile"  size="40"   class=small/>&nbsp;
                		<input type="checkbox" name="has_header"{$HAS_HEADER_CHECKED} />&nbsp; {$MOD.LBL_HAS_HEADER}
				{if $MODULE eq 'Accounts' || $MODULE eq 'Contacts' || $MODULE eq 'Products'}
				&nbsp;<input type="checkbox" name="overwrite" {$OVERWRITE_CHECKED} />&nbsp; {$MOD.LBL_OVERWRITE}
				{/if}
					</td>
				   </tr>
				   {*<tr >
							<td align="right" valign="top" width="25%"><b>De-Limiter : </b></td>
								<td align="left" valign="top" width="75%">
								<input type="text"  class="importBox"  />&nbsp;
							</td>
						   </tr>
					
						   <tr >
							<td align="right" valign="top" class="small" >	
								<b>Use Data Source :</b>
							</td>
								<td align="left" valign="top" class="small" >
								<input name="custom" type="radio" value="" class="small" />&nbsp;Custom
							</td>
						   </tr>
						   <tr >
							<td align="right" valign="top">&nbsp;</td>
							<td align="left" valign="top"><input name="custom" type="radio" value="" class="small" /> 
								Pre - Defined 
							</td>
				   </tr>*}
				   <tr ><td colspan="2" height="50">&nbsp;</td></tr>
				    <tr >
						<td colspan="2" align="right" style="padding-right:40px;" class="reportCreateBottom">
							<input title="{$MOD.LBL_NEXT}" accessKey="" class="crmButton small save" type="submit" name="button" value="  {$MOD.LBL_NEXT} &rsaquo; "  onclick="this.form.action.value='Import';this.form.step.value='2'; return verify_data(this.form);">
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
