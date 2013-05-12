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
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/ColorPicker2.js"></script>
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>

<script language="JavaScript" type="text/javascript">

 	var cp2 = new ColorPicker('window');
	
function pickColor(color)
{ldelim}
	ColorPicker_targetInput.value = color;
        ColorPicker_targetInput.style.backgroundColor = color;
{rdelim}	

function openPopup(){ldelim}
		window.open("index.php?module=Users&action=UsersAjax&file=RolePopup&parenttab=Settings","roles_popup_window","height=425,width=640,toolbar=no,menubar=no,dependent=yes,resizable =no");
	{rdelim}	
</script>	

<script language="javascript">
function check_duplicate()
{ldelim}
	var user_name = window.document.EditView.user_name.value;
	new Ajax.Request(
                'index.php',
                {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
                        method: 'post',
                        postBody: 'module=Users&action=UsersAjax&file=Save&ajax=true&dup_check=true&userName='+user_name,
                        onComplete: function(response) {ldelim}
			        var result = trim(response.responseText);
				if(result.indexOf('SUCCESS') > -1)
			                document.EditView.submit();
       				else
			                alert(result);
                        {rdelim}
                {rdelim}
        );

{rdelim}

</script>


<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td class="showPanelBg" style="padding: 1px;" valign="top" width="100%">

	<div align=center>
	{if $PARENTTAB eq 'Settings'}
		{include file='SetMenu.tpl'}
	{/if}

		<form name="EditView" method="POST" action="index.php">
		<input type="hidden" name="module" value="Users">
		<input type="hidden" name="record" value="{$ID}">
		<input type="hidden" name="mode" value="{$MODE}">
		<input type='hidden' name='parenttab' value='{$PARENTTAB}'>
		<input type="hidden" name="action">
		<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
		<input type="hidden" name="return_id" value="{$RETURN_ID}">
		<input type="hidden" name="return_action" value="{$RETURN_ACTION}">

	<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="settingsSelUITopLine">
	<tr><td align="left">
		<table class="settingsSelUITopLine" border="0" cellpadding="5" cellspacing="0" align="left" width="100%">
		<tr>
			<td rowspan="2" width="48"><img src="{$IMAGE_PATH}ico-users.gif" align="absmiddle"></td>
			<td align="left">	
				<span class="lvtHeaderText">
				{if $PARENTTAB neq ''}	
				<b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS} </a> &gt; <a href="index.php?module=Users&action=index&parenttab=Settings">{$MOD.LBL_USERS}</a> &gt; 
					{if $MODE eq 'edit'}
						{$UMOD.LBL_EDITING} "{$USERNAME}" 
					{else}
						{$UMOD.LBL_CREATE_NEW_USER}
					{/if}
					</b></span>
				{else}
                                <span class="lvtHeaderText">
                                <b>{$APP.LBL_MY_PREFERENCES}</b>
                                </span>
                                {/if}
			</td>
			<td rowspan="2" nowrap>&nbsp;
			</td>
	 	</tr>
		<tr>
			{if $MODE eq 'edit'}
				<td align="left"><b class="small">{$UMOD.LBL_EDIT_VIEW} "{$USERNAME}"</b>
			{else}
				<td align="left"><b class="small">{$UMOD.LBL_CREATE_NEW_USER}</b>
			{/if}
			</td>
                </tr>
		</table>
	</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
		<td nowrap align="right">
				<input title="{$APP.LBL_SAVE_BUTTON_TITLE}" accesskey="{$APP.LBL_SAVE_BUTTON_KEY}" class="small crmbutton save"  name="button" value="  {$APP.LBL_SAVE_BUTTON_LABEL}  "  onclick="this.form.action.value='Save'; return verify_data(EditView)" style="width: 70px;" type="button" />
				<input title="{$APP.LBL_CANCEL_BUTTON_TITLE}" accesskey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="small crmbutton cancel" name="button" value="  {$APP.LBL_CANCEL_BUTTON_LABEL}  " onclick="goback()" style="width: 70px;" type="button" />
						
		</td>
	</tr>
	<tr><td class="padTab" align="left">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">

		<tr><td colspan="2">
			<table align="center" border="0" cellpadding="0" cellspacing="0" width="99%">
			<tr>
			    <td align="left" valign="top">
			             <table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr><td align="left">
						
		                                <table class="tableHeading" border="0" cellpadding="5" cellspacing="0" width="100%">
                		                <tr>
                                		    
		                                     <td class="big">
                		                        <strong>{$UMOD.LBL_USER_LOGIN_ROLE}</strong>
                                		     </td>
		                                     <td class="small" align="right">&nbsp;</td>
		                                  
                		              	</tr>
                                		</table>
		                                <table border="0" cellpadding="5" cellspacing="0" width="100%">
