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
				<input type="hidden" name="action" value="Import">


				<!-- IMPORT LEADS STARTS HERE  -->
				<br />
				<table align="center" cellpadding="5" cellspacing="0" width="95%" class="mailClient importLeadUI small" border="0">
				   <tr>
					<td colspan="2" height="50" valign="middle" align="left" class="mailClientBg  genHeaderSmall">{$MOD.LBL_MODULE_NAME}{$APP.$MODULE}</td>
				   </tr>
				  
				   <tr >
					<td colspan="2" align="center" valign="top" >
						<div align='center' width='100%'><font color='green'><b>导入完毕</b></font></div>
                        <div>
                        <font color='green'><b>成功插入记录：<font color=red>{$success_account_insert}</font>；失败:<font color=red>{$failed_account_insert}</font></b></font><br>
                        <font color='green'><b>其中重复跳过的记录:<font color=red>{$tiaoguo_account}</font></b></font></div>
					</td>
				   </tr>
				    
				   <tr ><td colspan="2" height="50">&nbsp;</td></tr>
				    <tr >
						<td colspan="2" align="right" style="padding-right:40px;" class="reportCreateBottom">
                       
							<input title="{$MOD.LBL_IMPORT_MORE}" accessKey="" class="crmButton small save" type="submit" name="button" value="  {$MOD.LBL_IMPORT_MORE} &rsaquo; "  onclick="this.form.action.value='Import';this.form.step.value='1'; ">
                            
                            <input type="button" name="button" value="返回客户" accessyKey="F"  class="crmButton small edit"
                            onclick="javascript:location.href='index.php?module=Accounts&action=ListView'" />
						</td>
				   </tr>		
                 </form>
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
