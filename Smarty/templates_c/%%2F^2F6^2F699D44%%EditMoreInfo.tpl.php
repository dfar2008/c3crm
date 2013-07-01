<?php /* Smarty version 2.6.18, created on 2013-07-01 16:22:41
         compiled from Relsettings/EditMoreInfo.tpl */ ?>
<!--	Setting Contact		-->
<ul class="breadcrumb">
	<li><a href="#"><?php echo $this->_tpl_vars['RELSETHEAD']; ?>
</a> <span class="divider">/</span></li>
	<li class="active"><a href="index.php?module=Relsettings&action=index&relset=<?php echo $this->_tpl_vars['RELSET']; ?>
&parenttab=Settings"><?php echo $this->_tpl_vars['RELSETARRAY'][$this->_tpl_vars['RELSET']]; ?>
</a> <span class="divider">/</span></li>
	<li class="active"><?php echo $this->_tpl_vars['RELSETTITLE']; ?>
</li>
	<li class="pull-right">
		<?php if ($this->_tpl_vars['RELSETMODE'] == 'edit'): ?>
			<button type="button" class="btn btn-small btn-success" style="margin-top:-2px;"
				 onclick="check();">
				<i class="icon-ok icon-white"></i><?php echo $this->_tpl_vars['APP']['LBL_SAVE_LABEL']; ?>

			</button>
		<?php else: ?>
			<button type="button" class="btn btn-small btn-primary" style="margin-top:-2px;"
				onclick="this.form.relsetmode.value='edit';this.form.submit();">
				<i class="icon-edit icon-white"></i><?php echo $this->_tpl_vars['APP']['LBL_EDIT_BUTTON_LABEL']; ?>

			</button>
		<?php endif; ?>
	</li>
</ul>

<?php if ($this->_tpl_vars['RELSETMODE'] == 'edit'): ?>
	<input type="hidden" name="user_name" value="<?php echo $this->_tpl_vars['user_name']; ?>
">
    <input type="hidden" name="record" value="<?php echo $this->_tpl_vars['record']; ?>
">
    <input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['mode']; ?>
">
	<table class="table table-condensed table-bordered">
		<tbody style="text-align: center;">
		  <tr>
			<th style="width:150px;">姓名</th>
			<td style="text-align:left;">
				<input type="text" value="<?php echo $this->_tpl_vars['last_name']; ?>
" name="last_name">
			</td>
		  </tr><tr>
			<th style="width:150px;">Email</th>
			<td style="text-align:left;">
				<?php if ($this->_tpl_vars['readonly'] == 'readonly'): ?>
					<?php echo $this->_tpl_vars['email1']; ?>

					<input  type="hidden" value="<?php echo $this->_tpl_vars['email1']; ?>
" name="email1"  />
				<?php else: ?>
					 <input  type="text" value="<?php echo $this->_tpl_vars['email1']; ?>
" name="email1"  />
				<?php endif; ?>
			</td>
		  </tr><tr>
			<th style="width:150px;">手机</th>
			<td style="text-align:left;">
				<input  type="text" value="<?php echo $this->_tpl_vars['phone_mobile']; ?>
" name="phone_mobile">
			</td>
		  </tr>
		</tbody>
	</table>
<?php else: ?>
	<table class="table table-condensed table-bordered">
		<tbody style="text-align: center;">
		  <tr>
			<th style="width:150px;">姓名</th>
			<td style="text-align:left;"><?php echo $this->_tpl_vars['last_name']; ?>
</td>
		  </tr><tr>
			<th style="width:150px;">Email</th>
			<td style="text-align:left;"><?php echo $this->_tpl_vars['email1']; ?>
</td>
		  </tr><tr>
			<th style="width:150px;">手机</th>
			<td style="text-align:left;"><?php echo $this->_tpl_vars['phone_mobile']; ?>
</td>
		  </tr>
		</tbody>
	</table>
<?php endif; ?>

<script>
<?php echo '
function check()
{	
	if (document.relsetform.email1.value == \'\') {
		alert(\'Email不能为空\');
		document.relsetform.email1.focus();
		return false;
	}
	var mobile = /^0?(13[0-9]|15[012356789]|18[0236789]|14[57])[0-9]{8}$/; 
	var phone_mobile = document.relsetform.phone_mobile.value;
	if (!mobile.test(phone_mobile)) {
		alert(\'手机格式不正确\');
		document.relsetform.phone_mobile.focus();
		return false;
	}
	var reg = /^([a-zA-Z0-9]+[_|\\_|\\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\\_|\\.]?)*[a-zA-Z0-9]+\\.[a-zA-Z]{2,3}$/;
	var email1 = document.relsetform.email1.value;
	if (!reg.test(email1)) {
		alert(\'Email格式不正确\');
		document.relsetform.email1.focus();
		return false;
	}
	$.ajax({  
		   type: "GET",
		   url:"index.php?module=Relsettings&action=RelsettingsAjax&file=EditMoreInfo&ajax=true&email1="+email1+"&phone_mobile="+phone_mobile,
		   success: function(msg){
				if(msg.indexOf(\'FAILEDPHONE\') != \'-1\') {
					alert("手机重复!");
					document.relsetform.phone_mobile.focus();
					return false;	
				}else if(msg.indexOf(\'FAILEDEMAIL\') != \'-1\') {
					alert("Email重复!");
					document.relsetform.email1.focus();
					return false;	
				}else if(msg.indexOf(\'SUCCESS\') != \'-1\'){
					document.relsetform.action.value = "SaveMoreInfo";
					document.relsetform.submit();
				}
		   }  
    });
}
'; ?>

</script>