<?php /* Smarty version 2.6.18, created on 2013-07-01 16:22:45
         compiled from Relsettings/SmsAccount.tpl */ ?>
<ul class="breadcrumb">
	<li><a href="#"><?php echo $this->_tpl_vars['RELSETHEAD']; ?>
</a> <span class="divider">/</span></li>
	<li class="active"><a href="index.php?module=Relsettings&action=index&relset=<?php echo $this->_tpl_vars['RELSET']; ?>
&parenttab=Settings"><?php echo $this->_tpl_vars['RELSETARRAY'][$this->_tpl_vars['RELSET']]; ?>
</a> <span class="divider">/</span></li>
	<li class="active"><?php echo $this->_tpl_vars['RELSETTITLE']; ?>
</li>
	<li class="pull-right">
		<button type="button" class="btn btn-small btn-success" style="margin-top:-2px;"
			 onclick="return check();">
			<i class="icon-ok icon-white"></i><?php echo $this->_tpl_vars['APP']['LBL_SAVE_LABEL']; ?>

		</button>
	</li>
</ul>

<input type="hidden" name="userid" value="<?php echo $this->_tpl_vars['userid']; ?>
">
<table class="table table-condensed table-bordered ">
	<tbody style="text-align: center;">
	  <tr>
		<th style="width:150px;"><?php echo $this->_tpl_vars['MOD']['LBL_DUANXINZHANGHAO']; ?>
</th>
		<td style="text-align:left;">
			<input  type="text" value="<?php echo $this->_tpl_vars['username']; ?>
" name="username">
		</td>
	  </tr><tr>
		<th><?php echo $this->_tpl_vars['MOD']['LBL_DUANXINMIMA']; ?>
</th>
		<td style="text-align:left;">
			<input  type="password" value="<?php echo $this->_tpl_vars['password']; ?>
" name="password">
		</td>
	</tr><tr>
		<th><?php echo $this->_tpl_vars['MOD']['LBL_DUANXINTIAOSHU']; ?>
</th>
		<td style="text-align:left;">
			<?php echo $this->_tpl_vars['num']; ?>

		</td>
	</tr><tr>
		<th>本月已用条数</th>
		<td style="text-align:left;">
			<?php echo $this->_tpl_vars['sys_monthuse']; ?>

		</td>
	</tr><tr>
		<th>套餐本月未用条数</th>
		<td style="text-align:left;">
			<font color="#FF0000"><?php echo $this->_tpl_vars['weiyong']; ?>
</font>
		</td>
	</tr><tr>
		<th>本月套餐结束日期</th>
		<td style="text-align:left;">
			<?php echo $this->_tpl_vars['nextclearday']; ?>

		</td>
	</tr>
	</tbody>
</table>
<table class="table">
	<tr>
		<td colspan="<?php echo $this->_tpl_vars['counthead']; ?>
">
			还没有短信账号?<a href="http://c3sms.sinaapp.com/register.php" target="_blank"><font color=red><b>点击注册</b></font></a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			短信条数不足?<a href="http://c3sms.sinaapp.com/" target="_blank"><font color=red><b>点击充值</b></font></a>
		</td>
	</tr>
	<tr>
		<td colspan="<?php echo $this->_tpl_vars['counthead']; ?>
">
			<font color=red>提示:</font>当前有短信的用户，直接填写当前系统的账号，密码 即可。
		</td>
	</tr>
</table>

<script>
<?php echo '
function check(){
	if (document.relsetform.username.value == \'\') {
		alert(\'短信账号不能为空\');
		document.relsetform.username.focus();
		return false;
	}
	if (document.relsetform.password.value == \'\') {
		alert(\'短信密码不能为空\');
		document.relsetform.password.focus();
		return false;
	}else {
		document.relsetform.action.value = \'SaveSmsAccount\';
		var issubmit = document.relsetform.issubmit;
		if(issubmit.value == "1"){
			issubmit.value = "2";
			document.relsetform.submit();
		}
	}
}
'; ?>

</script>