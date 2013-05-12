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
<tbody><tr>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
	{if $EMAILCONFIG_MODE neq 'edit'}	
	<form action="index.php" method="post" name="MailServer" id="form">
	<input type="hidden" name="emailconfig_mode">
	{else}
	<form action="index.php" method="post" name="MailServer" id="form" onsubmit="return validate_mail_server(MailServer);">
	<input type="hidden" name="server_type" value="email">
	{/if}
	<input type="hidden" name="module" value="Relsettings">
	<input type="hidden" name="action">
	<input type="hidden" name="parenttab" value="Settings">
	<input type="hidden" name="return_module" value="Relsettings">
	<input type="hidden" name="return_action" value="EmailConfig">
	<div align=center>
			

				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}ogmailserver.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings">{$MOD.LBL_RELSETTINGS}</a> > {$MOD.LBL_MAIL_SERVER_SETTINGS} </b></td>
				</tr>
				<tr>
					<td valign=top class="small">{$MOD.LBL_MAIL_SERVER_DESC} </td>
				</tr>
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
					<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						<td class="big"><strong>{$MOD.LBL_MAIL_SERVER_SMTP}</strong>&nbsp;<br>{$ERROR_MSG}</td>
						{if $EMAILCONFIG_MODE neq 'edit'}	
						<td class="small" align=right>
							<input class="crmButton small edit" title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" onclick="this.form.action.value='EmailConfig';this.form.emailconfig_mode.value='edit'" type="submit" name="Edit" value="{$APP.LBL_EDIT_BUTTON_LABEL}">
						</td>
						{else}
						<td class="small" align=right>
							<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save" onclick="this.form.action.value='Save';" type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" >&nbsp;&nbsp;
    							<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}>" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmButton small cancel" onclick="goback()" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
						</td>
						{/if}
					</tr>
					</table>
					
					{if $EMAILCONFIG_MODE neq 'edit'}	
					<table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow">
					<tr>
					<td class="small" valign=top ><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                          <tr>
                            <td width="20%" nowrap class="small cellLabel"><strong>{$MOD.LBL_OUTGOING_MAIL_SERVER}</strong></td>
                            <td width="80%" class="small cellText"><strong>{$MAILSERVER}&nbsp;</strong></td>
                          </tr>
			   <tr>
                            <td width="20%" nowrap class="small cellLabel"><strong>{$MOD.LBL_OUTGOING_MAIL_SERVER_PORT}</strong></td>
                            <td width="80%" class="small cellText"><strong>{$MAILSERVER_PORT}&nbsp;</strong></td>
                          </tr>
                          <tr valign="top">
                            <td nowrap class="small cellLabel"><strong>{$MOD.LBL_USERNAME}</strong></td>
                            <td class="small cellText">{$USERNAME}&nbsp;</td>
                          </tr>
                          <tr>
                            <td nowrap class="small cellLabel"><strong>{$MOD.LBL_PASWRD}</strong></td>
                            <td class="small cellText">
				{if $PASSWORD neq ''}
				******
				{/if}&nbsp;
			     </td>
                          </tr>
                          <tr> 
                            <td nowrap class="small cellLabel"><strong>{$MOD.LBL_REQUIRES_AUTHENT}</strong></td>
                            <td class="small cellText">
				{if $SMTP_AUTH eq 'checked'}
					{$MOD.LBL_YES}
				{else}
					{$MOD.LBL_NO}
				{/if}
			    </td>
                          </tr>
                          <tr valign="top">
                            <td nowrap class="small cellLabel"><strong>{$MOD.LBL_MAILSENDPERSON}</strong></td>
                            <td class="small cellText">{$FROMNAME}&nbsp;</td>
                          </tr>
                          <tr valign="top">
                            <td nowrap class="small cellLabel"><strong>{$MOD.LBL_MAILSENDMAIL}</strong></td>
                            <td class="small cellText">{$FROMEMAIL}&nbsp;</td>
                          </tr>
                          <tr valign="top">
                            <td nowrap class="small cellLabel"><strong>发送间隔</strong></td>
                            <td class="small cellText">{$INTERVAL}&nbsp;（秒）</td>
                          </tr>
                        </table>
			  {else}
					
			<table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow">
			<tr>
			<td class="small" valign=top ><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                        <tr>
                            <td width="20%" nowrap class="small cellLabel"><strong>{$MOD.LBL_OUTGOING_MAIL_SERVER}</strong></td>
                            <td width="80%" class="small cellText">
				<input type="text" class="detailedViewTextBox small" value="{$MAILSERVER}" name="server">
			    </td>
                          </tr>
			  <tr>
                            <td width="20%" nowrap class="small cellLabel"><strong>{$MOD.LBL_OUTGOING_MAIL_SERVER_PORT}</strong></td>
                            <td width="80%" class="small cellText">
				<input type="text" class="detailedViewTextBox small" value="{$MAILSERVER_PORT}" name="port">
			    </td>
                          </tr>
                          <tr valign="top">
                            <td nowrap class="small cellLabel"><strong>{$MOD.LBL_USERNAME}</strong></td>
                            <td class="small cellText">
				<input type="text" class="detailedViewTextBox small" value="{$USERNAME}" name="server_username">
			    </td>
                          </tr>
                          <tr>
                            <td nowrap class="small cellLabel"><strong>{$MOD.LBL_PASWRD}</strong></td>
                            <td class="small cellText">
				<input type="password" class="detailedViewTextBox small" value="{$PASSWORD}" name="server_password">
			    </td>
                          </tr>
                          <tr> 
                            <td nowrap class="small cellLabel"><strong>{$MOD.LBL_REQUIRES_AUTHENT}</strong></td>
                            <td class="small cellText">
                              	<input type="checkbox" name="smtp_auth" {$SMTP_AUTH}/>
			    </td>
                          </tr>
                          <tr>
                            <td nowrap class="small cellLabel"><strong>{$MOD.LBL_MAILSENDPERSON}</strong></td>
                            <td class="small cellText">
				<input type="text" class="detailedViewTextBox small" value="{$FROMNAME}" name="from_name">
			    </td>
                          </tr>
                          <tr>
                            <td nowrap class="small cellLabel"><strong>{$MOD.LBL_MAILSENDMAIL}</strong></td>
                            <td class="small cellText">
				<input type="text" class="detailedViewTextBox small" value="{$FROMEMAIL}" name="from_email">
				&nbsp;&nbsp;<br>({$MOD.LBL_FROMEMAILNOTICE})
			    </td>
                          </tr>
                          <tr>
                            <td nowrap class="small cellLabel"><strong>发送间隔</strong></td>
                            <td class="small cellText">
                            
                             {$intervaloptions} （秒）
                           
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
function validate_mail_server(form)
{
	if(form.server.value =='')
	{
		alert("服务器名称不能为空")
		return false;
	}
	if(form.from_email.value !='')
	{
		return patternValidate("from_email","Email","Email");
	}
	
	return true;
}
</script>
{/literal}
