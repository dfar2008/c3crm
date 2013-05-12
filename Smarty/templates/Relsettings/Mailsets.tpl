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
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody>
	<tr>
     <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
     
	{if $MAILSETS_MODE neq 'edit'}	
	<form action="index.php" method="post" name="MailsetServer" id="form">
	<input type="hidden" name="mailsets_mode">
	{else}
	<form action="index.php" method="post" name="MailsetServer" id="form" onsubmit="return validate(MailsetServer);">
	{/if}
	<input type="hidden" name="module" value="Relsettings">
	<input type="hidden" name="action">
	<input type="hidden" name="parenttab" value="Settings">
	<input type="hidden" name="return_module" value="Relsettings">
	<input type="hidden" name="return_action" value="Mailsets">
    
	<div align=center>
    
			

				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}relatedinfo.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings">{$MOD.LBL_RELSETTINGS}</a> > {$MOD.LBL_MAILSETS} </b></td>
				</tr>
				<tr>
					<td valign=top class="small">{$MOD.LBL_MAILSETS_DESCRIPTION} </td>
				</tr>
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
					<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						<td class="big"><strong>{$MOD.LBL_MAILSETS}</strong></td>
						{if $MAILSETS_MODE neq 'edit'}	
						<td class="small" align=right>
							<input class="crmButton small edit" title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" onclick="this.form.action.value='Mailsets';this.form.mailsets_mode.value='edit'" type="submit" name="Edit" value="{$APP.LBL_EDIT_BUTTON_LABEL}">
						</td>
						{else}
						<td class="small" align=right>
							<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save" onclick="this.form.action.value='SaveMailsets';" type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" >&nbsp;&nbsp;
    							<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}>" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmButton small cancel" onclick="goback()" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
						</td>
						{/if}
					</tr>
					</table>
					
					{if $MAILSETS_MODE neq 'edit'}	
						<table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow">
						<tr>
						<td class="small" valign=top ><table width="100%"  border="0" cellspacing="0" cellpadding="5">
						  <tr valign="top">
						    <td width="20%" nowrap class="cellLabel"><strong>{$MOD.LBL_MAILSENDPERSON}</strong></td>
						    <td width="80%" class="cellText">{$SENDPERSON}&nbsp;</td>
						  </tr>
						  <tr>
						    <td width="20%" nowrap class="cellLabel"><strong>{$MOD.LBL_MAILSENDMAIL}</strong></td>
						    <td width="80%" class="cellText">{$SENDMAIL}&nbsp;</td>
						  </tr>	
						 
						</table>
				        {else}					
						<table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow">
						<tr>
						<td class="small" valign=top ><table width="100%"  border="0" cellspacing="0" cellpadding="5">
						  <tr valign="top">
						    <td width="20%" nowrap class="cellLabel"><strong>{$MOD.LBL_MAILSENDPERSON}</strong></td>
						    <td width="80%" class="cellText">
							<input type="text" class="detailedViewTextBox small" value="{$SENDPERSON}" name="sendperson">
						    </td>
						  </tr>
						  <tr>
						    <td width="20%" nowrap class="cellLabel"><strong>{$MOD.LBL_MAILSENDMAIL}</strong></td>
						    <td width="80%" class="cellText">
							<input type="text" class="detailedViewTextBox small" value="{$SENDMAIL}" name="sendmail">
						    </td>
						  </tr>
						  
						</table>				
			                {/if}
						
						</td>
					  </tr>
					</table>
				
				</td>
				</tr>
				</table>
			
			
			
			</td>
			</tr>
			</table>
		</td>
	</tr>
	</table>
		
	</div>
	</form>
	
</td>
   </tr>
</tbody>
</table>
{literal}
<script>
function validate(form)
{
	if(form.sendperson.value =='')
	{
		alert("发件人姓名不能为空");
		return false;
	}
	if(form.sendmail.value =='')
	{
		alert("发件人邮件不能为空");
		return false;
	}
	var filter = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	if(filter.test(form.sendmail.value))
	{
		return true;
	}else{
		alert("发件人邮件格式不正确");
		return false;
	}

	return true;
}
</script>
{/literal}
