<!--	Setting Contact		-->
<ul class="breadcrumb">
	<li><a href="#">{$RELSETHEAD}</a> <span class="divider">/</span></li>
	<li class="active"><a href="index.php?module=Relsettings&action=index&relset={$RELSET}&parenttab=Settings">{$RELSETARRAY[$RELSET]}</a> <span class="divider">/</span></li>
	<li class="active">{$RELSETTITLE}</li>
	<li class="pull-right">
		<button type="button" class="btn btn-small btn-success" style="margin-top:-2px;"
			onclick="check();">
			<i class="icon-ok icon-white"></i>{$APP.LBL_SAVE_LABEL}
		</button>
	</li>
</ul>

<input type="hidden" name="changepassword" value="true">
<input type="hidden" name="user_name" value="{$user_name}">
<input type="hidden" name="record" value="{$record}">
<input type="hidden" name="department" value="{$department}">
<table class="table table-condensed table-bordered table-hover">
	<tbody style="text-align: center;">
		<tr>
			<th style="width:150px;">{$MOD.LBL_OLD_PASSWORD}</th>
			<td style="text-align:left;">
				<input  type="password" class="detailedViewTextBox small" value="" name="old_password">
			</td>
		</tr><tr>
			<th style="width:150px;">{$MOD.LBL_NEW_PASSWORD}</th>
			<td style="text-align:left;">
				<input  type="password" class="detailedViewTextBox small" value="" name="new_password">
			</td>
		</tr><tr>
			<th style="width:150px;">{$MOD.LBL_NEW_PASSWORD_AGAIN}</th>
			<td style="text-align:left;">
				<input  type="password" class="detailedViewTextBox small" value="" name="confirm_password">
			</td>
		</tr>
	</tbody>
</table>
<script>
{literal}
function check()
{	
	if (document.relsetform.department.value == 'weibo') {
		alert('微薄登录用户不能修改密码');
		document.relsetform.department.focus();
		return false;
	}
	if (document.relsetform.old_password.value == '') {
		alert('原密码不能为空');
		document.relsetform.old_password.focus();
		return false;
	}
	if (document.relsetform.new_password.value == '') {
		alert('新密码不能为空');
		document.relsetform.new_password.focus();
		return false;
	}
	if (document.relsetform.confirm_password.value == '') {
		alert('确认密码不能为空');
		document.relsetform.confirm_password.focus();
		return false;
	}
	if (document.relsetform.new_password.value != document.relsetform.confirm_password.value) {
		alert('新密码和确认密码不相符');
		document.relsetform.confirm_password.focus();
		return false;
	} else {
		document.relsetform.action.value = "DoEditPwd";
		document.relsetform.submit();
	}
}
{/literal}
</script>