<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody>
<tr>
   <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">

	
<form action="index.php" method="post" name="editform" id="editform">
    <input type="hidden" name="userid" value="">
    <input type="hidden" name="module" value="Settings">
    <input type="hidden" name="action" value="CreateMoreInfo">
    
	<div align=center>
			

				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}ico-users.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> > {$MOD.LBL_CREATE_MORE_INFO} </b></td>
				</tr>
				
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
					<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						<td class="big"><strong>{$MOD.LBL_EDIT_MORE_INFO}</strong>&nbsp;</td>

						<td class="small" align=right>
							<input title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="crmButton small save"  type="button" name="savebutton" value="{$APP.LBL_SAVE_BUTTON_LABEL}" onClick="return check();">&nbsp;&nbsp;
    							<input title="{$APP.LBL_CANCEL_BUTTON_LABEL}>" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="crmButton small cancel" onclick="goback()" type="button" name="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}">
						</td>
					</tr>
					</table>
					
			     <table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow ">
                    <tr>
                    <td class="small" valign=top >
                    
			  
                    <table width="100%"  border="0" cellspacing="0" cellpadding="5">
					<tr>
                        <td width="20%" nowrap class="small cellLabel"><strong>用户名</strong></td>
                        <td width="80%" class="small cellText">
                        <input  type="user_name" class="detailedViewTextBox small" style="width:200px" value="" name="user_name">

			是否管理员<input name="is_admin"  tabindex="6" type="checkbox">
                        </td>
                      </tr>
					  <tr>
                        <td width="20%" nowrap class="small cellLabel"><strong>密码</strong></td>
                        <td width="80%" class="small cellText">
                        <input  type="password" class="detailedViewTextBox small" style="width:200px" value="" name="user_password">
                        </td>
                      </tr>
					  <tr>
                        <td width="20%" nowrap class="small cellLabel"><strong>确认密码</strong></td>
                        <td width="80%" class="small cellText">
                        <input  type="password" class="detailedViewTextBox small" style="width:200px" value="" name="repassword">
                        </td>
                      </tr>
                     <tr>
                        <td width="20%" nowrap class="small cellLabel"><strong>姓名</strong></td>
                        <td width="80%" class="small cellText">
                        <input  type="nicheng" class="detailedViewTextBox small" style="width:200px" value="" name="last_name">
                        </td>
                      </tr>
                      <tr valign="top">
                        <td nowrap class="small cellLabel"><strong><font color="#FF0000">*</font>Email</strong></td>
                        <td class="small cellText">                            
                           <input  type="text" class="detailedViewTextBox small" style="width:200px" value="" name="email1"  />                          
                        </td>
                      </tr>
                      <tr valign="top">
                        <td nowrap class="small cellLabel"><strong>手机</strong></td>
                        <td class="small cellText">
                            <input  type="text" class="detailedViewTextBox small" style="width:200px" value="" name="phone_mobile">
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
    if (document.editform.user_name.value == '') {
		alert('用户名不能为空');
		document.editform.user_name.focus();
		return false;
	}
	var user_name = document.editform.user_name.value;
	 if (document.editform.user_password.value == '') {
		alert('密码不能为空');
		document.editform.user_password.focus();
		return false;
	}
	else if(document.editform.user_password.value != document.editform.repassword.value){
		alert('密码和确认密码不相符');
		document.editform.repassword.focus();
		return false;
	}
	var user_password = document.editform.user_password.value;
	if (document.editform.email1.value == '') {
		alert('Email不能为空');
		document.editform.email1.focus();
		return false;
	}
	if (document.editform.phone_mobile.value == '') {
		alert('手机不能为空');
		document.editform.phone_mobile.focus();
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
			postBody:"module=Settings&action=SettingsAjax&file=CreateMoreInfo&ajax=true&email1="+email1+"&phone_mobile="+phone_mobile+"&user_name="+user_name+"&user_password="+user_password,
			onComplete: function(response) 
				{  result = response.responseText;
				        if(result.indexOf('FAILEDUSER') != '-1') 
					{
						alert("用户名重复或用户数超过5个!");
						document.editform.user_name.focus();
						return false;	
					}else if(result.indexOf('FAILEDPHONE') != '-1') 
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
