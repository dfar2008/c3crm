<?php /* Smarty version 2.6.18, created on 2013-01-17 18:29:01
         compiled from Accounts/EditView.tpl */ ?>
<script type="text/javascript" src="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/<?php echo $this->_tpl_vars['SINGLE_MOD']; ?>
.js"></script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'Buttons_List_edit.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>	
<form name="EditView" method="POST" action="index.php">
			<input type="hidden" name="module" value="<?php echo $this->_tpl_vars['MODULE']; ?>
">
			<input type="hidden" name="record" value="<?php echo $this->_tpl_vars['ID']; ?>
">
			<input type="hidden" name="mode" value="<?php echo $this->_tpl_vars['MODE']; ?>
">
			<input type="hidden" name="action">
			<input type="hidden" name="parenttab" value="<?php echo $this->_tpl_vars['CATEGORY']; ?>
">
			<input type="hidden" name="return_module" value="<?php echo $this->_tpl_vars['RETURN_MODULE']; ?>
">
			<input type="hidden" name="return_id" value="<?php echo $this->_tpl_vars['RETURN_ID']; ?>
">
			<input type="hidden" name="return_action" value="<?php echo $this->_tpl_vars['RETURN_ACTION']; ?>
">
			<input type="hidden" name="return_viewname" value="<?php echo $this->_tpl_vars['RETURN_VIEWNAME']; ?>
">

<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
   <tr>

	<td  valign=top width=100%>
				<div class="small" style="padding:0px">

			
						<table border=0 cellspacing=0 cellpadding=0 width=100% align=left>
			 <tr>
					<td>
						<table border=0 cellspacing=0 cellpadding=3 width=100% class="small">
						   <tr>
							<td class="dvtTabCache" style="width:10px" nowrap>&nbsp;</td>
						   </tr>
						</table>
					</td>
				   </tr>
               <tr>
				<td valign=top align=left >
					<table border=0 cellspacing=0 cellpadding=3 width=100% class="dvtContentSpace">
					   <tr>

						<td align=left>
												
							<table border=0 cellspacing=0 cellpadding=0 width=100%>
							   <tr>
								<td id ="autocom"></td>
							   </tr>
							   <tr>
								<td style="padding-left:10px" >
									<!-- General details -->
									<table border=0 cellspacing=0 cellpadding=0 width=100% class="small" >
									  <tr>
										<td  colspan=4 style="padding:5px">
											<div align="center">												
                                				                                	<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';check_duplicate()" type="button" name="savebutton" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >&nbsp;&nbsp;&nbsp;&nbsp;
												        <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="goback()" type="button" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
  " style="width:70px">
											</div>
										</td>
									   </tr>

									   <!-- included to handle the edit fields based on ui types -->
									   <?php $_from = $this->_tpl_vars['BLOCKS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['header'] => $this->_tpl_vars['data']):
?>
                                       <tr><td colspan=4 style="height:10px;"></td></tr>
									      <tr>
										<td colspan=4 class="detailedViewHeader">
											<b><?php echo $this->_tpl_vars['header']; ?>
</b>
										
										</td>
									      </tr>

										<!-- Handle the ui types display -->
										<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "DisplayFields.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

									   <?php endforeach; endif; unset($_from); ?>
                                     

									  

									   <tr>
										<td  colspan=4 style="padding:5px">
											<div align="center">												
                                				                                	<input title="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_KEY']; ?>
" class="crmbutton small save" onclick="this.form.action.value='Save';check_duplicate()" type="button" name="savebutton" value="  <?php echo $this->_tpl_vars['APP']['LBL_SAVE_BUTTON_LABEL']; ?>
  " style="width:70px" >&nbsp;&nbsp;&nbsp;&nbsp;
												        <input title="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_TITLE']; ?>
" accessKey="<?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_KEY']; ?>
" class="crmbutton small cancel" onclick="goback()" type="button" name="button" value="  <?php echo $this->_tpl_vars['APP']['LBL_CANCEL_BUTTON_LABEL']; ?>
  " style="width:70px">
											</div>
										</td>
									   </tr>
									</table>
								</td>
							   </tr>
							</table>
						</td>
					   </tr>
					</table>
                     <!-- zhuaiyao-->
               
			   </tr>
			</table>
		<div>
	</td>
   </tr>
</table>

</form>

<?php if ($this->_tpl_vars['MODULE'] == 'Accounts'): ?>
<script>
	ScrollEffect.limit = 201;
	ScrollEffect.closelimit= 200;
</script>
<?php endif; ?>
<script>	

        var fieldname = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDNAME']; ?>
)

        var fieldlabel = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDLABEL']; ?>
)

        var fielddatatype = new Array(<?php echo $this->_tpl_vars['VALIDATION_DATA_FIELDDATATYPE']; ?>
)
	if(getObj("customernum") != undefined) {
		if(getObj("customernum").value == "") {
			getObj("customernum").value = "<?php echo $this->_tpl_vars['APP']['AUTO_GEN_CODE']; ?>
";
			//getObj("customernum").setAttribute("readOnly","true");
		}
		else {
			//getObj("customernum").setAttribute("readOnly","true");
		}
	}

</script>