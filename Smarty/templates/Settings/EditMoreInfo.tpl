<link rel="stylesheet" type="text/css" href="themes/bootcss/css/Setting.css">
{literal}
<script>
function check()
{	
	if(document.editform.user_password.value != document.editform.repassword.value){
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
	var userid = document.editform.userid.value;
	var hint="";


	$.ajax({
		type:"GET",
		url:"index.php?module=Settings&action=SettingsAjax&file=EditMoreInfo&ajax=true&email1="+email1+"&phone_mobile="+phone_mobile+"&userid="+userid+"&user_password="+user_password,
		success:function(msg){
		  hint = msg;
			if(msg.indexOf('FAILEDPHONE')!='-1'){
				alert("手机重复!");
				document.editform.phone_mobile.focus();
				return false;
			}else if(msg.indexOf('FAILEDEMAIL')!='-1'){
				alert("Email重复!");
				document.editform.email1.focus();
				return false;
			}
		},
		complete:function(){
			if(hint.indexOf('SUCCESS')!='-1'){
			document.editform.action.value = "SaveMoreInfo";
			document.editform.submit();
			}
		},
		error:function(msg){
			alert(msg);
		}

	});
}

</script>
{/literal}

<form action="index.php" method="post" name="editform" id="editform">
	<input type="hidden" name="user_name" value="{$user_name}">
    <input type="hidden" name="userid" value="{$userid}">
    <input type="hidden" name="mode" value="{$mode}">
    <input type="hidden" name="module" value="Settings">
    <input type="hidden" name="action" value="EditMoreInfo">
	<!--content-->
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span2">
				<div class="accordion" id="settingion1" style="overflow:auto;height:580px">
                {include file='Settings/SettingLeft.tpl'}
				</div>
			</div>
			 <div class="span10" style="margin-left:10px;">
				 <div class="row-fluid box" style="height:602px">
					<div class="tab-header">{$MOD.LBL_EDIT_MORE_INFO}</div>
					<div class="padded" style="overflow:auto;height:520px;">
						<!-- content body start-->
						{if $mode neq 'edit'}
						<table class="table table-hover table-bordered dvtable table-condensedforev">
							<tr>
								<td width="20%" nowrap class="small cellLabel dvt"><strong>用户名</strong></td>
								<td width="80%" class="small cellText">
								{$user_name}
								</td>
							</tr>
							<tr>
							<td width="20%" nowrap class="small cellLabel dvt"><strong>密码</strong></td>
							<td width="80%" class="small cellText dvt">
							<input  type="password" class="detailedViewTextBox small" style="width:200px" value="" name="user_password">
							<font color="#FF0000">(提示:如果不需要修改密码,此项和"确认密码"不填即可)</font>
							</td>
						  </tr>
						  <tr>
							<td width="20%" nowrap class="small cellLabel dvt"><strong>确认密码</strong></td>
							<td width="80%" class="small cellText">
							<input  type="password" class="detailedViewTextBox small" style="width:200px" value="" name="repassword">
							</td>
						  </tr>
						 <tr>
							<td width="20%" nowrap class="small cellLabel dvt"><strong>姓名</strong></td>
							<td width="80%" class="small cellText">
							{$last_name}
							</td>
						  </tr>
						  <tr valign="top">
							<td nowrap class="small cellLabel dvt"><strong>Email</strong></td>
							<td class="small cellText">
							   {$email1}
							 </td>
						  </tr>
						  <tr valign="top">
							<td nowrap class="small cellLabel dvt"><strong>手机</strong></td>
							<td class="small cellText">
								{$phone_mobile}
							 </td>
						  </tr>
						</table>
						{else}
						<table class="table table-bordered table-hover dvtable table-condensedforev">
							<tr>
								<td width="20%" nowrap class="small cellLabel dvt"><strong>用户名</strong></td>
								<td width="80%" class="small cellText">
								<label class="checkbox small">
								{$user_name}是否管理员
								{if $ISADMIN}
									{if $record != $userid}
									<input name="is_admin"  checked tabindex="6" type="checkbox" ></td>
									{else}
									<input name="is_admin" type="hidden" value="on">
									<input name="is_admin_display"  checked tabindex="6" type="checkbox" disabled></td>
									{/if}
								{else}
									<input name="is_admin" tabindex="6" type="checkbox"></td>
								{/if}
								</label>
								</td>
							</tr>
							<tr>
								<td width="20%" nowrap class="small cellLabel dvt"><strong>密码</strong></td>
								<td width="80%" class="small cellText">
								<input  type="password" class="detailedViewTextBox small" style="width:200px" value="" name="user_password">
								<font color="#FF0000">(提示:如果不需要修改密码,此项和"确认密码"不填即可)</font>
								</td>
							</tr>
							<tr>
								<td width="20%" nowrap class="small cellLabel dvt"><strong>确认密码</strong></td>
								<td width="80%" class="small cellText">
								<input  type="password" class="detailedViewTextBox small" style="width:200px" value="" name="repassword">
								</td>
							</tr>
							<tr>
								<td width="20%" nowrap class="small cellLabel dvt"><strong>姓名</strong></td>
								<td width="80%" class="small cellText">
								<input  type="text" class="detailedViewTextBox small " style="width:200px" value="{$last_name}" name="last_name">
								</td>
							</tr>
							<tr valign="top">
								<td nowrap class="small cellLabel dvt"><strong><font color="#FF0000">*</font>Email</strong></td>
								<td class="small cellText">
									{if $readonly eq 'readonly'}
										{$email1}
										<input  type="hidden" class="detailedViewTextBox small" value="{$email1}" name="email1"  />
									{else}
										 <input  type="text" class="detailedViewTextBox small" style="width:200px" value="{$email1}" name="email1"  />
									{/if}
								</td>
							</tr>
							<tr valign="top">
								<td nowrap class="small cellLabel dvt"><strong>手机</strong></td>
								<td class="small cellText">
									<input  type="text" class="detailedViewTextBox small" style="width:200px" value="{$phone_mobile}" name="phone_mobile">
								</td>
							</tr>
						</table>
						{/if}

						{if $mode neq 'edit'}
						<div class="pull-left" style="margin-left:10px;margin-top:5px">
							<button class="btn btn-small btn-inverse" title="{$APP.LBL_EDIT_BUTTON_TITLE}" accessKey="{$APP.LBL_EDIT_BUTTON_KEY}" onclick="this.form.mode.value='edit'" type="submit" name="Edit" value="">
							<i class="icon-edit icon-white"></i> {$APP.LBL_EDIT_BUTTON_LABEL}
							</button>
						</div>
						{else}
						<div class="pull-left" style="margin-left:10px;margin-top:5px">
							<button title="{$APP.LBL_CANCEL_BUTTON_LABEL}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="btn btn-small btn-primary" onclick="goback()" type="button" name="button" value="">
								<i class="icon-arrow-left icon-white"></i> {$APP.LBL_CANCEL_BUTTON_LABEL}
							</button>
						</div>

						<div class="pull-right" style="margin-right:10px;margin-top:5px">
							<button title="{$APP.LBL_SAVE_BUTTON_LABEL}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" class="btn btn-small btn-success save"  type="button" name="savebutton" value="" onClick="return check();">
								<i class="icon-ok icon-white"></i> {$APP.LBL_SAVE_BUTTON_LABEL}
							</button>
						</div>
						{/if}

					</div>
				 </div>
			</div>
		</div>

	</div>
	<!--content end-->
</form>



