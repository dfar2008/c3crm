<?php /* Smarty version 2.6.18, created on 2013-04-12 16:28:45
         compiled from Relsettings/SmsAccount.tpl */ ?>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody>
<tr>
   <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">

	
<form action="index.php" method="post" name="editform" id="editform">
    <input type="hidden" name="userid" value="<?php echo $this->_tpl_vars['userid']; ?>
">
     <input type="hidden" name="module" value="Relsettings">
      <input type="hidden" name="action" value="SaveSmsAccount">
	
	<div align=center>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'SetMenu.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<!-- DISPLAY -->
			<?php if ($this->_tpl_vars['MODE'] != 'edit'): ?>
			<b><font color=red><?php echo $this->_tpl_vars['DUPLICATE_ERROR']; ?>
 </font></b>
			<?php endif; ?>

				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
picklist.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_SETTINGS']; ?>
</a> > <?php echo $this->_tpl_vars['MOD']['LBL_DUANXINZHANGHAOSHEZHI']; ?>
 </b></td>
				</tr>
				
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
					<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						<td class="big"><strong><?php echo $this->_tpl_vars['MOD']['LBL_DUANXINZHANGHAOSHEZHI']; ?>
</strong>&nbsp;</td>
						
						<td class="small" align=right>
							<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmButton small save"  type="submit" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
" onClick="return check();">&nbsp;&nbsp;
    							<input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
>" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmButton small cancel" onclick="goback()" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
">
						</td>
					</tr>
					</table>
					
					
					
			<table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow">
			<tr>
			<td class="small" valign=top ><table width="100%"  border="0" cellspacing="0" cellpadding="5">
                        <tr>
                            <td width="20%" nowrap class="small cellLabel"><strong><?php echo $this->_tpl_vars['MOD']['LBL_DUANXINZHANGHAO']; ?>
</strong></td>
                            <td width="80%" class="small cellText">
				<input  type="username" class="detailedViewTextBox small" value="<?php echo $this->_tpl_vars['username']; ?>
" name="username">
			    </td>
                          </tr>
			  <tr>
                            <td width="20%" nowrap class="small cellLabel"><strong><?php echo $this->_tpl_vars['MOD']['LBL_DUANXINMIMA']; ?>
</strong></td>
                            <td width="80%" class="small cellText">
				<input  type="password" class="detailedViewTextBox small" value="<?php echo $this->_tpl_vars['password']; ?>
" name="password">
			    </td>
                          </tr>
                          <tr valign="top">
                            <td nowrap class="small cellLabel"><strong><?php echo $this->_tpl_vars['MOD']['LBL_DUANXINTIAOSHU']; ?>
</strong></td>
                            <td class="small cellText">
                            <?php echo $this->_tpl_vars['num']; ?>

						    </td>
                          </tr>
                          
                          <tr valign="top">
                            <td nowrap class="small cellLabel"><strong>本月已用条数</strong></td>
                            <td class="small cellText">
                            <?php echo $this->_tpl_vars['sys_monthuse']; ?>

						    </td>
                          </tr>
                          
                          <tr valign="top">
                            <td nowrap class="small cellLabel"><strong>套餐本月未用条数</strong></td>
                            <td class="small cellText">
                            <font color="#FF0000"><?php echo $this->_tpl_vars['weiyong']; ?>
</font>
						    </td>
                          </tr>
                          
                          <tr valign="top">
                            <td nowrap class="small cellLabel"><strong>本月套餐结束日期</strong></td>
                            <td class="small cellText">
                            <?php echo $this->_tpl_vars['nextclearday']; ?>

						    </td>
                          </tr>
                          
                         <tr valign="top">
                            <td class="small cellText" colspan="2">
                            
                            还没有短信账号?<a href="http://c3sms.sinaapp.com/register.php" target="_blank"><font color=red><b>点击注册</b></font></a>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            短信条数不足?<a href="http://c3sms.sinaapp.com/" target="_blank"><font color=red><b>点击充值</b></font></a>
                            
                            <br><br>
                            
                            <font color=red>提示:</font>当前有短信的用户，直接填写当前系统的账号，密码 即可。
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
<?php echo '
<script>
function check()
{	
	if (document.editform.username.value == \'\') {
		alert(\'短信账号不能为空\');
		document.editform.username.focus();
		return false;
	}
	
	if (document.editform.password.value == \'\') {
		alert(\'短信密码不能为空\');
		document.editform.password.focus();
		return false;
	}else {
		 document.editform.submit();
	}
}
</script>
'; ?>
