<?php /* Smarty version 2.6.18, created on 2013-05-10 11:30:17
         compiled from Relsettings/EditMoreInfo.tpl */ ?>
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody>
<tr>
   <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">

	
<form action="index.php" method="post" name="editform" id="editform">
    <input type="hidden" name="user_name" value="<?php echo $this->_tpl_vars['user_name']; ?>
">
    <input type="hidden" name="record" value="<?php echo $this->_tpl_vars['record']; ?>
">
    <input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['mode']; ?>
">
    <input type="hidden" name="module" value="Relsettings">
    <input type="hidden" name="action" value="EditMoreInfo">
    
	<div align=center>
			

				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="<?php echo $this->_tpl_vars['IMAGE_PATH']; ?>
ico-users.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings"><?php echo $this->_tpl_vars['MOD']['LBL_RELSETTINGS']; ?>
</a> > <?php echo $this->_tpl_vars['MOD']['LBL_EDIT_MORE_INFO']; ?>
 </b></td>
				</tr>
				
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
					<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						<td class="big"><strong><?php echo $this->_tpl_vars['MOD']['LBL_EDIT_MORE_INFO']; ?>
</strong>&nbsp;</td>
						<?php if ($this->_tpl_vars['mode'] != 'edit'): ?>
                        <td class="small" align=right>
							<input class="crmButton small edit" title="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_KEY']; ?>
" onclick="this.form.mode.value='edit'" type="submit" name="Edit" value="<?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_LABEL']; ?>
">
						</td>
                        <?php else: ?>
						<td class="small" align=right>
							<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmButton small save"  type="button" name="savebutton" value="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
" onClick="return check();">&nbsp;&nbsp;
    							<input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
>" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmButton small cancel" onclick="goback()" type="button" name="button" value="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
">
						</td>
                        <?php endif; ?>
					</tr>
					</table>
					
			     <table border=0 cellspacing=0 cellpadding=0 width=100% class="listRow ">
                    <tr>
                    <td class="small" valign=top >
                    
			  <?php if ($this->_tpl_vars['mode'] != 'edit'): ?>
                   <table width="100%"  border="0" cellspacing="0" cellpadding="5">
                     <tr>
                        <td width="20%" nowrap class="small cellLabel"><strong>姓名</strong></td>
                        <td width="80%" class="small cellText">
                        <?php echo $this->_tpl_vars['last_name']; ?>

                        </td>
                      </tr>
                      <tr valign="top">
                        <td nowrap class="small cellLabel"><strong>Email</strong></td>
                        <td class="small cellText">
                           <?php echo $this->_tpl_vars['email1']; ?>

                         </td>
                      </tr>
                      <tr valign="top">
                        <td nowrap class="small cellLabel"><strong>手机</strong></td>
                        <td class="small cellText">
							<?php echo $this->_tpl_vars['phone_mobile']; ?>

                         </td>
                      </tr>
                    </table>
				<?php else: ?>
                    <table width="100%"  border="0" cellspacing="0" cellpadding="5">
                     <tr>
                        <td width="20%" nowrap class="small cellLabel"><strong>姓名</strong></td>
                        <td width="80%" class="small cellText">
                        <input  type="nicheng" class="detailedViewTextBox small" value="<?php echo $this->_tpl_vars['last_name']; ?>
" name="last_name">
                        </td>
                      </tr>
                      <tr valign="top">
                        <td nowrap class="small cellLabel"><strong><font color="#FF0000">*</font>Email</strong></td>
                        <td class="small cellText">
                            <?php if ($this->_tpl_vars['readonly'] == 'readonly'): ?>
                            	<?php echo $this->_tpl_vars['email1']; ?>

                                <input  type="hidden" class="detailedViewTextBox small" value="<?php echo $this->_tpl_vars['email1']; ?>
" name="email1"  />
                            <?php else: ?>
                           		 <input  type="text" class="detailedViewTextBox small" value="<?php echo $this->_tpl_vars['email1']; ?>
" name="email1"  />
                            <?php endif; ?>
                         </td>
                      </tr>
                      <tr valign="top">
                        <td nowrap class="small cellLabel"><strong>手机</strong></td>
                        <td class="small cellText">
                            <input  type="text" class="detailedViewTextBox small" value="<?php echo $this->_tpl_vars['phone_mobile']; ?>
" name="phone_mobile">
                         </td>
                      </tr>
                    </table>
                 <?php endif; ?>
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
	if (document.editform.email1.value == \'\') {
		alert(\'Email不能为空\');
		document.editform.email1.focus();
		return false;
	}
	var mobile = /^0?(13[0-9]|15[012356789]|18[0236789]|14[57])[0-9]{8}$/; 
	var phone_mobile = document.editform.phone_mobile.value;
	if (!mobile.test(phone_mobile)) {
		alert(\'手机格式不正确\');
		document.editform.phone_mobile.focus();
		return false;
	}
	var reg = /^([a-zA-Z0-9]+[_|\\_|\\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\\_|\\.]?)*[a-zA-Z0-9]+\\.[a-zA-Z]{2,3}$/;
	var email1 = document.editform.email1.value;
	if (!reg.test(email1)) {
		alert(\'Email格式不正确\');
		document.editform.email1.focus();
		return false;
	} 
	new Ajax.Request(
			\'index.php\',
			{queue: {position: \'end\', scope: \'command\'},
			method: \'post\',
			postBody:"module=Relsettings&action=RelsettingsAjax&file=EditMoreInfo&ajax=true&email1="+email1+"&phone_mobile="+phone_mobile,
			onComplete: function(response) 
				{  result = response.responseText;
					if(result.indexOf(\'FAILEDPHONE\') != \'-1\') 
					{
						alert("手机重复!");
						document.editform.phone_mobile.focus();
						return false;	
					}else if(result.indexOf(\'FAILEDEMAIL\') != \'-1\') 
					{
						alert("Email重复!");
						document.editform.email1.focus();
						return false;	
					}
					else if(result.indexOf(\'SUCCESS\') != \'-1\')
					{
						document.editform.action.value = "SaveMoreInfo";
						document.editform.submit();
					}
				}
			}
	)	
}

</script>
'; ?>