<tbody>
<tr style="height: 25px;">
<td class="dvtCellLabel" align="right" width="20%"><font color="red">*</font> 用户名</td>
<td class="dvtCellInfo" align="left" width="30%"><input name="user_name" value="" tabindex="1" class="detailedViewTextBox" onfocus="this.className='detailedViewTextBoxOn'" onblur="this.className='detailedViewTextBox'" type="text"></td>
<td class="dvtCellLabel" align="right" width="20%">管理员</td>
<td class="dvtCellInfo" align="left" width="30%"><input name="is_admin" tabindex="6" type="checkbox"></td>
</tr>
<tr style="height: 25px;">
<td class="dvtCellLabel" align="right" width="20%"><font color="red">*</font> 密码</td>
<td class="dvtCellInfo" align="left" width="30%"><input name="user_password" tabindex="2" value="" class="detailedViewTextBox" onfocus="this.className='detailedViewTextBoxOn'" onblur="this.className='detailedViewTextBox'" type="password">
</td>
<td class="dvtCellLabel" align="right" width="20%">状态</td>
<td class="dvtCellInfo" align="left" width="30%">
<select name="status" tabindex="8" class="small"><option value="Active">Active</option><option value="Inactive">Inactive</option></select>
</td>
</tr>
<tr style="height: 25px;">
<td class="dvtCellLabel" align="right" width="20%">
<font color="red">*</font> 确认密码</td>
<td class="dvtCellInfo" align="left" width="30%">
<input name="confirm_password" tabindex="3" value="" class="detailedViewTextBox" onfocus="this.className='detailedViewTextBoxOn'" onblur="this.className='detailedViewTextBox'" type="password">
</td>
<td class="dvtCellLabel" align="right" width="20%">
<font color="red">*</font> 角色</td>
<td class="dvtCellInfo" align="left" width="30%">
<input name="role_name" id="role_name" readonly="readonly" class="txtBox" tabindex="5" value="" type="text">&nbsp;
<a href="javascript:openPopup();"><img src="themes/softed/images/select.gif" align="absmiddle" border="0"></a>
<input name="user_role" id="user_role" value="" type="hidden">
</td>
</tr>
<tr style="height: 25px;">
<td class="dvtCellLabel" align="right" width="20%"><font color="red">*</font> 姓名</td>
<td class="dvtCellInfo" align="left" width="30%">
<input name="last_name" id="last_name" value="" tabindex="9" class="detailedViewTextBox" onfocus="this.className='detailedViewTextBoxOn'" onblur="this.className='detailedViewTextBox'" type="text">
</td>		
<td class="dvtCellLabel" align="right" width="20%"><font color="red">*</font> 电话</td>
<td class="dvtCellInfo" align="left" width="30%">
<input name="phone_work" id="phone_work" value="" tabindex="9" class="detailedViewTextBox" onfocus="this.className='detailedViewTextBoxOn'" onblur="this.className='detailedViewTextBox'" type="text">
</td>
</tr>

<td class="dvtCellLabel" align="right" width="20%">
<font color="red">*</font> Email</td>
<td class="dvtCellInfo" align="left" width="30%"><input name="email1" id="email1" value="" tabindex="7" class="detailedViewTextBox" onfocus="this.className='detailedViewTextBoxOn'" onblur="this.className='detailedViewTextBox'" type="text"></td>
<td class="dvtCellLabel" align="right" width="20%">部门</td>
<td class="dvtCellInfo" align="left" width="30%">
<select name="groupid" tabindex="8" class="small">{$GROUP_OPTION}</select>
</td>
</tbody>
							
						</table>
					   	
					    </table>
					 </td></tr>
					</table>
			  	   </td></tr>
				   </table>
				  </td></tr>
				
				</table>
			</td>
			</tr>
			</table>
			</form>	
</td>
</tr>
</table>
</td></tr></table>
<br>
{$JAVASCRIPT}
