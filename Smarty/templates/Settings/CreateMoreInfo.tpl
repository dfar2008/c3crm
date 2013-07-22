<link rel="stylesheet" type="text/css" href="themes/bootcss/css/Setting.css">
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			{include file='Settings/SettingLeft.tpl'}
		</div>
		<div class="span10" style="margin-left:10px">
			<form action="index.php" method="post" name="editform" id="editform">
				<input type="hidden" name="userid" value="">
				<input type="hidden" name="module" value="Settings">
				<input type="hidden" name="action" value="CreateMoreInfo">
				<div class="row-fluid box" style="height:602px">
					<div class="tab-header">{$MOD.LBL_CREATE_MORE_INFO}</div>
					<div class="padded">
						<div class="breadcrumb" style="height:25px">
							<button type="button" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="btn btn-small btn-primary pull-left" onclick="goback()">
								<i class= "icon-arrow-left icon-white"></i> {$APP.LBL_CANCEL_BUTTON_LABEL}
							</button>
							<button  accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="btn btn-small btn-success pull-right" type="button" name="savebutton"  onClick="return check();">
								<i class="icon-ok icon-white"></i> {$APP.LBL_SAVE_BUTTON_LABEL}
							</button>
						</div>
						<table width="100%" class="table table-condensedfordv table-hover table-bordered dvtable">
							<tr>
								<td class="dvt" align="right"><strong>是否管理员</strong></td>
								<td><input name="is_admin"  tabindex="6" type="checkbox"></td>
							</tr>
							<tr>
								<td class="dvt"><strong>用户名</strong></td>
								<td>
								<input type="text" value="" name="user_name">
								</td>
							</tr>
							<tr>
								<td class="dvt"><strong>密码</strong></td>
								<td >
								<input  type="password"   value="" name="user_password">
								</td>
							  </tr>
							  <tr>
								<td class="dvt"><strong>确认密码</strong></td>
								<td>
								<input  type="password"  value="" name="repassword">
								</td>
							  </tr>
							 <tr>
								<td nowrap class="dvt"><strong>姓名</strong></td>
								<td >
								<input  type="text"value="" name="last_name">
								</td>
							  </tr>
							  <tr valign="top">
								<td class="dvt"><strong><font color="#FF0000">*</font>Email</strong></td>
								<td>                            
								   <input  type="text"  value="" name="email1"  />                          
								</td>
							  </tr>
							  <tr valign="top">
								<td class="dvt"><strong>手机</strong></td>
								<td>
									<input  type="text" value="" name="phone_mobile">
								 </td>
							  </tr>
						</table>
					</div>
				</div>

			</form>
			
		</div>
	</div>
</div>
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
	$.ajax({
		type:"GET",
		url:"index.php?module=Settings&action=SettingsAjax&file=CreateMoreInfo&ajax=true&email1="+email1+"&phone_mobile="+phone_mobile+"&user_name="+user_name+"&user_password="+user_password,
		success : function(msg){
			if(msg.indexOf('FAILEDUSER')!='-1'){
				alert("用户名重复或用户数超过5个!");
				document.editform.user_name.focus();
				return false;	
			}else if(msg.indexOf('FAILEDPHONE') != '-1'){
				alert("手机重复!");
				document.editform.phone_mobile.focus();
				return false;	
			}else if(msg.indexOf('FAILEDEMAIL') != '-1'){
				alert("Email重复!");
				document.editform.email1.focus();
				return false;	
			}else if(msg.indexOf('SUCCESS') != '-1'){
				document.editform.action.value = "SaveMoreInfo";
				document.editform.submit();
			}
		}
	});
	
}

</script>
{/literal}
