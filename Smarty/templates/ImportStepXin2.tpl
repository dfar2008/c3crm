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



<!-- header - level 2 tabs -->
{include file='Buttons_List.tpl'}	

<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%" class="small">
   <tr>
	<td class="showPanelBg" valign="top" width="100%">

		<!-- Import UI Starts -->
		<table  cellpadding="0" cellspacing="0" width="100%" border=0 >
		   <tr>
			<td width="75%" valign=top>
				<form enctype="multipart/form-data" name="Import" method="POST" action="index.php">
				<input type="hidden" name="module" value="Accounts">
				<input type="hidden" name="step" value="1">
				<input type="hidden" name="action" value="Import2">


				<!-- IMPORT LEADS STARTS HERE  -->
				<br />
				<table align="center" cellpadding="5" cellspacing="0" width="95%" class="mailClient importLeadUI small" border="0">
				   <tr>
					<td colspan="2" height="50" valign="middle" align="left" class="mailClientBg  genHeaderSmall">{$MOD.LBL_MODULE_NAME}{$APP.$MODULE}</td>
				   </tr>
				  
				   <tr >
					<td colspan="2" align="left" valign="top" style="padding-left:10px;" >
						<div align='left' width='100%'  style="line-height:25px; padding-left:5px; font-size:16px;"><font color='green'><b>导入完成</b></font></div>
                        <div style="line-height:25px; padding-left:5px; font-size:14px;"><font color='green'>订单导入:成功<b><font color=red>{$success_salesorder}</b></font>,失败<b><font color=red>{$fail_salesorder}</b></font>,跳过<b><font color=red>{$jump_salesorder}</b></font></font></div>
                        <div  style="line-height:25px; padding-left:5px; font-size:14px;"><font color='green'>客户导入:成功<b><font color=red>{$success_account}</b></font>,失败<b><font color=red>{$fail_account}</b></font>,跳过<b><font color=red>{$jump_account}</b></font></font></div>
                         <div  style="line-height:25px; padding-left:5px; font-size:14px;"><font color='green'>产品导入:成功<b><font color=red>{$success_product}</b></font>,失败<b><font color=red>{$fail_product}</b></font>,跳过<b><font color=red>{$jump_product}</b></font></font></div>
                          
					</td>
				   </tr>
				    
				   <tr ><td colspan="2" height="50">&nbsp;</td></tr>
				    <tr >
						<td colspan="2" align="right" style="padding-right:40px;" class="reportCreateBottom">
                       
							<input title="{$MOD.LBL_IMPORT_MORE}" accessKey="" class="crmButton small save" type="submit" name="button" value="  {$MOD.LBL_IMPORT_MORE} &rsaquo; "  onclick="this.form.action.value='Import2';this.form.step.value='1'; ">
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
