<ul class="breadcrumb">
	<li><a href="#">{$RELSETHEAD}</a> <span class="divider">/</span></li>
	<li class="active"><a href="index.php?module=Relsettings&action=index&relset={$RELSET}&parenttab=Settings">{$RELSETARRAY[$RELSET]}</a> <span class="divider">/</span></li>
	<li class="active">{$RELSETTITLE}</li>
	<li class="pull-right">
		<button type="button" class="btn btn-small btn-success" style="margin-top:-2px;"
			 onclick="return check();">
			<i class="icon-ok icon-white"></i>{$APP.LBL_SAVE_LABEL}
		</button>
	</li>
</ul>

<input type="hidden" name="userid" value="{$userid}">
<table class="table table-condensed table-bordered ">
	<tbody style="text-align: center;">
	  <tr>
		<th style="width:150px;">{$MOD.LBL_DUANXINZHANGHAO}</th>
		<td style="text-align:left;">
			<input  type="text" value="{$username}" name="username">
		</td>
	  </tr><tr>
		<th>{$MOD.LBL_DUANXINMIMA}</th>
		<td style="text-align:left;">
			<input  type="password" value="{$password}" name="password">
		</td>
	</tr><tr>
		<th>{$MOD.LBL_DUANXINTIAOSHU}</th>
		<td style="text-align:left;">
			{$num}
		</td>
	</tr><tr>
		<th>本月已用条数</th>
		<td style="text-align:left;">
			{$sys_monthuse}
		</td>
	</tr><tr>
		<th>套餐本月未用条数</th>
		<td style="text-align:left;">
			<font color="#FF0000">{$weiyong}</font>
		</td>
	</tr><tr>
		<th>本月套餐结束日期</th>
		<td style="text-align:left;">
			{$nextclearday}
		</td>
	</tr>
	</tbody>
</table>
<table class="table">
	<tr>
		<td colspan="{$counthead}">
			还没有短信账号?<a href="http://c3sms.sinaapp.com/register.php" target="_blank"><font color=red><b>点击注册</b></font></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			短信条数不足?<a href="http://c3sms.sinaapp.com/" target="_blank"><font color=red><b>点击充值</b></font></a>
		</td>
	</tr>
	<tr>
		<td colspan="{$counthead}">
			<font color=red>提示:</font>当前有短信的用户，直接填写当前系统的账号，密码 即可。
		</td>
	</tr>
</table>

<script>
{literal}
function check(){
	if (document.relsetform.username.value == '') {
		alert('短信账号不能为空');
		document.relsetform.username.focus();
		return false;
	}
	if (document.relsetform.password.value == '') {
		alert('短信密码不能为空');
		document.relsetform.password.focus();
		return false;
	}else {
		document.relsetform.action.value = 'SaveSmsAccount';
		var issubmit = document.relsetform.issubmit;
		if(issubmit.value == "1"){
			issubmit.value = "2";
			document.relsetform.submit();
		}
	}
}
{/literal}
</script>