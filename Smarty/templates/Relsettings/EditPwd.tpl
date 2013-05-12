<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody>
<tr>
   <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">

	
<form action="DoEditPwd.php" method="post" name="editform" id="editform">
	<input type="hidden" name="changepassword" value="true">
    <input type="hidden" name="user_name" value="{$user_name}">
    <input type="hidden" name="record" value="{$record}">
	<input type="hidden" name="department" value="{$department}">
	
	<div align=center>
			

				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}set-IcoTwoTabConfig.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings">{$MOD.LBL_RELSETTINGS}</a> > {$MOD.LBL_EDIT_PASSWORD} </b></td>
				</tr>
				
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
					<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						<td class="big"><strong>{$MOD.LBL_EDIT_PASSWORD}</strong>&nbsp;</td>
						
						<td class="small" align=right>
							<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save"  type="submit" name="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" onClick="return check();">&nbsp;&nbsp;
    							<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}>" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmButton small cancel" onclick="goback()" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
						</td>
					</tr>
					</table>
					
					
					
			<table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow">
			<tr>
			<td class="small" valign=top ><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                        <tr>
                            <td width="20%" nowrap class="small cellLabel"><strong>{$MOD.LBL_OLD_PASSWORD}</strong></td>
                            <td width="80%" class="small cellText">
				<input  type="password" class="detailedViewTextBox small" value="" name="old_password">
			    </td>
                          </tr>
			  <tr>
                            <td width="20%" nowrap class="small cellLabel"><strong>{$MOD.LBL_NEW_PASSWORD}</strong></td>
                            <td width="80%" class="small cellText">
				<input  type="password" class="detailedViewTextBox small" value="" name="new_password">
			    </td>
                          </tr>
                          <tr valign="top">
                            <td nowrap class="small cellLabel"><strong>{$MOD.LBL_NEW_PASSWORD_AGAIN}</strong></td>
                            <td class="small cellText">
				<input  type="password" class="detailedViewTextBox small" value="" name="confirm_password">
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
	if (document.editform.department.value == 'weibo') {
		alert('微薄登录用户不能修改密码');
		document.editform.department.focus();
		return false;
	}
	if (document.editform.old_password.value == '') {
		alert('原密码不能为空');
		document.editform.old_password.focus();
		return false;
	}
	if (document.editform.new_password.value == '') {
		alert('新密码不能为空');
		document.editform.new_password.focus();
		return false;
	}
	if (document.editform.confirm_password.value == '') {
		alert('确认密码不能为空');
		document.editform.confirm_password.focus();
		return false;
	}
	if (document.editform.new_password.value != document.editform.confirm_password.value) {
		alert('新密码和确认密码不相符');
		document.editform.confirm_password.focus();
		return false;
	} else {
		 document.editform.submit();
	}
}
</script>
{/literal}
