<link rel="stylesheet" type="text/css" href="themes/bootcss/css/Setting.css">
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2">
			<div class="accordion" id="settingion1" style="overflow:auto;height:580px;">
			{include file='Settings/SettingLeft.tpl'}
			</div>
		</div>

		<div class="span10" style="margin-left:10px">
			<div class="row-fluid box" style="height:602px">
				<div class="tab-header">{$MOD.LBL_DUANXINZHANGHAO}</div>
					<!--<div class="page-header" style="margin-top:-10px">
						<h4 style="margin-bottom:-8px">
							<img src="{$IMAGE_PATH}ico_mobile.gif" alt="Sms" width="48" height="48" border=0 title="Sms">{$MOD.LBL_DUANXINZHANGHAO}
							<small>短信账号管理</small>
						</h4>
					</div>-->
				<div class="padded">
					<form name="relsetform" id="editform" method="post" action="index.php">
					<input type="hidden" name="userid" value="{$userid}" />
					<input type="hidden" name="module" value="Settings" />
					<input type="hidden" name="action" value="SaveSmsAccount" />

					<div style="margin-top:-8px">
						<div class="pull-left">
							<button type="button" class="btn btn-primary btn-small" onclick="goback()">
								<i class="icon-arrow-left icon-white"></i> 取消
							</button>
						</div>
						<div class="pull-right">
							<button class="btn btn-small btn-success" type="button" name=""  onclick="return check();">
								<i class="icon-ok icon-white"></i> {$APP.LBL_SAVE_LABEL}
							</button>
						</div>
					</div>
					<br><br>

					<!--content start-->
					<div >

						<table class="table table-condensed table-bordered table-hover">
							<tbody style="text-align: center;">
							  <tr>
								<th class="dvt" style="width:150px;">{$MOD.LBL_DUANXINZHANGHAO}</th>
								<td  style="text-align:left;">
									<input  type="text" value="{$username}" name="username">
								</td>
							  </tr><tr>
								<th class="dvt">{$MOD.LBL_DUANXINMIMA}</th>
								<td style="text-align:left;">
									<input  type="password" value="{$password}" name="password">
								</td>
							</tr><tr>
								<th class="dvt">{$MOD.LBL_DUANXINTIAOSHU}</th>
								<td style="text-align:left;">
									{$num}
								</td>
							</tr><tr>
								<th class="dvt">本月已用条数</th>
								<td style="text-align:left;">
									{$sys_monthuse}
								</td>
							</tr><tr>
								<th class="dvt">套餐本月未用条数</th>
								<td style="text-align:left;">
									<font color="#FF0000">{$weiyong}</font>
								</td>
							</tr><tr>
								<th class="dvt">本月套餐结束日期</th>
								<td style="text-align:left;">
									{$nextclearday}
								</td>
							</tr>
							</tbody>
						</table>
						<br>
						<table >
							<tr>
								<td colspan="{$counthead}">
									还没有短信账号?<a href="http://c3sms.sinaapp.com/register.php" target="_blank"><font color=red><b>点击注册</b></font></a>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									短信条数不足?<a href="http://c3sms.sinaapp.com/" target="_blank"><font color=red><b>点击充值</b></font></a>
								</td>
							</tr>
							<tr>
								<td colspan="{$counthead}">
									<em><font color=red>提示:</font>当前有短信的用户，直接填写当前系统的账号，密码 即可。</em>
								</td>
							</tr>
						</table>
						

					</div>
			<!--content end-->
					</form>

				</div>
			</div>

		</div>
	</div>

</div>

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
		//if(issubmit.value == "1"){
			//issubmit.value = "2";
			document.relsetform.submit();
		//}
	}
}
{/literal}
</script>