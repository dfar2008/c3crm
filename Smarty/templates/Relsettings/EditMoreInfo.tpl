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

	
<form action="index.php" method="post" name="editform" id="editform">
    <input type="hidden" name="user_name" value="{$user_name}">
    <input type="hidden" name="record" value="{$record}">
    <input type="hidden" name="mode" value="{$mode}">
    <input type="hidden" name="module" value="Relsettings">
    <input type="hidden" name="action" value="EditMoreInfo">
    
	<div align=center>
			

				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}ico-users.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings">{$MOD.LBL_RELSETTINGS}</a> > {$MOD.LBL_EDIT_MORE_INFO} </b></td>
				</tr>
				
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
					<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						<td class="big"><strong>{$MOD.LBL_EDIT_MORE_INFO}</strong>&nbsp;</td>
						{if $mode neq 'edit'}
                        <td class="small" align=right>
							<input class="crmButton small edit" title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" onclick="this.form.mode.value='edit'" type="submit" name="Edit" value="{$APP.LBL_EDIT_BUTTON_LABEL}">
						</td>
                        {else}
						<td class="small" align=right>
							<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save"  type="button" name="savebutton" value="{$APP.LBL_SAVE_BUTTON_LABEL}" onClick="return check();">&nbsp;&nbsp;
    							<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}>" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmButton small cancel" onclick="goback()" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
						</td>
                        {/if}
					</tr>
					</table>
					
			     <table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow ">
                    <tr>
                    <td class="small" valign=top >
                    
			  {if $mode neq 'edit'}
                   <table width="100%"  border="0" cellspacing="0" cellpadding="5">
                     <tr>
                        <td width="20%" nowrap class="small cellLabel"><strong>姓名</strong></td>
                        <td width="80%" class="small cellText">
                        {$last_name}
                        </td>
                      </tr>
                      <tr valign="top">
                        <td nowrap class="small cellLabel"><strong>Email</strong></td>
                        <td class="small cellText">
                           {$email1}
                         </td>
                      </tr>
                      <tr valign="top">
                        <td nowrap class="small cellLabel"><strong>手机</strong></td>
                        <td class="small cellText">
							{$phone_mobile}
                         </td>
                      </tr>
                    </table>
				{else}
                    <table width="100%"  border="0" cellspacing="0" cellpadding="5">
                     <tr>
                        <td width="20%" nowrap class="small cellLabel"><strong>姓名</strong></td>
                        <td width="80%" class="small cellText">
                        <input  type="nicheng" class="detailedViewTextBox small" value="{$last_name}" name="last_name">
                        </td>
                      </tr>
                      <tr valign="top">
                        <td nowrap class="small cellLabel"><strong><font color="#FF0000">*</font>Email</strong></td>
                        <td class="small cellText">
                            {if $readonly eq 'readonly'}
                            	{$email1}
                                <input  type="hidden" class="detailedViewTextBox small" value="{$email1}" name="email1"  />
                            {else}
                           		 <input  type="text" class="detailedViewTextBox small" value="{$email1}" name="email1"  />
                            {/if}
                         </td>
                      </tr>
                      <tr valign="top">
                        <td nowrap class="small cellLabel"><strong>手机</strong></td>
                        <td class="small cellText">
                            <input  type="text" class="detailedViewTextBox small" value="{$phone_mobile}" name="phone_mobile">
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
function check()
{	
	if (document.editform.email1.value == '') {
		alert('Email不能为空');
		document.editform.email1.focus();
		return false;
	}
	var mobile = /^0?(13[0-9]|15[012356789]|18[0236789]|14[57])[0-9]{8}$/; 
	var phone_mobile = document.editform.phone_mobile.value;
	if (!mobile.test(phone_mobile)) {
		alert('手机格式不正确');
		document.editform.phone_mobile.focus();
		return false;
	}
	var reg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	var email1 = document.editform.email1.value;
	if (!reg.test(email1)) {
		alert('Email格式不正确');
		document.editform.email1.focus();
		return false;
	} 
	new Ajax.Request(
			'index.php',
			{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody:"module=Relsettings&action=RelsettingsAjax&file=EditMoreInfo&ajax=true&email1="+email1+"&phone_mobile="+phone_mobile,
			onComplete: function(response) 
				{  result = response.responseText;
					if(result.indexOf('FAILEDPHONE') != '-1') 
					{
						alert("手机重复!");
						document.editform.phone_mobile.focus();
						return false;	
					}else if(result.indexOf('FAILEDEMAIL') != '-1') 
					{
						alert("Email重复!");
						document.editform.email1.focus();
						return false;	
					}
					else if(result.indexOf('SUCCESS') != '-1')
					{
						document.editform.action.value = "SaveMoreInfo";
						document.editform.submit();
					}
				}
			}
	)	
}

</script>
{/literal}
